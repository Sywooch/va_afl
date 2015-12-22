<?php
use app\components\Helper;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

?>

<div class="profile-container">
    <!-- begin profile-section -->
    <div class="profile-section">
        <!-- begin profile-left -->
        <div class="profile-left">
            <!-- begin profile-image -->
            <?php if (isset($user->avatar) && file_exists(Yii::getAlias('@app/web/img/avatars/') . $user->avatar)) {
                echo Html::beginTag('div', ['class' => 'profile-image']);
                echo Html::img('/img/avatars/' . $user->avatar);
                echo Html::tag('i', '', ['class' => 'fa fa-user hide']);
                echo Html::endTag('div');
            } ?>
            <!-- end profile-image -->
        </div>
        <!-- end profile-left -->
        <!-- begin profile-right -->
        <div class="profile-right">
            <!-- begin profile-info -->
            <div class="profile-info">
                <div class="table-responsive">
                    <!-- begin table -->
                    <?= DetailView::widget([
                        'model' => $user,
                        'options' => ['class' => 'table table-profile'],
                        'template' => '<tr><td class="field">{label}</td><td>{value}</td>',
                        'attributes' => [
                            [
                                'attribute' => '',
                                'format' => 'raw',
                                'value' => '<h2>' . $user->full_name . '<small> ' . $user->pilot->rank->name_ru . '</small></h2>',
                            ],
                            'vid',
                            [
                                'attribute' => 'Часов налета',
                                'format' => 'raw',
                                'value' => '575',
                            ],
                            [
                                'attribute' => 'Часов налета за ВАГ',
                                'format' => 'raw',
                                'value' => Helper::getTimeFormatted($user->pilot->time),
                            ],
                            [
                                'attribute' => 'Страна',
                                'format' => 'raw',
                                'value' => '<img src="' . Helper::getFlagLink($user->country) . '"> ' . Helper::getCountryCode($user->country),
                            ],
                            [
                                'attribute' => 'Город',
                                'format' => 'raw',
                                'value' => 'Москва',
                            ],
                            [
                                'attribute' => 'День рождения',
                                'format' => 'raw',
                                'value' => '01.01.1980',
                            ],
                        ]
                    ]) ?>
                </div>


                <!-- end table -->
            </div>
            <!-- end profile-info -->
        </div>
        <!-- end profile-right -->
    </div>
    <!-- end profile-section -->
    <!-- begin profile-section -->
    <div class="profile-section">
        <!-- begin row -->
        <div class="row">
            <!-- begin col-4 -->
            <div class="col-md-4">
                <h4 class="title">Сообщения</h4>
                <!-- begin scrollbar -->
                <div data-scrollbar="true" data-height="280px" class="bg-silver">
                    <!-- begin chats -->
                    <ul class="chats">
                        <li class="left">
                            <span class="date-time">yesterday 11:23pm</span>
                            <a href="javascript:;" class="name">Sowse Bawdy</a>
                            <a href="javascript:;" class="image"><img alt="" src="/img/user-12.jpg"></a>
                            <div class="message">
                                Личные сообщения (лучше с форума)
                            </div>
                        </li>
                        <li class="right">
                            <span class="date-time">08:12am</span>
                            <a href="#" class="name"><span class="label label-primary">ADMIN</span> Me</a>
                            <a href="javascript:;" class="image"><img alt="" src="/img/user-13.jpg"></a>
                            <div class="message">
                                Отвечаем
                            </div>
                        </li>
                        <li class="left">
                            <span class="date-time">09:20am</span>
                            <a href="#" class="name">Neck Jolly</a>
                            <a href="javascript:;" class="image"><img alt="" src="/img/user-10.jpg"></a>
                            <div class="message">
                                Смотрится неплохо
                            </div>
                        </li>
                    </ul>
                    <!-- end chats -->
                </div>
                <!-- end scrollbar -->
            </div>
            <!-- end col-4 -->
            <!-- begin col-4 -->
            <div class="col-md-4">
                <h4 class="title">Последние полеты
                    <small> как вариант</small>
                </h4>
                <!-- begin scrollbar -->
                <div data-scrollbar="true" data-height="280px" class="bg-silver">
                    <!-- begin table -->
                    <?= GridView::widget([
                        'dataProvider' => $flightsProvider,
                        'options' => ['class' => 'table table-condensed'],
                        'columns' => [
                            'acf_type',
                            'dep_time:datetime',
                            'landing_time:datetime'
                        ],
                    ]) ?>
                    <!--<table class="table table-condensed">
                        <thead>
                        <tr>
                            <th>Самолет</th>
                            <th>Маршрут</th>
                            <th>Время в пути</th>
                            <th>Дата</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="col-md-1 p-r-5">
                                Тут будет иконка самолета
                            </td>
                            <td>
                                UUDD-URSS
                            </td>
                            <td>5 часов 32 минуты</td>
                            <td>11.12.2015</td>
                        </tr>
                        <tr>
                            <td class="col-md-1 p-r-5">
                                <i class="fa fa-plane fa-lg"></i>
                            </td>
                            <td>
                                URSS-UUDD
                            </td>
                            <td>18 часов</td>
                            <td>15.12.2045</td>
                        </tr>
                    </table>-->
                    <!-- end table -->
                </div>
                <!-- end scrollbar -->
            </div>
            <!-- end col-4 -->
            <!-- begin col-4 -->
            <div class="col-md-4">
                <h4 class="title">Здесь будет что-то
                    <small>возможно</small>
                </h4>
                <!-- begin scrollbar -->
                <div data-scrollbar="true" data-height="280px" class="bg-silver">
                    <!-- begin todolist -->
                    <ul class="todolist">
                        <li class="active">
                            <a href="javascript:;" class="todolist-container active" data-click="todolist">
                                <div class="todolist-input"><i class="fa fa-square-o"></i></div>
                                <div class="todolist-title">Что-то уже сделано</div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;" class="todolist-container" data-click="todolist">
                                <div class="todolist-input"><i class="fa fa-square-o"></i></div>
                                <div class="todolist-title">А что-то еще нет</div>
                            </a>
                        </li>
                    </ul>
                    <!-- end todolist -->
                </div>
                <!-- end scrollbar -->
            </div>
            <!-- end col-4 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end profile-section -->
</div>