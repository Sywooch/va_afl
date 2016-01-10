<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Flights';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flights-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Flights', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget(
        [
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
                'user_id',
                'booking_id',
                'callsign',
                'first_seen',
                // 'last_seen',
                // 'from_icao',
                // 'to_icao',
                // 'flightplan:ntext',
                // 'remarks:ntext',
                // 'dep_time',
                // 'eet',
                // 'landing_time',
                // 'sim',
                // 'fob',
                // 'pob',
                // 'acf_type',
                // 'fleet_regnum',
                // 'status',
                // 'alternate1',
                // 'alternate2',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]
    ); ?>

</div>