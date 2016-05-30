<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 30.05.16
 * Time: 4:02
 */
?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title"><?= Yii::t('app', 'Notifications') ?></h4>
    </div>
    <div class="panel-body">
        <ul class="timeline">
            <?php foreach ($notifications as $notification): ?>
                <li>
                    <!-- begin timeline-time -->
                    <div class="timeline-time">
                            <span class="date"><?=
                                (new \DateTime($notification->content->created))->format(
                                    'd F Y'
                                ) ?></span>
                            <span class="time"><?=
                                (new \DateTime($notification->content->created))->format(
                                    'H:i'
                                ) ?></span>
                    </div>
                    <div class="timeline-icon">
                        <a href="javascript:;"><i class="fa fa-rss" aria-hidden="true"></i></a>
                    </div>
                    <div class="timeline-body">
                        <div class="timeline-header">
                            <span class="userimage"><?= $notification->iconHTML ?></span>
                            <span class="username"><a
                                    href="/pilot/profile/<?= $notification->fromUser->vid ?>"><?= $notification->fromUser->full_name ?></a></span>
                        </div>
                        <div class="timeline-content">
                            <h4 class="template-title">
                                <?php if ($notification->content->text): ?>
                                    <?= $notification->content->text ?>
                                <?php else: ?>
                                    <p><?= $notification->content->description ?></p>
                                <?php endif; ?>
                            </h4>
                        </div>
                        <hr>
                    </div>
                </li>
            <?php endforeach; ?>
    </div>
</div>