<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Flights */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Flights', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flights-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a(
            'Delete',
            ['delete', 'id' => $model->id],
            [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]
        ) ?>
    </p>

    <?=
    DetailView::widget(
        [
            'model' => $model,
            'attributes' => [
                'id',
                'user_id',
                'booking_id',
                'callsign',
                'first_seen',
                'last_seen',
                'from_icao',
                'to_icao',
                'flightplan:ntext',
                'remarks:ntext',
                'dep_time',
                'eet',
                'landing_time',
                'sim',
                'fob',
                'pob',
                'acf_type',
                'fleet_regnum',
                'status',
                'alternate1',
            ],
        ]
    ) ?>

</div>