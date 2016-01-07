<?php

use yii\bootstrap\Html;

use app\models\Users;

?>
<div id="header" class="header navbar navbar-default navbar-fixed-top navbar-inverse">
    <!-- begin container-fluid -->
    <div class="container-fluid">
        <!-- begin mobile sidebar expand / collapse button -->
        <div class="navbar-header">
            <p align="center"><a href="/site/index" class="navbar-brand"><img src="http://s017.radikal.ru/i424/1601/6d/0b20cb4f66c8.png" style="height: 100%"></a></p>
        </div>
        <!-- end mobile sidebar expand / collapse button -->

        <!-- begin header navigation right -->
        <ul class="nav navbar-nav navbar-right">
            <li>
                <div id="clock">
                    <ul>
                        <li id="hours"></li>
                        <li id="point">:</li>
                        <li id="min"></li>
                        <li id="point">:</li>
                        <li id="sec"></li>
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
                        <?php $user = Users::getAuthUser();
                        if (isset($user->avatar) && file_exists(
                                Yii::getAlias('@app/web/img/avatars/') . $user->avatar
                            )
                        ) {
                            echo Html::img('/img/avatars/' . $user->avatar);
                        } else {
                            echo Html::img('/img/avatars/default.png');
                        } ?>
                        <span class="hidden-xs"><?php echo Yii::$app->user->identity->full_name ?></span> <b
                            class="caret"></b>
                    </a>
                    <ul class="dropdown-menu animated fadeInLeft">
                        <li class="arrow"></li>
                        <li><a href="/pilot/edit/<?= Yii::$app->user->identity->vid ?>">Edit Profile</a></li>
                        <li><a href="javascript:;"><span class="badge badge-danger pull-right">2</span> Inbox</a></li>
                        <li><a href="javascript:;">Calendar</a></li>
                        <li><a href="javascript:;">Setting</a></li>
                        <li class="divider"></li>
                        <li><a data-method="post" href="/site/logout">Log Out</a></li>
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