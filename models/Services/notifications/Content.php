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

class Content
{
    const TEMPLATE_LIKE = 601;
    const TEMPLATE_COMMENT = 668;

    /**
     * @param $user
     * @param $content
     */
    public static function like($user, $content)
    {
        $array = [
            '[user]' => Users::findOne($user)->full_name,
            '[content_name_en]' => $content->name_en,
            '[content_name_ru]' => $content->name_ru,
            '[link]' => $content->contentLink,
        ];

        Yii::trace(var_export($array, 1));

        Notification::add($content->author,$user, \app\models\Content::template(self::TEMPLATE_LIKE, $array));
    }

    /**
     * @param $user
     * @param $content
     * @param $text
     * @param $to
     */
    public static function comment($user, $content, $text, $to = 0)
    {
        $array = [
            '[user]' => Users::findOne($user)->full_name,
            '[content_name_en]' => $content->name_en,
            '[content_name_ru]' => $content->name_ru,
            '[text]' => $text,
            '[link]' => $content->contentLink,
        ];

        Yii::trace(var_export($array, 1));

        Notification::add($to == 0 ? $content->author : $to, $user, \app\models\Content::template(self::TEMPLATE_COMMENT, $array));
    }
} 