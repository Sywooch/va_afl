<?php

use app\models\Booking;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use yii\grid\GridView;
use app\components\Helper;
?>

<!-- begin #header -->
<div id="header" class="header navbar navbar-transparent navbar-fixed-top">
    <!-- begin container -->
    <div class="container">
        <!-- begin navbar-header -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#header-navbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="index.html" class="navbar-brand">
                <span class="brand-logo"></span>
                        <span class="brand-text">
                            <span class="text-theme">Color</span> Admin
                        </span>
            </a>
        </div>
        <!-- end navbar-header -->
        <!-- begin navbar-collapse -->
        <div class="collapse navbar-collapse" id="header-navbar">
            <ul class="nav navbar-nav navbar-right">
                <li class="active dropdown">
                    <a href="#home" data-click="scroll-to-target" data-toggle="dropdown">HOME <b class="caret"></b></a>
                    <ul class="dropdown-menu dropdown-menu-left animated fadeInDown">
                        <li><a href="index.html">Page with Transparent Header</a></li>
                        <li><a href="index_inverse_header.html">Page with Inverse Header</a></li>
                        <li><a href="index_default_header.html">Page with White Header</a></li>
                        <li><a href="extra_element.html">Extra Element</a></li>
                    </ul>
                </li>
                <li><a href="#about" data-click="scroll-to-target">ABOUT</a></li>
                <li><a href="#team" data-click="scroll-to-target">TEAM</a></li>
                <li><a href="#service" data-click="scroll-to-target">SERVICES</a></li>
                <li><a href="#work" data-click="scroll-to-target">WORK</a></li>
                <li><a href="#client" data-click="scroll-to-target">CLIENT</a></li>
                <li><a href="#pricing" data-click="scroll-to-target">PRICING</a></li>
                <li><a href="#contact" data-click="scroll-to-target">CONTACT</a></li>
                <li><a href="/users/auth/login"><i class="fa fa-user"></i>LOGIN</a></li>
            </ul>
        </div>
        <!-- end navbar-collapse -->
    </div>
    <!-- end container -->
</div>
<!-- end #header -->

<!-- begin #home -->
<div id="home" class="content has-bg home">
    <!-- begin content-bg -->
    <div class="content-bg">
        <img src="/landing/img/main.jpg" alt="Home"/>
    </div>
    <!-- end content-bg -->
    <!-- begin container -->
    <div class="container home-content">
        <h1>Welcome to Color Admin</h1>

        <h3>Multipurpose One Page Theme</h3>

        <p>
            We have created a multi-purpose theme that take the form of One-Page or Multi-Page Version.<br/>
            Use our <a href="#">theme panel</a> to select your favorite theme color.
        </p>
        <a href="#" class="btn btn-success">Explore More</a> <a href="#" class="btn btn-outline">Purchase Now</a><br/>
        <br/>
        or <a href="#">subscribe</a> newsletter
    </div>
    <!-- end container -->
</div>
<!-- end #home -->

