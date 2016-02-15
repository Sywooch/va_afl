<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 15.02.16
 * Time: 12:33
 */

namespace app\models\Events;

use app\models\Content;

class ExternalEvents
{
    public static function add($evt)
    {
        if (self::checkContent($evt)) {
            $content = self::saveContent($evt);
            $event = self::saveEvent($evt, $content);
            $eventConditions = self::saveEventConditions($evt, $event);
        }
    }

    private static function checkContent($evt)
    {
        return Content::find()->andWhere(['=', 'name_ru', $evt->event])->andWhere(
            ['=', 'category_id', Events::CONTENT_CATEGORY]
        )->one();
    }

    private static function saveEventConditions($evt, $event_id)
    {
        $eventCondition1 = new EventsConditions();
        $eventCondition1->event_id = $event_id;
        $eventCondition1->variable = 'from_icao';
        $eventCondition1->value = $evt->airport;
        $eventCondition1->save;
    }

    private static function saveEvent($evt, $content)
    {
        $event = new Events();
        $event->start = date('Y-m-d H:i:s', strtotime($evt->date . " " . $evt->fromUTC));
        $event->stop = date('Y-m-d H:i:s', strtotime($evt->date . " " . $evt->toUTC));
        $event->content = $content;
        $event->save();
        return $event->id;
    }

    private static function saveContent($evt)
    {
        $content = new Content();

        $content->name = $evt->event;
        $content->eng_name = $evt->eevent;
        $content->text_ru = $evt->description;
        $content->text_en = $evt->edescription;
        $content->img = $evt->engbanner;
        $content->save();

        return $content->id;
    }
} 