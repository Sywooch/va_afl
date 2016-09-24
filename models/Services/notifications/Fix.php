<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 24.09.16
 * Time: 23:30
 */

namespace app\models\Services\notifications;


use app\components\Slack;
use Yii;

class Fix {

    const CONTENT_REQUEST = 3305;
    const CONTENT_ACCEPT = 3307;

    public static function request($flight){
        $slack = new Slack('#dev_reports', "User {$flight->user->full_name} request fix flight {$flight->id}; http://va-afl.su/airline/flights/view/{$flight->id}");
        $slack->sent();

        $array = [
            '[flight_id]' => $flight->id,
            '[full_name]' => "{$flight->callsign} {$flight->from_icao}-{$flight->to_icao} " . (new \DateTime($flight->first_seen))->format('d.m.Y')
        ];
        Notification::add($flight->user_id, 0, \app\models\Content::template(self::CONTENT_REQUEST, $array), 'fa-spinner', 'orange');
    }

    public static function accept($flight)
    {
        $slack = new Slack('#dev_reports', "Flight {$flight->id} by {$flight->user->full_name} fixed; http://va-afl.su/airline/flights/view/{$flight->id}");
        $slack->sent();

        $array = [
            '[flight_id]' => $flight->id,
            '[full_name]' => "{$flight->callsign} {$flight->from_icao}-{$flight->to_icao} " . (new \DateTime($flight->first_seen))->format('d.m.Y')
        ];
        Notification::add($flight->user_id,Yii::$app->user->id, \app\models\Content::template(self::CONTENT_ACCEPT, $array), 'fa-thumbs-up', 'green');
    }
} 