<?php
/**
 * Created by PhpStorm.
 * User: nfedoseev
 * Date: 12.12.2016
 * Time: 12:07
 */
use app\components\Stats;
use app\models\Flights;
use app\models\Pax;
use app\models\Users;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title"><?= Yii::t('app', 'Status') ?>
        </h4>
    </div>
    <div class="panel-body">
        <?=
        DetailView::widget(
            [
                'model' => $user,
                'options' => ['class' => 'table table-profile'],
                'template' => '<tr><td class="field">{label}</td><td>{value}</td>',
                'attributes' => [
                    [
                        'attribute' => 'online',
                        'label' => Yii::t('app', 'Users online on site'),
                        'format' => 'raw',
                        'value' => Users::countOnline()
                    ],
                    [
                        'attribute' => 'online',
                        'label' => Yii::t('app', 'Users on site in 24 hours'),
                        'format' => 'raw',
                        'value' => Users::countDay()
                    ],
                    [
                        'attribute' => 'online',
                        'label' => Yii::t('app', 'Currently in the air'),
                        'format' => 'raw',
                        'value' => Flights::countOnline()
                    ],
                    [
                        'attribute' => 'online',
                        'label' => Yii::t('app', 'Users flew for 24 hours'),
                        'format' => 'raw',
                        'value' => Flights::countDay()
                    ],
                    [
                        'attribute' => 'flights',
                        'label' => '<hr>',
                        'format' => 'raw',
                        'value' => '<hr>',
                    ],
                    [
                        'attribute' => 'rating',
                        'label' => Yii::t('top', 'Your rating'),
                        'format' => 'raw',
                        'value' => ($user->pilot->topAll ? $user->pilot->topAll->rating_count : 0),
                    ],
                    [
                        'attribute' => 'rating',
                        'label' => Yii::t('top', 'Your position by rating'),
                        'format' => 'raw',
                        'value' => ($user->pilot->topAll ? Html::a(
                            $user->pilot->topAll->rating_pos . ' (<span style="color:' . ($user->pilot->topAll->rating_pos_change_day >= 0 ? 'darkgreen;"> +' : '#8b0000;"> ') . $user->pilot->topAll->rating_pos_change_day . '</span> / <span style="color:' . ($user->pilot->topAll->rating_pos_change_week >= 0 ? 'darkgreen;"> +' : '#8b0000;"> ') . $user->pilot->topAll->rating_pos_change_week . '</span>)',
                            Url::to(
                                [
                                    '/users/top/all'
                                ]
                            ),
                            [
                                'target' => '_blank'
                            ]
                        ) : '#'),
                    ],
                    [
                        'attribute' => 'rating',
                        'label' => Yii::t('top', 'Your rating by month'),
                        'format' => 'raw',
                        'value' => ($user->pilot->topMouth ?
                            $user->pilot->topMouth->rating_count : 0),
                    ],
                    [
                        'attribute' => 'rating',
                        'label' => Yii::t('top', 'Your position by rating by month'),
                        'format' => 'raw',
                        'value' => ($user->pilot->topMouth ? Html::a(
                            $user->pilot->topMouth->rating_pos,
                            Url::to(
                                [
                                    '/users/top/month'
                                ]
                            ),
                            [
                                'target' => '_blank'
                            ]
                        ) : '#'),
                    ],
                    [
                        'attribute' => 'flights',
                        'label' => '<hr>',
                        'format' => 'raw',
                        'value' => '<hr>',
                    ],
                    [
                        'attribute' => 'flights',
                        'label' => Yii::t('app', 'Total flights'),
                        'format' => 'raw',
                        'value' => Stats::flights(),
                    ],
                    [
                        'attribute' => 'site',
                        'label' => Yii::t('app', 'Registered users'),
                        'format' => 'raw',
                        'value' => Stats::members(),
                    ],
                    [
                        'attribute' => 'flights',
                        'label' => '<hr>',
                        'format' => 'raw',
                        'value' => '<hr>',
                    ],
                    [
                        'attribute' => 'rating',
                        'label' => Yii::t('app', 'Number of passengers waiting for flights'),
                        'format' => 'raw',
                        'value' => '<h4 class="panel-title status-' . (Pax::find()->sum('num_pax') > 0 ? 'online' : 'offline') . '"><b>' . Pax::find()->sum('num_pax') . ' <i class="fa '.(Pax::find()->sum('num_pax') > 0 ? 'fa-check-circle' : 'fa-times-circle') . '" aria-hidden="true"></i></b></h4>',
                    ],
                ]
            ]
        ) ?>
    </div>
</div>
