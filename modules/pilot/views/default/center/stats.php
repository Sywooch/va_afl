<?php
/**
 * Created by PhpStorm.
 * User: nfedoseev
 * Date: 30.09.2016
 * Time: 23:33
 */
use dosamigos\highcharts\HighCharts;
use yii\web\JsExpression;

?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title"><?= Yii::t('app', 'Graphs') ?></h4>
    </div>
    <div class="panel-body bg-silver">
        <?php
        echo HighCharts::widget(
            [
                'clientOptions' => [
                    'colors' => ['#F59C1A', '#FF5B57', '#B6C2C9', '#2D353C', '#348FE2'],
                    'title' => [
                        'text' => Yii::t('app', 'Flights during 14 days'),
                    ],
                    'exporting' => [
                        'enabled' => false
                    ],
                    'credits' => [
                        'enabled' => false
                    ],
                    'xAxis' => [
                        'categories' => $stats['days'],
                    ],
                    'labels' => [
                        'items' => [
                            [
                                'style' => [
                                    'left' => '50px',
                                    'top' => '18px',
                                    'color' => new JsExpression('(Highcharts.theme && Highcharts.theme.textColor) || "black"'),
                                ],
                            ],
                        ],
                    ],
                    'series' => [
                        [
                            'type' => 'spline',
                            'name' => 'Average',
                            'data' => $stats['count'],
                            'marker' => [
                                'lineWidth' => 2,
                                'lineColor' => new JsExpression('Highcharts.getOptions().colors[3]'),
                                'fillColor' => 'red',
                            ],
                        ],
                    ],
                ]
            ]
        ); ?>
    </div>
</div>