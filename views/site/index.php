<?php

use app\components\Helper;
use app\components\Stats;
use app\models\Booking;
use app\models\Flights;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div id="header" class="header navbar navbar-transparent navbar-fixed-top">
    <!-- begin container -->
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#header-navbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="#" class="navbar-brand" style="padding-top: 6px;">
                        <span class="brand-text">
                            <img height="40" src="/img/logo-dark.png">
                        </span>
            </a>
        </div>
        <div class="collapse navbar-collapse" id="header-navbar">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#home" data-click="scroll-to-target"><?php if (Yii::$app->request->get('lang') == 'RU'): ?>Главная<?php else: ?>Home<?php endif; ?></a></li>
                <li><a href="#online" data-click="scroll-to-target"><?php if (Yii::$app->request->get('lang') == 'RU'): ?>Онлайн<?php else: ?>Online<?php endif; ?></a></li>
                <li><a href="#about" data-click="scroll-to-target"><?php if (Yii::$app->request->get('lang') == 'RU'): ?>О нас<?php else: ?>About<?php endif; ?></a></li>
                <li><a href="#service" data-click="scroll-to-target"><?php if (Yii::$app->request->get('lang') == 'RU'): ?>Сервисы<?php else: ?>Services<?php endif; ?></a></li>
                <li><a href="#contact" data-click="scroll-to-target"><?php if (Yii::$app->request->get('lang') == 'RU'): ?>Связаться с нами<?php else: ?>Contact<?php endif; ?></a></li>
                <li><a href="/users/auth/login<?php if (Yii::$app->request->get('lang') == 'RU'): ?>?lang=RU<?php endif; ?>"><i class="fa fa-user-plus" aria-hidden="true"></i> <?php if (Yii::$app->request->get('lang') == 'RU'): ?>Войти или Зарегистрироваться<?php else: ?>Login or Sign Up<?php endif; ?></a></li>
            </ul>
        </div>
    </div>
</div>
<div id="home" class="content has-bg home">
    <div class="content-bg">
        <img src="/landing/img/main.jpg" alt="Home"/>
    </div>
    <div class="container home-content">
        <h1><?php if (Yii::$app->request->get(
                    'lang'
                ) == 'RU'
            ): ?>Добро пожаловать в ВА "АФЛ"<?php else: ?>Welcome to VA AFL<?php endif; ?></h1>

        <h3><?php if (Yii::$app->request->get(
                    'lang'
                ) == 'RU'
            ): ?>Лучший выбор симмера<?php else: ?>Simmers' best choise<?php endif; ?></h3>

        <p>
            <?php if (Yii::$app->request->get(
                    'lang'
                ) == 'RU'
            ): ?>Мы стремимся создать лучшую ВА в IVAO<?php else: ?>We strive to create the best VA in IVAO.<?php endif; ?>
            <br/>
            <?php if (Yii::$app->request->get('lang') == 'RU'): ?>Зарегистрируйтесь на <a href="/users/auth/login">странице
                вступления</a> чтобы стать частью нашей компании.<?php else: ?>Sign up on <a href="/users/auth/login">registration
                page</a> to become a part of our company.<?php endif; ?>
        </p>
        <a href="/users/auth/login" class="btn btn-success"><?php if (Yii::$app->request->get(
                    'lang'
                ) == 'RU'
            ): ?>Зарегистрироваться<?php else: ?>Sign Up<?php endif; ?></a>
        <?php if (Yii::$app->request->get('lang') == 'RU'): ?>
            <a href="/" class="btn btn-outline"><img src="/img/flags/countries/16x11/gb.png"> Switch to English</a><br/>
        <?php else: ?>
            <a href="/?lang=RU" class="btn btn-outline"><img src="/img/flags/countries/16x11/ru.png"> Перевести на
                Русский</a><br/>
        <?php endif; ?>
    </div>
