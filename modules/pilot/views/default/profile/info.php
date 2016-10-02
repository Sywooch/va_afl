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
                    'attribute' => 'rating',
                    'label' => Yii::t('top', 'Rating'),
                    'format' => 'raw',
                    'value' => ($user->pilot->topAll ? Html::a(
                            $user->pilot->topAll->rating_count.' ('.$user->pilot->topAll->rating_pos.')',
                            Url::to(
                                [
                                    '/users/top/all'
                                ]
                            ),
                            [
                                'data-toggle' => "tooltip",
                                'data-placement' => "top",
                                'title' => Html::encode(Yii::t('top', 'Position by Rating'))
                            ]
                        ) : '').' / '. ($user->pilot->topMouth ? Html::a(
                            $user->pilot->topMouth->rating_count.' ('.$user->pilot->topMouth->rating_pos.')',
                            Url::to(
                                [
                                    '/users/top/month'
                                ]
                            ),
                            [
                                'data-toggle' => "tooltip",
                                'data-placement' => "top",
                                'title' => Html::encode(Yii::t('top', 'Position by Rating').' '.Yii::t('top','by month'))
                            ]
                        ) : ''),
                ],
                [
                    'attribute' => 'flights_num',
                    'label' => Yii::t('user', 'Total flights'),
                    'format' => 'raw',
                    'value' => $user->pilot->flightsCount.' ('.($user->pilot->topAll ? Html::a(
                            $user->pilot->topAll->flights_pos,
                            Url::to(
                                [
                                    '/users/top/all'
                                ]
                            ),
                            [
                                'data-toggle' => "tooltip",
                                'data-placement' => "top",
                                'title' => Html::encode(Yii::t('top', 'Position by Flights'))
                            ]
                        ) : '').' / '. ($user->pilot->topMouth ? Html::a(
                            $user->pilot->topMouth->flights_pos,
                            Url::to(
                                [
                                    '/users/top/month'
                                ]
                            ),
                            [
                                'data-toggle' => "tooltip",
                                'data-placement' => "top",
                                'title' => Html::encode(Yii::t('top', 'Position by Flights').' '.Yii::t('top', 'by month'))
                            ]
                        ) : '').')',
                ],
                [
                    'attribute' => 'total_hours',
                    'label' => Yii::t('user', 'Total hours'),
                    'format' => 'raw',
                    'value' => Helper::getTimeFormatted($user->pilot->time).' ('.($user->pilot->topAll ? Html::a(
                            $user->pilot->topAll->hours_pos,
                            Url::to(
                                [
                                    '/users/top/all'
                                ]
                            ),
                            [
                                'data-toggle' => "tooltip",
                                'data-placement' => "top",
                                'title' => Html::encode(Yii::t('top', 'Position by Online Hours'))
                            ]
                        ) : '').' / '. ($user->pilot->topMouth ? Html::a(
                            $user->pilot->topMouth->hours_pos,
                            Url::to(
                                [
                                    '/users/top/month'
                                ]
                            ),
                            [
                                'data-toggle' => "tooltip",
                                'data-placement' => "top",
                                'title' => Html::encode(Yii::t('top', 'Position by Online Hours').' '.Yii::t('top', 'by month'))
                            ]
                        ) : '').')',
                ],
                [
                    'attribute' => 'total_miles',
                    'label' => Yii::t('user', 'Total miles'),
                    'format' => 'raw',
                    'value' => $user->pilot->miles,
                ],
                [
                    'attribute' => 'total_pax',
                    'label' => Yii::t('user', 'Total pax'),
                    'format' => 'raw',
                    'value' => $user->pilot->passengers.' ('.($user->pilot->topAll ? Html::a(
                            $user->pilot->topAll->pax_pos,
                            Url::to(
                                [
                                    '/users/top/all'
                                ]
                            ),
                            [
                                'data-toggle' => "tooltip",
                                'data-placement' => "top",
                                'title' => Html::encode(Yii::t('top', 'Position by PAXs'))
                            ]
                        ) : '').' / '. ($user->pilot->topMouth ? Html::a(
                            $user->pilot->topMouth->pax_pos,
                            Url::to(
                                [
                                    '/users/top/month'
                                ]
                            ),
                            [
                                'data-toggle' => "tooltip",
                                'data-placement' => "top",
                                'title' => Html::encode(Yii::t('top', 'Position by PAXs').' '.Yii::t('top', 'by month'))
                            ]
                        ) : '').')',
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