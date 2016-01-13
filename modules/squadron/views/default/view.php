<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

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
                                'template' => '{accept} {refuse} {unlock} {suspend}'
                                    /*function ($model) {
                                        switch ($model->status) {
                                            case($model::STATUS_PENDING):
                                                return '{accept} {refuse}';
                                                break;

                                            case($model::STATUS_SUSPENDED):
                                                return '{unlock}';
                                                break;
                                            default:
                                                return '{suspend}';
                                                break;
                                        }
                                    }
                                    TODO: починить */,
                                'buttons' => [
                                    'accept' => function ($url, $model) {
                                        return Html::a('<span class="glyphicon glyphicon-ok"></span>', $url, [
                                            'title' => Yii::t('app', 'Accept'),
                                            'data' => [
                                                'method' => 'post',
                                                'params' => [
                                                    'squadron' => $model->squadron_id,
                                                    'user_id' => $model->user_id
                                                ]
                                            ]
                                        ]);
                                    },
                                    'refuse' => function ($url, $model) {
                                        return Html::a('<span class="glyphicon glyphicon-remove"></span>', $url, [
                                            'title' => Yii::t('app', 'Refuse'),
                                            'data' => [
                                                'method' => 'post',
                                                'params' => [
                                                    'squadron' => $model->squadron_id,
                                                    'user_id' => $model->user_id
                                                ]
                                            ]
                                        ]);
                                    },
                                    'suspend' => function ($url, $model) {
                                        return Html::a('<span class="glyphicon glyphicon-lock"></span>', $url, [
                                            'title' => Yii::t('app', 'Suspend'),
                                            'data' => [
                                                'method' => 'post',
                                                'params' => [
                                                    'squadron' => $model->squadron_id,
                                                    'user_id' => $model->user_id
                                                ]
                                            ]
                                        ]);
                                    },
                                    'unlock' => function ($url, $model) {
                                        return Html::a('<span class="glyphicon glyphicon-plus"></span>', $url, [
                                            'title' => Yii::t('app', 'Unlock'),
                                            'data' => [
                                                'method' => 'post',
                                                'params' => [
                                                    'squadron' => $model->squadron_id,
                                                    'user_id' => $model->user_id
                                                ]
                                            ]
                                        ]);
                                    }

                                ],
                                'urlCreator' => function ($action) {
                                    if ($action === 'accept') {
                                        return Url::to(['accept']);
                                    } elseif ($action === 'refuse') {
                                        return Url::to(['refuse']);
                                    } elseif ($action === 'suspend') {
                                        return Url::to(['suspend']);
                                    } elseif ($action === 'unlock') {
                                        return Url::to(['unlock']);
                                    }//TODO: переделать в switch
                                }
                            ],

                        ],
                    ]); ?>
                    <?php Pjax::end() ?>
                    <?= Html::a('Отправить заявку на вступление', Url::to(['join']),
                        [
                            'class' => 'btn btn-primary',
                            'data' => [
                                'method' => 'post',
                                'params' => ['squadron' => $squadron->id]
                            ]
                        ]) ?>
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
                        <li class="active"><a href="#default-tab-1" data-toggle="tab" aria-expanded="true">Default Tab
                                1</a>
                        </li>
                        <li class=""><a href="#default-tab-2" data-toggle="tab" aria-expanded="false">Default Tab 2</a>
                        </li>
                        <li class=""><a href="#default-tab-3" data-toggle="tab" aria-expanded="false">Default Tab 3</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="default-tab-1">
                            <p>
                                <img
                                    src="http://samolets.com/wp-content/gallery/boeing-737-800-aeroflot/boeing-737-800-vp-brf-aeroflot-3.jpg"
                                    height="400">
                                <br>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                Integer ac dui eu felis hendrerit lobortis. Phasellus elementum, nibh eget
                                adipiscing
                                porttitor,
                                est diam sagittis orci, a ornare nisi quam elementum tortor. Proin interdum ante
                                porta
                                est
                                convallis
                                dapibus dictum in nibh. Aenean quis massa congue metus mollis fermentum eget et
                                tellus.
                                Aenean tincidunt, mauris ut dignissim lacinia, nisi urna consectetur sapien, nec
                                eleifend orci
                                eros id lectus.
                            </p>
                            <p class="text-right m-b-0">
                                <a href="javascript:;" class="btn btn-white m-r-5">Default</a>
                                <a href="javascript:;" class="btn btn-primary">Primary</a>
                            </p>
                        </div>
                        <div class="tab-pane fade" id="default-tab-2">
                            <blockquote>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                <small>Someone famous in <cite title="Source Title">Source Title</cite></small>
                            </blockquote>
                            <h4>Lorem ipsum dolor sit amet</h4>
                            <p>
                                Nullam ac sapien justo. Nam augue mauris, malesuada non magna sed, feugiat blandit
                                ligula.
                                In tristique tincidunt purus id iaculis. Pellentesque volutpat tortor a mauris
                                convallis,
                                sit amet scelerisque lectus adipiscing.
                            </p>
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