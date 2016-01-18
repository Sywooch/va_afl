<?php
use app\components\Helper;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $user app\models\Users */
/* @var $form yii\widgets\ActiveForm */
$this->title = Yii::t('app', 'Pilot Center');
$this->params['breadcrumbs'] = [
    ['label' => $this->title]
];

?>
<div class="row">
    <?= $this->render('header', ['user' => $user]) ?>
</div>
<div class="row">
    <div class="col-md-8">
        <?= $this->render('onlinetable', ['onlineProvider' => $onlineProvider]) ?>
    </div>
    <div class="col-md-4">
        <!-- begin panel -->
    <?= $this->render('news', ['news' => $news]) ?>
    </div>
</div>
<div class="row">
    <!-- begin col-4 -->
    <div class="col-md-4">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">
                    Visitors Origin
                </h4>
            </div>
            <div id="visitors-map" class="bg-black" style="height: 181px;"></div>
            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-inverse text-ellipsis">
                    <span class="badge badge-success">20.95%</span>
                    1. United State
                </a>
                <a href="#" class="list-group-item list-group-item-inverse text-ellipsis">
                    <span class="badge badge-primary">16.12%</span>
                    2. India
                </a>
                <a href="#" class="list-group-item list-group-item-inverse text-ellipsis">
                    <span class="badge badge-inverse">14.99%</span>
                    3. South Korea
                </a>
            </div>
        </div>
    </div>
    <!-- end col-4 -->
    <!-- begin col-4 -->
    <div class="col-md-4">
        <!-- begin panel -->
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">Today's Schedule</h4>
            </div>
            <div id="schedule-calendar" class="bootstrap-calendar"></div>
            <div class="list-group">
                <a href="#" class="list-group-item text-ellipsis">
                    <span class="badge badge-success">9:00 am</span> Sales Reporting
                </a>
                <a href="#" class="list-group-item text-ellipsis">
                    <span class="badge badge-primary">2:45 pm</span> Have a meeting with sales team
                </a>
            </div>
        </div>
        <!-- end panel -->
    </div>
    <!-- end col-4 -->
    <!-- begin col-4 -->
    <div class="col-md-4">
        <!-- begin panel -->
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">New Registered Users <span
                        class="pull-right label label-success">24 new users</span></h4>
            </div>
            <ul class="registered-users-list clearfix">
                <li>
                    <a href="javascript:;"><img src="/img/user-5.jpg" alt=""/></a>
                    <h4 class="username text-ellipsis">
                        Savory Posh
                        <small>Algerian</small>
                    </h4>
                </li>
                <li>
                    <a href="javascript:;"><img src="/img/user-3.jpg" alt=""/></a>
                    <h4 class="username text-ellipsis">
                        Ancient Caviar
                        <small>Korean</small>
                    </h4>
                </li>
                <li>
                    <a href="javascript:;"><img src="/img/user-1.jpg" alt=""/></a>
                    <h4 class="username text-ellipsis">
                        Marble Lungs
                        <small>Indian</small>
                    </h4>
                </li>
                <li>
                    <a href="javascript:;"><img src="/img/user-8.jpg" alt=""/></a>
                    <h4 class="username text-ellipsis">
                        Blank Bloke
                        <small>Japanese</small>
                    </h4>
                </li>
                <li>
                    <a href="javascript:;"><img src="/img/user-2.jpg" alt=""/></a>
                    <h4 class="username text-ellipsis">
                        Hip Sculling
                        <small>Cuban</small>
                    </h4>
                </li>
                <li>
                    <a href="javascript:;"><img src="/img/user-6.jpg" alt=""/></a>
                    <h4 class="username text-ellipsis">
                        Flat Moon
                        <small>Nepalese</small>
                    </h4>
                </li>
                <li>
                    <a href="javascript:;"><img src="/img/user-4.jpg" alt=""/></a>
                    <h4 class="username text-ellipsis">
                        Packed Puffs
                        <small>Malaysian></small>
                    </h4>
                </li>
                <li>
                    <a href="javascript:;"><img src="/img/user-9.jpg" alt=""/></a>
                    <h4 class="username text-ellipsis">
                        Clay Hike
                        <small>Swedish</small>
                    </h4>
                </li>
            </ul>
            <div class="panel-footer text-center">
                <a href="javascript:;" class="text-inverse">View All</a>
            </div>
        </div>
        <!-- end panel -->
    </div>
    <!-- end col-4 -->
</div>
<?= Html::button('Launch edit profile',
    ['class' => 'btn btn-primary btn-lg', 'data-toggle' => 'modal', 'data-target' => '#modal-dialog']) ?>

<?= $this->render('../edit_modal', ['user' => $user]) ?>