</div>
<div id="online" class="content" data-scrollview="true">
    <!-- begin container -->
    <div class="container">
        <h2 class="content-title"><?php if (Yii::$app->request->get(
                    'lang'
                ) == 'RU'
            ): ?>Онлайн<?php else: ?>Online<?php endif; ?></h2>

        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">&nbsp;<span class="label label-success pull-right"><?= Flights::countOnline() ?>
                        Online</span>
                </h4>
            </div>
            <div class="panel-body bg-silver">
                <div class="table table-condensed">
                    <?=
                    GridView::widget(
                        [
                            'dataProvider' => $onlineProvider,
                            'layout' => '{items}{pager}',
                            'options' => [
                                'class' => 'time-table table table-striped table-bordered',
                                'style' => ''
                            ],
                            'columns' => [
                                [
                                    'attribute' => 'callsign',
                                    'label' => Yii::t('flights', 'Callsign'),
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                            return (($data->stream && isset($data->user->pilot->stream_link)) ?
                                                '<a href="' . $data->user->pilot->stream_link . '">' . '<i class="fa fa-rss" style="color: green"></i></a>' :
                                                '<i class="fa fa-rss"></i>') . ' ' . ((isset($data->flight)) ?
                                                Html::a(
                                                    Html::encode($data->callsign),
                                                    Url::to(['/airline/flights/view/' . $data->id]),
                                                    [
                                                        'data-toggle' => "tooltip",
                                                        'data-placement' => "top",
                                                        'title' => Html::encode($data->user->full_name)
                                                    ]
                                                ) : Html::tag(
                                                    'span',
                                                    $data->callsign,
                                                    [
                                                        'title' => $data->user->full_name,
                                                        'data-toggle' => 'tooltip',
                                                        'data-placement' => "top",
                                                        'style' => 'cursor:pointer;'
                                                    ]
                                                ));
                                        },
                                ],
                                [
                                    'attribute' => 'flight.acf_type',
                                    'label' => Yii::t('flights', 'Type'),
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                            return ($data->flight ? $data->flight->acf_type : ($data->fleet ? Html::tag(
                                                'span',
                                                $data->fleet->type_code,
                                                [
                                                    'title' => $data->fleet->regnum,
                                                    'data-toggle' => 'tooltip',
                                                    'data-placement' => "top",
                                                    'style' => 'cursor:pointer;'
                                                ]
                                            ) : 'XXXX'));
                                        },
                                ],
                                [
                                    'attribute' => 'from_to',
                                    'label' => Yii::t('flights', 'Route'),
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                            return Html::a(
                                                Html::img(Helper::getFlagLink($data->departure->iso)) . ' ' .
                                                Html::encode($data->from_icao),
                                                Url::to(
                                                    [
                                                        '/airline/airports/view/',
                                                        'id' => $data->from_icao
                                                    ]
                                                ),
                                                [
                                                    'data-toggle' => "tooltip",
                                                    'data-placement' => "top",
                                                    'title' => Html::encode(
                                                            "{$data->departure->name} ({$data->departure->city}, {$data->departure->iso})"
                                                        )
                                                ]
                                            ) . ' - ' . Html::a(
                                                Html::img(Helper::getFlagLink($data->arrival->iso)) . ' ' .
                                                Html::encode($data->to_icao),
                                                Url::to(['/airline/airports/view/', 'id' => $data->to_icao]),
                                                [
                                                    'data-toggle' => "tooltip",
                                                    'data-placement' => "top",
                                                    'title' => Html::encode(
                                                            "{$data->arrival->name} ({$data->arrival->city}, {$data->arrival->iso})"
                                                        )
                                                ]
                                            );
                                        },
                                ],
                                [
                                    'attribute' => 'flight.dep_time',
                                    'label' => Yii::t('flights', 'Dep Time'),
                                    'format' => ['date', 'php:H:i'],
                                    'value' => function ($data) {
                                            if (isset($data->flight)) {
                                                return date('H:i', strtotime($data->flight->dep_time));
                                            } else {
                                                return "0:0";
                                            }
                                        }
                                ],
                                [
                                    'attribute' => 'flight.eta_time',
                                    'label' => Yii::t('flights', 'Landing Time'),
                                    'format' => ['date', 'php:H:i'],
                                    'value' => function ($data) {
                                            if (isset($data->flight)) {
                                                return $data->flight->eta_time;
                                            } else {
                                                return "00:00";
                                            }
                                        }
                                ],
                                [
                                    'attribute' => 'status',
                                    'contentOptions' => ['class' => 'status'],
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                            $ret = '<span class="';

                                            switch ($data->g_status) {
                                                case Booking::STATUS_BOOKED:
                                                    $ret .= 'booked">Booked';
                                                    break;
                                                case Booking::STATUS_BOARDING:
                                                    $ret .= 'boarding">Boarding';
                                                    break;
                                                case Booking::STATUS_DEPARTING:
                                                    $ret .= 'departing">Departing';
                                                    break;
                                                case Booking::STATUS_ENROUTE:
                                                    $ret .= 'en-route">En-route';
                                                    break;
                                                case Booking::STATUS_LOSS:
                                                    $ret .= 'booked">Loss contact';
                                                    break;
                                                case Booking::STATUS_APPROACH:
                                                    $ret .= 'approach">Approach';
                                                    break;
                                                case Booking::STATUS_LANDED:
                                                    $ret .= 'landed">Landed';
                                                    break;
                                                case Booking::STATUS_ON_BLOCKS:
                                                    $ret .= 'on-blocks">On blocks';
                                                    break;
                                                default:
                                                    $ret .= '">###';
                                                    break;
                                            }

                                            $ret .= '</span>';
                                            return $ret;
                                        }
                                ]
                            ],
                        ]
                    ) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="about" class="content" data-scrollview="true">
    <div class="container" data-animation="true" data-animation-type="fadeInDown">
        <h2 class="content-title"><?php if (Yii::$app->request->get(
                    'lang'
                ) == 'RU'
            ): ?>О Нас<?php else: ?>About Us<?php endif; ?></h2>

        <p class="content-desc">
            <?php if (Yii::$app->request->get('lang') == 'RU'): ?>
                Виртуальная авиакомпания АЭРОФЛОТ была образована и официально зарегистрирована в сети ИВАО в январе 2012 года. Спустя три года после основания наша виртуальная авиакомпания была полностью обновлена. Теперь для всех пилотов стал доступен один из лучших сайтов среди виртуальных авиакомпаний, непревзойденный Центр Пилота, уникальная система трекинга и многое другое!
            <?php else: ?>
                Virtual Airlines was founded and officially registered at the IVAO Network at January 2012. Three years later, in February 2015 our virtual airlines was totally updated. Now we have one of the best website among other VAs, ultimate Pilot Center, custom tracking system and much more!
            <?php endif; ?>
        </p>
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="about">
                    <h3><?php if (Yii::$app->request->get(
                                'lang'
                            ) == 'RU'
                        ): ?>Наша История<?php else: ?>Our Story<?php endif; ?></h3>
                    <?php if (Yii::$app->request->get('lang') == 'RU'): ?>
                        <p>
                            Перезапуску подвергся не только сайт, но и философия компании, цель которой – стать лучшей
                            виртуальной авиакомпанией в сети ИВАО. Наша команда делает все необходимое, чтобы пилоты
                            получали максимальный реализм и удовольствием во время онлайн полетов под позывным AFL.
                            Больше не требуется никакого дополнительного программного обеспечения – просто забронируй
                            рейс в Центре Пилота, подключись онлайн к ИВАО и наслаждайся виртуальным небом!
                        </p>
                        <?php else: ?>
                    <p>
                        We restarted with a vision to make the best virtual airline at the IVAO network. We do our best
                        to make all pilots the most realistic experience with online flying. No any additional software
                        needed – just book your flight at the Pilot Center, connect to the IVAO and enjoy virtual sky!
                        Our fleet consists of the real air company aircraft – types, tail numbers – everything matches
                        as real as it gets! Boeing, Airbus, Sukhoi SuperJet – all these perfect aircraft are available.
                    </p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <h3><?php if (Yii::$app->request->get(
                            'lang'
                        ) == 'RU'
                    ): ?>Наша философия<?php else: ?>Our Philosophy<?php endif; ?></h3>

                <div class="about-author">
                    <div class="quote bg-silver">
                        <i class="fa fa-quote-left"></i>

                        <h3><?php if (Yii::$app->request->get('lang') == 'RU'): ?>
                                Мы стремимся к совершенству
                            <?php else: ?>
                                We are striving for perfection
                            <?php endif; ?></h3>
                        <i class="fa fa-quote-right"></i>
                    </div>
                    <div class="author">
                        <div class="info">
                            <?php if (Yii::$app->request->get('lang') == 'RU'): ?>
                                Команда ВА "АФЛ"
                            <?php else: ?>
                                VA AFL Team
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="milestone" class="content bg-black-darker has-bg" data-scrollview="true">
    <div class="content-bg">
        <img src="/landing/img/milestone-bg.jpg" alt="Milestone"/>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-3 milestone-col">
                <div class="milestone">
                    <div class="number" data-animation="true" data-animation-type="number" data-final-number="<?= Stats::members() ?>">
                        <?= Stats::members() ?>
                    </div>
                    <div class="title"><?php if (Yii::$app->request->get('lang') == 'RU'): ?>
                            Пользователей
                        <?php else: ?>
                            Members
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 milestone-col">
                <div class="milestone">
                    <div class="number" data-animation="true" data-animation-type="number"
                         data-final-number=" <?= Stats::flights() ?>">
                        <?= Stats::flights() ?>
                    </div>
                    <div class="title"><?php if (Yii::$app->request->get('lang') == 'RU'): ?>
                            Полётов
                        <?php else: ?>
                            Flights
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 milestone-col">
                <div class="milestone">
                    <div class="number" data-animation="true" data-animation-type="number" data-final-number="<?= Stats::paxs() ?>">
                        <?= Stats::paxs() ?>
                    </div>
                    <div class="title"><?php if (Yii::$app->request->get('lang') == 'RU'): ?>
                            Пассажиров
                        <?php else: ?>
                            PAXs
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 milestone-col">
                <div class="milestone">
                    <div class="number" data-animation="true" data-animation-type="number"
                         data-final-number="<?= Stats::nm() ?>">
                        <?= Stats::nm() ?>
                    </div>
                    <div class="title"><?php if (Yii::$app->request->get('lang') == 'RU'): ?>
                            Миль
                        <?php else: ?>
                            Miles flown
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="service" class="content" data-scrollview="true">
    <div class="container">
        <h2 class="content-title"><?php if (Yii::$app->request->get('lang') == 'RU'): ?>
                Наши Сервисы
            <?php else: ?>
                Our Services
            <?php endif; ?></h2>

        <div class="row">
            <div class="col-md-4 col-sm-4">
                <div class="service">
                    <div class="icon bg-theme" data-animation="true" data-animation-type="bounceIn"><i
                            class="fa fa-cog"></i></div>
                    <div class="info">
                        <h4 class="title"><?php if (Yii::$app->request->get('lang') == 'RU'): ?>
                                Забронировать свой рейс за 15 секунд!
                            <?php else: ?>
                                Book, Connect and Fly
                            <?php endif; ?></h4>

                        <p class="desc"><?php if (Yii::$app->request->get('lang') == 'RU'): ?>
                                Не нужно устанавливать никаких дополнительных программ! Просто забронируйте рейс в Центре Пилота, подключитесь онлайн в ИВАО и начинайте вашу карьеру пилота!
                            <?php else: ?>
                                No additional software is needed! Just book your flight at the Pilot Center,
                                connect online with the IVAO network and start your career!
                            <?php endif; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4">
                <div class="service">
                    <div class="icon bg-theme" data-animation="true" data-animation-type="bounceIn"><i
                            class="fa fa-paint-brush"></i></div>
                    <div class="info">
                        <h4 class="title"><?php if (Yii::$app->request->get('lang') == 'RU'): ?>
                                Действительно активное сообщество
                            <?php else: ?>
                                Active Community
                            <?php endif; ?></h4>

                        <p class="desc"><?php if (Yii::$app->request->get('lang') == 'RU'): ?>
                                Полеты, мероприятия, тренировки и многое другое с нашим активным сообществом! Форум и TeamSpeak3 доступны 24/7.
                            <?php else: ?>
                                Flights, events, training and much more with our active community! VA Forum
                                and
                                TeamSpeak3 - live 24/7.
                            <?php endif; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4">
                <div class="service">
                    <div class="icon bg-theme" data-animation="true" data-animation-type="bounceIn"><i
                            class="fa fa-file"></i></div>
                    <div class="info">
                        <h4 class="title"><?php if (Yii::$app->request->get('lang') == 'RU'): ?>
                                Непревзойденный Центр Пилота
                            <?php else: ?>
                                Ultimate Pilot Center
                            <?php endif; ?></h4>

                        <p class="desc"><?php if (Yii::$app->request->get('lang') == 'RU'): ?>
                                Множество уникальных функций и дружелюбный интерфейс помогут с головой погрузиться в мир виртуальной авиации!
                            <?php else: ?>
                                Lots of features and user friendly interface will attract you to fly more and
                                more with different aircraft types and multiple destinations!
                            <?php endif; ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-sm-4">
                <div class="service">
                    <div class="icon bg-theme" data-animation="true" data-animation-type="bounceIn"><i
                            class="fa fa-code"></i></div>
                    <div class="info">
                        <h4 class="title"><?php if (Yii::$app->request->get('lang') == 'RU'): ?>
                                Более 40 000 направлений
                            <?php else: ?>
                                40 000+ Destinations
                            <?php endif; ?></h4>

                        <p class="desc"><?php if (Yii::$app->request->get('lang') == 'RU'): ?>
                                Огромное количество направлений по всему миру доступно для полетов под позывным крупнейшего авиаперевозчика России - AFL
                            <?php else: ?>
                                Aeroflot is the flag carrier and largest airline of the Russian Federation.
                                Enjoy the simulation with our Virtual Airlines!
                            <?php endif; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4">
                <div class="service">
                    <div class="icon bg-theme" data-animation="true" data-animation-type="bounceIn"><i
                            class="fa fa-shopping-cart"></i></div>
                    <div class="info">
                        <h4 class="title"><?php if (Yii::$app->request->get('lang') == 'RU'): ?>
                                Почему Мы
                            <?php else: ?>
                                Why Choose Us
                            <?php endif; ?></h4>

                        <p class="desc"><?php if (Yii::$app->request->get('lang') == 'RU'): ?>
                                ВА "АФЛ" предлагает множество уникальных функций, не доступных в других виртуальных авиакомпаниях: уникальный трекер полетов, планировщик полетов и многое другое! В независимости от того, являетесь вы новичком или опытным виртуальным пилотом, коллектив ВА "АФЛ" всегда готов помочь или ответить на возникшие вопросы.
                            <?php else: ?>
                                VA AFL offers many features that you don’t get in other virtual airlines:
                                custom
                                flight tracker, airports database, flight planner and much more! Whether you are a newbie or
                                an experienced virtual pilot our dedicated staff team is ready to help and advice for any
                                questions you may have.
                            <?php endif; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4">
                <div class="service">
                    <div class="icon bg-theme" data-animation="true" data-animation-type="bounceIn"><i
                            class="fa fa-heart"></i></div>
                    <div class="info">
                        <h4 class="title">IVAO</h4>

                        <p class="desc"><?php if (Yii::$app->request->get('lang') == 'RU'): ?>
                                Чтобы начать свою карьеру в ВА "АФЛ" необходимо быть зарегистрированным в сети IVAO – независимый и бесплатный сервис для энтузиастов, увлеченных авиацией, объединяющий все мировое сообщество любителей авиасимуляторов.
                                Регистрация в ИВАО
                            <?php else: ?>
                                In order to get started, you should first be registered at the IVAO Network -
                                dedicated, independent, free of charge service to enthusiasts and individuals enjoying and
                                participating in the flight simulation community worldwide.
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="contact" class="content bg-silver-lighter" data-scrollview="true">
    <div class="container">
        <h2 class="content-title"><?php if (Yii::$app->request->get('lang') == 'RU'): ?>
                Связаться с нами
            <?php else: ?>
                Contact Us
            <?php endif; ?></h2>

        <p class="content-desc">
            <?php if (Yii::$app->request->get('lang') == 'RU'): ?>
            <?php else: ?>
            <?php endif; ?>
        </p>
        <!-- begin row -->
        <div class="row">
            <!-- begin col-6 -->
            <div class="col-md-12" data-animation="true" data-animation-type="fadeInLeft">
                <h3><?php if (Yii::$app->request->get('lang') == 'RU'): ?>
                        Если вам что-то не ясно, свяжитесь с нами
                    <?php else: ?>
                        If you have any questions or offers, do not hesitate to contact us
                    <?php endif; ?></h3>

                <p>
                    <a href="mailto:support@va-afl.su">support@va-afl.su</a>
                </p>
            </div>
        </div>
    </div>
</div>
<div id="footer" class="footer">
    <div class="container">
        <div class="footer-brand">
            VA AFL
        </div>
        <p>
            "VA AFL" is non-commercial virtual orginisation of aviation enthusiasts. "VA AFL" is NOT an official or
            authorised website of the real-life aircompany "Aeroflot0 - Russian airlines". "VA AFL" does NOT affilated
            to the real aircompany "Aeroflot - Russian airlines" or its representatives. "VA AFL" is irrelevant to any
            kind of activites of the real aircompany "Aeroflot - Russian airlines". To visit real aircompany "Aeroflot -
            Russian airlines" website <a href="http://www.aeroflot.ru/">click here</a>.
            <br/>&copy; 2012-<?= date('Y') ?>
        </p>
        <p class="social-list">
            <a target="_blank" href="https://vk.com/va_afl"><i class="fa fa-vk fa-fw"></i></a>
        </p>
    </div>
</div>