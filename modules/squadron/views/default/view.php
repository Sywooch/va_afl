<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use app\models\SquadronUsers;

/* @var $this yii\web\View */
/* @var $model app\models\Squadrons */

$this->title = Yii::$app->language == 'RU' ? $squadron->name_ru : $squadron->name_en;
$this->params['breadcrumbs'][] = ['label' => 'Squads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="squads-view">
    <h1 class="page-header"><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Список пилотов</h4>
                </div>
                <div class="panel-body">
                    <?php Pjax::begin() ?>
                    <?= GridView::widget([
                        'dataProvider' => $membersProvider,
                        'tableOptions' => ['class' => 'table table-bordered'],
                        'rowOptions' => function ($model) {
                            switch ($model->status) {
                                case($model::STATUS_PENDING):
                                    return ['class' => 'success'];
                                    break;
                                case($model::STATUS_SUSPENDED):
                                    return ['class' => 'danger'];
                                    break;
                                default:
                                    return ['class' => ''];
                                    break;
                            }
                        },
                        'columns' => [
                            [
                                'attribute' => 'member_name',
                                'label' => 'Member Name',
                                'value' => function ($data) {
                                    return $data->user->full_name;
                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{button1} {button2}',
                                'buttons' => [
                                    'button1' => function ($url, $model, $key) {
                                        switch ($model->status) {
                                            case($model::STATUS_PENDING):
                                                return Html::a('<i class="fa fa-plus"></i>', Url::to(['accept']), [
                                                    'title' => Yii::t('app', 'Accept'),
                                                    'data' => [
                                                        'method' => 'post',
                                                        'params' => [
                                                            'squadron' => $model->squadron_id,
                                                            'user_id' => $model->user_id
                                                        ]
                                                    ]
                                                ]);
                                                break;
                                            case($model::STATUS_ACTIVE):
                                                return Html::a('<i class="fa fa-lock"></i></span>',
                                                    Url::to(['suspend']), [
                                                        'title' => Yii::t('app', 'Suspend'),
                                                        'data' => [
                                                            'method' => 'post',
                                                            'params' => [
                                                                'squadron' => $model->squadron_id,
                                                                'user_id' => $model->user_id
                                                            ]
                                                        ]
                                                    ]);
                                                break;
                                            case($model::STATUS_SUSPENDED):
                                                return Html::a('<i class="fa fa-unlock"></i></span>',
                                                    Url::to(['unlock']),
                                                    [
                                                        'title' => Yii::t('app', 'Unlock'),
                                                        'data' => [
                                                            'method' => 'post',
                                                            'params' => [
                                                                'squadron' => $model->squadron_id,
                                                                'user_id' => $model->user_id
                                                            ]
                                                        ]
                                                    ]);
                                                break;
                                            default:
                                                break;
                                        };
                                    },
                                    'button2' => function ($url, $model, $key) {
                                        return Html::a('<i class="fa fa-minus"></i>', Url::to(['memberdelete']), [
                                            'title' => Yii::t('app', 'Delete Member'),
                                            'data' => [
                                                'method' => 'post',
                                                'params' => [
                                                    'squadron' => $model->squadron_id,
                                                    'user_id' => $model->user_id
                                                ]
                                            ]
                                        ]);
                                    },
                                ],
                            ],
                        ],
                    ]); ?>
                    <?php Pjax::end() ?>
                    <div class="row">
                        <div class="col-md-12">
                            <?php if (!$squadron->getUserStatus()) {
                                echo Html::a('Подать заявку', Url::to(['join']),
                                    [
                                        'class' => 'btn btn-primary',
                                        'data' => [
                                            'method' => 'post',
                                            'params' => ['squadron' => $squadron->id]
                                        ]
                                    ]);
                            } elseif ($squadron->getUserStatus() == SquadronUsers::STATUS_PENDING) {
                                echo Html::a('Отменить заявку', Url::to(['memberdelete']),
                                    [
                                        'class' => 'btn btn-default',
                                        'data' => [
                                            'method' => 'post',
                                            'params' => ['squadron' => $squadron->id, 'user_id' => Yii::$app->user->id]
                                        ]
                                    ]);
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Информация</h4>
                </div>
                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#default-tab-1" data-toggle="tab"
                                              aria-expanded="true"><?= $squadron->squadronInfo->name ?></a>
                        </li>
                        <li class=""><a href="#default-tab-2" data-toggle="tab"
                                        aria-expanded="false"><?= $squadron->squadronRules->name ?></a>
                        </li>
                        <li class=""><a href="#default-tab-3" data-toggle="tab" aria-expanded="false">Новости</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="default-tab-1">
                            <?= $squadron->squadronInfo->text ?>
                        </div>
                        <div class="tab-pane fade" id="default-tab-2">
                            <?= $squadron->squadronRules->text ?>
                        </div>
                        <div class="tab-pane fade" id="default-tab-3">
                            <p>
								<span class="fa-stack fa-4x pull-left m-r-10">
									<i class="fa fa-square-o fa-stack-2x"></i>
									<i class="fa fa-twitter fa-stack-1x"></i>
								</span>
                                Praesent tincidunt nulla ut elit vestibulum viverra. Sed placerat magna eget eros
                                accumsan
                                elementum.
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam quis lobortis neque.
                                Maecenas justo odio, bibendum fringilla quam nec, commodo rutrum quam.
                                Donec cursus erat in lacus congue sodales. Nunc bibendum id augue sit amet placerat.
                                Quisque et quam id felis tempus volutpat at at diam. Vivamus ac diam turpis.Sed at
                                lacinia
                                augue.
                                Nulla facilisi. Fusce at erat suscipit, dapibus elit quis, luctus nulla.
                                Quisque adipiscing dui nec orci fermentum blandit.
                                Sed at lacinia augue. Nulla facilisi. Fusce at erat suscipit, dapibus elit quis, luctus
                                nulla.
                                Quisque adipiscing dui nec orci fermentum blandit.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>