<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 21.09.15
 * Time: 18:36
 */
?>
<div id="sidebar" class="sidebar">
    <div data-scrollbar="true" data-height="100%">
        <ul class="nav">
            <li class="nav-profile">
                <?php if (!Yii::$app->user->isGuest): ?>
                    <div class="info">
                        <?php echo Yii::$app->user->identity->full_name ?>
                        <small>Front end developer</small>
                    </div>
                    <img src="/img/user-13.jpg" alt=""/>
                <?php else: ?>
                    <a href="site/login">
                        <span class="hidden-xs">Login</span>
                    </a>
                <?php endif; ?>
            </li>
        </ul>
        <ul class="nav">
            <li>
                <a href="/pilot/profile">
                    <i class="fa fa-laptop"></i>
                    <span>Центр пилота</span>
                </a>
            </li>
            <li>
                <a href="/pilot/booking">
                    <i class="fa fa-laptop"></i>
                    <span>Бронирование</span>
                </a>
            </li>
            <li class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-laptop"></i>
                    <span>Моя статистика</span>
                </a>
                <ul class="sub-menu">
                    <li><a href="/pilot/balance" data-toggle="ajax">Баланс (Выписка)</a></li>
                    <li><a href="/pilot/flights" data-toggle="ajax">История полетов</a></li>
                    <li><a href="/pilot/ivaoprofile" data-toggle="ajax">Профиль ИВАО</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="fa fa-laptop"></i>
                    <span>Аренда</span>
                </a>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="fa fa-laptop"></i>
                    <span>Трансфер</span>
                </a>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="fa fa-laptop"></i>
                    <span>Миссии</span>
                </a>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="fa fa-laptop"></i>
                    <span>Туры</span>
                </a>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="fa fa-laptop"></i>
                    <span>Webeye</span>
                </a>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="fa fa-laptop"></i>
                    <span>Сервисы</span>
                </a>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="fa fa-laptop"></i>
                    <span>Форум</span>
                </a>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="fa fa-laptop"></i>
                    <span>Скриншоты</span>
                </a>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="fa fa-laptop"></i>
                    <span>Документы</span>
                </a>
            </li>
            <li class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-laptop"></i>
                    <span>ВАГ АФЛ</span>
                </a>
                <ul class="sub-menu">
                    <li><a href="/content/ts3" data-toggle="ajax">TS3 Viewer</a></li>
                    <li><a href="/content/about" data-toggle="ajax">О Группе</a></li>
                    <li><a href="/squad/list" data-toggle="ajax">Летные отряды</a></li>
                    <li><a href="#" data-toggle="ajax">Список пилотов</a></li>
                    <li><a href="#" data-toggle="ajax">Авиапарк</a></li>
                    <li><a href="#" data-toggle="ajax">Расписание</a></li>
                    <li><a href="#" data-toggle="ajax">Руководство</a></li>
                    <li><a href="#" data-toggle="ajax">IVAO</a></li>
                    <li><a href="#" data-toggle="ajax">Контакты</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify">
                    <i class="fa fa-angle-double-left"></i>
                </a>
            </li>
        </ul>
    </div>
</div>
<div class="sidebar-bg"></div>
