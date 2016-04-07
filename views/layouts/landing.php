<?php
/**
 * Created by PhpStorm.
 * User: bth
 * Date: 12.11.15
 * Time: 15:41
 */

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="<?= Yii::$app->language ?>">
<!--<![endif]-->
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <title>Color Admin | One Page Parallax Front End Theme</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>

    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet"/>
    <link href="/landing/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="/landing/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>
    <link href="/landing/css/animate.min.css" rel="stylesheet"/>
    <link href="/landing/css/style.min.css" rel="stylesheet"/>
    <link href="/landing/css/style-responsive.min.css" rel="stylesheet"/>
    <link href="/landing/css/theme/default.css" id="theme" rel="stylesheet"/>
    <!-- ================== END BASE CSS STYLE ================== -->

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="/landing/plugins/pace/pace.min.js"></script>
    <!-- ================== END BASE JS ================== -->
</head>
<body data-spy="scroll" data-target="#header-navbar" data-offset="51">
<!-- begin #page-container -->
<div id="page-container" class="fade">
    <?= $content ?>
    <!-- end theme-panel -->
</div>
<!-- end #page-container -->

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
</body>
</html>

