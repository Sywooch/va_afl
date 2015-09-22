<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 21.09.15
 * Time: 18:36
 */
use app\components\Menu;

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
                    <a href="/site/login">
                        <span class="hidden-xs">Login</span>
                    </a>
                <?php endif; ?>
            </li>
        </ul>
        <?php
        echo Menu::widget(
            [
                'items' => [
                    [
                        'name' => Yii::t('app', 'Pilot center'),
                        'url' => \yii\helpers\Url::to('/pilot/profile'),
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
                            ['name' => Yii::t('app', 'Balance'), 'url' => \yii\helpers\Url::to('/pilot/balance')],
                            ['name' => Yii::t('app', 'Flights'), 'url' => \yii\helpers\Url::to('/pilot/flights')],
                            ['name' => Yii::t('app', 'IVAO profile'), 'url' => \yii\helpers\Url::to('IVAO')],
                        ],
                        'icon' => 'fa-bar-chart'
                    ],
                    [
                        'name' => Yii::t('app', 'Craft rental'),
                        'url' => \yii\helpers\Url::to('/pilot/leasing'),
                        'icon' => 'fa-money'
                    ],
                    [
                        'name' => Yii::t('app', 'Transfer'),
                        'url' => \yii\helpers\Url::to('/pilot/transfer'),
                        'icon' => 'fa-bus'
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
                        'url' => \yii\helpers\Url::to('/events/list'),
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
                        'url' => \yii\helpers\Url::to('/airline/services'),
                        'icon' => 'fa-laptop'
                    ],
                    [
                        'name' => Yii::t('app', 'Screenshots'),
                        'url' => \yii\helpers\Url::to('/airline/screenshots'),
                        'icon' => 'fa-picture-o'
                    ],
                    [
                        'name' => Yii::t('app', 'Forum'),
                        'url' => \yii\helpers\Url::to('/airline/forum'),
                        'icon' => 'fa-rss'
                    ],
                    [
                        'name' => Yii::t('app', 'Resources'),
                        'url' => \yii\helpers\Url::to('/resources/index'),
                        'icon' => 'fa-cloud-download'
                    ],
                    [
                        'name' => Yii::t('app', 'Shop'),
                        'icon' => 'fa-shopping-cart',
                        'items' => [
                            ['name' => Yii::t('app', 'My purchases'), 'url' => '/shop/purchases'],
                            ['name' => Yii::t('app', 'Slot-machine'), 'url' => '/shop/slos'],
                        ]
                    ],
                    [
                        'name' => Yii::t('app', 'VAG AFL'),
                        'icon' => 'fa-info-circle',
                        'items' => [
                            ['name' => 'TS3 Viewer', 'url' => '/content/ts3'],
                            ['name' => Yii::t('app', 'About'), 'url' => '/content/about'],
                            ['name' => Yii::t('app', 'Squadrons'), 'url' => '/squad/list'],
                            ['name' => Yii::t('app', 'Pilots roster'), 'url' => '/airline/pilots'],
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
