<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;

use app\components\Helper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Flights';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flights-index">
    <?php
    if (!$from_view) {
        ?>
        <h1><?= Html::encode($this->title) ?></h1>
        <?php
    }
    ?>
    <div id="flights_grid"  data-scrollbar="true" data-height="350px">
        <?php Pjax::begin() ?>
        <?=
        GridView::widget(
            [
                'dataProvider' => $dataProvider,
                'layout' => (!$from_view)?'{items}{pager}':'{items}',
                'tableOptions' => ($from_view)?['class'=>'table table-bordered']:['class'=>'table table-bordered table-striped table-condensed'],
                'columns' => [
                    [
                        'attribute' => 'callsign',
                        'label' => Yii::t('flights', 'Callsign'),
                        'format' => 'raw',
                        'value' => function ($data) use ($from_view) {
                            if(!empty($data->track))
                            return Html::a(
                                Html::encode($data->callsign),
                                (!$from_view)?
                                Url::to(['/airline/flights/view/' . $data->id]):
                                'javascript:reload('.$data->id.',map)'
                            );
                            return Html::encode($data->callsign);
                        },
                    ],
                    [
                        'attribute' => 'acf_type',
                        'label' => Yii::t('flights', 'Aircraft'),
                        'format' => 'raw',
                        'value' => function ($data) {
                                return Html::a(
                                    Html::encode($data->fleet->type_code),
                                    Url::to(
                                        [
                                            '/airline/fleet/view/'.$data->fleet->id,
                                        ]
                                    ),
                                    [
                                        'data-toggle' => "tooltip",
                                        'data-placement' => "top",
                                        'title' => Html::encode("{$data->fleet->regnum} ({$data->fleet->full_type})")
                                    ]);
                            }
                    ],
                    [
                        'attribute' => 'from_to',
                        'label' => Yii::t('flights', 'Route'),
                        'format' => 'raw',
                        'value' => function ($data) {
                            return Html::a(
                                Html::img(Helper::getFlagLink($data->depAirport->iso)).' '.
                                Html::encode($data->from_icao),
                                Url::to(
                                    [
                                        '/airline/airports/view/',
                                        'id' => $data->from_icao
                                    ]
                                ),
                                [
                                    'data-toggle' => "tooltip",
                                    'data-placement' => "top",
                                    'title' => Html::encode(
                                            $data->depAirport->name
                                        ) . ' (' . $data->depAirport->city . ')'
                                ]
                            ) . ' - ' . Html::a(
                                Html::img(Helper::getFlagLink($data->arrAirport->iso)).' '.
                                Html::encode($data->to_icao),
                                Url::to(['/airline/airports/view/', 'id' => $data->to_icao]),
                                [
                                    'data-toggle' => "tooltip",
                                    'data-placement' => "top",
                                    'title' => Html::encode(
                                            $data->arrAirport->name
                                        ) . ' (' . $data->arrAirport->city . ')'
                                ]
                            );
                        },
                    ],
                    [
                        'attribute' => 'flight_time',
                        'label' => Yii::t('flights', 'Flight Time'),
                        'value' => function ($data) {
                            return Helper::getTimeFormatted($data->flight_time);
                        },
                        'visible' => !$from_view
                    ],
                    [
                        'attribute' => 'first_seen',
                        'label' => Yii::t('app', 'Date'),
                        'format' => ['date', 'php:d.m.Y']
                    ],
                ],
            ]
        ) ?>
        <?php Pjax::end() ?>
    </div>
</div>