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
}