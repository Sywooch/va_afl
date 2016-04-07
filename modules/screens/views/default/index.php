<?php

use yii\helpers\Html;

\app\assets\ContentAsset::register($this);
/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Screens');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>
<ul class="timeline">
    <?php foreach ($screens as $screen) : ?>
        <li>
            <!-- begin timeline-time -->
            <div class="timeline-time">
                <span class="date"><?= $screen->createdDT->format('d F Y')?></span>
                <span class="time"><?= $screen->createdDT->format('H:i')?></span>
            </div>
            <!-- end timeline-time -->
            <!-- begin timeline-icon -->
            <div class="timeline-icon">
                <a href="javascript:;"><i class="fa fa-camera"></i></a>
            </div>
            <!-- end timeline-icon -->
            <!-- begin timeline-body -->
            <div class="timeline-body">
                <div class="timeline-header">
                    <span class="userimage"><img src="<?= $screen->authorUser->avatarLink ?>" alt=""/></span>
                    <span class="username"><?= $screen->authorUser->full_name ?></span>
                    <span class="pull-right text-muted"><?= $screen->views ?></span>
                </div>
                <div class="timeline-content">
                    <h4 class="template-title">
                        <i class="fa fa-map-marker text-danger fa-fw"></i>
                        <a href="/screens/view/<?= $screen->id ?>"><?= $screen->name ?></a>
                    </h4>

                    <p><?= $screen->description ?></p>

                    <p class="m-t-20">
                        <img src="<?= $screen->imgLink ?>" alt=""/>
                    </p>
                </div>
                <div class="timeline-footer">
                    <a href="javascript:content_like(<?= $screen->id ?>);" id="btn_like_<?= $screen->id ?>" class="m-r-15 btn btn-default<?= $screen->like ? ' disabled btn-success' : '' ?>"><i class="fa fa-thumbs-up fa-fw"></i> Like</a>
                    <button class="btn btn-default" id="btn_like_<?= $screen->id ?>_num"disabled><?= $screen->likesCount ?></button>
                </div>

            </div>
        </li>
    <?php endforeach; ?>
</ul>