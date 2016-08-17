<?php

use app\models\Users;

?>
<div class="vertical-box">
    <?= $this->render('_sidebar', ['type' => $type]) ?>
    <div class="vertical-box-column">
        <ul class="list-group list-group-lg no-radius list-email dialog-wrapper">
            <?php foreach ($content['data'] as $msg) : ?>
                <li onclick="location.href = '/mail/details/<?= $msg['id'] ?>'" class="list-group-item inverse dialog">
                    <a href="/mail/details/<?= $msg['id'] ?>" class="email-user">
                        <img src="<?=
                        Users::find()->where(['vid' => $msg['from']])->one() ? Users::find()->where(
                            ['vid' => $msg['from']]
                        )->one()->avatarLink : '' ?>" alt=""/>
                    </a>

                    <div class="email-info">
                        <span class="email-time"><?=
                            (new \DateTime($msg['created']))->format(
                                'g:ia \o\n l jS F'
                            ) ?></span>
                        <h5 class="email-title">
                            <a href="/mail/details/<?= $msg['id'] ?>"><?= $msg['chat']['topic'] ?></a>
                        </h5>

                        <p class="email-desc">
                            <?= explode(' ', Users::find()->where(['vid' => $msg['from']])->one() ? Users::find()->where(
                                    ['vid' => $msg['from']]
                                )->one()->full_name . ' (' . $msg['from'] . ')' : $msg['from'])[0] ?>
                            : <?= explode("\n", $msg['text'])[0] ?>
                        </p>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="wrapper bg-silver-lighter clearfix">
            <div class="btn-group pull-right">
                <button class="btn btn-white btn-sm">
                    <i class="fa fa-chevron-left"></i>
                </button>
                <button class="btn btn-white btn-sm">
                    <i class="fa fa-chevron-right"></i>
                </button>
            </div>
            <div class="m-t-5"><?= count($content['data']) ?> chats</div>
        </div>
    </div>
</div>