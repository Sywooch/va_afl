<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 15.02.16
 * Time: 12:02
 */

namespace app\models\Events;

use Yii;

class Calendar
{
    public static function all(){
        return self::prepare(Events::find()->all());
    }

    public static function center(){
        return self::prepare(Events::find()->where('type > 1')->all());
    }

    public static function prepare($mEvents)
    {
        $events = [];
        foreach ($mEvents as $event) {
            if (empty($event->access) || Yii::$app->user->can($event->access)) {
                $events[] = [
                    'title' => $event->contentInfo->name,
                    'start' => $event->start,
                    'stop' => $event->stop,
                    'color' => $event->color,
                    'url' => '/events/' . $event->id,
                ];
            }
        }
        return $events;
    }
} 