<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Content */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->categoryInfo->name, 'url' => ['/content/categories/view/'.$model->categoryInfo->link]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title"><?= Html::encode($this->title) ?></h4>
    </div>

    <div class="panel-body">
        <div class="well row" style="min-height: 50px">
            <div class="col-md-6">
                <?php if (Yii::$app->user->can($model->categoryInfo->access_edit) || Yii::$app->user->can(
                        'content/edit'
                    )
                ): ?>
                    <?= Html::a(Yii::t('app', 'Update'), ['update/' . $model->id], ['class' => 'btn btn-primary']) ?>
                    <?=
                    Html::a(
                        Yii::t('app', 'Delete'),
                        ['delete/' . $model->id],
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
                <p class="text-right"> Author: <?=
                    Html::a(
                        $model->authorUser->full_name,
                        Url::to('/pilot/profile/' . $model->authorUser->vid)
                    ) ?></p>

                <p class="text-right">
                    Category: <?=
                    Html::a(
                        $model->categoryInfo->name,
                        Url::to('/content/categories/view/' . $model->categoryInfo->link)
                    ) ?>
                </p>
            </div>
        </div>
        <div class="container">
            <?= $model->getText() ?>
        </div>
    </div>

</div>
