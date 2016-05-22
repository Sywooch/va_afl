<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 10.01.16
 * Time: 21:00
 */

use app\components\Helper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
?>
<!-- begin panel -->
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title"><?= Yii::t('app', 'Top') ?></h4>
    </div>
    <div class="panel-body bg-silver">


        <?php Pjax::begin();?>
        <?=
        GridView::widget(
            [
                'dataProvider' => $top,
                'layout' => '{items}{pager}',
                'options' => ['class' => 'table table-condensed'],
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
                                    )
                                );
                            }
                    ],
                    'pilot.level',
                    [
                        'attribute' => 'pilot.billingUserBalance',
                        'value' => function ($data) {
                                return isset($data->pilot->billingUserBalance) ? $data->pilot->billingUserBalance->balance : 0;
                            }
                    ]
                ]
            ]
        ); ?>
        <?php Pjax::end(); ?>
    </div>
</div>