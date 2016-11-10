<?php
/**
 * Created by PhpStorm.
 * User: nfedoseev
 * Date: 10.11.2016
 * Time: 23:26
 */

namespace app\models\Services\notifications;

use Yii;

class Mail
{
    public static function sent($user, $content, $link)
    {
        Yii::$app->mailer->compose('notification_news.php', ['user' => $user, 'content' => $content, 'link' => $link])
            ->setFrom(Yii::$app->params['serverEmail'])
            ->setTo($user->email)
            ->setSubject('VA AFL ' . $content->name_en)
            ->send();
    }
}