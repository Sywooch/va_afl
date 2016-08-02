<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 02.08.16
 * Time: 9:58
 */
use app\models\ContentCategories;

?>
    <div class="col-md-9">
        <div class="panel panel-news">
            <div class="panel-body">
                <h2><?= $model->name ?></h2>

                <p>
                    <small>Posted: April 25, 2015</small>
                    |
                    <small>By: Admin | 3 Comments</small>
                </p>
                <?= $model->text ?>

                <hr>
            </div>
        </div>


    </div><!--/col-12-->

<?= $this->render('sidebar', ['categories' => ContentCategories::news()]) ?>