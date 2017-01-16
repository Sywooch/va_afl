<?php

use app\components\Helper;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use app\assets\MapAsset;

MapAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\models\Airports */

$this->title = $model->fullname;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Airports'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="airports-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>

    </p>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title"><?= Yii::t('app', 'Map') ?></h4>
                </div>
                <div class="panel-body">
                    <div id="map" style="height: 450px"></div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title"><?= Yii::t('app', 'Information') ?></h4>
                </div>
                <div class="panel-body">
                    <?=
                    DetailView::widget(
                        [
                            'options' => ['class' => 'table table-condensed table-striped'],
                            'model' => $model,
                            'attributes' => [
                                'icao',
                                'fullname',
                                'coord',
                                'alt',
                                'iata',
                                'city',
                                'iso',
                                'FIR',
                            ],
                        ]
                    ) ?>
                    <hr>
                    <?php
                    if (Yii::$app->user->can('airports/edit')) {
                        echo Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id],
                            ['class' => 'btn btn-primary']);
                        echo Html::a(
                            Yii::t('app', 'Delete'),
                            ['delete', 'id' => $model->id],
                            [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                    'method' => 'post',
                                ],
                            ]
                        );
                    } ?>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title"><?= Yii::t('app', 'Fleet') ?></h4>
                </div>

                <div class="panel-body">

                    <?php Pjax::begin(); ?>
                    <?=
                    GridView::widget(
                        [
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'tableOptions' => [
                                'class' => 'table table-bordered table-striped table-hover'
                            ],
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
                                            ),
                                            [
                                                'target' => '_blank',
                                                'data-pjax' => '0'
                                            ]
                                        );

                                    }
                                ],
                                'type_code',
                                [
                                    'attribute' => 'status',
                                    'label' => Yii::t('app', 'Status'),
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                        switch ($data->status) {
                                            case -1:
                                                return '<i class="fa fa-calendar"></i> ' . Yii::t('flights',
                                                    'In History');
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
                                                'target' => '_blank',
                                                'data-pjax' => '0',
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
        <div class="col-md-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title"><?= Yii::t('app', 'Pilots') ?></h4>
                </div>
                <div class="panel-body" style="display: block;">
                    <?php Pjax::begin(); ?>
                    <?php echo \yii\grid\GridView::widget(
                        [
                            'dataProvider' => $pilotsProvider,
                            'tableOptions' => [
                                'class' => 'table table-bordered table-striped table-hover'
                            ],
                            'layout' => '{items}{pager}',
                            'columns' => [
                                [
                                    'attribute' => 'full_name',
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                        return "<img src=" . $data->flaglink . "> " .
                                        Html::a($data->full_name, Url::to('/pilot/profile/' . $data->vid));
                                    }
                                ],
                            ]
                        ]
                    ); ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    var map;

    function initMap() {
        var myLatLng = {lat: <?= $model->lat ?>, lng: <?= $model->lon ?>};
        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map
        });
    }

    setTimeout(function () {
        initialize(10, <?= $model->lat ?>, <?= $model->lon ?>);
        initMap();
    }, 500);

</script>