<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 02.08.16
 * Time: 11:33
 */
use app\models\Content;

?>
<div class="col-lg-3 panel">
    <div class="panel-body">
        <h4><?= Yii::t('app', 'Categories') ?></h4>

        <div class="hline"></div>
        <p><a href="/news"> <?= Yii::t('app', 'All') ?></a> <span
                class="badge badge-theme pull-right"><?= count($all) ?></span></p>
        <?php foreach ($categories as $cat): ?>

            <p><a href="/news/<?= $cat->link ?>"> <?= $cat->name ?></a> <span
                    class="badge badge-theme pull-right"><?= count($cat->content) ?></span></p>
        <?php endforeach; ?>
        <hr>

        <h4><?= Yii::t('app', 'Recent') ?></h4>

        <div class="hline"></div>
        <ul class="popular-posts list-unstyled">
            <?php foreach (Content::news(5) as $post): ?>
                <li class="row">
                    <div class="col-md-3">
                        <a class="thumbnail" target="_blank" href="/pilot/profile/<?= $post->author ?>"><img
                                class="img-rounded" data-toggle="tooltip" data-placement="top" title="<?= $post->authorUser->full_name ?>" src="<?= $post->authorUser->avatarLink ?>"></a>
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