<?php
/**
 * Created by PhpStorm.
 * User: nfedoseev
 * Date: 10.11.2016
 * Time: 23:01
 */

namespace app\models\Services\notifications;

use Yii;

use app\models\Users;

class Notifications
{
    /**
     * @param $content \app\models\Content
     */
    public static function add($content)
    {
        set_time_limit(0);
        foreach (Users::active() as $user) {
            if (Yii::$app->authManager->checkAccess($user->vid, $content->categoryInfo->access_feed)) {
                Notification::add($user->vid, $content->author, $content->id);
            }
        }
    }
}