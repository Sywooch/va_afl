<?php

namespace app\assets;

use yii\web\AssetBundle;

class OnlineTableAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/css/online_table/air-table.css'
    ];
    public $js = [
        '/js/online_table/base.js',
        '/js/online_table/wow.js',
    ];
    public $depends = [
    ];
}
