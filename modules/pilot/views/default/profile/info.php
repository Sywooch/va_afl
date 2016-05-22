<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 23.05.16
 * Time: 1:43
 */
use app\components\Helper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
?>
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
                                'title' => Html::encode("{$user->pilot->airport->city}, {$user->pilot->airport->iso}")
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