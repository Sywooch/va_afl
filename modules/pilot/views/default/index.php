<?php
use app\components\Helper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use dosamigos\highcharts\HighCharts;
use yii\helpers\BaseVarDumper;
use yii\widgets\DetailView;

$this->title = Yii::t('app', 'Statistics');
$this->params['breadcrumbs'] = [
    ['label' => Yii::t('app', 'Pilot Center'), 'url' => '/pilot/center'],
    ['label' => $this->title]
]; ?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title"><?= Yii::t('app', 'Information') ?></h4>
    </div>
    <div class="panel-body" style="display: block;">
        <div class="table-responsive" style="padding-top: 6px">
            <?=
            DetailView::widget(
                [
                    'model' => $user,
                    'options' => ['class' => 'table table-profile'],
                    'template' => '<tr><td class="field">{label}</td><td>{value}</td>',
                    'attributes' => [
                        [
                            'attribute' => 'VID',
                            'label' => 'IVAO ID',
                            'format' => 'raw',
                            'value' => Html::a(
                                    Html::encode($user->vid),
                                    'http://ivao.aero/Member.aspx?Id=' . $user->vid,
                                    ['target' => '_blank']
                                ),
                        ],
                        [
                            'attribute' => 'location',
                            'label' => Yii::t('user', 'Location'),
                            'format' => 'raw',
                            'value' => '<img src="' . $user->pilot->airport->flaglink . '"> ' . Html::a(
                                    Html::encode($user->pilot->airport->name . ' (' . $user->pilot->location . ')'),
                                    Url::to(
                                        [
                                            '/airline/airports/view/',
                                            'id' => $user->pilot->location
                                        ]
                                    ),
                                    [
                                        'data-toggle' => "tooltip",
                                        'data-placement' => "top",
                                        'title' => Html::encode(
                                                "{$user->pilot->airport->city}, {$user->pilot->airport->iso}"
                                            )
                                    ]
                                ),
                        ],
                        [
                            'attribute' => 'flights_num',
                            'label' => Yii::t('user', 'Total flights'),
                            'value' => $user->pilot->flightsCount,
                        ],
                        [
                            'attribute' => 'total_hours',
                            'label' => Yii::t('user', 'Total hours'),
                            'value' => Helper::getTimeFormatted($user->pilot->time),
                        ],
                        [
                            'attribute' => 'total_miles',
                            'label' => Yii::t('user', 'Total miles'),
                            'value' => $user->pilot->miles,
                        ],
                        [
                            'attribute' => 'total_pax',
                            'label' => Yii::t('user', 'Total pax'),
                            'value' => $user->pilot->passengers,
                        ],
                        [
                            'attribute' => 'user_comments',
                            'label' => Yii::t('user', 'User Comments'),
                            'value' => $user->pilot->user_comments,
                        ],
                        [
                            'attribute' => 'user_comments',
                            'label' => Yii::t('user', 'Staff Comments'),
                            'value' => $user->pilot->staff_comments,
                        ],
                    ]
                ]
            ) ?>
        </div>
    </div>
