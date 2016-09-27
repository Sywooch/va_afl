<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 */
class PilotFlightsMapAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
        'https://maps.googleapis.com/maps/api/js?key=AIzaSyBUjqLo07DhgO3zXdBLoe2abvDmMaxVwVs',
        '/js/maps/profile.js'
    ];
    public $depends = [
    ];
}
