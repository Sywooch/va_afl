<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 23.05.16
 * Time: 1:44
 */
use dosamigos\highcharts\HighCharts;

?>
<?php if ($user->pilot->statWeekdays != null): ?>
    <div class="raw">
        <div class="col-md-1"></div>
        <div class="col-md-5">
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
        <div class="col-md-5">
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
        <div class="col-md-1"></div>
    </div>
<?php else: ?>
    <div class="jumbotron" style="border-radius: 10px;" align="center">
        <h2>Упс... Нет данных</h2>

        <p>Данный пилот еще не совершал рейсов</p>
    </div>
<?php endif; ?>