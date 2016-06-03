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
    /**
     * @param $user
     * @param $content
     * @param $template
     */
    public static function like($user, $content, $template)
    {
        $array = [
            '[user]' => Users::findOne($user)->full_name,
            '[content_name_en]' => $content->name_en,
            '[content_name_ru]' => $content->name_ru,
            '[link]' => '/'.($content->category == 16 ? 'screens' : 'content').'/view/'.$content->id,
        ];

        Yii::trace(var_export($array, 1));

        Notification::add($content->author,$user, \app\models\Content::template($template, $array));
    }
} 