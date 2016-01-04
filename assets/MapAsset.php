<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 */
class MapAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
        'js/maps/profile.js',
        'https://maps.googleapis.com/maps/api/js?v=3.exp?key=AIzaSyCPS9tJyG2KhyAMjWgGONE8v-3qnCjB-Os&sensor=true&libraries=weather'
    ];
    public $depends = [
    ];
}
