<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use dosamigos\highcharts\HighCharts;

$this->title = 'Fleet Profiles stats';
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="raw">
        <?php foreach ($stats as $name => $stat): ?>

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
                                'text' => Yii::t('charts', $name . ' PROFILE STATISTICS'),
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
                                    'data' => $stat,
                                    'innerSize' => '65%'
                                ]
                            ]
                        ]
                    ]
                ); ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
