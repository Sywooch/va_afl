<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 28.05.16
 * Time: 19:30
 */

namespace app\models\Services\notifications;

use Yii;

use app\components\Slack;


class FlightOps
{
    const TEMPLATE_DELETE = 3855;
    const TEMPLATE_AIRCRAFT_RETURN = 3874;

    /**
     * @param $booking \app\models\Booking
     */
    public static function bookingDelete($booking)
    {
        $array = [
            '[callsign]' => $booking->callsign,
            '[created]' => $booking->created,
        ];

        Yii::trace(var_export($array, 1));
        Notification::add($booking->user_id, 0, \app\models\Content::template(self::TEMPLATE_DELETE, $array), 'fa-clock-o', 'orange');
    }

    /**
     * @param $flight \app\models\Flights
     */
    public static function aircraftReturn($flight)
    {
        $array = [
            '[callsign]' => $flight->callsign,
            '[landing_time]' => $flight->landing_time,
        ];

        Yii::trace(var_export($array, 1));
        Notification::add($flight->user_id, 0, \app\models\Content::template(self::TEMPLATE_AIRCRAFT_RETURN, $array), 'fa-clock-o', 'orange');
        $slack = new Slack('#flights', "Aircraft {$flight->fleet->regnum} ({$flight->fleet->type_code}) returned to {$flight->fleet->home_airport} from {$flight->fleet->location}; Last flight by {$flight->booking->user->full_name} ({$flight->booking->user_id}) {$flight->callsign} first_seen - {$flight->first_seen} http://va-afl.su/airline/flights/view/{$flight->id}");
        $slack->sent();
    }
} 