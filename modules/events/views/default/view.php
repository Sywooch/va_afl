<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

\app\assets\ContentAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\Events */

$this->title = $model->contentInfo->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Events'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->contentInfo->name;
?>

<div class="col-md-12" style="padding-bottom: 10px;">
    <div class="well row" style="min-height: 50px;">
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
</div>
<div class="col-md-9">
    <div class="panel panel-inverse">
        <div class="panel-heading"><h4 class="panel-title">About</h4></div>

        <div class="panel-body">
            <h1 class="text-center"><?= Html::encode($this->title) ?></h1>
            <?= $model->contentInfo->getDescription() ?>
            <?php if ($model->contentInfo->img): ?>
                <img class="center-block" height="450px" src="<?= $model->contentInfo->img ?>">
                <hr>
            <?php endif; ?>
            <?= $model->contentInfo->getText() ?>
            <hr>
            <h4><?= Yii::t('app', 'Comments') ?></h4>
            <div>
                <div id="comments" style="min-height: 100px">

                </div>
                <div style="padding-top: 10px">
                    <div class="input-group">
                        <input type="text" class="form-control input-sm" name="message" id="message"
                               placeholder="<?= Yii::t('app', 'Enter your message here') ?>.">
                        <span class="input-group-btn">
                        <button onclick="content_comment(<?= $model->contentInfo->id ?>)" class="btn btn-primary btn-sm"
                                type="button"><?= Yii::t('app', 'Send') ?></button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-3">
    <div class="panel panel-inverse">
        <div class="panel-heading"><h4 class="panel-title">Additional Info</h4></div>

        <div class="panel-body">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th><h4><?= $model->airbridge ? Yii::t('flights', 'Airbridge') : Yii::t('app',
                                'Airports') ?> </h4>
                    </th>
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
                                    href="/airline/airports/view/<?= $airport->icao ?>"><?= $airport->fullname ?></a>
                            </td>
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
                                    href="/airline/airports/view/<?= $airport->icao ?>"><?= $airport->fullname ?></a>
                            </td>
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
    </div>
</div>
<script>
    setTimeout(function () {
        $("#comments").load("/content/comments/<?= $model->contentInfo->id ?>");
    }, 400);
</script>