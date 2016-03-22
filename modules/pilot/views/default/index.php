<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use dosamigos\highcharts\HighCharts;
use yii\helpers\BaseVarDumper;

$this->title = Yii::t('app', 'Statistics');
$this->params['breadcrumbs'] = [
    ['label' => Yii::t('app', 'Pilot Center'), 'url' => '/pilot/center'],
    ['label' => $this->title]
]; ?>
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