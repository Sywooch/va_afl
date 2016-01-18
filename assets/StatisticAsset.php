<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 */
class StatisticAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
        'js/maps/profile.js'
    ];
    public $depends = [
    ];
}
