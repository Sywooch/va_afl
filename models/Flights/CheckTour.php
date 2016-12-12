<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 09.06.16
 * Time: 8:23
 */

namespace app\models\Flights;


use app\components\Levels;
use app\models\BillingUserBalance;
use app\models\Content;
use app\models\Services\notifications\Notification;
use app\models\Tours\ToursUsers;
use app\models\Tours\ToursUsersLegs;
use app\models\Services\notifications\Feed;

class CheckTour
{
    const TEMPLATE_START = 806;
    const TEMPLATE_LEG = 807;
    const TEMPLATE_TOUR = 808;
    
    public static function flight($flight)
    {
        foreach (ToursUsers::find()->where(['user_id' => $flight->user_id])
                     ->andFilterWhere(
                         [
                             'or',
                             [
                                 'status' => [
                                     ToursUsers::STATUS_ACTIVE,
                                     ToursUsers::STATUS_ASSIGNED
                                 ]
                             ]
                         ]
                     )->all() as $_tour) {
            if ($_tour->tour->status == 1
                && $flight->first_seen >= $_tour->tour->start
                && $flight->first_seen <= $_tour->tour->stop
                && $_tour->nextLeg->from == $flight->from_icao
                && $_tour->nextLeg->to == $flight->to_icao
            ) {

                if ($_tour->status == ToursUsers::STATUS_ASSIGNED) {
                    $_tour->status = ToursUsers::STATUS_ACTIVE;
                    $_tour->save();

                    self::notification($flight, $_tour, self::TEMPLATE_START);
                    Levels::addExp(1000, $flight->user_id);
                }

                if (!$leg = ToursUsersLegs::findOne([
                    'flight_id' => $flight->id,
                    'tour_id' => $_tour->tour_id,
                    'leg_id' => $_tour->nextLeg->leg_id
                ])
                ) {
                    $leg = new ToursUsersLegs;
                    $leg->tour_id = $_tour->tour_id;
                    $leg->leg_id = $_tour->nextLeg->leg_id;
                    $leg->flight_id = $flight->id;
                    $leg->user_id = $flight->user_id;
                    $leg->status = ToursUsersLegs::STATUS_FLIGHT_STARTED;
                    $leg->save();
                }
            }
        }
    }

    /**
     * @param $flight \app\models\Flights
     * @param $_tour
     * @param $TEMPLATE
     */
    private static function notification($flight, $_tour, $TEMPLATE)
    {
        $array = [
            '[tour_id]' => $_tour->tour->id,
            '[tour_ru]' => $_tour->tour->content->name_ru,
            '[tour_en]' => $_tour->tour->content->name_en,
            '[leg_total]' => $_tour->tour->getToursLegs()->count(),
            '[name]' => $flight->user->full_name,
            '[vid]' => $flight->user_id,
        ];

        if (isset($_tour->tourUser)) {
            $array['[leg]'] = $_tour->tourUser->legs_finished;
        }

        Notification::add($flight->user_id, 0, Content::template($TEMPLATE, $array));

        switch ($TEMPLATE) {
            case self::TEMPLATE_START:
                Feed::tourStart($array);
                break;
            case self::TEMPLATE_TOUR:
                Feed::tourEnd($array);
                break;
        }
    }

    public static function end($flight)
    {
        foreach (ToursUsersLegs::find()->where(['flight_id' => $flight->id])->all() as $_tour) {
            if ($flight->to_icao == $flight->landing) {
                $_tour->status = ToursUsersLegs::STATUS_FLIGHT_FINISHED;
                $_tour->tourUser->legs_finished = $_tour->tourUser->legs_finished + 1;

                if ($_tour->tourUser->legs_finished == $_tour->tour->getToursLegs()->count()) {
                    $_tour->tourUser->status = ToursUsers::STATUS_COMPLETED;
                    self::notification($flight, $_tour, self::TEMPLATE_TOUR);
                    Levels::addExp($_tour->tour->exp, $flight->user_id);
                    BillingUserBalance::addMoney($flight->user_id, $flight->id, $_tour->tour->vucs, 57);
                } else {
                    self::notification($flight, $_tour, self::TEMPLATE_LEG);
                    Levels::addExp(200, $flight->user_id);
                }
            } else {
                $_tour->status = ToursUsersLegs::STATUS_FLIGHT_FAILED;
            }

            $_tour->save();
            $_tour->tourUser->save();
        }
    }
} 