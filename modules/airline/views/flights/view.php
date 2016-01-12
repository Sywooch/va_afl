<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use app\assets\MapAsset;
use app\models\Users;

/* @var $this yii\web\View */
/* @var $model app\models\Flights */

MapAsset::register($this);
\app\assets\FlightsAsset::register($this);
$this->title = isset($model) ? "{$model->callsign} {$model->from_icao}-{$model->to_icao}" : 'Flights ' . $user_id ? 'of ' . Users::find(
        ['vid' => $user_id]
    )->one()->full_name . " ({$user_id})" : '';

if ($user_id) {
    $this->params['breadcrumbs'][] = [
        'label' => Yii::$app->user->identity->vid == $user_id ? Yii::t(
                'app',
                'Pilot Center'
            ) : Users::find(['vid' => $user_id])->one()->full_name,
        'url' => [Yii::$app->user->identity->vid == $user_id ? 'center' : 'profile']
    ];
}

$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .left {
        position: absolute;
        top: 70px;
        left: 250px;
        z-index: 10;
        width: 350px;
        background-color: rgba(0, 0, 0, 0.7);
        max-height: 350px;
    }

    .right {
        position: absolute;
        bottom: 20px;
        right: 20px;
        z-index: 10;
        width: 450px;
        background-color: rgba(0, 0, 0, 0.7);
    }

    .main {
        position: absolute;
        top: 22px;
        left: 0px;
        right: 1px;
        bottom: 1px;
    }

    .title {
        color: yellow;
        cursor: pointer;
    }
</style>
<div class="left panel">
    <div class="panel-heading">
        <h4 class="title text-center" data-toggle="details" id="callsign"><?=
            isset($model) ? Html::encode(
                $model->callsign
            ) : '' ?></h4>
    </div>
    <div class="panel-body" id="details">

    </div>
</div>
<div class="right panel">
    <div class="panel-header">
        <h4 class="title text-center" data-toggle="flights"><?= Yii::t('app', 'Flights') ?></h4>
    </div>
    <div class="panel-body" id="flights" data-scrollbar="true" data-height="400px">
        <?= $this->render('index', ['dataProvider' => $dataProvider, 'from_view' => $this]) ?>
    </div>
</div>
<div class="main" id="map" data-flightid="<?= isset($model) ? $model->id : '' ?>"></div>

