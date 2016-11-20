<?php
/**
 * Created by PhpStorm.
 * User: nfedoseev
 * Date: 20.11.2016
 * Time: 5:06
 */

namespace app\models\Flights\ops;

use yii\helpers\ArrayHelper;

use app\models\Content;
use app\models\Schedule;

class ScheduleUpdate
{
    const CONTENT_NEWS = 5328;

    public function __construct()
    {
        $new = Schedule::find()->where(['DATE(added)' => gmdate("Y-m-d")]);
        $array = [
            '[date]' => gmdate("d.m.Y"),
            '[count]' => $new->count(),
            '[where]' => $this->prepareList(ArrayHelper::getColumn($new->groupBy('arr')->all(), 'arr')),
        ];

        Content::template(self::CONTENT_NEWS, $array, 40);
    }

    private function prepareList($array){
        $text = '';
        foreach($array as $item){
            $text .= '<li>'.$item.'</li>';
        }
        return $text;
    }
}