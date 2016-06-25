<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\ContentCategories */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Content'), 'url' => ['/content']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Content Categories'), 'url' => ['/content/categories']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-categories-view">

    <h1><?= $this->title ?></h1>
    <?php if (Yii::$app->user->can('content/edit') || Yii::$app->user->can($model->access_edit)): ?>
    <div class="well">
        <?php endif; ?>
        <?php if (Yii::$app->user->can($model->access_edit) || Yii::$app->user->can('content/edit')): ?>
            <?=
            Html::a(
                Yii::t('app', 'Create'),
                ['/content/create'],
                [
                    'class' => 'btn btn-success',
                    'data' => [
                        'method' => 'post',
                        'params' => [
                            'category_id' => $model->id,
                        ]
                    ]
                ]
            ) ?>        <?php endif; ?>
        <?php if (Yii::$app->user->can('content/edit')): ?>
            <?= Html::a(Yii::t('app', 'Update'), ['/content/categories/update/' . $model->id], ['class' => 'btn btn-primary']) ?>
            <?=
            Html::a(
                Yii::t('app', 'Delete'),
                ['/content/categories/delete/' . $model->id],
                [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]
            ) ?>
        <?php endif; ?>
        <?php if (Yii::$app->user->can('content/edit') || Yii::$app->user->can($model->access_edit)): ?>
            </div>
        <?php endif; ?>

    <?php if (Yii::$app->user->can('content/edit') || Yii::$app->user->can($model->access_edit)): ?>
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title"><?= Yii::t('content', 'Category information') ?></h4>
            </div>

            <div class="panel-body">
                <?=
                DetailView::widget(
                    [
                        'model' => $model,
                        'attributes' => [
                            'link',
                            'link_to',
                            'name_ru',
                            'name_en',
                            'access_read',
                            'access_edit',
                            'access_feed',
                            'news',
                            'notifications',
                        ],
                    ]
                ) ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title"><?= Yii::t('content', 'Articles') ?></h4>
        </div>

        <div class="panel-body">
            <?=
            GridView::widget(
                [
                    'options' => ['class' => 'grid-view striped condensed bordered'],
                    'dataProvider' => new \yii\data\ActiveDataProvider(['query' => $model->getContent()]),
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
    </div>
</div>
