<?php $model->viewsPlus() ?>
<div class="timeline-time">
    <span class="date"><?= $model->createdDT->format('d F Y') ?></span>
    <span class="time"><?= $model->createdDT->format('H:i') ?></span>
</div>
<div class="timeline-icon">
    <a href="javascript:;"><i class="fa <?= $model->categoryInfo->icon ?>"></i></a>
</div>
<div class="timeline-body" style="margin-right: 0;">
    <div class="timeline-header">
        <span class="userimage"><img src="<?= $model->authorUser->avatarLink ?>" alt=""/></span>
        <img title="<?= $model->authorUser->country ?>" style="display: inline;"
             src="<?= $model->authorUser->flaglink ?>">
        <span class="username"><a target="_blank" href="/pilot/profile/<?= $model->authorUser->vid ?>">
                                <?= $model->authorUser->full_name ?>
                                </a></span>
        <h3 style="padding-left: 7px; display: inline"><span class="label label-warning">
                <i class="fa fa-star"
                   aria-hidden="true"></i> <?= $model->authorUser->pilot->level ?></span>
        </h3>
        <span class="pull-right text-muted"><?= $model->views ?></span>
    </div>
    <div class="timeline-content">
        <h4 class="template-title">
            <i class="<?= $model->icon ? $model->icon : 'fa fa-map-marker text-danger fa-fw' ?>"></i>
            <a target="_blank" href="<?= $model->contentLink ?>"><?= $model->name ?></a>
        </h4>

        <p><?= $model->text ?></p>
        <?php if ($model->img): ?>
            <p class="m-t-20">
                <?php if ($model->category == 16): ?>
                <a name="<?= $model->id ?>" href="#<?= $model->id ?>" class="imgmodel">
                    <?php endif; ?>
                    <img src="<?= $model->imgLink ?>" alt=""/>
                    <?php if ($model->category == 16): ?></a><?php endif; ?>
            </p>
        <?php endif; ?>
    </div>
    <div class="timeline-footer">
        <a href="javascript:content_like(<?= $model->id ?>);" id="btn_like_<?= $model->id ?>"
           class="m-r-15 btn btn-default<?= $model->like ? ' disabled btn-success' : '' ?>"><i
                class="fa fa-thumbs-up fa-fw"></i> Like</a>
        <button class="btn btn-default" id="btn_like_<?= $model->id ?>_num"
                disabled><?= $model->likesCount ?></button>
    </div>
</div>