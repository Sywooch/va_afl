<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 15.02.16
 * Time: 12:33
 */

namespace app\models\Events;

use app\models\Content;
use app\components\Slack;
use app\models\Log;

class ExternalEvent
{
    /**
     * Старый ли это эвент
     * @var bool
     */
    private $old;
    /**
     * Название на англ.
     * @var string
     */
    private $name;
    /**
     * Эвент
     * @var app\models\Events
     */
    private $event;

    /**
     * процесс добавления
     * @param $evt Класс с данными
     */
    public function __construct($evt)
    {
        $this->old = $this->checkContent($evt);
        //если контента нет
        if (!$this->old) {
            //добавляем в лог
            Log::action($evt->eevent, 'create', 'events', 'div', '', serialize($evt), 1);

            //сохраняем контент
            $content = $this->saveContent($evt);

            //сохраняем эвент
            $event = $this->saveEvent($evt, $content);

            $this->event = $event;
            //сохраняем условия эвента
            //$eventConditions =  $this->saveEventConditions($evt, $event);
            return true;
        }
    }

    public function slack($channel)
    {
        if (!$this->old) {
            $slack = new Slack($channel, 'New Event - ');
            $slack->addLink('http://dev.va-aeroflot.su/events/' . $this->event, $this->name);
            $slack->sent();
        }
    }

    /**
     * Проверка существования контента для эвента
     * @param $evt Класс с данными
     * @return bool
     */
    private function checkContent($evt)
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
    private function saveEventConditions($evt, $event_id)
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
    private function saveEvent($evt, $content)
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
    private function saveContent($evt)
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

        $this->name = $content->name_en;

        return $content->id;
    }
} 