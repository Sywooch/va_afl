<?php
use app\components\Helper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;
use dosamigos\highcharts\HighCharts;

?>

<div class="profile-container">
    <!-- begin profile-section -->
    <div class="profile-section">
        <!-- begin profile-left -->
        <div class="profile-left">
            <!-- begin profile-image -->
            <?= Html::beginTag('div', ['class' => 'profile-image']) ?>

            <?php
            if (isset($user->avatar) && file_exists(Yii::getAlias('@app/web/img/avatars/') . $user->avatar)) {
                echo Html::img('/img/avatars/' . $user->avatar);
            } else {
                echo Html::img('/img/avatars/default.png');
            } ?>

            <?= Html::tag('i', '', ['class' => 'fa fa-user hide']) ?>
            <?= Html::endTag('div') ?>
            <div class="">
                <ul class="list-group nopoints">
                    <li class="list-group-item list-group-item-success" style="background-color: #33BDBD">
                        Active
                    </li>
                    <li class="list-group-item list-group-item-warning" style="background-color: #FDEBD1;">
                        Supervisor
                    </li>
                    <li class="list-group-item list-group-item">
                        Examiner
                    </li>
                    <li class="list-group-item list-group-item">
                        Trainer
                    </li>
                    <li class="list-group-item list-group-item">
                        <a href="">Board of Directors Member</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- end profile-left -->
        <!-- begin profile-right -->
        <div class="profile-right">
            <!-- begin profile-info -->
            <?php //\yii\helpers\BaseVarDumper::dump($user->pilot->statAcfTypes, 10, true) ?>
            <div class="profile-info">
                <table class="table table-profile" style="margin-left: -3px; margin-bottom: 0;">
                    <tr>
                        <td class="field"><h2><img
                                    src="<?= Helper::getFlagLink($user->country) ?>"> <?= $user->full_name ?></h2></td>
                    </tr>
                </table>
                <div class="row">
                    <div class="col-md-4">
                        <div class="table-responsive" style="padding-top: 6px">
                            <!-- begin table -->
                            <?=
                            DetailView::widget(
                                [
                                    'model' => $user,
                                    'options' => ['class' => 'table table-profile'],
                                    'template' => '<tr><td class="field">{label}</td><td>{value}</td>',
                                    'attributes' => [
                                        [
                                            'attribute' => 'VID',
                                            'label' => 'IVAO ID',
                                            'format' => 'raw',
                                            'value' => Html::a(Html::encode($user->vid),
                                                'http://ivao.aero/Member.aspx?Id=' . $user->vid),
                                        ],
                                        [
                                            'attribute' => 'location',
                                            'label' => Yii::t('app', 'Location'),
                                            'format' => 'raw',
                                            'value' => '<img src="' . Helper::getFlagLink($user->country) . '"> ' . Html::a(Html::encode($user->pilot->airport->name . ' (' . $user->pilot->location . ')'),
                                                    Url::to([
                                                        '/airline/airports/view/',
                                                        'id' => $user->pilot->location
                                                    ])),
                                        ],
                                        [
                                            'attribute' => 'flights_num',
                                            'label' => Yii::t('app', 'Total flights'),
                                            'value' => $user->pilot->flightsCount,
                                        ],
                                        [
                                            'attribute' => 'total_hours',
                                            'label' => Yii::t('app', 'Total hours'),
                                            'value' => Helper::getTimeFormatted($user->pilot->time),
                                        ],
                                        [
                                            'attribute' => 'total_miles',
                                            'label' => Yii::t('app', 'Total miles'),
                                            'value' => $user->pilot->miles,
                                        ],
                                        [
                                            'attribute' => 'total_pax',
                                            'label' => Yii::t('app', 'Total pax'),
                                            'value' => $user->pilot->passengers,
                                        ],
                                    ]
                                ]
                            ) ?>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-offset-1">
                        <?= HighCharts::widget([
                            'clientOptions' => [
                                'colors' => [
                                    '#F59C1A',
                                    '#FF5B57',
                                    '#B6C2C9',
                                    '#2D353C',
                                    '#2A72B5',
                                    '#CC4946',
                                    '#00ACAC'
                                ],
                                'chart' => [
                                    'type' => 'pie',
                                    'plotBackgroundColor' => null,
                                    'backgroundColor' => null,
                                    'plotBorderWidth' => null,
                                    'plotShadow' => false,
                                    'height' => 300,
                                    'marginBottom' => 60,
                                    'style' => [
                                        'fontFamily' => 'Open Sans',
                                        'fontSize' => '12px',
                                        'color' => '#777777',
                                        'fontWeight' => '600',
                                    ]
                                ],
                                'title' => [
                                    'text' => 'AIRCRAFT USAGE',
                                    'style' => [
                                        'fontFamily' => 'Open Sans',
                                        'fontSize' => '12px',
                                        'color' => '#777777',
                                        'fontWeight' => '600'
                                    ]
                                ],
                                'exporting' => [
                                    'enabled' => false
                                ],
                                'credits' => [
                                    'enabled' => false
                                ],
                                'tooltip' => [
                                    'pointFormat' => '{series.name}: <b>{point.percentage:.1f}%</b>',
                                    'style' => [
                                        'fontFamily' => 'Open Sans',
                                        'fontSize' => '12px',
                                        'color' => '#777777',
                                        'fontWeight' => '600'
                                    ]
                                ],
                                'plotOptions' => [
                                    'pie' => [
                                        'allowPointSelect' => true,
                                        'cursor' => 'pointer',
                                        'dataLabels' => [
                                            'enabled' => false
                                        ],
                                        'showInLegend' => true,
                                    ]
                                ],
                                'legend' => [
                                    'itemStyle' => [
                                        'fontFamily' => 'Open Sans',
                                        'fontSize' => '12px',
                                        'color' => '#777777',
                                        'fontWeight' => '600',
                                    ],
                                    'borderColor' => '#FFFFFF',
                                ],
                                'series' => [
                                    [
                                        'name' => 'Types',
                                        'colorByPoint' => true,
                                        'data' => $user->pilot->statWeekdays,
                                        'innerSize' => '65%'
                                    ]
                                ]
                            ]
                        ]); ?>
                    </div>
                    <div class="col-md-3">
                        <?= HighCharts::widget([
                            'clientOptions' => [
                                'colors' => ['#F59C1A', '#FF5B57', '#B6C2C9', '#2D353C', '#348FE2'],
                                'chart' => [
                                    'type' => 'pie',
                                    'plotBackgroundColor' => null,
                                    'backgroundColor' => null,
                                    'plotBorderWidth' => null,
                                    'plotShadow' => false,
                                    'height' => 300,
                                    'marginBottom' => 60,
                                    'style' => [
                                        'fontFamily' => 'Open Sans',
                                        'fontSize' => '12px',
                                        'color' => '#777777',
                                        'fontWeight' => '600',
                                    ]
                                ],
                                'title' => [
                                    'text' => 'AIRCRAFT USAGE',
                                    'style' => [
                                        'fontFamily' => 'Open Sans',
                                        'fontSize' => '12px',
                                        'color' => '#777777',
                                        'fontWeight' => '600'
                                    ]
                                ],
                                'exporting' => [
                                    'enabled' => false
                                ],
                                'credits' => [
                                    'enabled' => false
                                ],
                                'tooltip' => [
                                    'pointFormat' => '{series.name}: <b>{point.percentage:.1f}%</b>',
                                    'style' => [
                                        'fontFamily' => 'Open Sans',
                                        'fontSize' => '12px',
                                        'color' => '#777777',
                                        'fontWeight' => '600'
                                    ]
                                ],
                                'plotOptions' => [
                                    'pie' => [
                                        'allowPointSelect' => true,
                                        'cursor' => 'pointer',
                                        'dataLabels' => [
                                            'enabled' => false
                                        ],
                                        'showInLegend' => true,
                                    ]
                                ],
                                'legend' => [
                                    'itemStyle' => [
                                        'fontFamily' => 'Open Sans',
                                        'fontSize' => '12px',
                                        'color' => '#777777',
                                        'fontWeight' => '600',
                                    ],
                                    'borderColor' => '#FFFFFF',
                                ],
                                'series' => [
                                    [
                                        'name' => 'Types',
                                        'colorByPoint' => true,
                                        'data' => $user->pilot->statAcfTypes,
                                        'innerSize' => '65%'
                                    ]
                                ]
                            ]
                        ]); ?>
                    </div>

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
                <div data-scrollbar="true" data-height="270px" class="bg-silver">
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
                <div class="bg-silver">
                    <!-- begin table -->
                    <?=
                    GridView::widget(
                        [
                            'dataProvider' => $flightsProvider,
                            'layout' => '{items}{pager}',
                            'options' => ['class' => 'table table-condensed'],
                            'columns' => [
                                [
                                    'attribute' => 'callsign',
                                    'label' => Yii::t('flights', 'Callsign'),
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                        return Html::a(Html::encode($data->callsign),
                                            Url::to(['/airline/flights/view/' . $data->id]));
                                    },
                                ],
                                'acf_type',
                                [
                                    'attribute' => 'from_to',
                                    'label' => Yii::t('flights', 'Route'),
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                        return Html::a(Html::encode($data->from_icao), Url::to([
                                            '/airline/airports/view/',
                                            'id' => $data->from_icao
                                        ])) . '-' . Html::a(Html::encode($data->to_icao),
                                            Url::to(['/airline/airports/view/', 'id' => $data->to_icao]));
                                    },
                                ],
                                [
                                    'attribute' => 'flight_time',
                                    'label' => Yii::t('flights', 'Flight Time'),
                                    'value' => function ($data) {
                                        return Helper::getTimeFormatted(
                                            strtotime($data->landing_time) - strtotime($data->dep_time)
                                        );
                                    }
                                ]
                            ],
                        ]
                    ) ?>
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
                <div data-scrollbar="true" data-height="270px" class="bg-silver">
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