<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 20.02.16
 * Time: 6:31
 */
use yii\helpers\Url;
?>
<!-- begin panel -->
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title"><?= Yii::t('app', 'Events') ?></h4>
    </div>
    <div class="panel-body">
        <div id="carousel-example" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <?php $i = 0; ?>
                <?php foreach ($events as $event) : ?>
                    <div class="item<?= $i == 0 ? ' active' : '' ?>">
                        <a href="<?= Url::to('/events/' . $event->id)?>"><img src="<?= $event->contentInfo->img ?>" width="1140" height="610" alt=""></a>
                    </div>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </div>
            <a class="left carousel-control" href="#carousel-example" data-slide="prev">
                <span class="icon-arrow-left2"></span>
            </a>
            <a class="right carousel-control" href="#carousel-example" data-slide="next">
                <span class="icon-arrow-right2"></span>
            </a>
        </div>
    </div>
</div>
<!-- end panel -->