<!-- begin #pricing -->
<div id="pricing" class="content" data-scrollview="true">
    <!-- begin container -->
    <div class="container">
        <h2 class="content-title">Our Price</h2>

        <p class="content-desc">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum consectetur eros dolor,<br/>
            sed bibendum turpis luctus eget
        </p>

        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">Online Table <span class="label label-success pull-right">1 Online</span>
                </h4>
            </div>
            <div class="panel-body bg-silver">
                <div class="table table-condensed">
                    <?= GridView::widget(
                    [
                    'dataProvider' => $onlineProvider,
                    'layout' => '{items}{pager}',
                    'options' => [
                    'class' => 'time-table table table-striped table-bordered',
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
                    return Html::tag(
                    'span',
                    $data->fleet->type_code,
                    [
                    'title' => $data->fleet->regnum,
                    'data-toggle' => 'tooltip',
                    'data-placement' => "top",
                    'style' => 'cursor:pointer;'
                    ]
                    );
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
    <!-- end container -->
</div>
<!-- end #pricing -->

<!-- begin #about -->
<div id="about" class="content" data-scrollview="true">
    <!-- begin container -->
    <div class="container" data-animation="true" data-animation-type="fadeInDown">
        <h2 class="content-title">About Us</h2>

        <p class="content-desc">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum consectetur eros dolor,<br/>
            sed bibendum turpis luctus eget
        </p>
        <!-- begin row -->
        <div class="row">
            <!-- begin col-4 -->
            <div class="col-md-4 col-sm-6">
                <!-- begin about -->
                <div class="about">
                    <h3>Our Story</h3>

                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Vestibulum posuere augue eget ante porttitor fringilla.
                        Aliquam laoreet, sem eu dapibus congue, velit justo ullamcorper urna,
                        non rutrum dolor risus non sapien. Vivamus vel tincidunt quam.
                        Donec ultrices nisl ipsum, sed elementum ex dictum nec.
                    </p>

                    <p>
                        In non libero at orci rutrum viverra at ac felis.
                        Curabitur a efficitur libero, eu finibus quam.
                        Pellentesque pretium ante vitae est molestie, ut faucibus tortor commodo.
                        Donec gravida, eros ac pretium cursus, est erat dapibus quam,
                        sit amet dapibus nisl magna sit amet orci.
                    </p>
                </div>
                <!-- end about -->
            </div>
            <!-- end col-4 -->
            <!-- begin col-4 -->
            <div class="col-md-4 col-sm-6">
                <h3>Our Philosophy</h3>
                <!-- begin about-author -->
                <div class="about-author">
                    <div class="quote bg-silver">
                        <i class="fa fa-quote-left"></i>

                        <h3>We work harder,<br/><span>to let our user keep simple</span></h3>
                        <i class="fa fa-quote-right"></i>
                    </div>
                    <div class="author">
                        <div class="image">
                            <img src="/landing/img/user-1.jpg" alt="Sean Ngu"/>
                        </div>
                        <div class="info">
                            Sean Ngu
                            <small>Front End Developer</small>
                        </div>
                    </div>
                </div>
                <!-- end about-author -->
            </div>
            <!-- end col-4 -->
            <!-- begin col-4 -->
            <div class="col-md-4 col-sm-12">
                <h3>Our Experience</h3>
                <!-- begin skills -->
                <div class="skills">
                    <div class="skills-name">Front End</div>
                    <div class="progress progress-striped">
                        <div class="progress-bar progress-bar-success" style="width: 95%">
                            <span class="progress-number">95%</span>
                        </div>
                    </div>
                    <div class="skills-name">Programming</div>
                    <div class="progress progress-striped">
                        <div class="progress-bar progress-bar-success" style="width: 90%">
                            <span class="progress-number">90%</span>
                        </div>
                    </div>
                    <div class="skills-name">Database Design</div>
                    <div class="progress progress-striped">
                        <div class="progress-bar progress-bar-success" style="width: 85%">
                            <span class="progress-number">85%</span>
                        </div>
                    </div>
                    <div class="skills-name">Wordpress</div>
                    <div class="progress progress-striped">
                        <div class="progress-bar progress-bar-success" style="width: 80%">
                            <span class="progress-number">80%</span>
                        </div>
                    </div>
                </div>
                <!-- end skills -->
            </div>
            <!-- end col-4 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end #about -->

<!-- begin #milestone -->
<div id="milestone" class="content bg-black-darker has-bg" data-scrollview="true">
    <!-- begin content-bg -->
    <div class="content-bg">
        <img src="/landing/img/milestone-bg.jpg" alt="Milestone"/>
    </div>
    <!-- end content-bg -->
    <!-- begin container -->
    <div class="container">
        <!-- begin row -->
        <div class="row">
            <!-- begin col-3 -->
            <div class="col-md-3 col-sm-3 milestone-col">
                <div class="milestone">
                    <div class="number" data-animation="true" data-animation-type="number" data-final-number="1292">
                        1,292
                    </div>
                    <div class="title">Themes & Template</div>
                </div>
            </div>
            <!-- end col-3 -->
            <!-- begin col-3 -->
            <div class="col-md-3 col-sm-3 milestone-col">
                <div class="milestone">
                    <div class="number" data-animation="true" data-animation-type="number" data-final-number="9039">
                        9,039
                    </div>
                    <div class="title">Registered Members</div>
                </div>
            </div>
            <!-- end col-3 -->
            <!-- begin col-3 -->
            <div class="col-md-3 col-sm-3 milestone-col">
                <div class="milestone">
                    <div class="number" data-animation="true" data-animation-type="number"
                         data-final-number="89291">
                        89,291
                    </div>
                    <div class="title">Items Sold</div>
                </div>
            </div>
            <!-- end col-3 -->
            <!-- begin col-3 -->
            <div class="col-md-3 col-sm-3 milestone-col">
                <div class="milestone">
                    <div class="number" data-animation="true" data-animation-type="number" data-final-number="129">
                        129
                    </div>
                    <div class="title">Theme Authors</div>
                </div>
            </div>
            <!-- end col-3 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end #milestone -->

<!-- begin #team -->
<div id="team" class="content" data-scrollview="true">
    <!-- begin container -->
    <div class="container">
        <h2 class="content-title">Our Team</h2>

        <p class="content-desc">
            Phasellus suscipit nisi hendrerit metus pharetra dignissim. Nullam nunc ante, viverra quis<br/>
            ex non, porttitor iaculis nisi.
        </p>
        <!-- begin row -->
        <div class="row">
            <!-- begin col-4 -->
            <div class="col-md-4 col-sm-4">
                <!-- begin team -->
                <div class="team">
                    <div class="image" data-animation="true" data-animation-type="flipInX">
                        <img src="/landing/img/user-1.jpg" alt="Ryan Teller"/>
                    </div>
                    <div class="info">
                        <h3 class="name">Ryan Teller</h3>

                        <div class="title text-theme">FOUNDER</div>
                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget
                            dolor.</p>

                        <div class="social">
                            <a href="#"><i class="fa fa-facebook fa-lg fa-fw"></i></a>
                            <a href="#"><i class="fa fa-twitter fa-lg fa-fw"></i></a>
                            <a href="#"><i class="fa fa-google-plus fa-lg fa-fw"></i></a>
                        </div>
                    </div>
                </div>
                <!-- end team -->
            </div>
            <!-- end col-4 -->
            <!-- begin col-4 -->
            <div class="col-md-4 col-sm-4">
                <!-- begin team -->
                <div class="team">
                    <div class="image" data-animation="true" data-animation-type="flipInX">
                        <img src="/landing/img/user-2.jpg" alt="Jonny Cash"/>
                    </div>
                    <div class="info">
                        <h3 class="name">Johnny Cash</h3>

                        <div class="title text-theme">WEB DEVELOPER</div>
                        <p>Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat
                            massa
                            quis enim.</p>

                        <div class="social">
                            <a href="#"><i class="fa fa-facebook fa-lg fa-fw"></i></a>
                            <a href="#"><i class="fa fa-twitter fa-lg fa-fw"></i></a>
                            <a href="#"><i class="fa fa-google-plus fa-lg fa-fw"></i></a>
                        </div>
                    </div>
                </div>
                <!-- end team -->
            </div>
            <!-- end col-4 -->
            <!-- begin col-4 -->
            <div class="col-md-4 col-sm-4">
                <!-- begin team -->
                <div class="team">
                    <div class="image" data-animation="true" data-animation-type="flipInX">
                        <img src="/landing/img/user-3.jpg" alt="Mia Donovan"/>
                    </div>
                    <div class="info">
                        <h3 class="name">Mia Donovan</h3>

                        <div class="title text-theme">WEB DESIGNER</div>
                        <p>Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. </p>

                        <div class="social">
                            <a href="#"><i class="fa fa-facebook fa-lg fa-fw"></i></a>
                            <a href="#"><i class="fa fa-twitter fa-lg fa-fw"></i></a>
                            <a href="#"><i class="fa fa-google-plus fa-lg fa-fw"></i></a>
                        </div>
                    </div>
                </div>
                <!-- end team -->
            </div>
            <!-- end col-4 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end #team -->

<!-- begin #quote -->
<div id="quote" class="content bg-black-darker has-bg" data-scrollview="true">
    <!-- begin content-bg -->
    <div class="content-bg">
        <img src="/landing/img/quote-bg.jpg" alt="Quote"/>
    </div>
    <!-- end content-bg -->
    <!-- begin container -->
    <div class="container" data-animation="true" data-animation-type="fadeInLeft">
        <!-- begin row -->
        <div class="row">
            <!-- begin col-12 -->
            <div class="col-md-12 quote">
                <i class="fa fa-quote-left"></i> Passion leads to design, design leads to performance, <br/>
                performance leads to <span class="text-theme">success</span>!
                <i class="fa fa-quote-right"></i>
                <small>Sean Themes, Developer Teams in Malaysia</small>
            </div>
            <!-- end col-12 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end #quote -->

<!-- beign #service -->
<div id="service" class="content" data-scrollview="true">
    <!-- begin container -->
    <div class="container">
        <h2 class="content-title">Our Services</h2>

        <p class="content-desc">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum consectetur eros dolor,<br/>
            sed bibendum turpis luctus eget
        </p>
        <!-- begin row -->
        <div class="row">
            <!-- begin col-4 -->
            <div class="col-md-4 col-sm-4">
                <div class="service">
                    <div class="icon bg-theme" data-animation="true" data-animation-type="bounceIn"><i
                            class="fa fa-cog"></i></div>
                    <div class="info">
                        <h4 class="title">Easy to Customize</h4>

                        <p class="desc">Duis in lorem placerat, iaculis nisi vitae, ultrices tortor. Vestibulum
                            molestie
                            ipsum nulla. Maecenas nec hendrerit eros, sit amet maximus leo.</p>
                    </div>
                </div>
            </div>
            <!-- end col-4 -->
            <!-- begin col-4 -->
            <div class="col-md-4 col-sm-4">
                <div class="service">
                    <div class="icon bg-theme" data-animation="true" data-animation-type="bounceIn"><i
                            class="fa fa-paint-brush"></i></div>
                    <div class="info">
                        <h4 class="title">Clean & Careful Design</h4>

                        <p class="desc">Etiam nulla turpis, gravida et orci ac, viverra commodo ipsum. Donec nec
                            mauris
                            faucibus, congue nisi sit amet, lobortis arcu.</p>
                    </div>
                </div>
            </div>
            <!-- end col-4 -->
            <!-- begin col-4 -->
            <div class="col-md-4 col-sm-4">
                <div class="service">
                    <div class="icon bg-theme" data-animation="true" data-animation-type="bounceIn"><i
                            class="fa fa-file"></i></div>
                    <div class="info">
                        <h4 class="title">Well Documented</h4>

                        <p class="desc">Ut vel laoreet tortor. Donec venenatis ex velit, eget bibendum purus
                            accumsan
                            cursus. Curabitur pulvinar iaculis diam.</p>
                    </div>
                </div>
            </div>
            <!-- end col-4 -->
        </div>
        <!-- end row -->
        <!-- begin row -->
        <div class="row">
            <!-- begin col-4 -->
            <div class="col-md-4 col-sm-4">
                <div class="service">
                    <div class="icon bg-theme" data-animation="true" data-animation-type="bounceIn"><i
                            class="fa fa-code"></i></div>
                    <div class="info">
                        <h4 class="title">Re-usable Code</h4>

                        <p class="desc">Aenean et elementum dui. Aenean massa enim, suscipit ut molestie quis,
                            pretium
                            sed orci. Ut faucibus egestas mattis.</p>
                    </div>
                </div>
            </div>
            <!-- end col-4 -->
            <!-- begin col-4 -->
            <div class="col-md-4 col-sm-4">
                <div class="service">
                    <div class="icon bg-theme" data-animation="true" data-animation-type="bounceIn"><i
                            class="fa fa-shopping-cart"></i></div>
                    <div class="info">
                        <h4 class="title">Online Shop</h4>

                        <p class="desc">Quisque gravida metus in sollicitudin feugiat. Class aptent taciti sociosqu
                            ad
                            litora torquent per conubia nostra, per inceptos himenaeos.</p>
                    </div>
                </div>
            </div>
            <!-- end col-4 -->
            <!-- begin col-4 -->
            <div class="col-md-4 col-sm-4">
                <div class="service">
                    <div class="icon bg-theme" data-animation="true" data-animation-type="bounceIn"><i
                            class="fa fa-heart"></i></div>
                    <div class="info">
                        <h4 class="title">Free Support</h4>

                        <p class="desc">Integer consectetur, massa id mattis tincidunt, sapien erat malesuada
                            turpis,
                            nec vehicula lacus felis nec libero. Fusce non lorem nisl.</p>
                    </div>
                </div>
            </div>
            <!-- end col-4 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end #about -->

<!-- beign #action-box -->
<div id="action-box" class="content has-bg" data-scrollview="true">
    <!-- begin content-bg -->
    <div class="content-bg">
        <img src="/landing/img/action-bg.jpg" alt="Action"/>
    </div>
    <!-- end content-bg -->
    <!-- begin container -->
    <div class="container" data-animation="true" data-animation-type="fadeInRight">
        <!-- begin row -->
        <div class="row action-box">
            <!-- begin col-9 -->
            <div class="col-md-9 col-sm-9">
                <div class="icon-large text-theme">
                    <i class="fa fa-binoculars"></i>
                </div>
                <h3>CHECK OUT OUR ADMIN THEME!</h3>

                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus faucibus magna eu lacinia
                    eleifend.
                </p>
            </div>
            <!-- end col-9 -->
            <!-- begin col-3 -->
            <div class="col-md-3 col-sm-3">
                <a href="#" class="btn btn-outline btn-block">Live Preview</a>
            </div>
            <!-- end col-3 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end #action-box -->

<!-- begin #work -->
<div id="work" class="content" data-scrollview="true">
    <!-- begin container -->
    <div class="container" data-animation="true" data-animation-type="fadeInDown">
        <h2 class="content-title">Our Latest Work</h2>

        <p class="content-desc">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum consectetur eros dolor,<br/>
            sed bibendum turpis luctus eget
        </p>
        <!-- begin row -->
        <div class="row row-space-10">
            <!-- begin col-3 -->
            <div class="col-md-3 col-sm-6">
                <!-- begin work -->
                <div class="work">
                    <div class="image">
                        <a href="#"><img src="/landing/img/work-1.jpg" alt="Work 1"/></a>
                    </div>
                    <div class="desc">
                        <span class="desc-title">Aliquam molestie</span>
                        <span class="desc-text">Lorem ipsum dolor sit amet</span>
                    </div>
                </div>
                <!-- end work -->
            </div>
            <!-- end col-3 -->
            <!-- begin col-3 -->
            <div class="col-md-3 col-sm-6">
                <!-- begin work -->
                <div class="work">
                    <div class="image">
                        <a href="#"><img src="/landing/img/work-3.jpg" alt="Work 3"/></a>
                    </div>
                    <div class="desc">
                        <span class="desc-title">Quisque at pulvinar lacus</span>
                        <span class="desc-text">Lorem ipsum dolor sit amet</span>
                    </div>
                </div>
                <!-- end work -->
            </div>
            <!-- end col-3 -->
            <!-- begin col-3 -->
            <div class="col-md-3 col-sm-6">
                <!-- begin work -->
                <div class="work">
                    <div class="image">
                        <a href="#"><img src="/landing/img/work-5.jpg" alt="Work 5"/></a>
                    </div>
                    <div class="desc">
                        <span class="desc-title">Vestibulum et erat ornare</span>
                        <span class="desc-text">Lorem ipsum dolor sit amet</span>
                    </div>
                </div>
                <!-- end work -->
            </div>
            <!-- end col-3 -->
            <!-- begin col-3 -->
            <div class="col-md-3 col-sm-6">
                <!-- begin work -->
                <div class="work">
                    <div class="image">
                        <a href="#"><img src="/landing/img/work-7.jpg" alt="Work 7"/></a>
                    </div>
                    <div class="desc">
                        <span class="desc-title">Sed vitae mollis magna</span>
                        <span class="desc-text">Lorem ipsum dolor sit amet</span>
                    </div>
                </div>
                <!-- end work -->
            </div>
            <!-- end col-3 -->
        </div>
        <!-- end row -->
        <!-- begin row -->
        <div class="row row-space-10">
            <!-- begin col-3 -->
            <div class="col-md-3 col-sm-6">
                <!-- begin work -->
                <div class="work">
                    <div class="image">
                        <a href="#"><img src="/landing/img/work-2.jpg" alt="Work 2"/></a>
                    </div>
                    <div class="desc">
                        <span class="desc-title">Suspendisse at mattis odio</span>
                        <span class="desc-text">Lorem ipsum dolor sit amet</span>
                    </div>
                </div>
                <!-- end work -->
            </div>
            <!-- end col-3 -->
            <!-- begin col-3 -->
            <div class="col-md-3 col-sm-6">
                <!-- begin work -->
                <div class="work">
                    <div class="image">
                        <a href="#"><img src="/landing/img/work-4.jpg" alt="Work 4"/></a>
                    </div>
                    <div class="desc">
                        <span class="desc-title">Aliquam vitae commodo diam</span>
                        <span class="desc-text">Lorem ipsum dolor sit amet</span>
                    </div>
                </div>
                <!-- end work -->
            </div>
            <!-- end col-3 -->
            <!-- begin col-3 -->
            <div class="col-md-3 col-sm-6">
                <!-- begin work -->
                <div class="work">
                    <div class="image">
                        <a href="#"><img src="/landing/img/work-6.jpg" alt="Work 6"/></a>
                    </div>
                    <div class="desc">
                        <span class="desc-title">Phasellus eu vehicula lorem</span>
                        <span class="desc-text">Lorem ipsum dolor sit amet</span>
                    </div>
                </div>
                <!-- end work -->
            </div>
            <!-- end col-3 -->
            <!-- begin col-3 -->
            <div class="col-md-3 col-sm-6">
                <!-- begin work -->
                <div class="work">
                    <div class="image">
                        <a href="#"><img src="/landing/img/work-8.jpg" alt="Work 8"/></a>
                    </div>
                    <div class="desc">
                        <span class="desc-title">Morbi bibendum pellentesque</span>
                        <span class="desc-text">Lorem ipsum dolor sit amet</span>
                    </div>
                </div>
                <!-- end work -->
            </div>
            <!-- end col-3 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end #work -->

<!-- begin #client -->
<div id="client" class="content has-bg bg-green" data-scrollview="true">
    <!-- begin content-bg -->
    <div class="content-bg">
        <img src="/landing/img/client-bg.jpg" alt="Client"/>
    </div>
    <!-- end content-bg -->
    <!-- begin container -->
    <div class="container" data-animation="true" data-animation-type="fadeInUp">
        <h2 class="content-title">Our Client Testimonials</h2>
        <!-- begin carousel -->
        <div class="carousel testimonials slide" data-ride="carousel" id="testimonials">
            <!-- begin carousel-inner -->
            <div class="carousel-inner text-center">
                <!-- begin item -->
                <div class="item active">
                    <blockquote>
                        <i class="fa fa-quote-left"></i>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce viverra, nulla ut interdum
                        fringilla,<br/>
                        urna massa cursus lectus, eget rutrum lectus neque non ex.
                        <i class="fa fa-quote-right"></i>
                    </blockquote>
                    <div class="name"> — <span class="text-theme">Mark Doe</span>, Designer</div>
                </div>
                <!-- end item -->
                <!-- begin item -->
                <div class="item">
                    <blockquote>
                        <i class="fa fa-quote-left"></i>
                        Donec cursus ligula at ante vulputate laoreet. Nulla egestas sit amet lorem non
                        bibendum.<br/>
                        Nulla eget risus velit. Pellentesque tincidunt velit vitae tincidunt finibus.
                        <i class="fa fa-quote-right"></i>
                    </blockquote>
                    <div class="name"> — <span class="text-theme">Joe Smith</span>, Developer</div>
                </div>
                <!-- end item -->
                <!-- begin item -->
                <div class="item">
                    <blockquote>
                        <i class="fa fa-quote-left"></i>
                        Sed tincidunt quis est sed ultrices. Sed feugiat auctor ipsum, sit amet accumsan elit
                        vestibulum<br/>
                        fringilla. In sollicitudin ac ligula eget vestibulum.
                        <i class="fa fa-quote-right"></i>
                    </blockquote>
                    <div class="name"> — <span class="text-theme">Linda Adams</span>, Programmer</div>
                </div>
                <!-- end item -->
            </div>
            <!-- end carousel-inner -->
            <!-- begin carousel-indicators -->
            <ol class="carousel-indicators">
                <li data-target="#testimonials" data-slide-to="0" class="active"></li>
                <li data-target="#testimonials" data-slide-to="1" class=""></li>
                <li data-target="#testimonials" data-slide-to="2" class=""></li>
            </ol>
            <!-- end carousel-indicators -->
        </div>
        <!-- end carousel -->
    </div>
    <!-- end containter -->
</div>
<!-- end #client -->

<!-- begin #contact -->
<div id="contact" class="content bg-silver-lighter" data-scrollview="true">
    <!-- begin container -->
    <div class="container">
        <h2 class="content-title">Contact Us</h2>

        <p class="content-desc">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum consectetur eros dolor,<br/>
            sed bibendum turpis luctus eget
        </p>
        <!-- begin row -->
        <div class="row">
            <!-- begin col-6 -->
            <div class="col-md-6" data-animation="true" data-animation-type="fadeInLeft">
                <h3>If you have a project you would like to discuss, get in touch with us.</h3>

                <p>
                    Morbi interdum mollis sapien. Sed ac risus. Phasellus lacinia, magna a ullamcorper laoreet,
                    lectus
                    arcu pulvinar risus, vitae facilisis libero dolor a purus.
                </p>

                <p>
                    <strong>SeanTheme Studio, Inc</strong><br/>
                    795 Folsom Ave, Suite 600<br/>
                    San Francisco, CA 94107<br/>
                    P: (123) 456-7890<br/>
                </p>

                <p>
                    <span class="phone">+11 (0) 123 456 78</span><br/>
                    <a href="mailto:hello@emailaddress.com">seanthemes@support.com</a>
                </p>
            </div>
            <!-- end col-6 -->
            <!-- begin col-6 -->
            <div class="col-md-6 form-col" data-animation="true" data-animation-type="fadeInRight">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="control-label col-md-3">Name <span class="text-theme">*</span></label>

                        <div class="col-md-9">
                            <input type="text" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Email <span class="text-theme">*</span></label>

                        <div class="col-md-9">
                            <input type="text" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Message <span class="text-theme">*</span></label>

                        <div class="col-md-9">
                            <textarea class="form-control" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3"></label>

                        <div class="col-md-9 text-left">
                            <button type="submit" class="btn btn-theme btn-block">Send Message</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- end col-6 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end #contact -->

<!-- begin #footer -->
<div id="footer" class="footer">
    <div class="container">
        <div class="footer-brand">
            <div class="footer-brand-logo"></div>
            Color Admin
        </div>
        <p>
            &copy; Copyright Color Admin 2014 <br/>
            An admin & front end theme with serious impact. Created by <a href="#">SeanTheme</a>
        </p>

        <p class="social-list">
            <a href="#"><i class="fa fa-facebook fa-fw"></i></a>
            <a href="#"><i class="fa fa-instagram fa-fw"></i></a>
            <a href="#"><i class="fa fa-twitter fa-fw"></i></a>
            <a href="#"><i class="fa fa-google-plus fa-fw"></i></a>
            <a href="#"><i class="fa fa-dribbble fa-fw"></i></a>
        </p>
    </div>
</div>
<!-- end #footer -->