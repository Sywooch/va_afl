<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 10.01.16
 * Time: 21:02
 */

use app\components\Helper;
use yii\helpers\Html;

?>
<!-- begin col-3 -->
<div class="col-md-3 col-sm-6">
    <div class="widget widget-stats bg-green">
        <div class="stats-icon stats-icon-lg"><i class="fa fa-globe fa-fw"></i></div>
        <div class="stats-title"><?= Yii::t('app', 'Location') ?></div>
        <div class="stats-number">
            <img alt="<?= $user->pilot->airport->iso ?>" src="<?= $user->pilot->airport->flaglink ?>"> <?= Html::encode($user->pilot->airport->name . ' (' . $user->pilot->location . ')') ?>
        </div>
        <div class="stats-progress progress">
            <div class="progress-bar" style="width: 70.1%;"></div>
        </div>
        <div class="stats-desc"><?= app\components\IvaoWx::metar($user->pilot->location) ?></div>
    </div>
</div>
<!-- end col-3 -->
<!-- begin col-3 -->
<div class="col-md-3 col-sm-6">
    <div class="widget widget-stats bg-blue">
        <div class="stats-icon stats-icon-lg"><i class="fa fa-tags fa-fw"></i></div>
        <div class="stats-title"><?= Yii::t('app', 'Total flights') ?></div>
        <div class="stats-number"><?= $user->pilot->flightsCount ?></div>
        <div class="stats-progress progress">
            <div class="progress-bar" style="width: 40.5%;"></div>
        </div>
        <div class="stats-desc"></div>
    </div>
</div>
<!-- end col-3 -->
<!-- begin col-3 -->
<div class="col-md-3 col-sm-6">
    <div class="widget widget-stats bg-purple">
        <div class="stats-icon stats-icon-lg"><i class="fa fa-shopping-cart fa-fw"></i></div>
        <div class="stats-title"><?= Yii::t('app', 'Total hours') ?></div>
        <div class="stats-number"><?= Helper::getTimeFormatted($user->pilot->time) ?></div>
        <div class="stats-progress progress">
            <div class="progress-bar" style="width: 76.3%;"></div>
        </div>
        <div class="stats-desc"></div>
    </div>
</div>
<!-- end col-3 -->
<!-- begin col-3 -->
<div class="col-md-3 col-sm-6">
    <div class="widget widget-stats bg-black">
        <div class="stats-icon stats-icon-lg"><i class="fa fa-comments fa-fw"></i></div>
        <div class="stats-title">VUC's</div>
        <div class="stats-number"><?= isset($user->pilot->billingUserBalance) ? $user->pilot->billingUserBalance->balance : 0 ?></div>
        <div class="stats-progress progress">
            <div class="progress-bar" style="width: 54.9%;"></div>
        </div>
        <div class="stats-desc"></div>
    </div>
</div>
<!-- end col-3 -->