<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;

use dosamigos\highcharts\HighCharts;

use app\components\Helper;

$this->title = Yii::t('app', 'Profile');
$this->params['breadcrumbs'] = [
    ['label' => Yii::t('app', 'Pilot'), 'url' => '/pilot'],
    ['label' => $this->title]
]; ?>
<div class="profile-container">
    <div class="profile-section">
        <div class="profile-left">
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
                    <li class="list-group-item" style="background-color: #33BDBD">
                        <?= $user->pilot->statusName; ?>
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
        <div class="profile-right">
            <?php //\yii\helpers\BaseVarDumper::dump($user->online, 10, true) ?>
            <div class="profile-info">
                <div class="row">
                    <div class="col-md-12">
                        <h2><img
                                src="<?= $user->flaglink ?>"> <?= $user->full_name ?>
                        </h2><?php echo $user->online ? Html::tag(
                            'span',
                            'Online',
                            ['class' => 'label label-success']
                        ) : Html::tag(
                            'span',
                            'Offline',
                            ['class' => 'label label-default']
                        ) ?>
                    </div>
                    <div class="col-md-4">
                        <div class="table-responsive" style="padding-top: 6px">
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
                                            'value' => Html::a(
                                                Html::encode($user->vid),
                                                'http://ivao.aero/Member.aspx?Id=' . $user->vid
                                            ),
                                        ],
                                        [
                                            'attribute' => 'location',
                                            'label' => Yii::t('user', 'Location'),
                                            'format' => 'raw',
                                            'value' => '<img src="' . $user->pilot->airport->flaglink . '"> ' . Html::a(
                                                    Html::encode($user->pilot->airport->name . ' (' . $user->pilot->location . ')'),
                                                    Url::to(
                                                        [
                                                            '/airline/airports/view/',
                                                            'id' => $user->pilot->location
                                                        ]
                                                    )
                                                ),
                                        ],
                                        [
                                            'attribute' => 'flights_num',
                                            'label' => Yii::t('user', 'Total flights'),
                                            'value' => $user->pilot->flightsCount,
                                        ],
                                        [
                                            'attribute' => 'total_hours',
                                            'label' => Yii::t('user', 'Total hours'),
                                            'value' => Helper::getTimeFormatted($user->pilot->time),
                                        ],
                                        [
                                            'attribute' => 'total_miles',
                                            'label' => Yii::t('user', 'Total miles'),
                                            'value' => $user->pilot->miles,
                                        ],
                                        [
                                            'attribute' => 'total_pax',
                                            'label' => Yii::t('user', 'Total pax'),
                                            'value' => $user->pilot->passengers,
                                        ],
                                    ]
                                ]
                            ) ?>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <?php if ($user->pilot->statWeekdays != null): ?>
                            <div class="raw">
                                <div class="col-md-1"></div>
                                <div class="col-md-5">
                                    <?php
                                    echo HighCharts::widget(
                                        [
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
                                                    'style' => [
                                                        'fontFamily' => 'Open Sans',
                                                        'fontSize' => '12px',
                                                        'color' => '#777777',
                                                        'fontWeight' => '600',
                                                    ]
                                                ],
                                                'title' => [
                                                    'text' => Yii::t('charts', 'WEEKDAY STATISTICS'),
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
                                        ]
                                    ); ?>
                                </div>
                                <div class="col-md-5">
                                    <?php echo HighCharts::widget(
                                        [
                                            'clientOptions' => [
                                                'colors' => ['#F59C1A', '#FF5B57', '#B6C2C9', '#2D353C', '#348FE2'],
                                                'chart' => [
                                                    'type' => 'pie',
                                                    'plotBackgroundColor' => null,
                                                    'backgroundColor' => null,
                                                    'plotBorderWidth' => null,
                                                    'plotShadow' => false,
                                                    'height' => 300,
                                                    'style' => [
                                                        'fontFamily' => 'Open Sans',
                                                        'fontSize' => '12px',
                                                        'color' => '#777777',
                                                        'fontWeight' => '600',
                                                    ]
                                                ],
                                                'title' => [
                                                    'text' => Yii::t('charts', 'AIRCRAFT USAGE'),
                                                    'style' => [
                                                        'fontFamily' => 'Open Sans',
                                                        'fontSize' => '12px',
                                                        'color' => '#777777',
                                                        'fontWeight' => '600',
                                                        'margin-top' => 20,
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
                                        ]
                                    ); ?>
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                        <?php else: ?>
                            <div class="jumbotron" style="border-radius: 10px;" align="center">
                                <h2>Упс... Нет данных</h2>

                                <p>Данный пилот еще не совершал рейсов</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="profile-section">
            <div class="row">
                <div class="col-md-4">
                    <h4 class="title">Сообщения</h4>
                    <div data-scrollbar="true" data-height="270px" class="bg-silver">
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
                    </div>
                </div>
                <div class="col-md-4">
                    <h4 class="title">Последние полеты
                        <small> как вариант</small>
                    </h4>
                    <div class="bg-silver">
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
                                            return Html::a(
                                                Html::encode($data->callsign),
                                                Url::to(['/airline/flights/view/' . $data->id])
                                            );
                                        },
                                    ],
                                    'acf_type',
                                    [
                                        'attribute' => 'from_to',
                                        'label' => Yii::t('flights', 'Route'),
                                        'format' => 'raw',
                                        'value' => function ($data) {
                                            return Html::a(
                                                Html::encode($data->from_icao),
                                                Url::to(
                                                    [
                                                        '/airline/airports/view/',
                                                        'id' => $data->from_icao
                                                    ]
                                                )
                                            ) . '-' . Html::a(
                                                Html::encode($data->to_icao),
                                                Url::to(['/airline/airports/view/', 'id' => $data->to_icao])
                                            );
                                        },
                                    ],
                                    [
                                        'attribute' => 'flight_time',
                                        'label' => Yii::t('flights', 'Flight Time'),
                                        'value' => function ($data) {
                                            return Helper::getTimeFormatted($data->flight_time);
                                        }
                                    ]
                                ],
                            ]
                        ) ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <h4 class="title">Здесь будет что-то
                        <small>возможно</small>
                    </h4>
                    <div data-scrollbar="true" data-height="270px" class="bg-silver">
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
                    </div>
                </div>
            </div>
        </div>
    </div>