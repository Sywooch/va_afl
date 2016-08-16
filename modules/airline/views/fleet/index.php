<?php

use app\components\Helper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\airline\models\FleetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Fleets');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fleet-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php if (Yii::$app->user->can('fleet/edit')): ?>
        <p>
            <?= Html::a(Yii::t('app', 'Create Fleet'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif; ?>

    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title"></h4>
        </div>

        <div class="panel-body">
            <?php Pjax::begin(); ?>
            <?=
            GridView::widget(
                [
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        [
                            'attribute' => 'regnum',
                            'label' => Yii::t('flights', 'Aircraft'),
                            'format' => 'raw',
                            'value' => function ($data) {
                                    return Html::a(
                                        Html::encode($data->regnum),
                                        Url::to(
                                            [
                                                '/airline/fleet/view/' . $data->id,
                                            ]
                                        )
                                    );

                                }
                        ],
                        'type_code',
                        [
                            'attribute' => 'location',
                            'label' => Yii::t('app', 'Location'),
                            'format' => 'raw',
                            'value' => function ($data) {
                                    return Html::a(
                                        Html::img(
                                            Helper::getFlagLink($data->airportInfo->iso)
                                        ) . ' ' .
                                        Html::encode(
                                            $data->airportInfo->name
                                        ) . ' (' . Html::encode($data->location) . ')',
                                        Url::to(
                                            [
                                                '/airline/airports/view/',
                                                'id' => $data->location
                                            ]
                                        ),
                                        [
                                            'data-toggle' => "tooltip",
                                            'data-placement' => "top",
                                            'title' => Html::encode($data->airportInfo->city)
                                        ]
                                    );
                                },
                        ],
                        [
                            'attribute' => 'status',
                            'label' => Yii::t('app', 'Status'),
                            'format' => 'raw',
                            'value' => function ($data) {
                                    switch ($data->status) {
                                        case -1:
                                            return '<i class="fa fa-calendar"></i> ' . Yii::t('flights', 'In History');
                                            break;
                                        case 0:
                                            return '<i class="fa fa-unlock"></i> ' . Yii::t('flights', 'Available');
                                            break;
                                        case 1:
                                            return '<i class="fa fa-lock"></i> ' . Yii::t('flights', 'Booked');
                                            break;
                                        case 2:
                                            return '<i class="fa fa-plane"></i> ' . Yii::t('flights', 'In flight');
                                            break;
                                        default:
                                            return '<i class="fa fa-lock"></i> ' . Yii::t('flights', 'No info');
                                    }
                                },
                        ],
                        [
                            'attribute' => 'lastFlight',
                            'label' => Yii::t('app', 'Last') . ' ' . Yii::t('app', 'Flight'),
                            'format' => 'raw',
                            'value' => function ($data) {
                                    return $data->lastFlight != null ? Html::a(
                                        Html::encode(
                                            $data->lastFlight->callsign
                                        ) . ' (' . $data->lastFlight->landing_time . ')',
                                        Url::to(
                                            [
                                                '/airline/flights/view/',
                                                'id' => $data->lastFlight->id
                                            ]
                                        ),
                                        [
                                            'data-toggle' => "tooltip",
                                            'data-placement' => "top",
                                            'title' => Html::encode(
                                                    $data->lastFlight->user->full_name
                                                ) . ' (' . $data->lastFlight->user->vid . ')'
                                        ]
                                    ) : '';
                                }
                        ],
                        [
                            'attribute' => 'profileInfo.name',
                            'label' => 'Profile Name',
                            'format' => 'raw',
                            'value' => function ($data) {
                                    return isset($data->profileInfo) ? $data->profileInfo->name : '###';
                                },
                            'visible' => Yii::$app->user->can('fleet/edit')
                        ],
                    ],
                ]
            ); ?>
            <?php Pjax::end(); ?>

        </div>
    </div>
</div>
