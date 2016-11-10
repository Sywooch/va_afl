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
        $link = '/news/' . $content->categoryInfo->link . '/' . $content->link;
        set_time_limit(0);
        foreach (Users::active() as $user) {
            if (Yii::$app->authManager->checkAccess($user->vid, $content->categoryInfo->access_feed)) {
                if (!empty($user->email) && $user->mail == 1) {
                    try {
                        Mail::sent($user, $content, $link);
                    } catch (\Exception $ex) {

                    }
                }
            }
        }
    }
} 