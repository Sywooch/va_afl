<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Airports */

$this->title = $model->fullname;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Airports'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="airports-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        if (Yii::$app->user->can('airports/edit')) {
            echo Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
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
    </p>

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

</div>
