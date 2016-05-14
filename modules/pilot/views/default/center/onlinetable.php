<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 10.01.16
 * Time: 21:00
 */

use app\components\Helper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

?>
<!-- begin panel -->
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title"><?= Yii::t('app', 'Online Table') ?> <span class="label label-success pull-right"><?= $onlineProvider->getTotalCount() ?> Online</span>
        </h4>
    </div>
    <div class="panel-body bg-silver">
        <?=
        GridView::widget(
            [
                'dataProvider' => $onlineProvider,
                'layout' => '{items}{pager}',
                'options' => ['class' => 'time-table table table-striped table-bordered'],
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
                    [
                        'attribute' => 'user.full_name',
                        'label' => Yii::t('flights', 'Pilot'),
                        'format' => 'raw',
                        'value' => function ($data) {
                                return Html::img(Helper::getFlagLink($data->user->country)).' '.Html::a(
                                    Html::encode($data->user->full_name),
                                    Url::to(
                                        [
                                            '/pilot/profile/',
                                            'id' => $data->user_id
                                        ]
                                    ));

                            }
                    ],
                    [
                        'attribute' => 'acf_type',
                        'label' => Yii::t('flights', 'Type'),
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
                                        'title' => Html::encode("{$data->depAirport->name} ({$data->depAirport->city}, {$data->depAirport->iso})")
                                    ]
                                ) . ' - ' . Html::a(
                                    Html::img(Helper::getFlagLink($data->arrAirport->iso)).' '.
                                    Html::encode($data->to_icao),
                                    Url::to(['/airline/airports/view/', 'id' => $data->to_icao]),
                                    [
                                        'data-toggle' => "tooltip",
                                        'data-placement' => "top",
                                        'title' => Html::encode("{$data->arrAirport->name} ({$data->arrAirport->city}, {$data->arrAirport->iso})")
                                    ]
                                );
                            },
                    ],
                    [
                        'attribute' => 'dep_time',
                        'label' => Yii::t('flights', 'Dep Time'),
                        'format' => ['date', 'php:H:i']
                    ],
                    [
                        'attribute' => 'landing_time',
                        'label' => Yii::t('flights', 'Landing Time'),
                        'format' => ['date', 'php:H:i'],
                        'value' => function ($data) {
                                $eet = explode(':', $data->eet);
                                $eet_seconds = $eet[0] * 3600 + $eet[1] * 60 + $eet[2];
                                $dep_time = strtotime($data->dep_time);
                                $landing_time = $dep_time + $eet_seconds;
                                return date('H:i', $landing_time);
                            }
                    ],
                    [
                        'attribute' => 'status',

                    ]
                ],
            ]
        ) ?>
    </div>
</div>