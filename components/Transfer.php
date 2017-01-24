<?php
/**
 * Created by PhpStorm.
 * User: nfedoseev
 * Date: 07.01.2017
 * Time: 9:02
 */

namespace app\components;


use app\models\Fleet;
use app\models\Users;

class Transfer
{
    public static function transferPilot($user_id, $to)
    {
        Users::transfer($user_id, $to);
    }

    public static function transferCraft($fleet_regnum, $landing, $user_id = 0)
    {
        Fleet::transfer($fleet_regnum, $landing, $user_id);
    }
}