<?php

use app\models\Content;
use yii\helpers\Html;

\app\assets\ContentAsset::register($this);
/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Feed');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<? /*
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
                          href="<?= $post->contentLink ?>"><?= $post->description ?></a>
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
*/ ?>
<div class="col-md-1"></div>
<div class="col-md-8">
    <?= \yii\widgets\ListView::widget([
        'dataProvider' => $feed,
        'layout' => "{items}\n{pager}",
        'options' => [
            'tag' => 'ul',
            'class' => 'timeline',
        ],
        'itemOptions' => [
            'class' => 'item',
            'tag' => 'li',
        ],
        'itemView' => '_post',
        'pager' => [
            'options' => [
                'class' => 'pagination well',
            ],
        ],
        //'pager' => ['class' => \kop\y2sp\ScrollPager::className()],
    ]); ?>
</div>
<div class="col-md-3">
    <div class="panel">
        <div class="panel-body">
            <?= Html::a('<i class="fa fa-picture-o"></i> ' . Yii::t('screens', 'Screenshots top'), '/screens/top',
                ['class' => 'btn btn-danger', 'target' => '_blank']) ?>
            <?= Html::a('<i class="fa fa-picture-o"></i> ' . Yii::t('screens', 'Upload screenshot'), '#',
                ['class' => 'btn btn-warning', 'onclick' => 'screenModal();']) ?>
        </div>
    </div>
</div>
<style>
    .timeline:before {
        content: none;
    }
</style>