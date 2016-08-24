<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 01.06.16
 * Time: 20:35
 */
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

use app\components\Helper;
use app\models\Users;

$this->title = "Briefing {$model->callsign} {$model->from_icao}-{$model->to_icao} " . (new \DateTime($model->created))->format(
        'd.m.Y'
    );

$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Pilot Center'),
    'url' => ['/pilot/center']
];

$this->params['breadcrumbs'][] = $this->title;

?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title"><?= Yii::t('flights', 'General Info') ?></h4>
    </div>

    <div class="panel-body">
        <div class="col-sm-2"><b><?= Yii::t('flights', 'Callsign') ?>:</b></div>
        <div class="col-sm-2"><b> <?= $model->callsign ?></b></div>
        <div class="col-sm-2"><b><?= Yii::t('app', 'Pilot in Command') ?>:</b></div>
        <div class="col-sm-6"><?= Html::img(Helper::getFlagLink($model->user->country)) ?>  <?=
            Html::a(
                $model->user->full_name,
                Url::to(['/pilot/profile/' . $model->user->vid])
            ) ?></b></div>
        <div class="col-md-12">
            <hr>
        </div>
    </div>
</div>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title"><?= Yii::t('flights', 'FPL') ?></h4>
    </div>
    <div class="panel-body">
        <div class="col-sm-2"><b><?= Yii::t('flights', 'Route') ?></b></div>
        <div class="col-sm-10" style="font: 14px Courier New, Monospace"><?= $model->briefing->routes->route ?></div>
        <div class="col-md-12">
            <hr>
        </div>
        <div class="col-sm-2"><b><?= Yii::t('flights', 'Remarks') ?></b></div>
        <div class="col-sm-10" style="font: 14px Courier New, Monospace"><?= $model->briefing->remarks ?></div>
        <div class="col-md-12">
            <hr>
        </div>
        <div class="col-sm-2"><b>FPL By IVAO</b></div>
        <div class="col-sm-3" style="font: 14px Courier New, Monospace"><?=
            str_replace(
                "\n",
                '<br>',
                ''
            ) ?></div>
    </div>
</div>
<?php if($model->fleet) :?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title"><?= Yii::t('flights', 'Aircraft Info') ?></h4>
    </div>

    <div class="panel-body">
        <div class="col-sm-2"><b><?= Yii::t('flights', 'Aircraft') ?>:</b></div>
        <div class="col-sm-10"><b><?= $model->fleet->full_type ?> (<?= $model->fleet->type_code ?>)</b></div>
        <div class="col-md-12">
            <hr>
        </div>
        <div class="col-sm-2"><b><?= Yii::t('flights', 'Tail number') ?>:</b></div>
        <div class="col-sm-10"><b><?=
            Html::a(
                $model->fleet->regnum,
                Url::to(['/airline/fleet/view/' . $model->fleet->id])
            ) ?></b>
        </div>
        <div class="col-md-12">
            <hr>
        </div>
        <div class="col-sm-2"><b> <?= Yii::t('flights', 'SELCAL') ?>:</b></div>
        <div class="col-sm-10"><?= $model->fleet->selcal ?></div>
    </div>
</div>
<?php endif; ?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title"><?= Yii::t('flights', 'Departure') ?></h4>
    </div>

    <div class="panel-body">
        <div class="col-sm-2"><b><?= Yii::t('app', 'Airport') ?>: </b></div>
        <div class="col-sm-10"><b><?= Html::img(Helper::getFlagLink($model->departure->iso)) ?> <?=
                Html::a(
                    Html::encode($model->from_icao),
                    Url::to(
                        [
                            '/airline/airports/view/',
                            'id' => $model->from_icao
                        ]
                    )
                );?> <?= Html::encode($model->departure->name) ?> (<?=
                Html::encode(
                    $model->departure->city
                ) ?>)</b>
        </div>
        <div class="col-md-12">
            <hr>
        </div>
        <div class="col-sm-2"><b>METAR: </b></div>
        <div class="col-sm-10" style="font: 14px Courier New, Monospace"><?=
            \app\components\IvaoWx::metar(
                $model->from_icao
            ) ?></div>
        <div class="col-md-12">
            <hr>
        </div>
        <div class="col-sm-2"><b>TAF: </b></div>
        <div class="col-sm-10" style="font: 14px Courier New, Monospace"><?=
            str_replace(
                "  ",
                '<br>',
                \app\components\IvaoWx::taf($model->from_icao)
            ) ?></div>
    </div>
</div>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title"><?= Yii::t('flights', 'Destination') ?></h4>
    </div>

    <div class="panel-body">
        <div class="col-sm-2"><b><?= Yii::t('app', 'Airport') ?>: </b></div>
        <div class="col-sm-10"><b><?= Html::img(Helper::getFlagLink($model->arrival->iso)) ?> <?=
                Html::a(
                    Html::encode($model->to_icao),
                    Url::to(
                        [
                            '/airline/airports/view/',
                            'id' => $model->to_icao
                        ]
                    )
                );?> <?= Html::encode($model->arrival->name) ?> (<?=
                Html::encode(
                    $model->arrival->city
                ) ?>)</b>
        </div>
        <div class="col-md-12">
            <hr>
        </div>
        <div class="col-sm-2"><b>METAR: </b></div>
        <div class="col-sm-10" style="font: 14px Courier New, Monospace"><?=
            \app\components\IvaoWx::metar(
                $model->to_icao
            ) ?></div>
        <div class="col-md-12">
            <hr>
        </div>
        <div class="col-sm-2"><b>TAF: </b></div>
        <div class="col-sm-10" style="font: 14px Courier New, Monospace"><?=
            str_replace(
                "  ",
                '<br>',
                \app\components\IvaoWx::taf($model->to_icao)
            ) ?></div>
    </div>
</div>
<?php if($model->briefing->routes->altn):?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title"><?= Yii::t('flights', 'Alternative') ?></h4>
    </div>

    <div class="panel-body">
        <div class="col-sm-2"><b><?= Yii::t('app', 'Airport') ?>: </b></div>
        <div class="col-sm-10"><b><?= Html::img(Helper::getFlagLink($model->briefing->routes->altnAirport->iso)) ?> <?=
                Html::a(
                    Html::encode($model->briefing->routes->altn),
                    Url::to(
                        [
                            '/airline/airports/view/',
                            'id' => $model->briefing->routes->altn
                        ]
                    )
                );?> <?= Html::encode($model->briefing->routes->altnAirport->name) ?> (<?=
                Html::encode(
                    $model->briefing->routes->altnAirport->city
                ) ?>)</b>
        </div>
        <div class="col-md-12">
            <hr>
        </div>
        <div class="col-sm-2"><b>METAR: </b></div>
        <div class="col-sm-10" style="font: 14px Courier New, Monospace"><?=
            \app\components\IvaoWx::metar(
                $model->briefing->routes->altn
            ) ?></div>
        <div class="col-md-12">
            <hr>
        </div>
        <div class="col-sm-2"><b>TAF: </b></div>
        <div class="col-sm-10" style="font: 14px Courier New, Monospace"><?=
            str_replace(
                "  ",
                '<br>',
                \app\components\IvaoWx::taf($model->briefing->routes->altn)
            ) ?></div>
    </div>
</div>
<?php endif; ?>