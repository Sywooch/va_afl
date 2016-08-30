<?php

namespace app\components;

use app\models\BillingUserBalance;
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
     * @return int
     */
    public static function paxs(){
        return (int)Flights::find()->sum('pob');
    }

    /**
     * Get all vucs count
     * @return int
     */
    public static function vucs(){
        return (int)BillingUserBalance::find()->where('user_vid > 0')->sum('balance');
    }

    /**
     * Get all distance from flights
     * @return int
     */
    public static function nm()
    {
        return (int)Flights::find()->sum('nm');
    }
}