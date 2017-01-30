<?php

use yii\helpers\Html;

use app\components\Menu;
use app\models\Users;

?>
<div id="sidebar" class="sidebar">
    <div data-scrollbar="true" data-height="100%">
        <ul class="nav">
            <li class="nav-profile" style="background-color: #2D353C; text-align: center">
                <?php if (!Yii::$app->user->isGuest): ?>
                    <?php
                    $user = Users::getAuthUser();
                    if (isset($user->avatar) && file_exists(Yii::getAlias('@app/web/img/avatars/') . $user->avatar)) {
                        echo Html::img(
                            '/img/avatars/' . $user->avatar,
                            ['style' => 'width: 100%;']
                        );
                    } else {
                        echo Html::img(
                            '/img/avatars/default.png',
                            ['style' => 'width: 100%;']
                        );
                    } ?>
                <?php endif; ?>
            </li>
        </ul>
        <?php
        echo Menu::widget(
            [
                'items' => [
                    [
                        'name' => Yii::t('app', 'Feed'),
                        'url' => \yii\helpers\Url::to('/pilot/feed'),
                        'icon' => 'fa-rss'
                    ],
                    [
                        'name' => Yii::t('app', 'Pilot Center'),
                        'url' => \yii\helpers\Url::to('/pilot/center'),
                        'icon' => 'fa-globe'
                    ],
                    [
                        'name' => Yii::t('app', 'Request flights fix'),
                        'url' => \yii\helpers\Url::to('/airline/flights/logbook?type=fix'),
                        'icon' => 'fa-cog',
                        'visible' => Yii::$app->user->can('supervisor'),
                        'badge' => \app\models\Flights::countRequest()
                    ],
                    [
                        'name' => Yii::t('app', 'Booking'),
                        'url' => \yii\helpers\Url::to('/pilot/booking'),
                        'icon' => 'fa-random'
                    ],
                    [
                        'name' => Yii::t('app', 'My messages'),
                        'url' => \yii\helpers\Url::to('/mail'),
                        'icon' => 'fa-envelope',
                        'badge' => \app\components\internal\api\chat\NewCounter::get()
                    ],
                    [
                        'name' => Yii::t('app', 'My statistics'),
                        'items' => [
                            ['name' => Yii::t('app', 'Main'), 'url' => \yii\helpers\Url::to('/pilot/index')],
                            [
                                'name' => Yii::t('app', 'Balance'),
                                'url' => \yii\helpers\Url::to('/pilot/balance/' . Yii::$app->user->identity->vid)
                            ],
                            [
                                'name' => Yii::t('app', 'Last Flights'),
                                'url' => \yii\helpers\Url::to(
                                        '/airline/flights/index/' . Yii::$app->user->identity->vid
                                    )
                            ],
                            [
                                'name' => Yii::t('app', 'Logbook'),
                                'url' => \yii\helpers\Url::to(
                                        '/airline/flights/logbook/' . Yii::$app->user->identity->vid
                                    )
                            ],
                            [
                                'name' => Yii::t('app', 'IVAO profile'),
                                'url' => 'https://www.ivao.aero/Member.aspx',
                                'linkOptions' => ['target' => '_blank']
                            ],
                        ],
                        'icon' => 'fa-bar-chart'
                    ],
                    [
                        'name' => Yii::t('app', 'Squadrons'),
                        'items' => [
                            [
                                'name' => Yii::t('app', 'Squadron A32X'),
                                'url' => \yii\helpers\Url::to('/squadron/view/1')
                            ],
                            [
                                'name' => Yii::t('app', 'Squadron B73X'),
                                'url' => \yii\helpers\Url::to('/squadron/view/2')
                            ],
                            [
                                'name' => Yii::t('app', 'Squadron HEAVY'),
                                'url' => \yii\helpers\Url::to('/squadron/view/3')
                            ],
                            [
                                'name' => Yii::t('app', 'Squadron SU95'),
                                'url' => \yii\helpers\Url::to('/squadron/view/4')
                            ],
                            [
                                'name' => Yii::t('app', 'Squadron OLD'),
                                'url' => \yii\helpers\Url::to('/squadron/view/6')
                            ]
                        ],
                        'icon' => 'fa-plane'
                    ],
                    [
                      'name' => Yii::t('app', 'News'),
                      'url' => \yii\helpers\Url::to('/news'),
                      'icon' => 'fa-newspaper-o'
                    ],
                    /*[
                        'name' => Yii::t('app', 'Missions'),
                        'url' => \yii\helpers\Url::to('/airline/missions'),
                        'icon' => 'fa-trophy'
                    ],*/
                    [
                        'name' => Yii::t('app', 'Tours'),
                        'url' => \yii\helpers\Url::to('/tours'),
                        'icon' => 'fa-location-arrow'
                    ],
                    [
                        'name' => Yii::t('app', 'Events'),
                        'url' => \yii\helpers\Url::to('/events'),
                        'icon' => 'fa-calendar'
                    ],
                    [
                        'name' => Yii::t('screens', 'Upload screenshot'),//. ' <span class="label label-warning m-l-5">Up</span>'
                        'url' => '#',
                        'icon' => 'fa-picture-o',
                        'linkOptions' => ['onclick' => 'screenModal();']
                    ],
                    [
                        'name' => 'WebEye',
                        'url' => 'http://webeye.ivao.aero',
                        'icon' => 'fa-eye',
                        'linkOptions' => ['target' => '_blank']
                    ],
                    [
                        'name' => 'TeamSpeak 3',
                        'url' => '/documents/handbook/teamspeak',
                        'icon' => 'fa-microphone',
                    ],
                    [
                        'name' => Yii::t('app', 'Services'),
                        'icon' => 'fa-laptop',
                        'items' => [
                            ['name' => Yii::t('app', 'Airports'), 'url' => '/airline/airports'],
                            ['name' => Yii::t('app', 'Airline statistics'), 'url' => '/airline/stats'],
                            //['name' => Yii::t('app', 'Content'), 'url' => \yii\helpers\Url::to('/content/index')],
                        ]
                    ],
                    [
                        'name' => Yii::t('app', 'Documents'),
                        'url' => \yii\helpers\Url::to('/documents'),
                        'icon' => 'fa-folder',
                        'active' => Yii::$app->request->url == '/documents/handbook/about' ? false : true,
                    ],
                    [
                        'name' => Yii::t('app', 'Forum'),
                        'url' => \yii\helpers\Url::to('http://forum.va-afl.su'),
                        'icon' => 'fa-rss',
                        'linkOptions' => ['target' => '_blank']
                    ],
                    /*[
                        'name' => Yii::t('app', 'Shop'),
                        'icon' => 'fa-shopping-cart',
                        'items' => [
                            ['name' => Yii::t('app', 'Shop'), 'url' => '/shop/index'],
                            ['name' => Yii::t('app', 'My purchases'), 'url' => '/shop/purchases'],
                            ['name' => Yii::t('app', 'Slot-machine'), 'url' => '/shop/slos'],
                        ]
                    ],*/
                    [
                        'name' => Yii::t('app', 'VA AFL'),
                        'icon' => 'fa-info-circle',
                        'items' => [
                            ['name' => Yii::t('app', 'About'), 'url' => '/documents/handbook/about'],
                            ['name' => Yii::t('app', 'Top'), 'url' => '/users/top/all'],
                            ['name' => Yii::t('app', 'Top').' '.Yii::t('top', 'by month'), 'url' => '/users/top/month'],
                            ['name' => Yii::t('app', 'Pilots roster'), 'url' => '/pilot/roster'],
                            ['name' => Yii::t('app', 'Fleet'), 'url' => '/airline/fleet'],
                            ['name' => Yii::t('app', 'Schedule'), 'url' => '/airline/schedule'],
                            ['name' => Yii::t('app', 'Staff'), 'url' => '/airline/staff'],
                            ['name' => Yii::t('app', 'Supervisors'), 'url' => '/airline/staff/supervisors'],
                            [
                                'name' => 'IVAO',
                                'url' => 'http://www.ivao.aero',
                                'linkOptions' => ['target' => '_blank']
                            ],
                            //['name' => Yii::t('app', 'Contacts'), 'url' => '/content/view/contacts']
                        ]
                    ],
                ]
            ]
        );
        ?>
    </div>
</div>
<div class="sidebar-bg"></div>
