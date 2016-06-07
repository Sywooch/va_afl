<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;

use dosamigos\highcharts\HighCharts;

use app\components\Helper;

$this->title = $user->full_name;
$this->params['breadcrumbs'] = [
    ['label' => Yii::t('app', 'Pilots Roster'), 'url' => '/pilot/roster'],
    ['label' => $this->title]
]; ?>
<div class="profile-container">
    <div class="profile-section row">
        <div class="col-md-2">
            <?= $this->render('left', ['user' => $user, 'staff' => $staff, 'squadrons' => $squadrons]) ?>
        </div>
        <div class="col-md-4">
            <?php //\yii\helpers\BaseVarDumper::dump($user->online, 10, true) ?>
            <div class="profile-info">
                <div class="row">
                    <div class="col-md-12">
                        <h2>
                            <img title="<?= $user->countryInfo->country ?>"
                                 src="<?= $user->flaglink ?>"> <?= $user->full_name ?>
                            <span class="label label-warning"><i class="fa fa-star"
                                                                 aria-hidden="true"></i> <?= $user->pilot->level ?></span>
                        </h2>
                    </div>
                    <div class="col-md-12">
                        <?= $this->render('info', ['user' => $user]) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title"><?= Yii::t('app', 'Statistics') ?></h4>
                </div>
                <div class="panel-body bg-silver">
                    <?= $this->render('stats', ['user' => $user]) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="profile-section">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <h4 class="panel-title"><?= Yii::t('app', 'Last Flights') ?></h4>
                    </div>
                    <div class="panel-body bg-silver">
                        <?= $this->render('flights', ['flightsProvider' => $flightsProvider]) ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <h4 class="panel-title"><?= Yii::t('app', 'Awards') ?></h4>
                    </div>
                    <div class="panel-body bg-silver">
                        <?= $this->render('awards', []) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>