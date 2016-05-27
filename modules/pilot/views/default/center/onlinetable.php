<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 10.01.16
 * Time: 21:00
 */

use app\components\Helper;
use app\models\Booking;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

\app\assets\OnlineTableAsset::register($this);
?>
<!-- begin panel -->
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title"><?= Yii::t('app', 'Online Timetable') ?> <span
                class="label label-success pull-right"><?= $onlineProvider->getTotalCount() ?> Online</span>
        </h4>
    </div>
    <div class="panel-body bg-silver">
        <div class="table table-condensed">
            <div class="table-responsive">
                <?=
                GridView::widget(
                    [
                        'dataProvider' => $onlineProvider,
                        'layout' => '{items}{pager}',
                        'options' => [
                            'class' => 'time-table table table-striped table-bordered wow bounceInDown animated" data-wow-duration="3s"',
                            'style' => 'visibility: visible; animation-duration: 3s; animation-name: bounceInDown;'
                        ],
                        'columns' => [
                            [
                                'attribute' => 'callsign',
                                'label' => Yii::t('flights', 'Callsign'),
                                'format' => 'raw',
                                'value' => function ($data) {
                                        return (($data->stream && isset($data->user->pilot->stream_link)) ?
                                            '<a href="' . $data->user->pilot->stream_link . '">' . '<i class="fa fa-rss" style="color: green"></i></a>' :
                                            '<i class="fa fa-rss"></i>') . ' ' . ((isset($data->flight)) ?
                                            Html::a(
                                                Html::encode($data->callsign),
                                                Url::to(['/airline/flights/view/' . $data->id]),
                                                [
                                                    'data-toggle' => "tooltip",
                                                    'data-placement' => "top",
                                                    'title' => Html::encode($data->user->full_name)
                                                ]
                                            ) : Html::tag(
                                                'span',
                                                $data->callsign,
                                                [
                                                    'title' => $data->user->full_name,
                                                    'data-toggle' => 'tooltip',
                                                    'data-placement' => "top",
                                                    'style' => 'cursor:pointer;'
                                                ]
                                            ));
                                    },
                            ],
                            [
                                'attribute' => 'flight.acf_type',
                                'label' => Yii::t('flights', 'Type'),
                                'format' => 'raw',
                                'value' => function ($data) {
                                        return Html::tag(
                                            'span',
                                            $data->fleet->type_code,
                                            [
                                                'title' => $data->fleet->regnum,
                                                'data-toggle' => 'tooltip',
                                                'data-placement' => "top",
                                                'style' => 'cursor:pointer;'
                                            ]
                                        );
                                    },
                            ],
                            [
                                'attribute' => 'from_to',
                                'label' => Yii::t('flights', 'Route'),
                                'format' => 'raw',
                                'value' => function ($data) {
                                        return Html::a(
                                            Html::img(Helper::getFlagLink($data->departure->iso)) . ' ' .
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
                                                        "{$data->departure->name} ({$data->departure->city}, {$data->departure->iso})"
                                                    )
                                            ]
                                        ) . ' - ' . Html::a(
                                            Html::img(Helper::getFlagLink($data->arrival->iso)) . ' ' .
                                            Html::encode($data->to_icao),
                                            Url::to(['/airline/airports/view/', 'id' => $data->to_icao]),
                                            [
                                                'data-toggle' => "tooltip",
                                                'data-placement' => "top",
                                                'title' => Html::encode(
                                                        "{$data->arrival->name} ({$data->arrival->city}, {$data->arrival->iso})"
                                                    )
                                            ]
                                        );
                                    },
                            ],
                            [
                                'attribute' => 'flight.dep_time',
                                'label' => Yii::t('flights', 'Dep Time'),
                                'format' => ['date', 'php:H:i'],
                                'value' => function ($data) {
                                        if (isset($data->flight)) {
                                            return date('H:i', strtotime($data->flight->dep_time));
                                        } else {
                                            return "0:0";
                                        }
                                    }
                            ],
                            [
                                'attribute' => 'flight.landing_time',
                                'label' => Yii::t('flights', 'Landing Time'),
                                'format' => ['date', 'php:H:i'],
                                'value' => function ($data) {
                                        if (isset($data->flight)) {
                                            $eet = explode(':', $data->flight->eet);
                                            $eet_seconds = $eet[0] * 3600 + $eet[1] * 60 + $eet[2];
                                            $dep_time = strtotime($data->flight->dep_time);
                                            $landing_time = $dep_time + $eet_seconds;
                                            return date('H:i', $landing_time);
                                        } else {
                                            return "0:0";
                                        }
                                    }
                            ],
                            [
                                'attribute' => 'status',
                                'contentOptions' => ['class' => 'status'],
                                'format' => 'raw',
                                'value' => function ($data) {
                                        $ret = '<span class="';

                                        switch ($data->g_status) {
                                            case Booking::STATUS_BOOKED:
                                                $ret .= 'booked">Booked';
                                                break;
                                            case Booking::STATUS_BOARDING:
                                                $ret .= 'boarding">Boarding';
                                                break;
                                            case Booking::STATUS_DEPARTING:
                                                $ret .= 'departing">Departing';
                                                break;
                                            case Booking::STATUS_ENROUTE:
                                                $ret .= 'en-route">En-route';
                                                break;
                                            case Booking::STATUS_APPROACH:
                                                $ret .= 'approach">Approach';
                                                break;
                                            case Booking::STATUS_LANDED:
                                                $ret .= 'landing">Landed';
                                                break;
                                            case Booking::STATUS_ON_BLOCKS:
                                                $ret .= 'on-blocks">On blocks';
                                                break;
                                        }

                                        $ret .= '</span>';
                                        return $ret;
                                    }
                            ]
                        ],
                    ]
                ) ?>
            </div>
        </div>
    </div>
</div>