<?php

namespace app\components;

use app\models\Flights;
use app\models\Users;

/**
 * Created by PhpStorm.
 * User: nfedoseev
 * Date: 29.08.2016
 * Time: 19:42
 */
class Stats
{
    /**
     * Get all members count
     * @return int
     */
    public static function members(){
        return (int) Users::find()->count();
    }

    /**
     * Get all flights count
     * @return int
     */
    public static function flights(){
        return (int) Flights::find()->count();
    }

    /**
     * Get all paxs count
     */
    public static function paxs(){
        //?
        return 0;
    }

    /**
     * Get all vucs count
     */
    public static function vucs(){
        //?
        return 0;
    }
}