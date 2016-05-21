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

        <div class="nav navbar-text progress progress-striped active" style="width: 500px; height: 20px">
            <div class="progress-bar progress-bar-success" style="font-weight: lighter; width: 80%"><?=
                Html::tag(
                    'span',
                    '600000 / 750000',
                    [
                        'title' => Yii::t('app', 'Experience'),
                        'data-toggle' => 'tooltip',
                        'data-placement' => "top"
                    ]
                )?></div>
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
                <a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle f-s-14">
                    <i class="fa fa-bell-o"></i>
                    <span class="label">5</span>
                </a>
                <ul class="dropdown-menu media-list pull-right animated fadeInDown">
                    <li class="dropdown-header">Notifications (5)</li>
                    <li class="media">
                        <a href="javascript:;">
                            <div class="media-left"><i class="fa fa-bug media-object bg-red"></i></div>
                            <div class="media-body">
                                <h6 class="media-heading">Server Error Reports</h6>

                                <div class="text-muted f-s-11">3 minutes ago</div>
                            </div>
                        </a>
                    </li>
                    <li class="media">
                        <a href="javascript:;">
                            <div class="media-left"><img src="/img/user-1.jpg" class="media-object" alt=""/></div>
                            <div class="media-body">
                                <h6 class="media-heading">John Smith</h6>

                                <p>Quisque pulvinar tellus sit amet sem scelerisque tincidunt.</p>

                                <div class="text-muted f-s-11">25 minutes ago</div>
                            </div>
                        </a>
                    </li>
                    <li class="media">
                        <a href="javascript:;">
                            <div class="media-left"><img src="/img/user-2.jpg" class="media-object" alt=""/></div>
                            <div class="media-body">
                                <h6 class="media-heading">Olivia</h6>

                                <p>Quisque pulvinar tellus sit amet sem scelerisque tincidunt.</p>

                                <div class="text-muted f-s-11">35 minutes ago</div>
                            </div>
                        </a>
                    </li>
                    <li class="media">
                        <a href="javascript:;">
                            <div class="media-left"><i class="fa fa-plus media-object bg-green"></i></div>
                            <div class="media-body">
                                <h6 class="media-heading"> New User Registered</h6>

                                <div class="text-muted f-s-11">1 hour ago</div>
                            </div>
                        </a>
                    </li>
                    <li class="media">
                        <a href="javascript:;">
                            <div class="media-left"><i class="fa fa-envelope media-object bg-blue"></i></div>
                            <div class="media-body">
                                <h6 class="media-heading"> New Email From John</h6>

                                <div class="text-muted f-s-11">2 hour ago</div>
                            </div>
                        </a>
                    </li>
                    <li class="dropdown-footer text-center">
                        <a href="javascript:;">View more</a>
                    </li>
                </ul>
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
                        <li><a href="/pilot/setting/<?= Yii::$app->user->identity->vid ?>"><?=
                                Yii::t(
                                    'app',
                                    'Setting'
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