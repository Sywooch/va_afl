<?php
/**
 * Created by PhpStorm.
 * User: nfedoseev
 * Date: 13.11.2016
 * Time: 21:35
 */

namespace app\models\Services\notifications\actions;


use app\components\Slack;
use app\models\Services\notifications\Content;
use app\models\Services\notifications\Mail;
use app\models\Services\notifications\Notification;
use app\models\Users;

class Members
{
    const TEMPLATE_ACTIVE = 5013;
    const TEMPLATE_UNLOCK = 5149;
    const TEMPLATE_LOCK = 5150;

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

    public static function block($pilot, $author)
    {
        $user = Users::findOne(['vid' => $pilot->user_id]);

        switch($pilot->avail_booking){
            case 1:
                $slack = new Slack('#members', "Booking unlocked member {$user->full_name} ({$user->vid}) https://va-afl.su/pilot/profile/{$user->vid}");
                Notification::add($user->vid, $author, self::TEMPLATE_UNLOCK, 'fa-glass', 'green');
                Mail::sent($user, \app\models\Content::findOne(['id' => self::TEMPLATE_UNLOCK]), '/pilot/center');
                break;
            case 0:
                $slack = new Slack('#members', "Booking locked for member {$user->full_name} ({$user->vid}) https://va-afl.su/pilot/profile/{$user->vid}");
                Notification::add($user->vid, $author, self::TEMPLATE_LOCK, 'fa-bomb', 'orange');
                Mail::sent($user, \app\models\Content::findOne(['id' => self::TEMPLATE_LOCK]), '/pilot/center');
                break;
            default:
                $slack = new Slack('#members', "@n_fedoseev, error status for member {$user->full_name} ({$user->vid})");
        }

        $slack->sent();
    }
}