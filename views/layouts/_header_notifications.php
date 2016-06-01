<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 28.05.16
 * Time: 19:09
 */
use app\models\Services\notifications\Notification;

?>
<a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle f-s-14">
    <i class="fa fa-bell-o"></i>
    <?php if (Notification::count() > 0): ?>
        <span class="label"><?= Notification::count() ?></span>
    <?php endif; ?>
</a>
<ul class="dropdown-menu media-list pull-right animated fadeInDown">
    <li class="dropdown-header"><?= Yii::t('app', 'Notifications') ?></li>
    <?php foreach (Notification::last() as $notification): ?>
        <li class="media">
            <a href="javascript:;">
                <div class="media-left"><?= $notification->iconHTML ?></div>
                <div class="media-body">
                    <h6 class="media-heading"><?= $notification->fromUser->full_name ?></h6>

                    <p><?= $notification->content->description ?></p>

                    <div class="text-muted f-s-11">
                        <?= (new \DateTime($notification->created))->format('g:ia \o\n l jS F') ?>
                    </div>
                </div>
            </a>
        </li>
    <?php endforeach; ?>
    <li class="dropdown-footer text-center">
        <a href="/pilot/notifications/index"><?= Yii::t('app', 'View more') ?></a>
    </li>
</ul>