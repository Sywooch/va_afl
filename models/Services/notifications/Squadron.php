<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 28.05.16
 * Time: 19:30
 */

namespace app\models\Services\notifications;

use Yii;

use app\models\Users;

class Squadron
{
    const TEMPLATE_JOIN = 1398;

    /**
     * @param $user int VID
     * @param $squad \app\models\Squadrons
     */
    public static function join($user, $squad)
    {
        $array = [
            '[user]' => Users::findOne($user)->full_name,
            '[abbr]' => $squad->abbr,
            '[name_ru]' => $squad->name_ru,
            '[name_en]' => $squad->name_en,
        ];

        Yii::trace(var_export($array, 1));

        Notification::add($user, 0, \app\models\Content::template(self::TEMPLATE_JOIN, $array));
    }
} 