</div>
<div class="panel panel-inverse">
<div class="panel-heading">
        <h4 class="panel-title"><?= $this->title ?></h4>
    </div>
    <div class="panel-body" style="display: block;">
        <div class="raw">
            <div class="col-md-3">
                <?php
                echo HighCharts::widget(
                    [
                        'clientOptions' => [
                            'colors' => [
                                '#F59C1A',
                                '#FF5B57',
                                '#B6C2C9',
                                '#2D353C',
                                '#2A72B5',
                                '#CC4946',
                                '#00ACAC'
                            ],
                            'chart' => [
                                'type' => 'pie',
                                'plotBackgroundColor' => null,
                                'backgroundColor' => null,
                                'plotBorderWidth' => null,
                                'plotShadow' => false,
                                'height' => 300,
                                'style' => [
                                    'fontFamily' => 'Open Sans',
                                    'fontSize' => '12px',
                                    'color' => '#777777',
                                    'fontWeight' => '600',
                                ]
                            ],
                            'title' => [
                                'text' => Yii::t('charts', 'WEEKDAY STATISTICS'),
                                'style' => [
                                    'fontFamily' => 'Open Sans',
                                    'fontSize' => '12px',
                                    'color' => '#777777',
                                    'fontWeight' => '600'
                                ]
                            ],
                            'exporting' => [
                                'enabled' => false
                            ],
                            'credits' => [
                                'enabled' => false
                            ],
                            'tooltip' => [
                                'pointFormat' => '{series.name}: <b>{point.percentage:.1f}%</b>',
                                'style' => [
                                    'fontFamily' => 'Open Sans',
                                    'fontSize' => '12px',
                                    'color' => '#777777',
                                    'fontWeight' => '600'
                                ]
                            ],
                            'plotOptions' => [
                                'pie' => [
                                    'allowPointSelect' => true,
                                    'cursor' => 'pointer',
                                    'dataLabels' => [
                                        'enabled' => false
                                    ],
                                    'showInLegend' => true,
                                ]
                            ],
                            'legend' => [
                                'itemStyle' => [
                                    'fontFamily' => 'Open Sans',
                                    'fontSize' => '12px',
                                    'color' => '#777777',
                                    'fontWeight' => '600',
                                ],
                                'borderColor' => '#FFFFFF',
                            ],
                            'series' => [
                                [
                                    'name' => 'Types',
                                    'colorByPoint' => true,
                                    'data' => $user->pilot->statWeekdays,
                                    'innerSize' => '65%'
                                ]
                            ]
                        ]
                    ]
                ); ?>
            </div>
            <div class="col-md-3">
                <?php echo HighCharts::widget(
                    [
                        'clientOptions' => [
                            'colors' => ['#F59C1A', '#FF5B57', '#B6C2C9', '#2D353C', '#348FE2'],
                            'chart' => [
                                'type' => 'pie',
                                'plotBackgroundColor' => null,
                                'backgroundColor' => null,
                                'plotBorderWidth' => null,
                                'plotShadow' => false,
                                'height' => 300,
                                'style' => [
                                    'fontFamily' => 'Open Sans',
                                    'fontSize' => '12px',
                                    'color' => '#777777',
                                    'fontWeight' => '600',
                                ]
                            ],
                            'title' => [
                                'text' => Yii::t('charts', 'AIRCRAFT USAGE'),
                                'style' => [
                                    'fontFamily' => 'Open Sans',
                                    'fontSize' => '12px',
                                    'color' => '#777777',
                                    'fontWeight' => '600',
                                    'margin-top' => 20,
                                ]
                            ],
                            'exporting' => [
                                'enabled' => false
                            ],
                            'credits' => [
                                'enabled' => false
                            ],
                            'tooltip' => [
                                'pointFormat' => '{series.name}: <b>{point.percentage:.1f}%</b>',
                                'style' => [
                                    'fontFamily' => 'Open Sans',
                                    'fontSize' => '12px',
                                    'color' => '#777777',
                                    'fontWeight' => '600'
                                ]
                            ],
                            'plotOptions' => [
                                'pie' => [
                                    'allowPointSelect' => true,
                                    'cursor' => 'pointer',
                                    'dataLabels' => [
                                        'enabled' => false
                                    ],
                                    'showInLegend' => true,
                                ]
                            ],
                            'legend' => [
                                'itemStyle' => [
                                    'fontFamily' => 'Open Sans',
                                    'fontSize' => '12px',
                                    'color' => '#777777',
                                    'fontWeight' => '600',
                                ],
                                'borderColor' => '#FFFFFF',
                            ],
                            'series' => [
                                [
                                    'name' => 'Types',
                                    'colorByPoint' => true,
                                    'data' => $user->pilot->statAcfTypes,
                                    'innerSize' => '65%'
                                ]
                            ]
                        ]
                    ]
                ); ?>
            </div>
            <div class="col-md-3">
                <?php echo HighCharts::widget(
                    [
                        'clientOptions' => [
                            'colors' => ['#F59C1A', '#FF5B57', '#B6C2C9', '#2D353C', '#348FE2'],
                            'chart' => [
                                'type' => 'pie',
                                'plotBackgroundColor' => null,
                                'backgroundColor' => null,
                                'plotBorderWidth' => null,
                                'plotShadow' => false,
                                'height' => 300,
                                'style' => [
                                    'fontFamily' => 'Open Sans',
                                    'fontSize' => '12px',
                                    'color' => '#777777',
                                    'fontWeight' => '600',
                                ]
                            ],
                            'title' => [
                                'text' => Yii::t('charts', 'FLIGHT TYPES'),
                                'style' => [
                                    'fontFamily' => 'Open Sans',
                                    'fontSize' => '12px',
                                    'color' => '#777777',
                                    'fontWeight' => '600',
                                    'margin-top' => 20,
                                ]
                            ],
                            'exporting' => [
                                'enabled' => false
                            ],
                            'credits' => [
                                'enabled' => false
                            ],
                            'tooltip' => [
                                'pointFormat' => '{series.name}: <b>{point.percentage:.1f}%</b>',
                                'style' => [
                                    'fontFamily' => 'Open Sans',
                                    'fontSize' => '12px',
                                    'color' => '#777777',
                                    'fontWeight' => '600'
                                ]
                            ],
                            'plotOptions' => [
                                'pie' => [
                                    'allowPointSelect' => true,
                                    'cursor' => 'pointer',
                                    'dataLabels' => [
                                        'enabled' => false
                                    ],
                                    'showInLegend' => true,
                                ]
                            ],
                            'legend' => [
                                'itemStyle' => [
                                    'fontFamily' => 'Open Sans',
                                    'fontSize' => '12px',
                                    'color' => '#777777',
                                    'fontWeight' => '600',
                                ],
                                'borderColor' => '#FFFFFF',
                            ],
                            'series' => [
                                [
                                    'name' => 'Types',
                                    'colorByPoint' => true,
                                    'data' => $user->pilot->statFlightsDomestic,
                                    'innerSize' => '65%'
                                ]
                            ]
                        ]
                    ]
                ); ?>
            </div>
        </div>
    </div>
</div>