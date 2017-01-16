<?php

use app\components\Helper;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Fleet */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fleets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fleet-view">
    <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-md-12">
            <?php if ($model->image_path) : ?>
                <img class="img-responsive center-block" height="350px" src="<?= $model->image_path ?>">
                <div class="col-md-12">
                    <hr>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-md-4">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title"><?= Yii::t('app', 'Information') ?></h4>
                </div>
                <div class="panel-body">
                    <?=
                    DetailView::widget(
                        [
                            'model' => $model,
                            'attributes' => [
                                'regnum',
                                'type_code',
                                'full_type',
                                [
                                    'attribute' => 'status',
                                    'label' => Yii::t('app', 'Status'),
                                    'format' => 'raw',
                                    'value' => $model->statusHTML
                                ],
                                [
                                    'attribute' => 'home_airport',
                                    'label' => Yii::t('app', 'Home Airport'),
                                    'format' => 'raw',
                                    'value' => Html::a(
                                        Html::img(
                                            Helper::getFlagLink($model->homeAirportInfo->iso)
                                        ) . ' ' .
                                        Html::encode(
                                            $model->homeAirportInfo->name
                                        ) . ' (' . Html::encode($model->home_airport) . ')',
                                        Url::to(
                                            [
                                                '/airline/airports/view/',
                                                'id' => $model->home_airport
                                            ]
                                        ),
                                        [
                                            'data-toggle' => "tooltip",
                                            'data-placement' => "top",
                                            'title' => Html::encode($model->homeAirportInfo->city)
                                        ]
                                    )
                                ],
                                [
                                    'attribute' => 'location',
                                    'label' => Yii::t('app', 'Location'),
                                    'format' => 'raw',
                                    'value' => Html::a(
                                        Html::img(
                                            Helper::getFlagLink($model->airportInfo->iso)
                                        ) . ' ' .
                                        Html::encode(
                                            $model->airportInfo->name
                                        ) . ' (' . Html::encode($model->location) . ')',
                                        Url::to(
                                            [
                                                '/airline/airports/view/',
                                                'id' => $model->location
                                            ]
                                        ),
                                        [
                                            'data-toggle' => "tooltip",
                                            'data-placement' => "top",
                                            'title' => Html::encode($model->airportInfo->city)
                                        ]
                                    )
                                ],
                                [
                                    'attribute' => 'users',
                                    'label' => Yii::t('flights', 'Pilot'),
                                    'format' => 'raw',
                                    'value' => Html::img(Helper::getFlagLink($model->user->country)) . ' ' . Html::a(
                                            Html::encode($model->user->full_name),
                                            Url::to(
                                                [
                                                    '/pilot/profile/',
                                                    'id' => $model->user_id
                                                ]), ['target' => '_blank'])
                                ],
                                [
                                    'attribute' => 'squadron_id',
                                    'label' => Yii::t('app', 'Flight Squadron'),
                                    'format' => 'raw',
                                    'value' => Html::a(
                                        \app\models\Squadrons::findOne($model->squadron_id)->abbr,
                                        Url::to(
                                            [
                                                '/squadron/view/',
                                                'id' => $model->squadron_id
                                            ]
                                        ),
                                        ['target' => '_blank']
                                    )
                                ],
                                'max_pax',
                                'hrs',
                                'max_hrs',
                                'need_srv',
                            ],
                        ]
                    ) ?>
                    <hr>
                    <?php if (Yii::$app->user->can('fleet/edit')): ?>
                        <p>
                            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], [
                                'class' => 'btn btn-primary',
                                'data' => [
                                    'method' => 'post',
                                ],
                            ]) ?>
                            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title"><?= Yii::t('app', 'Logbook') ?></h4>
                </div>
                <div class="panel-body">
                    <?php Pjax::begin(); ?>
                    <?=
                    GridView::widget(
                        [
                            'dataProvider' => $flightsProvider,
                            'layout' => '{items}{pager}',
                            'tableOptions' => ['class' => 'table table-bordered table-striped table-condensed'],
                            'columns' => [
                                [
                                    'attribute' => 'internal_id',
                                    'label' => Yii::t('flights', 'ID'),
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                        return Html::encode($data->id);
                                    },
                                ],
                                [
                                    'attribute' => 'callsign',
                                    'label' => Yii::t('flights', 'Callsign'),
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                        if (!empty($data->track)) {
                                            return Html::a(
                                                Html::encode($data->callsign),
                                                Url::to(['/airline/flights/view/' . $data->id]),
                                                ['target' => '_blank']
                                            );
                                        }
                                        return Html::encode($data->callsign);
                                    },
                                ],
                                [
                                    'attribute' => 'acf_type',
                                    'label' => Yii::t('flights', 'Aircraft'),
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                        return $data->fleet ? Html::a(
                                            Html::encode($data->fleet->regnum) . " (" . Html::encode($data->fleet->type_code) . ")",
                                            Url::to(
                                                [
                                                    '/airline/fleet/view/' . $data->fleet->id,
                                                ]
                                            ),
                                            [
                                                'target' => '_blank',
                                                'data-toggle' => "tooltip",
                                                'data-placement' => "top",
                                                'title' => Html::encode("{$data->fleet->full_type}")
                                            ]) : '';
                                    }
                                ],
                                [
                                    'attribute' => 'user.full_name',
                                    'label' => Yii::t('flights', 'Pilot'),
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                        return Html::img(Helper::getFlagLink($data->user->country)) . ' ' . Html::a(
                                            Html::encode($data->user->full_name),
                                            Url::to(
                                                [
                                                    '/pilot/profile/',
                                                    'id' => $data->user_id
                                                ]
                                            ),
                                            ['target' => '_blank']);
                                    }
                                ],
                                [
                                    'attribute' => 'from_to',
                                    'label' => Yii::t('flights', 'Route'),
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                        return ($data->depAirport ? Html::a(
                                            Html::img(Helper::getFlagLink($data->depAirport->iso)) . ' ' .
                                            Html::encode($data->from_icao),
                                            Url::to(
                                                [
                                                    '/airline/airports/view/',
                                                    'id' => $data->from_icao
                                                ]
                                            ),
                                            [
                                                'target' => '_blank',
                                                'data-toggle' => "tooltip",
                                                'data-placement' => "top",
                                                'title' => Html::encode("{$data->depAirport->name} ({$data->depAirport->city}, {$data->depAirport->iso})")
                                            ]
                                        ) : $data->from_icao) . ' - ' . ($data->arrAirport ? Html::a(
                                            Html::img(Helper::getFlagLink($data->arrAirport->iso)) . ' ' .
                                            Html::encode($data->to_icao),
                                            Url::to(['/airline/airports/view/', 'id' => $data->to_icao]),
                                            [
                                                'target' => '_blank',
                                                'data-toggle' => "tooltip",
                                                'data-placement' => "top",
                                                'title' => Html::encode("{$data->arrAirport->name} ({$data->arrAirport->city}, {$data->arrAirport->iso})")
                                            ]
                                        ) : $data->to_icao);
                                    },
                                ],
                                [
                                    'attribute' => 'flight_time',
                                    'label' => Yii::t('flights', 'Flight Time'),
                                    'value' => function ($data) {
                                        return Helper::getTimeFormatted($data->flight_time);
                                    },
                                ],
                                [
                                    'attribute' => 'first_seen',
                                    'label' => Yii::t('app', 'Date'),
                                    'format' => ['date', 'php:d.m.Y']
                                ],
                            ],
                        ]
                    ) ?>
                    <?php Pjax::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>
