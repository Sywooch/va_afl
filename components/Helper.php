<?php
/**
 * Created by PhpStorm.
 * User: BTH
 * Date: 24.09.15
 * Time: 22:01
 */
namespace app\components;

use yii\base\Component;

/**
 * Class Helper
 * @package yii\components
 */
class Helper extends Component
{
    /**
     * @param $countrycode
     * @return string
     */
    public static function getFlagLink($countrycode)
    {
        return "/img/flags/countries/16x11/".strtolower($countrycode).".png";
    }
    public static function getWhazzup()
    {
        $key="whazzupdata";
        if(!$data = \Yii::$app->cache->get($key))
        {
            $data = file_get_contents('http://api.ivao.aero/getdata/whazzup');
            \Yii::$app->cache->set($key,$data,180);
        }
        return $data;
    }
    public static function calculateDistanceLatLng($lat1,$lat2,$lon1,$lon2)
    {
        $R = 3443.9; // nm
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2.0) * sin($dLat / 2.0) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2.0) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $R * $c;
    }
}
