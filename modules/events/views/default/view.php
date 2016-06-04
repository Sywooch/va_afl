<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Events */

$this->title = $model->contentInfo->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Events'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->contentInfo->name;
?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title"><?= Html::encode($this->title) ?></h4>
    </div>

    <div class="panel-body">
        <div class="well row" style="min-height: 50px">
            <div class="col-md-6">
                <?php if (Yii::$app->user->can('events/edit')): ?>
                    <?=
                    Html::a(
                        Yii::t('app', 'Update Content'),
                        ['/content/update/' . $model->contentInfo->id],
                        ['class' => 'btn btn-primary']
                    ) ?>
                    <?=
                    Html::a(
                        Yii::t('app', 'Update Event'),
                        ['/events/update/' . $model->id],
                        ['class' => 'btn btn-primary']
                    ) ?>
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
                <?php if ($model->author != 0): ?>
                    <p class="text-right"> Author: <?=
                        Html::a(
                            $model->authorUser->full_name,
                            Url::to('/pilot/profile/' . $model->authorUser->vid)
                        ) ?></p>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-md-3">
            <h4></h4>
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th><h4><?= $model->airbridge ? Yii::t('flights', 'Airbridge') : Yii::t('app', 'Airports') ?> </h4></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="tablecat" style="padding:10px; text-align: center;" colspan="3">
                        <strong>Departures</strong></td>
                </tr>
                <?php if (!empty($model->fromArray)): ?>
                    <?php foreach ($model->fromArray as $airport): ?>
                        <tr>
                            <td><img src="<?= $airport->flagLink ?>"> <a
                                    href="/airline/airports/view/<?= $airport->icao ?>"><?= $airport->fullname ?></a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td><?= Yii::t('app', 'No info') ?></td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td class="tablecat" style="padding:10px; text-align: center;" colspan="3">
                        <strong>Arrivals</strong></td>
                </tr>
                <?php if (!empty($model->toArray)): ?>
                    <?php foreach ($model->toArray as $airport): ?>
                        <tr>
                            <td><img src="<?= $airport->flagLink ?>"> <a
                                    href="/airline/airports/view/<?= $airport->icao ?>"><?= $airport->fullname ?></a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td><?= Yii::t('app', 'No info') ?></td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-9">
            <?php if ($model->contentInfo->img): ?>
                <img width="900" src="<?= $model->contentInfo->img ?>">
            <?php endif; ?>
            <?= $model->contentInfo->getText() ?>
        </div>
    </div>
</div>