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
        'http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerwithlabel/src/markerwithlabel.js',
        '/js/maps/fontawesome-markers.min.js',
        '/js/maps/initializelayers.js'
    ];
    public $depends = [
    ];
}
