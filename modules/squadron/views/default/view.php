<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use app\models\SquadronUsers;

\app\assets\SquadronAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\models\Squadrons */

$this->title = Yii::$app->language == 'RU' ? $squadron->name_ru : $squadron->name_en;
$this->params['breadcrumbs'][] = ['label' => 'Squads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="squads-view">
    <div class="row">
        <div class="col-md-3 col-sm-6">
            <div class="widget widget-stats bg-green">
                <div class="stats-icon stats-icon-lg"><img width="50"
                                                           src="http://s004.radikal.ru/i207/1601/0a/b7c972385ab0.png">
                </div>
                <div class="stats-title"></div>
                <div class="stats-number">
                    <?= Html::encode($this->title) ?>
                </div>
            </div>
        </div>
        <!-- end col-3 -->
        <!-- begin col-3 -->
        <div class="col-md-3 col-sm-6">
            <div class="widget widget-stats bg-blue">
                <div class="stats-icon stats-icon-lg"><i class="fa fa-user fa-fw"></i></div>
                <div class="stats-title"><?= Yii::t('app', 'Total pax') ?></div>
                <div class="stats-number"><?= $squadron->totalPax ?></div>
            </div>
        </div>
        <!-- end col-3 -->
        <!-- begin col-3 -->
        <div class="col-md-3 col-sm-6">
            <div class="widget widget-stats bg-black">
                <div class="stats-icon stats-icon-lg"><i class="fa fa-money fa-fw"></i></div>
                <div class="stats-title">VUC заработано</div>
                <div class="stats-number"><?= $squadron->totalVUC ?></div>
            </div>
        </div>
        <!-- end col-3 -->
        <!-- begin col-3 -->
        <div class="col-md-3 col-sm-6">
            <div class="widget widget-stats bg-black">
                <div class="stats-icon stats-icon-lg"><i class="fa fa-arrows-h fa-fw"></i></div>
                <div class="stats-title">Миль пройдено</div>
                <div class="stats-number"><?= $squadron->totalMiles ?></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title"><?= Yii::t('app', 'News') ?>
                        <?= Html::a('<i class="fa fa-plus"></i>', Url::to(['/content/create']),
                            [
                                'class' => 'btn btn-success btn-xs pull-right',
                                'data' => [
                                    'method' => 'post',
                                    'params' => [
                                        'category_id' => 2,
                                    ]
                                ]
                            ]) ?>
                    </h4>
                </div>
                <div class="panel-body bg-silver" data-scrollbar="true" data-height="350px">
                    <div>
                        <ul class="chats">
                            <?php foreach ($news as $news_one): ?>
                                <li class="left">
                                    <span class="date-time"><?= (new \DateTime($news_one->created))->format(
                                            'g:ia \o\n l jS F'
                                        ) ?> <a
                                            href="/content/update/<?= $news_one->id ?>"><i
                                                class="fa fa-pencil"></i></a></span>
                                    <a href="/pilot/profile/<?= $news_one->author ?>"
                                       class="name"><?= $news_one->authorUser->full_name ?></a>
                                    <a class="image"><img alt="" src="/img/content/preview/<?= $news_one->preview ?>"/></a>

                                    <div class="message">
                                        <?= $news_one->text ?>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Список пилотов
                        <?php if (!$squadron->getUserStatus()) {
                            echo Html::button('Подать заявку',
                                [
                                    'class' => 'btn btn-primary btn-xs pull-right',
                                    'data-toggle' => 'modal',
                                    'data-target' => '#modal-dialog'
                                ]);
                            echo $this->render('squadron_join', ['squadron' => $squadron]);
                        } elseif ($squadron->getUserStatus() == SquadronUsers::STATUS_PENDING) {
                            echo Html::a('Отменить заявку', Url::to(['memberdelete']),
                                [
                                    'class' => 'btn btn-default btn-xs pull-right',
                                    'data' => [
                                        'method' => 'post',
                                        'params' => ['squadron' => $squadron->id, 'user_id' => Yii::$app->user->id]
                                    ]
                                ]);
                        } ?>
                    </h4>
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
                        <li class=""><a href="#default-tab-3" data-toggle="tab"
                                        aria-expanded="false"><?= Yii::t('squadron', 'Fleet and Last Flights') ?></a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="default-tab-1">
                            <?= $squadron->squadronInfo->text ?>
                            <?= Html::a(Yii::t('app', 'Update'),
                                Url::to(['/content/update', 'id' => $squadron->squadronInfo->id]),
                                ['class' => 'btn btn-primary pull-right']) ?>
                        </div>
                        <div class="tab-pane fade" id="default-tab-2">
                            <?= $squadron->squadronRules->text ?>
                            <?= Html::a(Yii::t('app', 'Update'),
                                Url::to(['/content/update', 'id' => $squadron->squadronRules->id]),
                                ['class' => 'btn btn-primary pull-right']) ?>
                        </div>
                        <div class="tab-pane fade" id="default-tab-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <?php Pjax::begin() ?>
                                    <?= GridView::widget([
                                        'dataProvider' => $fleetProvider,
                                        'columns' => [
                                            'regnum',
                                            'type_code',
                                            'location',
                                            'max_hrs'
                                        ],
                                    ]); ?>
                                    <?php Pjax::end() ?>
                                </div>
                                <div class="col-md-9">
                                    <?php Pjax::begin() ?>
                                    <?= GridView::widget([
                                        'dataProvider' => $flightsProvider,
                                        'columns' => [
                                            'user_id',
                                            'callsign',
                                            'fleet_regnum',
                                            'to_icao',
                                            'pob',
                                            'nm',
                                            'flight_time'
                                        ],
                                    ]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>