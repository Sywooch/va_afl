<?php

use yii\bootstrap\Html;

use app\models\Users;

?>
<div id="header" class="header navbar navbar-default navbar-fixed-top navbar-inverse">
    <!-- begin container-fluid -->
    <div class="container-fluid">
        <!-- begin mobile sidebar expand / collapse button -->
        <div class="navbar-header">
            <p align="center"><a href="/pilot/center" class="navbar-brand"><img src="/img/afl_logo.png"
                                                                                style="height: 100%"></a></p>
        </div>

        <div class="nav navbar-text progress progress-striped active" style="width: 330px; height: 20px">
            <div class="progress-bar progress-bar-warning" style="font-weight: lighter; width: <?= Yii::$app->user->identity->progress ?>%"><h4 style="margin-left: 0px; margin-top: 0px; text-align: left;"><?=
                Html::tag(
                    'span',
                    '<i class="fa fa-star" aria-hidden="true"></i> '.Yii::$app->user->identity->level,
                    [
                        'title'=> Yii::t('app', 'Level').' '.Yii::$app->user->identity->level,
                        'data-toggle' => 'tooltip',
                        'data-placement' => 'bottom',
                    ]
                )?></h4></div>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <li>
                <div id="clock">
                    <ul>
                        <li id="hours"><?= gmdate("G") ?></li>
                        <li id="point">:</li>
                        <li id="min"><?= gmdate("i") ?></li>
                        <li id="point">:</li>
                        <li id="sec"><?= gmdate("s") ?></li>
                    </ul>
            </li>
            <li class="dropdown">
                <?= $this->render('//layouts/_header_notifications') ?>
            </li>
            <?php if (!Yii::$app->user->isGuest): ?>
                <li class="dropdown navbar-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="hidden-xs"><?php echo Yii::$app->user->identity->full_name ?></span> <b
                            class="caret"></b>
                    </a>
                    <ul class="dropdown-menu animated fadeInLeft">
                        <li class="arrow"></li>
                        <li><a href="/pilot/center"><?= Yii::t('app', 'Pilot Center') ?></a></li>
                        <li class="divider"></li>
                        <li><a href="/pilot/edit/<?= Yii::$app->user->identity->vid ?>"><?= Yii::t('app', 'Edit') ?></a>
                        </li>
                        <li><a href="/pilot/settings/<?= Yii::$app->user->identity->vid ?>"><?=
                                Yii::t(
                                    'app',
                                    'Settings'
                                ) ?></a></li>
                        <li><a href="javascript:;"><?= Yii::t('app', 'Help') ?></a></li>
                        <li class="divider"></li>
                        <li><a data-method="post" href="/site/logout"><?= Yii::t('app', 'Log out') ?></a></li>
                    </ul>
                </li>
            <?php else: ?>
                <li class="navbar-user">
                    <a href="site/login">
                        <span class="hidden-xs">Login</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
        <!-- end header navigation right -->
    </div>
    <!-- end container-fluid -->
</div>