<?php

use app\models\Content;
use yii\helpers\Html;

\app\assets\ContentAsset::register($this);
/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Feed');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>
<div class="col-md-9">
    <ul class="timeline">
        <?php foreach ($feed as $post) : ?>
            <li>
                <!-- begin timeline-time -->
                <div class="timeline-time">
                    <span class="date"><?= $post->createdDT->format('d F Y') ?></span>
                    <span class="time"><?= $post->createdDT->format('H:i') ?></span>
                </div>
                <!-- end timeline-time -->
                <!-- begin timeline-icon -->
                <div class="timeline-icon">
                    <a href="javascript:;"><i class="fa fa-camera"></i></a>
                </div>
                <!-- end timeline-icon -->
                <!-- begin timeline-body -->
                <div class="timeline-body" style="margin-right: 0;">
                    <div class="timeline-header">
                        <span class="userimage"><img src="<?= $post->authorUser->avatarLink ?>" alt=""/></span>
                        <img title="<?= $post->authorUser->country ?>" style="display: inline;" src="<?= $post->authorUser->flaglink ?>">
                        <span class="username"><a href="/pilot/profile/<?= $post->authorUser->vid ?>">
                                <?= $post->authorUser->full_name ?>
                                </a></span>
                        <h3 style="display: inline"><span class="label label-warning">
                                    <i class="fa fa-star" aria-hidden="true"></i> <?= $post->authorUser->pilot->level ?></span></h3>
                        <span class="pull-right text-muted"><?= $post->views ?></span>
                    </div>
                    <div class="timeline-content">
                        <h4 class="template-title">
                            <i class="fa fa-map-marker text-danger fa-fw"></i>
                            <a target="_blank" href="<?= $post->contentLink ?>"><?= $post->name ?></a>
                        </h4>

                        <p><?= $post->description ?></p>
                        <?php if ($post->imgLink): ?>
                            <p class="m-t-20">
                                <?php if ($post->category == 16): ?>
                                <a name="<?= $post->id ?>" href="#<?= $post->id ?>" class="imgmodel">
                                    <?php endif; ?>
                                    <img src="<?= $post->imgLink ?>" alt=""/>
                                    <?php if ($post->category == 16): ?></a><?php endif; ?>
                            </p>
                        <?php endif; ?>
                    </div>
                    <div class="timeline-footer">
                        <a href="javascript:content_like(<?= $post->id ?>);" id="btn_like_<?= $post->id ?>"
                           class="m-r-15 btn btn-default<?= $post->like ? ' disabled btn-success' : '' ?>"><i
                                class="fa fa-thumbs-up fa-fw"></i> Like</a>
                        <button class="btn btn-default" id="btn_like_<?= $post->id ?>_num"
                                disabled><?= $post->likesCount ?></button>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<div class="col-lg-3 panel">
    <div class="panel-body">
        <h4><?= Yii::t('app', 'Categories') ?></h4>

        <div class="hline"></div>
        <p><a href="/news"> <?= Yii::t('app', 'All') ?></a> <span
                class="badge badge-theme pull-right"></span></p>
        <hr>

        <h4><?= Yii::t('app', 'Last news') ?></h4>

        <div class="hline"></div>
        <ul class="popular-posts list-unstyled">
            <?php foreach (Content::news(5) as $post): ?>
                <li class="row">
                    <div class="col-md-3">
                        <a class="thumbnail" target="_blank" href="/pilot/profile/<?= $post->author ?>"><img
                                class="img-rounded" data-toggle="tooltip" data-placement="top"
                                title="<?= $post->authorUser->full_name ?>" src="<?= $post->authorUser->avatarLink ?>"></a>
                    </div>
                    <div class="col-md-9">
                        <div class="col-md-12">
                            <p><a target="_blank"
                                  href="/news/<?= $post->categoryInfo->link ?>/<?= $post->link ?>"><?= $post->description ?></a>
                            </p>
                        </div>
                        <div class="col-md-12">
                            <em class="small"><?= $post->createdDT->format('d F Y') ?></em>
                        </div>
                    </div>
                </li>
                <li>
                    <hr>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>