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
    public static function transferPilot($user_id, $landing)
    {
        Users::transfer($user_id, $landing);
    }

    public static function transferCraft($fleet_regnum, $landing)
    {
        Fleet::transfer($fleet_regnum, $landing);
    }
}