<?php
/**
 * Created by PhpStorm.
 * User: nfedoseev
 * Date: 13.11.2016
 * Time: 21:35
 */

namespace app\models\Services\notifications\actions;


use app\components\Slack;
use app\models\Services\notifications\Notification;

class Members
{
    const TEMPLATE_ACTIVE = 5013;

    /**
     * @param \app\models\Users $user
     */
    public static function active($user){
        Notification::add($user->vid, 0, self::TEMPLATE_ACTIVE, 'fa-hand-spock-o', 'green');

        $slack = new Slack('#members', "Member {$user->full_name} ({$user->vid}) became active https://va-afl.su/pilot/profile/{$user->vid}");
        $slack->sent();
    }

    /**
     * @param \app\models\Users $user
     */
    public static function inactive($user)
    {
        $slack = new Slack('#members', "Member {$user->full_name} ({$user->vid}) became inactive https://va-afl.su/pilot/profile/{$user->vid}");
        $slack->sent();
    }
}