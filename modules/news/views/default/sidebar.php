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
        <h4>Search</h4>

        <div class="hline"></div>
        <p>
            <br>
            <input type="text" class="form-control" placeholder="Search something">
        </p>

        <hr>

        <h4>Categories</h4>

        <div class="hline"></div>
        <?php foreach ($categories as $cat): ?>

            <p><a href="/news/<?= $cat->link ?>"><i class="fa fa-angle-right"></i> <?= $cat->name ?></a> <span
                    class="badge badge-theme pull-right"><?= count($cat->content) ?></span></p>
        <?php endforeach; ?>
        <hr>

        <h4>Recent Posts</h4>

        <div class="hline"></div>
        <ul class="popular-posts list-unstyled">
            <li class="row">
                <div class="col-md-3">
                    <a class="thumbnail" href="#"><img class="img-rounded" src="//placehold.it/75x75"
                                                       alt="Popular Post"></a>
                </div>
                <div class="col-md-9">
                    <p class="pull-right"><a href="#">Lorem ipsum dolor sit amet consectetur adipiscing elit</a>
                    </p>
                    <em class="small">Posted on 02/21/14</em>
                </div>
            </li>

            <li class="row">
                <div class="col-md-3">
                    <a class="thumbnail" href="#"><img class="img-rounded" src="//placehold.it/75x75"
                                                       alt="Popular Post"></a>
                </div>
                <div class="col-md-9">
                    <p class="pull-right"><a href="#">Lorem ipsum dolor sit amet consectetur adipiscing elit</a>
                    </p>
                    <em class="small">Posted on 02/21/14</em>
                </div>
            </li>
            <li class="row">
                <div class="col-md-3">
                    <a class="thumbnail" href="#"><img class="img-rounded" src="//placehold.it/75x75"
                                                       alt="Popular Post"></a>
                </div>
                <div class="col-md-9">
                    <p class="pull-right"><a href="#">Lorem ipsum dolor sit amet consectetur adipiscing elit</a>
                    </p>
                    <em class="small">Posted on 02/21/14</em>
                </div>
            </li>
            <li class="row">
                <div class="col-md-3">
                    <a class="thumbnail" href="#"><img class="img-rounded" src="//placehold.it/75x75"
                                                       alt="Popular Post"></a>
                </div>
                <div class="col-md-9">
                    <p class="pull-right"><a href="#">Lorem ipsum dolor sit amet consectetur adipiscing elit</a>
                    </p>
                    <em class="small">Posted on 02/21/14</em>
                </div>
            </li>
        </ul>
    </div>
</div>