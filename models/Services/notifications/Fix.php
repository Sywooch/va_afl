<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 24.09.16
 * Time: 23:30
 */

namespace app\models\Services\notifications;


use app\components\Slack;
use app\models\Users;
use Yii;

class Fix
{

    const CONTENT_REQUEST = 3305;
    const CONTENT_ACCEPT = 3307;
    const CONTENT_REJECT = 3468;
    const SLACK_CHANNEL = '#flights';

    /**
     * @param \app\models\Flights $flight
     */
    public static function request($flight)
    {
        $slack = new Slack(self::SLACK_CHANNEL,
            "({$flight->id}) Flight fix request by {$flight->user->full_name} ({$flight->user->vid})\n" .
            "Flight Link: http://va-afl.su/airline/flights/view/{$flight->id}\n" .
            "IVAO Tracker Link: http://tracker.ivao.aero/search.php?vid={$flight->user->vid}&callsign={$flight->callsign}&conntype=PILOT&date=" . (new \DateTime($flight->first_seen))->format('Y-m-d') . "&search=Search");
        $slack->sent();

        $array = [
            '[flight_id]' => $flight->id,
            '[full_name]' => "{$flight->callsign} {$flight->from_icao}-{$flight->to_icao} " . (new \DateTime($flight->first_seen))->format('d.m.Y')
        ];
        Notification::add($flight->user_id, 0, \app\models\Content::template(self::CONTENT_REQUEST, $array),
            'fa-spinner', 'orange');
    }

    public static function accept($flight)
    {
        $user = Users::findOne(Yii::$app->user->id);
        $slack = new Slack(self::SLACK_CHANNEL,
            "({$flight->id}) Flight fix request by {$flight->user->full_name} ({$flight->user->vid}) accepted by {$user->full_name} ({$user->vid}).\n" .
            "Flight Link: http://va-afl.su/airline/flights/view/{$flight->id}\n");
        $slack->sent();

        $array = [
            '[flight_id]' => $flight->id,
            '[full_name]' => "{$flight->callsign} {$flight->from_icao}-{$flight->to_icao} " . (new \DateTime($flight->first_seen))->format('d.m.Y')
        ];
        Notification::add($flight->user_id, Yii::$app->user->id,
            \app\models\Content::template(self::CONTENT_ACCEPT, $array), 'fa-thumbs-up', 'green');
    }

    public static function reject($flight)
    {
        $user = Users::findOne(Yii::$app->user->id);
        $slack = new Slack(self::SLACK_CHANNEL,
            "({$flight->id}) Flight fix request by {$flight->user->full_name} ({$flight->user->vid}) rejected by {$user->full_name} ({$user->vid})\n" .
            "Flight Link: http://va-afl.su/airline/flights/view/{$flight->id}\n");
        $slack->sent();

        $array = [
            '[flight_id]' => $flight->id,
            '[full_name]' => "{$flight->callsign} {$flight->from_icao}-{$flight->to_icao} " . (new \DateTime($flight->first_seen))->format('d.m.Y')
        ];
        Notification::add($flight->user_id, Yii::$app->user->id,
            \app\models\Content::template(self::CONTENT_REJECT, $array), 'fa-ban', 'red');
    }
} 