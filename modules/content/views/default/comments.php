<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 07.04.16
 * Time: 23:15
 */
?>
<ul class="chats">
    <?php foreach ($model->comments as $comment): ?>
        <li class="left">
                        <span class="date-time"><?=
                            (new \DateTime($comment->write))->format(
                                'g:ia \o\n l jS F'
                            ) ?></span>
            <a href="/pilot/profile/<?= $comment->user_id ?>"
               class="name"><img alt="" height="50px"
                                 src="<?= $comment->user->avatarLink ?>"/> <?= $comment->user->full_name ?></a>

            <div class="message">
                <?= $comment->text ?>
            </div>
        </li>
    <?php endforeach; ?>
</ul>