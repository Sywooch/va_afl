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
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet"/>
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

<div id="page-container" class="fade in">
    <!-- begin register -->
    <div class="register register-with-news-feed">
        <!-- begin news-feed -->
        <div class="news-feed">
            <div class="news-image">
                <img src="assets/img/login-bg/bg-8.jpg" alt="">
            </div>
            <div class="news-caption">
                <h4 class="caption-title"><i class="fa fa-edit text-success"></i> Announcing the Color Admin app</h4>
                <p>
                    As a Color Admin Apps administrator, you use the Color Admin console to manage your organization’s
                    account, such as add new users, manage security settings, and turn on the services you want your
                    team to access.
                </p>
            </div>
        </div>
        <!-- end news-feed -->
        <!-- begin right-content -->
        <div class="right-content">
            <?= $content ?>
        </div>
        <!-- end right-content -->
    </div>
    <!-- end register -->
</div>
<?php $this->endBody() ?>

</body>