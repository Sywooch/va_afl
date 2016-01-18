<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ContentCategoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Content Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Content'), 'url' => ['/content']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-categories-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php if (Yii::$app->user->can('content/edit')): ?>
    <div class="well">
        <?= Html::a(Yii::t('app', 'Create Content Category'), ['create'], ['class' => 'btn btn-success']) ?>
    </div>
    <?php endif; ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function ($data) {
                        return Html::a($data->name, \yii\helpers\Url::to('/content/categories/view/' . $data->id));
                    }
            ]
        ],
    ]); ?>

</div>
