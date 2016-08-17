<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 10.01.16
 * Time: 21:02
 */

use app\components\Helper;
use app\models\Booking;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<!-- begin col-3 -->
<div class="col-md-3 col-sm-6">
    <div class="widget widget-stats bg-green">
        <div class="stats-icon stats-icon-lg"><i class="fa fa-globe fa-fw"></i></div>
        <div class="stats-title"><?= Yii::t('app', 'Location') ?></div>
        <div class="stats-number">
            <img alt="<?= $user->pilot->airport->iso ?>" src="<?= $user->pilot->airport->flaglink ?>"> <a
                href="/airline/airports/view/<?= $user->pilot->location ?>" style="color: white;"><?=
                Html::encode(
                    $user->pilot->airport->name . ' (' . $user->pilot->location . ')'
                ) ?></a>
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
        <div class="stats-title"><?= Yii::t('app', 'Current flight') ?></div>
        <div class="stats-number">
            <?php if (!$flight) : ?>
                <?= Yii::t('app', 'Offline') ?>
            <?php else: ?>
                <div class="row">
                    <div class="col-md-4">
                        <a href="/pilot/booking" style="color: white;"><?= $flight->callsign ?></a>
                    </div>
                    <div class="col-md-8">
                        <?=
                        Html::img(Helper::getFlagLink($flight->departure->iso)) . ' ' .
                        Html::tag(
                            'span',
                            $flight->departure->icao,
                            [
                                'title' => Html::encode(
                                        "{$flight->departure->name} ({$flight->departure->city}, {$flight->arrival->iso})"
                                    ),
                                'data-toggle' => 'tooltip1',
                                'style' => 'cursor:pointer;'
                            ]
                        ) .
                        ' — ' .
                        Html::img(Helper::getFlagLink($flight->arrival->iso)) . ' ' .
                        Html::tag(
                            'span',
                            $flight->arrival->icao,
                            [
                                'title' => Html::encode(
                                        "{$flight->arrival->name} ({$flight->arrival->city}, {$flight->arrival->iso})"
                                    ),
                                'data-toggle' => 'tooltip1',
                                'style' => 'cursor:pointer;'
                            ]
                        );?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="stats-progress progress">
            <div class="progress-bar" style="width: <?= $flight ? $flight->percent : 0 ?>%;"></div>
        </div>
        <div class="stats-desc">
            <?php if ($flight) : ?>
                <?php if ($flight->fleet) : ?><?= $flight->fleet->regnum ?> (<?= $flight->fleet->full_type ?>),<?php else: ?> <?= $flight->flight ? $flight->flight->acf_type.',' : ''?> <?php endif; ?><?php
                switch ($flight->g_status) {
                    case Booking::STATUS_BOOKED:
                        echo 'Booked';
                        break;
                    case Booking::STATUS_BOARDING:
                        echo 'Boarding';
                        break;
                    case Booking::STATUS_DEPARTING:
                        echo 'Departing';
                        break;
                    case Booking::STATUS_ENROUTE:
                        echo 'En-route';
                        break;
                    case Booking::STATUS_LOSS:
                        echo 'Loss contact';
                        break;
                    case Booking::STATUS_APPROACH:
                        echo 'Approach';
                        break;
                    case Booking::STATUS_LANDED:
                        echo 'Landed';
                        break;
                    case Booking::STATUS_ON_BLOCKS:
                        echo 'On blocks';
                        break;
                    default:
                        echo '">###';
                        break;
                }?>
            <?php endif; ?>
        </div>
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
        <div
            class="stats-number"><?= isset($user->pilot->billingUserBalance) ? $user->pilot->billingUserBalance->balance : 0 ?></div>
        <div class="stats-progress progress">
            <div class="progress-bar" style="width: 54.9%;"></div>
        </div>
        <div class="stats-desc"></div>
    </div>
</div>
<!-- end col-3 -->
<script>
    setTimeout(function () {
        $('span[data-toggle="tooltip1"]').tooltip({
            animated: 'fade',
            placement: 'top',
            container: 'body'
        });
    }, 400);
</script>