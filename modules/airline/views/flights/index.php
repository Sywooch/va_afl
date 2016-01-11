<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

use app\components\Helper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Flights';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flights-index">
    <?php
    if (!isset($from_view)) {
        ?>
        <h1><?= Html::encode($this->title) ?></h1>
        <?php
    }
    ?>
    <div id="flights">
        <?=
        GridView::widget(
            [
                'dataProvider' => $dataProvider,
                'layout' => (!isset($from_view))?'{items}{pager}':'{items}',
                'tableOptions' => (isset($from_view))?['class'=>'table table-bordered']:['class'=>'table table-bordered table-striped table-condensed'],
                'columns' => [
                    [
                        'attribute' => 'callsign',
                        'label' => Yii::t('flights', 'Callsign'),
                        'format' => 'raw',
                        'value' => function ($data) {
                            if(!empty($data->track))
                            return Html::a(
                                Html::encode($data->callsign),
                                Url::to(['/airline/flights/view/' . $data->id])
                            );
                            return Html::encode($data->callsign);
                        },
                    ],
                    'acf_type',
                    [
                        'attribute' => 'from_to',
                        'label' => Yii::t('flights', 'Route'),
                        'format' => 'raw',
                        'value' => function ($data) {
                            return Html::a(
                                Html::encode($data->from_icao),
                                Url::to(
                                    [
                                        '/airline/airports/view/',
                                        'id' => $data->from_icao
                                    ]
                                )
                            ) . '-' . Html::a(
                                Html::encode($data->to_icao),
                                Url::to(['/airline/airports/view/', 'id' => $data->to_icao])
                            );
                        },
                    ],
                    [
                        'attribute' => 'flight_time',
                        'label' => Yii::t('flights', 'Flight Time'),
                        'value' => function ($data) {
                            return Helper::getTimeFormatted($data->flight_time);
                        },
                        'visible' => !isset($from_view)
                    ],
                    [
                        'attribute' => 'first_seen',
                        'label' => Yii::t('app', 'Date'),
                        'format' => ['date', 'php:d.m.Y'],
                        'visible' => !isset($from_view)
                    ],
                ],
            ]
        ) ?>
    </div>
</div>