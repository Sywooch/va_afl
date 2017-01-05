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
     * @var app\models\Events\Events
     */
    private $event;

    /**
     * процесс добавления
     * @param $evt Класс с данными
     */
    public function __construct($evt, $type = '')
    {
        $this->old = $this->checkContent($evt);
        //если контента нет
        if (!$this->old) {
            //добавляем в лог
            //Log::action($evt->eevent, 'create', 'events', $type, '', serialize($evt), 0);

            //сохраняем контент
            $content = $this->saveContent($evt);

            //сохраняем эвент
            $event = $this->saveEvent($evt, $content);

            $this->event = $event;
            $this->linkContent(Content::findOne(['id' => $content]), $event);
            //сохраняем условия эвента
            //$eventConditions =  $this->saveEventConditions($evt, $event);
            return true;
        }
    }

    public function slack($channel)
    {
        if (!$this->old) {
            if (!empty($this->event) && !empty($this->name)) {
                $slack = new Slack($channel, 'New Event - ');
                $slack->addLink('http://va-afl.su/events/' . $this->event, $this->name);
                $slack->sent();
            }
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

        if (isset($evt->airport)) {
            $event->to = $evt->airport;
            $event->airbridge = 1;
        }

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

        if(!empty($evt->eevent)){
            $content->name_en = $evt->eevent;
        }else{
            $content->name_en = $evt->event;
        }

        $content->text_ru = $evt->description;
        if(!empty($evt->edescription)){
            $content->text_en = $evt->edescription;
        }else{
            $content->text_en = $evt->description;
        }

        $content->img = $evt->banner;
        $content->category = Events::CONTENT_CATEGORY;
        $content->created = date('Y-m-d H:i:s');

        $content->save();

        $this->name = $content->name_en;

        return $content->id;
    }

    /**
     * @param $content \app\models\Content
     * @param $event \app\models\Events\Events
     */
    private function linkContent($content, $event){
        $content->site = '/events/'.$event->id;
        $content->save();
    }
} 