<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Contents');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php
    if (Yii::$app->user->can('content/edit')): ?>
        <div class="well">
            <?= Html::a(Yii::t('content', 'Create Content'), ['create'], ['class' => 'btn btn-success']) ?>
            <?= Html::a(Yii::t('content', 'Content Category'), ['categories'], ['class' => 'btn btn-success']) ?>
        </div>
    <?php endif; ?>


    <?=
    GridView::widget(
        [
            'options' => ['class' => 'grid-view striped condensed bordered'],
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'attribute' => 'name',
                    'format' => 'raw',
                    'value' => function ($data) {
                            return Html::a($data->name, \yii\helpers\Url::to('/content/view/' . $data->id));
                        }
                ]
            ],
        ]
    ); ?>

</div>
