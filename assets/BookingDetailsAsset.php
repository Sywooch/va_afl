<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 */
class BookingDetailsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
        '/js/maps/booking_details.js'
    ];
    public $depends = [
    ];
}
