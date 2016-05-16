<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 17.01.16
 * Time: 1:35
 */

use yii\helpers\Html;

?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title"><?= Yii::t('app', 'News') ?>
        </h4>
    </div>
    <div class="panel-body bg-silver" data-scrollbar="true" data-height="350px">
        <div>
            <ul class="chats">
                <?php foreach ($news as $news_one): ?>
                    <li class="left">
                        <span class="date-time"><?= (new \DateTime($news_one->created))->format(
                                'g:ia \o\n l jS F'
                            ) ?></span>
                        <a href="/pilot/profile/<?= $news_one->author ?>" class="name"><?= $news_one->authorUser->full_name ?></a>
                        <a href="/content/view/<?= $news_one->id ?>" class="image"><img alt=""
                                                                  src="<?= $news_one->authorUser->avatarLink ?>"/></a>

                        <div class="message">
                            <p>#<?= $news_one->categoryInfo->link ?></p>
                            <p><?= $news_one->description ?></p>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>