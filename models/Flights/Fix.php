<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 24.09.16
 * Time: 23:28
 */

namespace app\models\Flights;

use Yii;
use yii\web\NotFoundHttpException;

use app\components\Helper;
use app\components\Levels;
use app\models\Billing;
use app\models\Booking;
use app\models\Fleet;
use app\models\Flights;
use app\models\Log;
use app\models\Services\notifications\Fix as Notifications;
use app\models\Users;

class Fix
{
    public static function request($id)
    {
        Notifications::request(self::findModel($id));
    }

    public static function accept($id)
    {
        if ($flight = self::findModel($id)) {
            $booking = Booking::find()->andWhere(['id' => $flight->id])->one();

            $flight->landing = $flight->to_icao;
            $flight->finished = gmdate('Y-m-d H:i:s');
            $flight->status = Flights::FLIGHT_STATUS_OK;
            $booking->status = Booking::BOOKING_FLIGHT_END;
            $flight->flight_time = round(Helper::time2seconds($flight->eet) / 60);

            Users::transfer($flight->user_id, $flight->landing);

            if ($booking->fleet_regnum) {
                Fleet::transfer($flight->fleet_regnum, $flight->landing);
                Fleet::changeStatus($booking->fleet_regnum, Fleet::STATUS_AVAIL);
                Fleet::checkSrv($booking->fleet_regnum, $flight->landing);
            }

            $flight->vucs = Billing::calculatePriceForFlight(
                $flight->from_icao,
                $flight->landing,
                unserialize($flight->paxtypes)
            );
            Billing::doFlightCosts($flight);
            Levels::flight($flight->user_id, $flight->nm);
            $booking->save();
            $flight->save();

            Status::get($booking, $flight->landing);


            Log::action(Yii::$app->user->id, 'success', 'flights', $id);

            Notifications::accept($flight);
        }

    }

    public static function reject($id)
    {

    }

    protected static function findModel($id)
    {
        if (($model = Flights::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
} 