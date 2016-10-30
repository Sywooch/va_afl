<?php

use app\models\Flights;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

\app\assets\ContentAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\Events */

$this->title = $model->contentInfo->name.' ('.$model->startDT->format('d.m.Y').' )';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Events'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->contentInfo->name;
?>

<div class="col-md-12" style="padding-bottom: 10px;">
    <div class="well row" style="min-height: 50px;">
        <div class="col-md-12">
            <?php if (Yii::$app->user->can('events/edit')): ?>
                <?=
                Html::a(
                    Yii::t('app', 'Update Content'),
                    ['/content/update/' . $model->contentInfo->id],
                    ['class' => 'btn btn-primary', 'target' => '_blank']
                ) ?>
                <?=
                Html::a(
                    Yii::t('app', 'Update Event'),
                    ['/events/update/' . $model->id],
                    ['class' => 'btn btn-primary', 'target' => '_blank']
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
    </div>
</div>
<div class="col-md-9">
    <div class="panel panel-inverse">
        <div class="panel-heading"><h4 class="panel-title">&nbsp;</h4></div>

        <div class="panel-body">
            <legend>
                <h2><?= Html::encode($this->title) ?></h2>
            </legend>
            <?= $model->contentInfo->getDescription() ?>
            <?php if ($model->contentInfo->img): ?>
                <img class="center-block" height="450px" src="<?= $model->contentInfo->imgLink ?>">
                <hr>
            <?php endif; ?>
            <h3><?= Yii::t('app', 'Information') ?></h3>
            <?= $model->contentInfo->getText() ?>
            <hr>
            <h3><?= Yii::t('app', 'Route') ?></h3>
            <?php if (!empty($model->fromArray)): ?>
                <?php $i = 0 ?>
                <?php foreach ($model->fromArray as $airport): ?>
                    <?= $i > 0 ? ',' : '' ?>
                    <img src="<?= $airport->flagLink ?>"><a href="/airline/airports/view/<?= $airport->icao ?>"><b><?= $airport->icao ?></b></a>
                    <?php $i++; endforeach; ?>
            <?php else: ?>
                <b>XXXX</b>
            <?php endif; ?>
            <?= $model->airbridge ? '↔' : '→'?>
            <?php if (!empty($model->toArray)): ?>
                <?php $i = 0 ?>
                <?php foreach ($model->toArray as $airport): ?>
                    <?= $i > 0 ? ', ' : '' ?>
                    <img src="<?= $airport->flagLink ?>"><a href="/airline/airports/view/<?= $airport->icao ?>"><b><?= $airport->icao ?></b></a>
                    <?php $i++; endforeach; ?>
            <?php else: ?>
                <b>XXXX</b>
            <?php endif; ?>
            <hr>
            <h3><?= Yii::t('app', 'Date and Time') ?></h3>
            <b><?= $model->startDT->format('d F Y') ?></b>
            <br>
            <b><?= $model->startDT->format('H:i') ?> → <?= $model->stopDT->format('H:i') ?></b>
            <hr>
            <p class="text-right">
                <?php if ($model->author != 0): ?>
                    <?= Yii::t('app', 'Author') ?>: <?=
                    Html::a(
                        $model->authorUser->full_name,
                        Url::to('/pilot/profile/' . $model->authorUser->vid)
                    ) ?>
                    <br>
                <?php endif; ?>
                <?= Yii::t('app', 'Created') ?>: <?= (new \DateTime($model->contentInfo->created))->format('d.m.Y') ?>
            </p>
            <hr>
            <legend>
                <h3><?= Yii::t('app', 'Comments') ?></h3>
            </legend>
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
        <div class="panel-heading"><h4 class="panel-title"><?= Yii::t('app', 'Statistics') ?></h4></div>

        <div class="panel-body">
            <div class="list-group">
                <h4 class="text-center"><?= Yii::t('app', 'Flights') ?>/<?= Yii::t('app', 'Participants') ?>:</h4>
                <h1 class="text-center" style="font-size: 4em;"><?= count($model->flights) ?><small>/<?= count($model->users) ?></small></h1>
            </div>
            <?= $this->render('flights', ['flightsProvider' => new ActiveDataProvider([
                'query' => Flights::find()->where(['id' => \yii\helpers\ArrayHelper::getColumn($model->flights, 'flight_id')]),
                'sort' => false,
                'pagination' => false,
            ])]) ?>
        </div>
    </div>
</div>
<script>
    setTimeout(function () {
        $("#comments").load("/content/comments/<?= $model->contentInfo->id ?>");
    }, 400);
</script>