<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 15.02.16
 * Time: 12:02
 */

namespace app\models\Events;

class Calendar
{
    public static function All()
    {
        $events = [];
        foreach (Events::find()->all() as $event) {
            $events[] = [
                'title' => $event->contentInfo->name,
                'start' => $event->start,
                'stop' => $event->stop,
                'color' => 'green',
                'url' => '/events/' . $event->id,
            ];
        }
        return $events;
    }
} 