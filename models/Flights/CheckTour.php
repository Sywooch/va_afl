<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 09.06.16
 * Time: 8:23
 */

namespace app\models\Flights;


use app\models\Content;
use app\models\Services\notifications\Notification;
use app\models\Tours\ToursUsers;
use app\models\Tours\ToursUsersLegs;

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
                                     \app\models\Tours\ToursUsers::STATUS_ACTIVE,
                                     \app\models\Tours\ToursUsers::STATUS_ASSIGNED
                                 ]
                             ]
                         ]
                     )->all() as $_tour) {
            if ($_tour->tour->status == 1
                && $flight->first_seen >= $_tour->tour->start
                && $flight->first_seen <= $_tour->tour->stop
                && $_tour->nextLeg->from == $flight->from_icao
                && $_tour->nextLeg->to == $flight->to_icao) {

                if($_tour->status == ToursUsers::STATUS_ASSIGNED){
                    $_tour->status = ToursUsers::STATUS_ACTIVE;
                    $_tour->save();

                    self::notification($flight, $_tour, self::TEMPLATE_START);
                }

                if(!$leg = ToursUsersLegs::findOne(['flight_id' => $flight->id, 'tour_id' => $_tour->tour_id, 'leg_id' => $_tour->nextLeg->leg_id])){
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

    public static function end($flight)
    {
        foreach (ToursUsersLegs::find()->where(['flight_id' => $flight->id])->all() as $_tour){
            if($flight->to_icao == $flight->landing){
                $_tour->status = ToursUsersLegs::STATUS_FLIGHT_FINISHED;
                $_tour->tourUser->legs_finished++;

                if($_tour->tourUser->legs_finished == $_tour->tour->getToursLegs()->count())
                {
                    $_tour->tourUser->status = ToursUsers::STATUS_COMPLETED;
                    self::notification($flight, $_tour, self::TEMPLATE_TOUR);
                }else{
                    self::notification($flight, $_tour, self::TEMPLATE_LEG);
                }
            }else{
                $_tour->status = ToursUsersLegs::STATUS_FLIGHT_FAILED;
            }

            $_tour->save();
        }
    }

    private static function notification($flight, $_tour, $TEMPLATE)
    {
        $array = [
            '[tour_id]' => $_tour->tour->id,
            '[tour_ru]' => $_tour->tour->content->name_ru,
            '[tour_en]' => $_tour->tour->content->name_en,
            '[leg_total]' => $_tour->tour->getToursLegs()->count()
        ];

        if(isset($_tour->tourUser)){
            $array['[leg]'] = $_tour->tourUser->legs_finished;
        }

        Notification::add($flight->user_id, 0, Content::template($TEMPLATE, $array));
    }
} 