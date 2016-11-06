<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

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
    <link href="/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>
    <link href="/css/animate.min.css" rel="stylesheet"/>
    <link href="/css/style.min.css" rel="stylesheet"/>
    <link href="/css/style-responsive.min.css" rel="stylesheet"/>
    <link href="/css/theme/default.css" rel="stylesheet"/>
    <link href="/css/custom.css" rel="stylesheet"/>
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
        <?= $content ?></div>

    <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i
            class="fa fa-angle-up"></i></a>
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
</script>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter28677336 = new Ya.Metrika({
                    id:28677336,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true,
                    trackHash:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/28677336" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</body>
</html>
<?php $this->endPage() ?>
