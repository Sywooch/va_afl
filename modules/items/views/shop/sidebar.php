<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 02.08.16
 * Time: 11:33
 */
?>
<div class="col-lg-3 panel">
    <div class="panel-body">
        <h4>Recent Posts</h4>

        <div class="hline"></div>
        <ul class="popular-posts list-unstyled">
            <?php foreach (\app\modules\items\models\Shop::lastAvailable() as $item): ?>
                <li class="row">
                    <div class="col-md-3">
                        <a class="thumbnail" href="#"><img class="img-rounded"
                                                           src="<?= $item->type->content->imgLink ?>"
                                                           style=" height:50px"
                                                           alt="Popular Post"></a>
                    </div>
                    <div class="col-md-9">
                        <p class="pull-right"><a href="#"><?= $item->type->content->name ?></a></p>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>