<?php
namespace app\components;

use app\models\Airports;
use app\models\Billing;
use Yii;
use yii\base\Component;

use app\models\Isocodes;
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

    public static function getAvatarLink($avatar){
        return "/img/avatars/".$avatar;
    }

    public static function getCountryCode($countrycode)
    {
        $country = Isocodes::find()->where(['code' => $countrycode])->one();
        return $country->country;
    }

    public static function getTimeFormatted($time)
    {
        $hours = floor($time/60);
        $minutes = $time - $hours*60;
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
            0 => 'Mon.',
            1 => 'Tue.',
            2 => 'Wed.',
            3 => 'Thu.',
            4 => 'Fri.',
            5 => 'Sat.',
            6 => 'Sun.'
        ];
        return $array[$day];
    }
    public static function calcTaxiPrice($from,$to)
    {
        $apfrom = Airports::find()->andWhere(['icao'=>$from])->one();
        $apto = Airports::find()->andWhere(['icao'=>$to])->one();
        $nms = self::calculateDistanceLatLng($apfrom->lat,$apto->lat,$apfrom->lon,$apto->lon);
        $priceforone = Billing::findOne(2)->base_cost * 3;
        return ceil($nms*$priceforone);
    }

    public static function dec2deg($dec, $dct)
    {
        $diretions = ['lat' => ['N', 'S'], 'lon' => ['E', 'W']];
        $direction = $diretions[$dct];
        $dir = ($dec < 0) ? $direction[1] : $direction[0];
        $dec = ($dec < 0) ? -$dec : $dec;
        $deg = intval($dec);
        $mns = ($dec - $deg) * 60;
        $scs = round(($mns - intval($mns)) * 60);
        $mns = intval($mns);

        return "$dir" . $deg . '° ' . $mns . '′ ' . $scs . '″';
    }

    public static function time2seconds($time='00:00:00')
    {
        list($hours, $mins, $secs) = explode(':', $time);
        return ($hours * 3600 ) + ($mins * 60 ) + $secs;
    }
}
