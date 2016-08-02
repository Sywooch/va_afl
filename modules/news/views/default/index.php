<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 02.08.16
 * Time: 9:58
 */
use app\models\ContentCategories;
?>
<div class="col-md-9">
    <div class="panel panel-news">
        <div class="panel-body">
            <?php foreach ($content as $post): ?>
            <div class="row">
                <br>

                <div class="col-md-2 col-sm-3 text-center">
                    <a class="story-img" href="/news/<?= $post->categoryInfo->link ?>/<?= $post->link ?>"><img src="//placehold.it/100" style="width:127px;height:72px"></a>
                </div>
                <div class="col-md-10 col-sm-9">
                    <h3 class="news-header"><a class="news-link" href="/news/<?= $post->categoryInfo->link ?>/<?= $post->link ?>"><?= $post->name ?></a></h3>

                    <div class="row">
                        <div class="col-xs-9">
                            <p><?= $post->description ?></p>

                            <ul class="list-inline">
                                <li><?= $post->created ?></li>
                                <li><a href="/news/<?= $post->categoryInfo->link ?>"><?= $post->categoryInfo->name ?></a></li>
                                <li><a href="#"><i class="glyphicon glyphicon-share"></i> 34 Comments</a></li>
                                <?php if (!empty($post->forum)) : ?>
                                    <li><a href="<?= $post->forum ?>"><i class="fa fa-comments"></i> <?= Yii::t('app', 'Discuss in forum') ?></a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <div class="col-xs-3"></div>
                    </div>
                </div>
            </div>
            <hr>
            <?php endforeach; ?>
            <a href="/" class="btn btn-primary pull-right btnNext">
                More <i class="glyphicon glyphicon-chevron-right"></i></a>
        </div>
    </div>
</div>

<?= $this->render('sidebar', ['categories' => ContentCategories::news()]) ?>