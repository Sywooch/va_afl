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

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (Yii::$app->user->can($model->access_edit) || Yii::$app->user->can('content/edit')): ?>
    <div class="well">
        <?php endif; ?>
        <?php if (Yii::$app->user->can($model->access_edit) || Yii::$app->user->can('content/edit')): ?>
            <?= Html::a(Yii::t('app', 'Create Content'), Url::to('/content/create'), ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
        <?php if (Yii::$app->user->can($model->access_edit) || Yii::$app->user->can('content/edit')): ?>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?=
            Html::a(
                Yii::t('app', 'Delete'),
                ['delete', 'id' => $model->id],
                [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]
            ) ?>
        <?php endif; ?>
        <?php if (Yii::$app->user->can($model->access_edit) || Yii::$app->user->can('content/edit')): ?>
    </div>
<?php endif; ?>

    <?php if (Yii::$app->user->can($model->access_edit) || Yii::$app->user->can('content/edit')): ?>
    <?=
    DetailView::widget(
        [
            'model' => $model,
            'attributes' => [
                'link',
                'name_ru',
                'name_en',
                'access_read',
                'access_edit'
            ],
        ]
    ) ?>
    <?php endif; ?>

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
