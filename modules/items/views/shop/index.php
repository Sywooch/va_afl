<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 02.08.16
 * Time: 9:58
 */

use yii\helpers\Html;

$this->title = Yii::t('app', 'Shop');
?>
<h1><?= $this->title ?></h1>
<div class="col-md-9">
    <div class="panel panel-news">
        <div class="panel-body">
            <?php foreach ($items as $item): ?>
                <div class="row">
                    <br>

                    <div class="col-md-2 col-sm-3 text-center">
                        <a class="story-img" href=""><img src="<?= $item->type->content->imgLink ?>"
                                                          style=" height:150px"></a>
                    </div>
                    <div class="col-md-10 col-sm-9">
                        <h3 class="news-header"><a class="news-link" href=""><?= $item->type->content->name ?></a></h3>

                        <div class="row">
                            <div class="col-xs-9">
                                <p><?= $item->type->content->description ?></p>

                                <ul class="list-inline">
                                    <li>
                                        <?php if ($item->availableItemsCount > 0): ?>
                                            <?=
                                            Html::button($item->type->cost . ' VUC\'s',
                                                [
                                                    'class' => 'btn btn-success',
                                                    'data-toggle' => 'modal',
                                                    'data-target' => '#modal-dialog',
                                                    'onclick' => 'loadModal(' . $item->type_id . ')'
                                                ]); ?>
                                        <?php else: ?>
                                            <button class="btn btn-danger" disabled="disabled">
                                                <?= Yii::t('app', 'No available') ?>
                                            </button>
                                        <?php endif; ?>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-xs-3"></div>
                        </div>
                    </div>
                </div>
                <hr>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?= $this->render('sidebar') ?>

<div class="modal fade" id="modal-dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" id="modal-div">
            </div>
        </div>
    </div>
</div>
<script>
    function loadModal(id) {
        $("#modal-div").load("/items/shop/modal/" + id);
    }
</script>
