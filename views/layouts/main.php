<?php

/* @var $this \yii\web\View */
/* @var $content string */


use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

use app\models\Users;
use app\models\Flights;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet"/>
    <link href="/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet"/>
    <link href="/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
    <link href="/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>
    <link href="/css/animate.min.css" rel="stylesheet"/>
    <link href="/css/style.min.css" rel="stylesheet"/>
    <link href="/css/style-responsive.min.css" rel="stylesheet"/>
    <link href="/css/theme/default.css" rel="stylesheet"/>
    <link href="/css/custom.css" rel="stylesheet"/>
    <?php
    $user = Users::getAuthUser();
    if ($user->pilot->interface_newyear): ?>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script type="text/javascript" src="/newyear/newyear.js"></script>
        <link rel="stylesheet" href="/newyear/style.css">
        <script src="/newyear/ok4.js" type="text/javascript"></script>
        <style>
            .nav-tabs.nav-justified>li, .nav-tabs>li{
                z-index: 1200;
            }
        </style>
    <?php endif; ?>
    <link id="theme">
    <!-- ================== END BASE CSS STYLE ================== -->

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="/plugins/pace/pace.min.js"></script>
    <!-- ================== END BASE JS ================== -->
</head>
<body>
<?php $this->beginBody() ?>
<?= $this->render('//layouts/_preloader') ?>

<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">

    <?= $this->render('//layouts/_header') ?>

    <?= $this->render('//layouts/_sidebar') ?>

    <div class="content" id="content">
        <div class="breadcrumbs text-right">
            <?php
            echo Breadcrumbs::widget(
                [
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]
            );
            ?>
        </div>
        <?php if (Yii::$app->controller->module->id == 'qa'): ?>
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title"> </h4>
            </div>
            <div class="panel-body bg-silver">
                <?php endif; ?>

                <?= $content ?>
                <?php if (Yii::$app->controller->module->id == 'qa'): ?>
            </div>
        </div>
    <?php endif; ?>
    </div>

    <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i
            class="fa fa-angle-up"></i></a>
</div>
<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <img src="" class="imagepreview" style="width: 100%;">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="model_title"></h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="modal_title"></h4>
            </div>
            <div class="modal-body" id="modal_body">

            </div>
        </div>
    </div>
</div>
<?php $this->endBody() ?>
<script src="/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
<script src="/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
<script src="/plugins/bootstrap/js/bootstrap.min.js"></script>
<!--[if lt IE 9]>
<script src="/crossbrowserjs/html5shiv.js"></script>
<script src="/crossbrowserjs/respond.min.js"></script>
<script src="/crossbrowserjs/excanvas.min.js"></script>
<![endif]-->
<script src="/plugins/jquery-hashchange/jquery.hashchange.min.js"></script>
<script src="/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="/plugins/jquery-cookie/jquery.cookie.js"></script>
<script src="/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>
<!-- ================== END BASE JS ================== -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="/js/apps.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->
<script src="https://userapi.com/js/api/openapi.js" type="text/javascript" charset="windows-1251"></script>
<script>
    $(document).ready(function () {
        App.init();
    });
    $('body').tooltip({
        selector: '[data-toggle="tooltip"]'
    });
    $(function () {
        $('.imgmodel').on('click', function () {
            $('.imagepreview').attr('src', $(this).find('img').attr('src'));
            $('#imagemodal').modal('show');
        });
    });
    function screenModal() {
        $("#modal_body").load("/screens/create");
        $('#modal').modal('show');
        $('#model_title').text('<?= Yii::t('app', 'Upload screenshot') ?>');
    };
    <?php if($id = Flights::checkNeedToEnd($user->vid)): ?>
    $("#modal_body").load("/airline/flights/end/<?= $id ?>");
    $('#modal').modal('show');
    $('#model_title').text('<?= Yii::t('app', 'Finish your flight!') ?>');
    <?php endif ?>
</script>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function () {
            try {
                w.yaCounter28677336 = new Ya.Metrika({
                    id: 28677336,
                    clickmap: true,
                    trackLinks: true,
                    accurateTrackBounce: true,
                    webvisor: true,
                    trackHash: true
                });
            } catch (e) {
            }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () {
                n.parentNode.insertBefore(s, n);
            };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else {
            f();
        }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript>
    <div><img src="https://mc.yandex.ru/watch/28677336" style="position:absolute; left:-9999px;" alt=""/></div>
</noscript>
<!-- /Yandex.Metrika counter -->
</body>
</html>
<?php $this->endPage() ?>
