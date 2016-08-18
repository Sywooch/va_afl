<?php

use app\models\Users;

?>
<div class="vertical-box">
    <?= $this->render('_sidebar', ['type' => $type]) ?>
    <div class="vertical-box-column bg-white">
        <div class="wrapper">
            <h4 class="m-b-15 m-t-0 p-b-10 underline"><?= $data['topic'] ?></h4>
            <form action="/mail/compose/<?= $data['id'] ?>" method="POST" name="email_to_form">
                <div class="m-b-15">
                    <textarea class="textarea form-control" name="text" id="text" rows="1"
                              placeholder="Enter text ..."></textarea>
                </div>
                <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>"/>
                <button type="submit" class="btn btn-primary p-l-40 p-r-40">Reply</button>
            </form>
        </div>
        <div class="wrapper bg-silver-lighter text-right clearfix">
            <div class="btn-group btn-toolbar">
            </div>
            <div class="btn-group m-l-5">
            </div>
        </div>
        <?php foreach ($data['messages'] as $msg): ?>
            <div class="wrapper">
                <ul class="media-list underline m-b-20 p-b-15">
                    <li class="media media-sm clearfix">
                        <a href="javascript:;" class="pull-left">
                        <img class="media-object rounded-corner" alt="" src="<?=
                        Users::find()->where(['vid' => $msg['from']])->one() ? Users::find()->where(
                            ['vid' => $msg['from']]
                        )->one()->avatarLink : '' ?>">
                    </a>

                    <div class="media-body">
                                    <span class="email-from text-inverse f-w-600">
                                        from <a href="/pilot/profile/<?= $msg['from'] ?>"><?=
                                        Users::find()->where(
                                            ['vid' => $msg['from']]
                                        )->one() ? Users::find()->where(['vid' => $msg['from']])->one(
                                            )->full_name . ' (' . $msg['from'] . ')' : $msg['from'] ?></a>

                                    </span><span class="text-muted m-l-5"><i
                                class="fa fa-clock-o fa-fw"></i> <?=
                            (new \DateTime($msg['created']))->format(
                                'm.d.y h:i:s A'
                            ) ?></span>
                    </div>
                </li>
            </ul>

            <?= nl2br($msg['text']) ?>
        </div>
            <div class="wrapper bg-silver-lighter text-right clearfix">
                <div class="btn-group btn-toolbar">
                </div>
                <div class="btn-group m-l-5">
                </div>
            </div>
        <?php endforeach; ?>
        <div class="wrapper bg-silver-lighter text-right clearfix">
            <div class="btn-group btn-toolbar">
            </div>
            <div class="btn-group m-l-5">
            </div>
        </div>
        <!-- end wrapper -->
    </div>
</div>