<?php

use app\components\Helper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Fleet */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fleets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fleet-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->user->can('fleet/edit')): ?>
        <p>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], [
                'class' => 'btn btn-primary',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
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

    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title"></h4>
        </div>

        <?php if ($model->image_path) : ?>
            <img class="img-responsive center-block" height="350px" src="<?= $model->image_path ?>">
            <div class="col-md-12">
                <hr>
            </div>
        <?php endif; ?>

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
            <div class="col-md-12">
                <hr>
            </div>
        </div>
    </div>
</div>
