<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Airports');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="airports-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        if (Yii::$app->user->can('airports/edit')) {
            echo Html::a(Yii::t('app', 'Create Airport'), ['create'], ['class' => 'btn btn-success']);
        }
        ?>
    </p>

    <?=
    GridView::widget(
        [
            'options' => ['class' => 'grid-view striped condensed bordered'],
            'dataProvider' => $dataProvider,
            'filterModel' => $model,
            'columns' => [
                [
                    'attribute' => 'icao',
                    'format' => 'raw',
                    'value' => function ($data) {
                            return Html::a($data->icao, \yii\helpers\Url::to('/airline/airports/view/' . $data->icao));
                        }
                ],
                'name',
                //'lat',
                //'lon',
                // 'alt',
                // 'iata',
                'city',
                [
                    'attribute' => 'country.country',
                    'format' => 'html',
                    'value' => function ($data) {
                            return "<img src='" . $data->flaglink . "'>" . $data->country->country;
                        }
                ],
                // 'FIR',

                ['class' => 'yii\grid\ActionColumn', 'visible' => Yii::$app->user->can('airports/edit')],
            ],
        ]
    ); ?>

</div>
