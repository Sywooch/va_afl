<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 02.08.16
 * Time: 9:58
 */
/**
 * @var $model \app\models\Content
 */
use app\models\Content;
use app\models\ContentCategories;

\app\assets\ContentAsset::register($this);
?>
    <div class="col-md-9">
        <div class="panel panel-news">
            <div class="panel-body">
                <h1><?= $model->name ?></h1>

                <ul class="list-inline">
                    <li><?= $model->createdDT->format('d F Y')?></li>
                    <li><a href="/news/<?= $model->categoryInfo->link ?>"><?= $model->categoryInfo->name ?></a></li>
                    <?php if (!empty($model->forum)) : ?>
                        <li><a href="<?= $model->forum ?>"><i class="fa fa-comments"></i> <?= Yii::t('app', 'Discuss in forum') ?></a></li>
                    <?php endif; ?>
                </ul>
                <?= $model->text ?>
                <hr>
                <h4><?= Yii::t('app', 'Author') ?></h4>
                <div class="timeline-header">
                    <span class="userimage"><img src="<?= $model->authorUser->avatarLink ?>" alt=""/></span>
                    <span class="username"><a href="/pilot/profile/<?= $model->authorUser->vid ?>"><?= $model->authorUser->full_name ?></a></span>
                    <span class="pull-right text-muted"><?= $model->views ?></span>
                </div>
                <hr>
                <a href="javascript:content_like(<?= $model->id ?>);" id="btn_like_<?= $model->id ?>"
                   class="m-r-15 btn btn-default<?= $model->like ? ' disabled btn-success' : '' ?>"><i
                        class="fa fa-thumbs-up fa-fw"></i> Like</a>
                <button class="btn btn-default" id="btn_like_<?= $model->id ?>_num"
                        disabled><?= $model->likesCount ?></button>
                <hr>
            </div>
        </div>


    </div><!--/col-12-->

<?= $this->render('sidebar', ['categories' => ContentCategories::news(), 'all' => Content::news()]) ?>