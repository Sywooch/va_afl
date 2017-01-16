<?php
/**
 * Created by PhpStorm.
 * User: nfedoseev
 * Date: 08.01.2017
 * Time: 23:33
 */
use app\components\Helper;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = Yii::t('app', 'Logbook');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t(
        'app',
        'Flights of ' . $user->full_name
    ),
    'url' => ['/pilot/profile/' . $user->vid]
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-12">
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title"><?= Yii::t('app', 'Logbook') ?></h4>
        </div>
        <div class="panel-body">
            <?php Pjax::begin(); ?>
            <?=
            GridView::widget(
                [
                    'dataProvider' => $flightsProvider,
                    'layout' => '{items}{pager}',
                    'tableOptions' => ['class' => 'table table-bordered table-striped table-condensed'],
                    'columns' => [
                        [
                            'attribute' => 'internal_id',
                            'label' => Yii::t('flights', 'ID'),
                            'format' => 'raw',
                            'value' => function ($data) {
                                return Html::encode($data->id);
                            },
                        ],
                        [
                            'attribute' => 'callsign',
                            'label' => Yii::t('flights', 'Callsign'),
                            'format' => 'raw',
                            'value' => function ($data) {
                                if (!empty($data->track)) {
                                    return Html::a(
                                        Html::encode($data->callsign),
                                        Url::to(['/airline/flights/view/' . $data->id]),
                                        ['target' => '_blank']
                                    );
                                }
                                return Html::encode($data->callsign);
                            },
                        ],
                        [
                            'attribute' => 'acf_type',
                            'label' => Yii::t('flights', 'Aircraft'),
                            'format' => 'raw',
                            'value' => function ($data) {
                                return $data->fleet ? Html::a(
                                    Html::encode($data->fleet->regnum) . " (" . Html::encode($data->fleet->type_code) . ")",
                                    Url::to(
                                        [
                                            '/airline/fleet/view/' . $data->fleet->id,
                                        ]
                                    ),
                                    [
                                        'target' => '_blank',
                                        'data-toggle' => "tooltip",
                                        'data-placement' => "top",
                                        'title' => Html::encode("{$data->fleet->full_type}")
                                    ]) : '';
                            }
                        ],
                        [
                            'attribute' => 'user.full_name',
                            'label' => Yii::t('flights', 'Pilot'),
                            'format' => 'raw',
                            'value' => function ($data) {
                                return Html::img(Helper::getFlagLink($data->user->country)) . ' ' . Html::a(
                                    Html::encode($data->user->full_name),
                                    Url::to(
                                        [
                                            '/pilot/profile/',
                                            'id' => $data->user_id
                                        ]
                                    ),
                                    ['target' => '_blank']);
                            }
                        ],
                        [
                            'attribute' => 'from_to',
                            'label' => Yii::t('flights', 'Route'),
                            'format' => 'raw',
                            'value' => function ($data) {
                                return ($data->depAirport ? Html::a(
                                    Html::img(Helper::getFlagLink($data->depAirport->iso)) . ' ' .
                                    Html::encode($data->from_icao),
                                    Url::to(
                                        [
                                            '/airline/airports/view/',
                                            'id' => $data->from_icao
                                        ]
                                    ),
                                    [
                                        'target' => '_blank',
                                        'data-toggle' => "tooltip",
                                        'data-placement' => "top",
                                        'title' => Html::encode("{$data->depAirport->name} ({$data->depAirport->city}, {$data->depAirport->iso})")
                                    ]
                                ) : $data->from_icao) . ' - ' . ($data->arrAirport ? Html::a(
                                    Html::img(Helper::getFlagLink($data->arrAirport->iso)) . ' ' .
                                    Html::encode($data->to_icao),
                                    Url::to(['/airline/airports/view/', 'id' => $data->to_icao]),
                                    [
                                        'target' => '_blank',
                                        'data-toggle' => "tooltip",
                                        'data-placement' => "top",
                                        'title' => Html::encode("{$data->arrAirport->name} ({$data->arrAirport->city}, {$data->arrAirport->iso})")
                                    ]
                                ) : $data->to_icao);
                            },
                        ],
                        [
                            'attribute' => 'flight_time',
                            'label' => Yii::t('flights', 'Flight Time'),
                            'value' => function ($data) {
                                return Helper::getTimeFormatted($data->flight_time);
                            },
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
</div>