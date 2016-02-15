<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Events */

$this->title = $model->contentInfo->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Events'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title"><?= Html::encode($this->title) ?></h4>
    </div>

    <div class="panel-body">
        <div class="well row" style="min-height: 50px">
            <div class="col-md-6">
                <?php if (Yii::$app->user->can('events/edit')): ?>
                    <?= Html::a(Yii::t('app', 'Update Content'), ['/content/update/' . $model->contentInfo->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a(Yii::t('app', 'Update Event'), ['/events/update/' . $model->id], ['class' => 'btn btn-primary']) ?>
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
            </div>
        </div>
        <div class="container">
            <?= $model->contentInfo->getText() ?>
        </div>
    </div>
</div>