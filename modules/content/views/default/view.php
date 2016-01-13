<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Content */

$this->title = $model->getName();
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="well row" style="min-height: 50px">
        <div class="col-md-6">
            <?php if (Yii::$app->user->can('content/edit') || Yii::$app->user->can(
                    'content/categories/edit/' . $model->categoryInfo->link
                )
            ): ?>
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
        </div>
        <div class="col-md-6">
            <p class="text-right"> Author: <?= Html::a(
                    $model->authorUser->full_name,
                    Url::to('/pilot/profile/' . $model->authorUser->vid)
                ) ?></p>
            <p class="text-right">
                Category: <?= Html::a(
                    $model->categoryInfo->name,
                    Url::to('/content/categories/view/' . $model->categoryInfo->link)
                ) ?>
            </p>
        </div>
    </div>

    <p>
        <?= Html::encode($model->getText()) ?>
    </p>

</div>
