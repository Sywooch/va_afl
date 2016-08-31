<?php
/**
 * Created by PhpStorm.
 * User: bth
 * Date: 12.11.15
 * Time: 15:41
 */

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

use app\assets\AppAsset;
use app\assets\OnlineTableAsset;
AppAsset::register($this);
OnlineTableAsset::register($this);
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
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet"/>
    <link href="/landing/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="/landing/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>
    <link href="/landing/css/animate.min.css" rel="stylesheet"/>
    <link href="/landing/css/style.min.css" rel="stylesheet"/>
    <link href="/landing/css/style-responsive.min.css" rel="stylesheet"/>
    <link href="/landing/css/theme/default.css" id="theme" rel="stylesheet"/>
    <link href="/css/custom.css" id="theme" rel="stylesheet"/>

    <!-- ================== END BASE CSS STYLE ================== -->

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="/plugins/pace/pace.min.js"></script>
    <!-- ================== END BASE JS ================== -->
</head>
<body data-spy="scroll" data-target="#header-navbar" data-offset="51">
<?php $this->beginBody() ?>
<!-- begin #page-container -->
<div id="page-container" class="fade">
    <?= $content ?>
    <!-- end theme-panel -->
</div>
<!-- end #page-container -->
<?php $this->endBody() ?>
<!-- ================== BEGIN BASE JS ================== -->
<script src="/landing/plugins/jquery/jquery-1.9.1.min.js"></script>
<script src="/landing/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
<script src="/landing/plugins/bootstrap/js/bootstrap.min.js"></script>
<!--[if lt IE 9]>
<script src="/landing/crossbrowserjs/html5shiv.js"></script>
<script src="/landing/crossbrowserjs/respond.min.js"></script>
<script src="/landing/crossbrowserjs/excanvas.min.js"></script>
<![endif]-->
<script src="/landing/plugins/jquery-cookie/jquery.cookie.js"></script>
<script src="/landing/plugins/scrollMonitor/scrollMonitor.js"></script>
<script src="/landing/js/apps.min.js"></script>
<!-- ================== END BASE JS ================== -->

<script>
    $(document).ready(function () {
        App.init();
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

