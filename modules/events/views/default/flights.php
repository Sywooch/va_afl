<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 23.05.16
 * Time: 1:48
 */
use app\components\Helper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

?>

<?=
GridView::widget(
    [
        'dataProvider' => $flightsProvider,
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
                            Url::to(['/airline/flights/view/' . $data->id]),
                            ['target' => '_blank']
                        );
                    },
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
                                'data-toggle' => "tooltip",
                                'data-placement' => "top",
                                'title' => $data->depAirport ? Html::encode(
                                        "{$data->depAirport->name} ({$data->depAirport->city}, {$data->depAirport->iso})"
                                    ) : ''
                            ]
                        ) : $data->from_icao). ' - ' . ($data->arrAirport ? Html::a(
                            Html::img(Helper::getFlagLink($data->arrAirport->iso)) . ' ' .
                            Html::encode($data->to_icao),
                            Url::to(['/airline/airports/view/', 'id' => $data->to_icao]),
                            [
                                'data-toggle' => "tooltip",
                                'data-placement' => "top",
                                'title' => Html::encode(
                                        "{$data->arrAirport->name} ({$data->arrAirport->city}, {$data->arrAirport->iso})"
                                    )
                            ]
                        ) : $data->to_icao);
                    },
            ],
            [
                'attribute' => 'flight_time',
                'label' => Yii::t('flights', 'Flight Time'),
                'value' => function ($data) {
                        return Helper::getTimeFormatted($data->flight_time);
                    }
            ]
        ],
    ]
) ?>