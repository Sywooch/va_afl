<?php
namespace app\components;

use yii\base\Component;
use \app\models\Isocodes;

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
    public static function getCountryCode($countrycode)
    {
        $country =Isocodes::find()->where(['code'=>$countrycode])->one();
        return $country->country;
    }
}