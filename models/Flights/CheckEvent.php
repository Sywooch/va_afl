<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 04.06.16
 * Time: 17:30
 */

namespace app\models\Flights;

use app\components\Levels;
use Yii;

use app\components\Slack;
use app\models\Events\Events;
use app\models\Events\EventsMembers;

class CheckEvent
{

    public static function flight($flight)
    {
        foreach (Events::active() as $event) {
            if (empty($event->access) || Yii::$app->authManager->checkAccess($flight->user_id, $event->access)) {
                self::check($event, $flight);
            }
        }
    }

    public static function end($flight)
    {
        if ($member = EventsMembers::flight($flight)) {
            foreach ($member as $_flight) {
                if ($_flight->status == EventsMembers::STATUS_ACTIVE_FLIGHT) {
                    $_flight->status = EventsMembers::STATUS_FINISHED_FLIGHT;
                }

                Levels::addExp(1000, $flight->user_id);

                $_flight->save();
            }
        }
    }


    private static function check($event, $flight)
    {
        $conditions = [
            'dep_time' => [['from_icao', 'fromArray']],
            'landing_time' => [['landing', 'toArray']],
            'eta_time' => [['to_icao', 'toArray']]
        ];

        if ($event->airbridge) {
            $conditions['dep_time'][] = ['from_icao', 'toArray'];
            $conditions['landing_time'][] = ['landing', 'fromArray'];
            $conditions['eta_time'][] = ['landing', 'fromArray'];
        }

        foreach ($conditions as $key => $_cond) {
            foreach ($_cond as $cond) {
                if (strtotime($flight->$key) >= strtotime($event->start) &&
                    strtotime($flight->$key) <= strtotime($event->stop) &&
                    array_key_exists($flight->{$cond[0]}, $event->{$cond[1]})
                ) {
                    self::makeActive($event, $flight);
                }
            }
        }
    }

    private static function makeActive($event, $flight)
    {
        if ($member = EventsMembers::get($event, $flight)) {
            if ($member->status < EventsMembers::STATUS_ACTIVE_FLIGHT) {
                $member->status = EventsMembers::STATUS_ACTIVE_FLIGHT;
                $member->save();

                self::slack($event, $flight);
            }
        } else {
            $_member = new EventsMembers();
            $_member->event_id = $event->id;
            $_member->user_id = $flight->user_id;
            $_member->status = EventsMembers::STATUS_ACTIVE_FLIGHT;
            $_member->flight_id = $flight->id;
            $_member->save();
            self::slack($event, $flight);
        }
    }

    private static function slack($event, $flight){
        $slack = new Slack('#events', $flight->callsign . " seen on the " . $event->contentInfo->name_en);
        $slack->sent();
    }
} 