<?php
namespace app\components;

use Yii;
use yii\base\Component;
use \app\models\Isocodes;
use app\models\Flights;

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
        return "/img/flags/countries/16x11/" . strtolower($countrycode) . ".png";
    }

    public static function getCountryCode($countrycode)
    {
        $country = Isocodes::find()->where(['code' => $countrycode])->one();
        return $country->country;
    }

    public static function getTimeFormatted($time)
    {
        $seconds = $time % 60;
        $time = ($time - $seconds) / 60;
        $minutes = $time % 60;
        $hours = ($time - $minutes) / 60;
        return $hours . ' ' . Yii::t('user', 'Hours') . ' ' . $minutes . ' ' . Yii::t('user', 'Minutes');
    }

    public static function getWhazzup()
    {
        $key = "whazzupdata";
        if (!$data = \Yii::$app->cache->get($key)) {
            $data = file_get_contents('http://api.ivao.aero/getdata/whazzup');
            \Yii::$app->cache->set($key, $data, 180);
        }
        return $data;
    }

    public static function calculateDistanceLatLng($lat1, $lat2, $lon1, $lon2)
    {
        $R = 3443.9; // nm
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2.0) * sin($dLat / 2.0) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2.0) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $R * $c;
    }

    public static function getWeekDayFromNumber($day)
    {
        $array = [
            1 => 'Mon.',
            2 => 'Tue.',
            3 => 'Wed.',
            4 => 'Thu.',
            5 => 'Fri.',
            6 => 'Sat.',
            7 => 'Sun.'
        ];
        return $array[$day];
    }
}
