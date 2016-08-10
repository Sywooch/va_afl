<?php
/**
 * Created by PhpStorm.
 * User: nfedoseev
 * Date: 10.08.2016
 * Time: 5:48
 */

namespace app\modules\items\models;


use app\models\Items\Items;

class Shop extends Items
{
    public static function all()
    {
        return self::find()->groupBy('type_id')->all();
    }

    public function getAvailableItemsCount()
    {
        return self::find()->where(['type_id' => $this->type_id, 'available' => 1])->count();
    }

    public static function lastAvailable(){
        return self::find()->where(['available' => 1])->orderBy('created desc')->limit(5)->all();
    }
}