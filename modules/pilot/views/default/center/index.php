<?php

use app\assets\MapAsset;

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

MapAsset::register($this);

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Pilot Center');
$this->params['breadcrumbs'] = [
    ['label' => Yii::t('app', 'Pilot'), 'url' => '/pilot'],
    ['label' => $this->title]
];

?>
<div id="map" style="width: 500px; height: 400px;"></div>
<script>
    setTimeout(function () {
        initialize(<?= Yii::$app->user->identity->vid ?>);
    },500);
</script>