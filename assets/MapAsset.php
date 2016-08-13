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
        'https://maps.googleapis.com/maps/api/js?key=AIzaSyBUjqLo07DhgO3zXdBLoe2abvDmMaxVwVs',
        'https://cdn.rawgit.com/googlemaps/v3-utility-library/master/markermanager/src/markermanager_packed.js',
        '/js/maps/fontawesome-markers.min.js',
        '/js/maps/initializelayers.js'
    ];
    public $depends = [
    ];
}
