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

class News
{
    /**
     * @param $content \app\models\Content
     */
    public static function add($content)
    {
        foreach(Users::active() as $user){
            if(Yii::$app->authManager->checkAccess($user->vid, $content->categoryInfo->access_feed)){
                Notification::add($user->vid, $content->author, $content->id);

               /* Yii::$app->mailer->compose('notification_news.php', ['user' => $user, 'content' => $content])
                    ->setFrom('noreply@va-transaero.ru')
                    ->setTo($user->email)
                    ->setSubject('AFL Group News '.$content->name_en)
                    ->send();*/
            }
        }
    }
} 