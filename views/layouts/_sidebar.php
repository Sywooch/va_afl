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
                        'name' => Yii::t('app', 'Pilot Center'),
                        'url' => \yii\helpers\Url::to('/pilot/center'),
                        'icon' => 'fa-globe'
                    ],
                    [
                        'name' => Yii::t('app', 'Booking'),
                        'url' => \yii\helpers\Url::to('/pilot/booking'),
                        'icon' => 'fa-plane'
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
                                'name' => Yii::t('app', 'Flights'),
                                'url' => \yii\helpers\Url::to('/airline/flights/index/' . Yii::$app->user->identity->vid)
                            ],
                            ['name' => Yii::t('app', 'IVAO profile'), 'url' => \yii\helpers\Url::to('IVAO')],
                        ],
                        'icon' => 'fa-bar-chart'
                    ],
                    [
                        'name' => Yii::t('app', 'Squadrons'),
                        'items' => [
                            ['name' => Yii::t('app', 'Squadron B73X'), 'url' => \yii\helpers\Url::to('squadron/view/1')],
                            ['name' => Yii::t('app', 'Squadron A32X'), 'url' => \yii\helpers\Url::to('squadron/view/2')],
                        ],
                        'icon' => 'fa-plane'
                    ],
                    [
                        'name' => Yii::t('app', 'Missions'),
                        'url' => \yii\helpers\Url::to('/airline/missions'),
                        'icon' => 'fa-trophy'
                    ],
                    [
                        'name' => Yii::t('app', 'Tours'),
                        'url' => \yii\helpers\Url::to('/airline/tours'),
                        'icon' => 'fa-location-arrow'
                    ],
                    [
                        'name' => Yii::t('app', 'Events'),
                        'url' => \yii\helpers\Url::to('/events'),
                        'icon' => 'fa-cutlery'
                    ],
                    [
                        'name' => 'WEBEye',
                        'url' => 'http://webeye.ivao.aero',
                        'icon' => 'fa-eye',
                        'linkOptions' => ['target' => '_blank']
                    ],
                    [
                        'name' => Yii::t('app', 'Services'),
                        'icon' => 'fa-laptop',
                        'items' => [
                            ['name' => Yii::t('app', 'Airports'), 'url' => '/airline/airports'],
                            ['name' => Yii::t('app', 'TeamSpeak 3'), 'url' => '/content/view/teamspeak']
                        ]
                    ],
                    [
                        'name' => Yii::t('app', 'Screenshots'),
                        'icon' => 'fa-picture-o',
                        'items' => [
                            ['name' => Yii::t('app', 'Feed'), 'url' => '/screens/index'],
                            ['name' => Yii::t('app', 'Top of the week'), 'url' => '/screens/top']
                        ]
                    ],
                    [
                        'name' => Yii::t('app', 'Forum'),
                        'url' => \yii\helpers\Url::to('/airline/forum'),
                        'icon' => 'fa-rss'
                    ],
                    [
                        'name' => Yii::t('app', 'Content'),
                        'url' => \yii\helpers\Url::to('/content/index'),
                        'icon' => 'fa-cloud-download'
                    ],
                    [
                        'name' => Yii::t('app', 'Shop'),
                        'icon' => 'fa-shopping-cart',
                        'items' => [
                            ['name' => Yii::t('app', 'Shop'), 'url' => '/shop/index'],
                            ['name' => Yii::t('app', 'My purchases'), 'url' => '/shop/purchases'],
                            ['name' => Yii::t('app', 'Slot-machine'), 'url' => '/shop/slos'],
                        ]
                    ],
                    [
                        'name' => Yii::t('app', 'VAG AFL'),
                        'icon' => 'fa-info-circle',
                        'items' => [
                            ['name' => Yii::t('app', 'About'), 'url' => '/content/about'],
                            ['name' => Yii::t('app', 'News'), 'url' => ''],
                            ['name' => Yii::t('app', 'Pilots roster'), 'url' => '/pilot/roster'],
                            ['name' => Yii::t('app', 'Fleet'), 'url' => '/fleet/index'],
                            ['name' => Yii::t('app', 'Schedule'), 'url' => '/airline/schedule'],
                            ['name' => Yii::t('app', 'Staff'), 'url' => '/airline/staff'],
                            [
                                'name' => 'IVAO',
                                'url' => 'http://www.ivao.aero',
                                'linkOptions' => ['target' => '_blank']
                            ],
                            ['name' => Yii::t('app', 'Contacts'), 'url' => '/airline/contacts']
                        ]
                    ],
                ]
            ]
        );
        ?>
    </div>
</div>
<div class="sidebar-bg"></div>
