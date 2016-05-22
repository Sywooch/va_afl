<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;

/**
 * Created by PhpStorm.
 * User: BTH
 * Date: 23.09.15
 * Time: 20:32
 */

$this->title = Yii::t('app', 'Pilots roster');
$this->params['breadcrumbs'] = [
    ['label' => $this->title]
]; ?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title"><?= $this->title ?></h4>
    </div>
    <div class="panel-body" style="display: block;">
        <?php Pjax::begin();?>
        <?php echo \yii\grid\GridView::widget(
            [
                'dataProvider' => $dataProvider,
                'tableOptions' => [
                    'class' => 'table table-bordered table-striped table-hover'
                ],
                'layout' => '{items}{pager}',
                'columns' => [
                    [
                        'attribute' => 'full_name',
                        'format' => 'raw',
                        'value' => function ($data) {
                                return "<img src=" . $data->flaglink . "> " .
                                Html::a($data->full_name, Url::to('/pilot/profile/' . $data->vid));
                            }
                    ],
                    [
                        'attribute' => 'pilot.location',
                        'format' => 'raw',
                        'value' => function ($data) {
                                return '<img src="' . $data->pilot->airport->flaglink . '"> ' . Html::a(
                                    Html::encode($data->pilot->airport->name . ' (' . $data->pilot->location . ')'),
                                    Url::to(
                                        [
                                            '/airline/airports/view/',
                                            'id' => $data->pilot->location
                                        ]
                                    ),
                                    [
                                        'data-toggle' => "tooltip",
                                        'data-placement' => "top",
                                        'title' => Html::encode("{$data->pilot->airport->city}, {$data->pilot->airport->iso}")
                                    ]
                                );
                            }
                    ],
                    'pilot.level',
                    [
                        'attribute' => 'pilot.billingUserBalance',
                        'value' => function ($data) {
                                return isset($data->pilot->billingUserBalance) ? $data->pilot->billingUserBalance->balance : 0;
                            }
                    ],
                    [
                        'attribute' => 'pilot.passengers',
                        'value' => function ($data) {
                                return isset($data->pilot->passengers) ? $data->pilot->passengers : 0;
                            }
                    ],
                    [
                        'attribute' => 'created_date',
                        'format' => ['date', 'php:d.m.Y']
                    ],
                ]
            ]
        ); ?>
        <?php Pjax::end(); ?>
    </div>
</div>