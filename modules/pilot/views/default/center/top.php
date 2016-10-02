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
        <h4 class="panel-title"><?= Yii::t('app', 'Top') . ' ' . Yii::t('top', 'by mouth') ?></h4>
    </div>
    <div class="panel-body">
        <?php Pjax::begin(); ?>
        <?=
        GridView::widget(
            [
                'dataProvider' => $dataProvider,
                'layout' => '{items}{pager}',
                'options' => ['class' => 'table table-condensed table-responsive'],
                'columns' => [
                    [
                        'label' => Yii::t('app', 'Pilot'),
                        'attribute' => 'user_id',
                        'format' => 'raw',
                        'value' => function ($data) {
                                return "<img src=" . $data->user->flaglink . "> " .
                                Html::a(
                                    $data->user->full_name,
                                    Url::to('/pilot/profile/' . $data->user->vid),
                                    ['target' => '_blank']
                                );
                            }
                    ],
                    [
                        'label' => Yii::t('app', 'Location'),
                        'attribute' => 'user.location',
                        'format' => 'raw',
                        'value' => function ($data) {
                                return '<img src="' . $data->user->pilot->airport->flaglink . '"> ' . Html::a(
                                    Html::encode(
                                        $data->user->pilot->airport->name . ' (' . $data->user->pilot->location . ')'
                                    ),
                                    Url::to(
                                        [
                                            '/airline/airports/view/',
                                            'id' => $data->user->pilot->location
                                        ]
                                    ),
                                    [
                                        'data-toggle' => "tooltip",
                                        'data-placement' => "top",
                                        'title' => Html::encode(
                                                "{$data->user->pilot->airport->city}, {$data->user->pilot->airport->iso}"
                                            )
                                    ]
                                );
                            }
                    ],
                    'rating_pos',
                    //'rating_count',
                ],
            ]
        ); ?>
        <?php Pjax::end(); ?>
    </div>
</div>