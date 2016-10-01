<?php
use app\assets\PilotFlightsMapAsset;
use app\components\Helper;
use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use dosamigos\highcharts\HighCharts;
use yii\helpers\BaseVarDumper;
use yii\widgets\DetailView;

$this->title = Yii::t('app', 'Statistics');
$this->params['breadcrumbs'] = [
    ['label' => Yii::t('app', 'Pilot Center'), 'url' => '/pilot/center'],
    ['label' => $this->title]
]; ?>

<?= Tabs::widget([
    'items' => [
        [
            'label' => Yii::t('app', 'Information'),
            'content' => $this->render('../profile/info', ['user' => $user], false, true),
            'active' => true
        ],
        [
            'label' => Yii::t('app', 'Graphs'),
            'content' =>  $this->render('../profile/graphs', ['user' => $user], false, true),
            'active' => false
        ],
        [
            'label' => Yii::t('app', 'Map'),
            'content' => $this->render('../profile/map', ['id' => Yii::$app->user->id], false, true),
            'active' => false
        ],
    ]
]) ?>