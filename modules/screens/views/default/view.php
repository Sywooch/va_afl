<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Content */
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Screenshots'), 'url' => ['/screens']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="well row" style="min-height: 50px">
    <div class="col-md-6">
        <?php if (Yii::$app->user->can('content/edit')): ?>
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
    </div>
</div>

<div class="row">
    <div class="col-md-12" style="padding-bottom: 50px;">
        <h1 style="text-align: center; margin: 30px auto;"><?= Html::encode($this->title) ?></h1>

        <div class="container">
            <img class="img-responsive container" src="<?= $model->imgLink ?>">
        </div>
    </div>

    <div class="col-md-12">
        <?= $model->getText() ?>
    </div>

    <div class="col-md-8">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title"><?= Yii::t('app', 'Comments') ?> <span
                        class="label label-success pull-right"><?= count($model->comments) ?> comments</span>
                </h4>
            </div>
            <div class="panel-body bg-silver" data-scrollbar="true" data-height="350px">
                <div>
                    <ul class="chats">
                        <?php foreach ($model->comments as $comment): ?>
                            <li class="left">
                        <span class="date-time"><?=
                            (new \DateTime($comment->write))->format(
                                'g:ia \o\n l jS F'
                            ) ?></span>
                                <a href="/pilot/profile/<?= $comment->user_id ?>"
                                   class="name"><img alt="" height="50px" src="<?= $comment->user->avatarLink ?>"/> <?= $comment->user->full_name ?></a>

                                <div class="message">
                                    <?= $comment->text ?>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title"><?= Yii::t('app', 'Likes') ?> <span
                        class="label label-success pull-right"><?= count($model->likes) ?> likes</span>
                </h4>
            </div>
            <div class="panel-body bg-silver" data-scrollbar="true" data-height="350px">
                <div>
                    <ul class="chats">
                        <?php foreach ($model->likes as $like): ?>
                            <li class="left">
                                <a href="/pilot/profile/<?= $like->user_id ?>"
                                   class="name"><img alt="" height="50px" src="<?= $like->user->avatarLink ?>"/> <?= $like->user->full_name ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
