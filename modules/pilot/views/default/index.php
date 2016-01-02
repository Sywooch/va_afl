<?php
use app\assets\MapAsset;

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

MapAsset::register($this);

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'My Statistics');
$this->params['breadcrumbs'] = [
    ['label' => Yii::t('app', 'Pilot Center'), 'url' => '/pilot/center'],
    ['label' => $this->title]
];

?>

<h1><?= Html::encode($this->title) ?></h1>
<div class="row">
    <div class="col-md-8">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">Map</h4>
            </div>
            <div class="panel-body">
                <div id="map" style="width: 1000px; height: 670px;"></div>
                <script>
                    setTimeout(function () {
                        initialize(<?= Yii::$app->user->identity->vid ?>);
                    }, 500);
                </script>
            </div>
        </div>
    </div>
</div>