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
                                'url' => \yii\helpers\Url::to(
                                        '/airline/flights/index/' . Yii::$app->user->identity->vid
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
                            ]
                        ],
                        'icon' => 'fa-plane'
                    ],
                    [
                      'name' => Yii::t('app', 'News'),
                      'url' => \yii\helpers\Url::to('/news'),
                      'icon' => 'fa-newspaper-o'
                    ],
                    [
                        'name' => Yii::t('app', 'Missions'),
                        'url' => \yii\helpers\Url::to('/airline/missions'),
                        'icon' => 'fa-trophy'
                    ],
                    [
                        'name' => Yii::t('app', 'Tours'),
                        'url' => \yii\helpers\Url::to('/tours'),
                        'icon' => 'fa-location-arrow'
                    ],
                    [
                        'name' => Yii::t('app', 'Events'),
                        'url' => \yii\helpers\Url::to('/events'),
                        'icon' => 'fa-cutlery'
                    ],
                    [
                        'name' => 'WebEye',
                        'url' => 'http://webeye.ivao.aero',
                        'icon' => 'fa-eye',
                        'linkOptions' => ['target' => '_blank']
                    ],
                    [
                        'name' => 'TeamSpeak 3',
                        'url' => '/content/view/teamspeak',
                        'icon' => 'fa-microphone',
                    ],
                    [
                        'name' => Yii::t('app', 'Screenshots'),
                        'icon' => 'fa-picture-o',
                        'items' => [
                            ['name' => Yii::t('screens', 'Feed'), 'url' => '/screens'],
                            ['name' => Yii::t('screens', 'Upload'), 'url' => '/screens/create'],
                            ['name' => Yii::t('screens', 'Personal Feed'), 'url' => '/screens/user/'.Yii::$app->user->identity->vid],
                            ['name' => Yii::t('screens', 'Top'), 'url' => '/screens/top'],
                        ]
                    ],
                    [
                        'name' => Yii::t('app', 'Services'),
                        'icon' => 'fa-laptop',
                        'items' => [
                            ['name' => Yii::t('app', 'Airports'), 'url' => '/airline/airports'],
                            ['name' => Yii::t('app', 'Content'), 'url' => \yii\helpers\Url::to('/content/index')],
                        ]
                    ],
                    [
                        'name' => Yii::t('app', 'Documents'),
                        'url' => \yii\helpers\Url::to('/content/documents'),
                        'icon' => 'fa-folder'
                    ],
                    [
                        'name' => Yii::t('app', 'Forum'),
                        'url' => \yii\helpers\Url::to('/forum'),
                        'icon' => 'fa-rss'
                    ],
                    [
                        'name' => Yii::t('app', 'Shop'),
                        'icon' => 'fa-shopping-cart',
                        'items' => [
                            ['name' => Yii::t('app', 'Shop'), 'url' => '/items/shop/index'],
                            ['name' => Yii::t('app', 'My purchases'), 'url' => '/items/shop/purchases'],
                            ['name' => Yii::t('app', 'Slot-machine'), 'url' => '/items/shop/slots'],
                        ]
                    ],
                    [
                        'name' => Yii::t('app', 'AFL Group'),
                        'icon' => 'fa-info-circle',
                        'items' => [
                            ['name' => Yii::t('app', 'About'), 'url' => '/content/view/about'],
                            //['name' => Yii::t('app', 'News'), 'url' => ''],
                            ['name' => Yii::t('app', 'Pilots roster'), 'url' => '/pilot/roster'],
                            ['name' => Yii::t('app', 'Fleet'), 'url' => '/airline/fleet'],
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
