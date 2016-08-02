<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 02.08.16
 * Time: 9:58
 */
?>
<div class="col-md-9">
    <div class="panel">
        <div class="panel-body">
            <?php foreach ($content as $post): ?>
            <div class="row">
                <br>

                <div class="col-md-2 col-sm-3 text-center">
                    <a class="story-img" href="/news/view/<?= $post->link ?>"><img src="//placehold.it/100" style="width:127px;height:72px"></a>
                </div>
                <div class="col-md-10 col-sm-9">
                    <h3 class="news-header"><a class="news-link" href="/news/view/<?= $post->link ?>"><?= $post->name ?></a></h3>

                    <div class="row">
                        <div class="col-xs-9">
                            <p><?= $post->description ?></p>

                            <ul class="list-inline">
                                <li><?= $post->created ?></li>
                                <li><a href="/content/news/<?= $post->categoryInfo->link ?>"><?= $post->categoryInfo->name ?></a></li>
                                <!-- <li><a href="#"><i class="glyphicon glyphicon-share"></i> 34 Like</a></li> -->
                                <?php if (!empty($post->forum)) : ?>
                                    <li><a href="<?= $post->forum ?>"><i class="fa fa-comments"></i> <?= Yii::t('app', 'Discuss in forum') ?></a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <div class="col-xs-3"></div>
                    </div>
                </div>
            </div>
            <hr>
            <?php endforeach; ?>
            <a href="/" class="btn btn-primary pull-right btnNext">More <i
                    class="glyphicon glyphicon-chevron-right"></i></a>
        </div>
    </div>


</div><!--/col-12-->

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

            <p><a href="/content/news/<?= $cat->link ?>"><i class="fa fa-angle-right"></i> <?= $cat->name ?></a> <span
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
<style>
    .panel {
        border-color: transparent;
        border-radius: 0;
    }

    .thumbnail {
        margin-bottom: 8px;
    }

    .img-container {
        overflow: hidden;
        height: 170px;
    }

    .img-container img {
        min-width: 280px;
        min-height: 180px;
        max-width: 380px;
        max-height: 280px;
    }

    .txt-container {
        overflow: hidden;
        height: 100px;
    }

    .panel .lead {
        overflow: hidden;
        height: 90px;
    }

    a, a:hover, a:active, a:visited {
        text-decoration: none;
    }

    .news-link {
        color: #3fa1ea;
    }

    .news-header {
        margin-top: 0px;
    }

    .news-link:visited {
        color: #204b73;
    }

    .news-link:hover {
        color: #234973;
    }
</style>