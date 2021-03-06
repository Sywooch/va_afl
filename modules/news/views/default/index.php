<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 02.08.16
 * Time: 9:58
 */
use app\models\Content;
use app\models\ContentCategories;

$this->title = Yii::t('app', 'News').' '.$name;
?>
<h1><?= $this->title ?></h1>
<div class="col-md-9">
    <div class="panel panel-news">
        <div class="panel-body">
            <?php foreach ($content as $post): ?>
            <div class="row">
                <br>

                <div class="col-md-4 col-sm-3 text-center">
                    <a class="story-img" href="/news/<?= $post->categoryInfo->link ?>/<?= $post->link ?>"><img src="<?= $post->imgLink ?>" style="width:127px;height:72px"></a>
                </div>
                <div class="col-md-8 col-sm-9">
                    <h3 class="news-header"><a class="news-link" href="/news/<?= $post->categoryInfo->link ?>/<?= $post->link ?>"><?= $post->name ?></a></h3>

                    <div class="row">
                        <div class="col-xs-9">
                            <p><?= $post->description ?></p>

                            <ul class="list-inline">
                                <li><?= $post->createdDT->format('d F Y')?></li>
                                <li><?= $post->views ?> <?= Yii::t('app', 'Views') ?></li>
                                <li><a href="/news/<?= $post->categoryInfo->link ?>"><?= $post->categoryInfo->name ?></a></li>
                                <?php if (!empty($post->forum)) : ?>
                                    <li><a target="_blank" href="<?= $post->forum ?>"><i class="fa fa-comments"></i> <?= Yii::t('app', 'Discuss in forum') ?></a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <div class="col-xs-3"></div>
                    </div>
                </div>
            </div>
            <hr>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?= $this->render('sidebar', ['categories' => ContentCategories::news(), 'all' => Content::news()]) ?>