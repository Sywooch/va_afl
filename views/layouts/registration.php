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

    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link href="/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
    <link href="/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="/css/animate.min.css" rel="stylesheet" />
    <link href="/css/style.min.css" rel="stylesheet" />
    <link href="/css/style-responsive.min.css" rel="stylesheet" />
    <link href="/css/theme/default.css" rel="stylesheet" id="theme" />
    <!-- ================== END BASE CSS STYLE ================== -->

</head>
<body class="pace-top bg-white">
<?php $this->beginBody() ?>
<?= $this->render('//layouts/_preloader') ?>

<!-- begin #page-container -->
<div id="page-container" class="fade">
    <!-- begin register -->
    <div class="register register-with-news-feed">
        <!-- begin news-feed -->
        <div class="news-feed">
            <div class="news-image">
                <img src="/img/login-bg/bg-8.jpg" alt="" />
            </div>
            <div class="news-caption">
                <h4 class="caption-title"><i class="fa fa-edit text-success"></i> Announcing the Color Admin app</h4>
                <p>
                    As a Color Admin Apps administrator, you use the Color Admin console to manage your organization’s account, such as add new users, manage security settings, and turn on the services you want your team to access.
                </p>
            </div>
        </div>
        <!-- end news-feed -->
        <!-- begin right-content -->
        <div class="right-content">
            <?= $content ?>
            <!-- end register-content -->
        </div>
        <!-- end right-content -->
    </div>
    <!-- end register -->
</div>
<!-- end page container -->

<!-- ================== BEGIN BASE JS ================== -->
<script src="/plugins/jquery/jquery-1.9.1.min.js"></script>
<script src="/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
<script src="/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
<script src="/plugins/bootstrap/js/bootstrap.min.js"></script>
<!--[if lt IE 9]>
<script src="/crossbrowserjs/html5shiv.js"></script>
<script src="/crossbrowserjs/respond.min.js"></script>
<script src="/crossbrowserjs/excanvas.min.js"></script>
<![endif]-->
<script src="/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="/plugins/jquery-cookie/jquery.cookie.js"></script>
<!-- ================== END BASE JS ================== -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="/js/apps.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->

<script>
    $(document).ready(function() {
        App.init();
    });
</script>
</body>
</html>

