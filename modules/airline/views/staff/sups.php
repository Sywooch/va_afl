<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = Yii::t('app', 'Supervisors');
$this->params['breadcrumbs'] = [
    ['label' => $this->title]
];

?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title"><?= $this->title ?></h4>
    </div>
    <div class="panel-body" style="display: block;">
        <?php Pjax::begin(); ?>
        <?php echo \yii\grid\GridView::widget(
            [
                'dataProvider' => $dataProvider,
                'tableOptions' => [
                    'class' => 'table table-bordered table-striped table-hover'
                ],
                'layout' => '{items}{pager}',
                'columns' => [
                    [
                        'attribute' => 'vid',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return Html::a($data->vid, Url::to('/pilot/profile/' . $data->vid));
                        }
                    ],
                    [
                        'attribute' => 'full_name',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return "<img src=" . $data->flaglink . "> " .$data->full_name;
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
                ]
            ]
        ); ?>
        <?php Pjax::end(); ?>
    </div>
</div>