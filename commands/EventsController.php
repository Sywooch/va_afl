<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 15.02.16
 * Time: 12:28
 */
namespace app\commands;

use Yii;
use yii\console\Controller;

use app\models\Events\ExternalEvent;

class EventsController extends Controller
{
    public function actionIndex()
    {
        $this->getIVAOEvents();
        $this->getDivisionEvents();
    }

    private function getIVAOEvents()
    {
        if (!\Yii::$app->cache->get('ivao_events')) {
            $rss = simplexml_load_string(
                str_replace("dc:date", "date", file_get_contents(Yii::$app->params['ivao_rss']))
            );

            foreach ($rss as $key => $item) {
                if ($key == 'item') {

                    $title = explode(" - ", $item->title);

                    $name = (string)(strripos($title[0], "online") !== false ? $title[0]." ".$item->date : $title[0]);

                    $description = $item->description;
                    $url = "<a href=\"{$item->link}\">More info</a><br>";

                    $date_start = $item->date;
                    $date_stop = $date_start;

                    //жесть
                    $start_time = explode(" ", $title[1])[1];

                    $temp = explode(":", explode(" ", $title[1])[1])[0] + 4;

                    if($temp >= 24){
                        $temp = 24 - $temp;
                    }

                    $stop_time = ($temp).":"."00";

                    $event = (object)[
                        'event' => $name,
                        'eevent' => $name,
                        'date' => (string)$item->date,
                        'fromUTC' => $start_time,
                        'toUTC' => $stop_time,
                        'description' => (string)$url." ".$item->description,
                        'edescription' => (string)$url." ". $item->description,
                        'banner' => '',
                        'engbanner' => ''
                    ];

                    $event = new ExternalEvent($event, 'ivao');
                }
            }

            \Yii::$app->cache->set('ivao_events', var_export($rss, true), 3600);
        }
    }

    /**
     * Функция забирает эвенты дивизиона
     */
    private function getDivisionEvents()
    {
        if (!\Yii::$app->cache->get('ru_div_events')) {
            /*
             $data = '{"events" : [{
              "id":122,
              "event":"Test123",
              "eevent":"Test123",
              "date":"21.2.2016",
              "fromUTC":"12:20:00",
              "toUTC":"19:00:00",
              "description":"123",
              "edescription":"122",
              "banner":"https://pp.vk.me/c629517/v629517055/32ab9/zwnEErBSNG0.jpg",
              "engbanner":"https://pp.vk.me/c629517/v629517055/32ab9/zwnEErBSNG0.jpg"
               }]}';
            */

            $data = file_get_contents(Yii::$app->params['ivaoru_api_url']);

            //скачиваем данные
            $edata = json_decode($data);

            //проверяем есть ли они
            if (isset($edata->errorMessage)) {
                throw new \Exception($edata->errorMessage);
            }

            if(!empty($edata)){
                //ставим кэш
                \Yii::$app->cache->set('ru_div_events', $edata, 3600);

                //прогоняем
                foreach ($edata->events as $evt) {
                    $event = new ExternalEvent($evt, 'div');
                    $event->slack('#events');
                }
            }
        }
    }
}