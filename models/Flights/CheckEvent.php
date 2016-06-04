<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 04.06.16
 * Time: 17:30
 */

namespace app\models\Flights;

use Yii;

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
        $member = EventsMembers::flight($flight);

        if ($member->status == EventsMembers::STATUS_ACTIVE_FLIGHT) {
            $member->status = EventsMembers::STATUS_FINISHED_FLIGHT;
        }

        $member->save();
    }


    private static function check($event, $flight)
    {
        $conditions = ['dep_time' => ['from_icao', 'fromArray'], 'landing_time' => ['to_icao', 'toArray']];

        foreach ($conditions as $key => $cond) {
            if (strtotime($flight->$key) >= strtotime($event->start) &&
                strtotime($flight->$key) <= strtotime($event->stop) &&
                in_array($flight->$cond[0], $event->$cond[1])
            ) {
                self::makeActive($flight, $event);
            }
        }
    }

    private static function makeActive($event, $flight)
    {
        if ($member = EventsMembers::get($event, $flight)) {
            if ($member->status < EventsMembers::STATUS_ACTIVE_FLIGHT) {
                $member->status = EventsMembers::STATUS_ACTIVE_FLIGHT;
                $member->save();
            }
        } else {
            $_member = new EventsMembers();
            $_member->event_id = $event->id;
            $_member->user_id = $flight->user_id;
            $_member->status = EventsMembers::STATUS_ACTIVE_FLIGHT;
            $_member->fligth_id = $flight->id;
            $_member->save();
        }
    }
} 