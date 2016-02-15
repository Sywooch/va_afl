<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 15.02.16
 * Time: 12:33
 */

namespace app\models\Events;

use app\models\Content;
use yii\helpers\BaseVarDumper;

class ExternalEvent
{
    /**
     * процесс добавления
     * @param $evt Класс с данными
     */
    public static function add($evt)
    {
        //если контента нет
        if (!self::checkContent($evt)) {
            //сохраняем контент
            $content = self::saveContent($evt);
            //сохраняем эвент
            $event = self::saveEvent($evt, $content);
            //сохраняем условия эвента
            //$eventConditions = self::saveEventConditions($evt, $event);
        }
    }

    /**
     * Проверка существования контента для эвента
     * @param $evt Класс с данными
     * @return bool
     */
    private static function checkContent($evt)
    {
        return Content::find()->andWhere(['=', 'name_ru', $evt->event])->andWhere(
            ['=', 'category', Events::CONTENT_CATEGORY]
        )->one() ? true : false;
    }

    /**
     * Сохранение условий эвента
     * @param $evt Класс с данными
     * @param int $event_id ID Эвента
     */
    private static function saveEventConditions($evt, $event_id)
    {
        $eventCondition1 = new EventsConditions();
        $eventCondition1->event_id = $event_id;
        $eventCondition1->variable = 'from_icao';
        $eventCondition1->value = $evt->airport;

        $eventCondition1->save;
    }

    /**
     * Сохранение эвента
     * @param $evt Класс с данными
     * @param int $content ID Контента
     * @return int ID Эвента
     */
    private static function saveEvent($evt, $content)
    {
        $event = new Events();

        $event->start = date('Y-m-d H:i:s', strtotime($evt->date . " " . $evt->fromUTC));
        $event->stop = date('Y-m-d H:i:s', strtotime($evt->date . " " . $evt->toUTC));
        $event->content = $content;
        $event->author = 0;
        $event->save();

        return $event->id;
    }

    /**
     * Сохранение контента
     * @param $evt Класс с данными
     * @return int ID Контента
     */
    private static function saveContent($evt)
    {
        $content = new Content();

        $content->name_ru = $evt->event;
        $content->name_en = $evt->eevent;
        $content->text_ru = $evt->description;
        $content->text_en = $evt->edescription;
        $content->img = $evt->engbanner;
        $content->category = Events::CONTENT_CATEGORY;
        $content->created = date('Y-m-d H:i:s');
        $content->save();

        return $content->id;
    }
} 