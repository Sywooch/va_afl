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

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    GridView::widget(
        [
            'dataProvider' => $dataProvider,
            'layout' => '{items}{pager}',
            'options' => ['class' => 'table table-condensed'],
            'columns' => [
                [
                    'attribute' => 'callsign',
                    'label' => Yii::t('flights', 'Callsign'),
                    'format' => 'raw',
                    'value' => function ($data) {
                            return Html::a(
                                Html::encode($data->callsign),
                                Url::to(['/airline/flights/view/' . $data->id])
                            );
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
                        }
                ],
                [
                    'attribute' => 'first_seen',
                    'label' => Yii::t('app', 'Date'),
                    'format' => ['date', 'php:d.m.Y']
                ],
            ],
        ]
    ) ?>
</div>