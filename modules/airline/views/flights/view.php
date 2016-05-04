<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use app\assets\MapAsset;
use app\models\Users;

/* @var $this yii\web\View */
/* @var $model app\models\Flights */

MapAsset::register($this);
\app\assets\FlightsAsset::register($this);
$this->title = isset($model) ? "{$model->callsign} {$model->from_icao}-{$model->to_icao}" : $user_id ? 'Flights of ' .
    Users::find()->where(['vid' => $user_id])->one()->full_name . " ({$user_id})" : 'Flights';

if ($user_id) {
    $this->params['breadcrumbs'][] = [
        'label' => Yii::$app->user->identity->vid == $user_id ? Yii::t(
                'app',
                'Pilot Center'
            ) : Users::find()->where(['vid' => $user_id])->one()->full_name,
        'url' => [Yii::$app->user->identity->vid == $user_id ? '/pilot/center' : '/pilot/profile']
    ];
}

$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .left {
        position: absolute;
        top: 50px;
        left: 20px;
        z-index: 10;
        width: 500px;
        background-color: rgba(0, 0, 0, 0.7);
    }

    .right {
        position: absolute;
        top: 50px;
        right: 20px;
        z-index: 10;
        width: 450px;
        background-color: rgba(0, 0, 0, 0.7);
    }

    .map {
        position: absolute;
        top: 10px;
        left: 0px;
        right: 0px;
        bottom: 0px;
    }

    .title {
        color: yellow;
        cursor: pointer;
    }

    .relative-map {
        position: relative;
        height: 100%;
    }
    .flightslist{
        max-height: 500px;
        overflow-x: scroll;
    }
</style>
    <div class="relative-map">
        <div class="left panel">
        <div class="panel-header">
        <h4 class="title text-center" data-toggle="flights"><?= Yii::t('app', 'Flights') ?></h4>
        </div>
    <div class="panel-body" id="flights" class="flightslist">
        <?= $this->render('index', ['dataProvider' => $dataProvider, 'from_view' => $this]) ?>
    </div>
</div>
<div class="right panel">
    <div class="panel-heading">
        <h4 class="title text-center" data-toggle="details" id="callsign"><?= Yii::t('flights', 'Flight Information') ?></h4>
    </div>
    <div class="panel-body" id="details">

    </div>
</div>
        <div class="map" id="map" data-flightid="<?= isset($model) ? $model->id : '' ?>"></div>
    </div>
<?php if (isset($init)): ?>
    <script>
        var init = <?= ($init == true ? 'true' : 'false')?>;
    </script>
<?php endif; ?>