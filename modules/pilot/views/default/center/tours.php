<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 17.01.16
 * Time: 1:35
 */

use app\components\Helper;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\bootstrap\Progress;

?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title" onclick="javascript: window.open('/tours')"><?= Yii::t('app', 'Tours') ?>
        </h4>
    </div>
    <div class="panel-body bg-silver" data-scrollbar="true" data-height="350px">
        <?=
        GridView::widget(
            [
                'dataProvider' => $toursProvider,
                'layout' => '{items}{pager}',
                'options' => ['class' => 'table table-condensed table-responsive'],
                'columns' => [
                    [
                        'attribute' => 'name',
                        'format' => 'raw',
                        'value' => function ($data) {
                                return Html::a($data->content->name, '/tours/view/'.$data->id, ['target' => '_blank']);
                            }
                    ],
                    [
                        'attribute' => 'progress',
                        'format' => 'raw',
                        'value' => function ($data) {
                                return Progress::widget([
                                        'percent' => $data->tourUser->percent,
                                        'label' => $data->tourUser->percent.'%',
                                        'barOptions' => [
                                            'class' => 'progress-bar-warning'
                                        ],
                                        'options' => [
                                            'class' => 'active progress-striped'
                                        ]
                                    ]);
                            }
                    ],
                    [
                        'attribute' => Yii::t('flights', 'Next Leg'),
                        'format' => 'raw',
                        'value' => function ($data) {
                                return Html::img(
                                    Helper::getFlagLink($data->tourUser->nextLeg->depAirport->iso)
                                ) . ' ' .
                                Html::tag(
                                    'span',
                                    $data->tourUser->nextLeg->depAirport->icao,
                                    [
                                        'title' => Html::encode(
                                                "{$data->tourUser->nextLeg->depAirport->name} ({$data->tourUser->nextLeg->depAirport->city}, {$data->tourUser->nextLeg->arrAirport->iso})"
                                            ),
                                        'data-toggle' => 'tooltip1',
                                        'style' => 'cursor:pointer;'
                                    ]
                                ) .
                                ' — ' .
                                Html::img(
                                    Helper::getFlagLink($data->tourUser->nextLeg->arrAirport->iso)
                                ) . ' ' .
                                Html::tag(
                                    'span',
                                    $data->tourUser->nextLeg->arrAirport->icao,
                                    [
                                        'title' => Html::encode(
                                                "{$data->tourUser->nextLeg->arrAirport->name} ({$data->tourUser->nextLeg->arrAirport->city}, {$data->tourUser->nextLeg->arrAirport->iso})"
                                            ),
                                        'data-toggle' => 'tooltip1',
                                        'style' => 'cursor:pointer;'
                                    ]
                                );
                            }
                    ]

                ]
            ]
        ); ?>
    </div>
</div>