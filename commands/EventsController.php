<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 15.02.16
 * Time: 12:28
 */
class ParseController extends Controller
{
    private function getDivisionEvents()
    {
        if (!\Yii::$app->cache->get('ru_div_events')) {
            $edata = json_decode(
                file_get_contents('http://ivaoru.org/api/futureevents?key=149b1f2f758e4ffa9ff0dec3b6a1e81a')
            );
            if (isset($edata->errorMessage) or empty($edata)) {
                return false;
            }
            \Yii::$app->cache->set('ru_div_events', $edata, 3600);
            foreach ($edata->events as $evt) {
                ExternalEvents::add($evt);
            }
        }
    }