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
        $this->getDivisionEvents();
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
            if (isset($edata->errorMessage) or empty($edata)) {
                throw new \Exception(isset($edata->errorMessage) ? $edata->errorMessage : 'empty data');
            }

            //ставим кэш
            \Yii::$app->cache->set('ru_div_events', $edata, 3600);

            //прогоняем
            foreach ($edata->events as $evt) {
                $event = new ExternalEvent($evt);
                $event->slack('#events');
            }
        }
    }
}