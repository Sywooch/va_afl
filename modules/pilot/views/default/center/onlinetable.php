<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 10.01.16
 * Time: 21:00
 */

use app\components\Helper;
use yii\helpers\Html;
use yii\grid\GridView;

?>
<!-- begin panel -->
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title"><?= Yii::t('app', 'Online Table') ?> <span class="label label-success pull-right">10 online</span>
        </h4>
    </div>
    <div class="panel-body bg-silver">
        <?=
        GridView::widget(
            [
                'dataProvider' => $onlineProvider,
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
                    ]
                ],
            ]
        ) ?>
    </div>
</div>