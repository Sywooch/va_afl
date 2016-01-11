<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use app\assets\MapAsset;

/* @var $this yii\web\View */
/* @var $model app\models\Flights */

MapAsset::register($this);
\app\assets\FlightsAsset::register($this);
$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Flights', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .left {
        position: absolute;
        top: 70px;
        left: 250px;
        z-index: 10;
        width: 350px;
        min-height: 400px;
        background-color: rgba(0,0,0,0.7);
    }

    .main {
        position: absolute;
        top: 22px;
        left: 0px;
        right: 1px;
        bottom: 1px;
    }

</style>
<div class="left panel">
    <div class="panel-heading">
        <h1><?= Html::encode($model->callsign) ?></h1>
    </div>
    <div class="panel-body">
        <?=
        //TODO: все дела красота
        DetailView::widget(
            [
                'model' => $model,
                'options' => ['class'=>'table table-bordered table-condensed'],
                'attributes' => [
                    'callsign',
                    'user_id',
                    'first_seen',
                    'last_seen',
                    'from_icao',
                    'to_icao',
                ],
            ]
        ) ?>
    </div>
</div>
<div class="main" id="map" data-flightid="<?=$model->id?>"></div>
