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

$this->title = "{$model->callsign} {$model->from_icao}-{$model->to_icao} " . (new \DateTime($model->first_seen))->format(
        'd.m.Y'
    );

$this->params['breadcrumbs'][] = [
    'label' => Yii::t(
            'app',
            'Flights of ' . Users::find()->where(['vid' => $model->user_id])->one()->full_name
        ),
    'url' => ['/airline/flights/index/' . $model->user_id]
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
        <div class="col-sm-6"><b> <?= Html::img(Helper::getFlagLink($model->user->country)) ?>  <?= Html::a(
                    $model->user->full_name,
                    Url::to(['/pilot/profile/' . $model->user->vid])
                ) ?></b></div>
        <div class="col-md-12">
            <hr>
        </div>
        <div class="col-sm-2"><b><?= Yii::t('flights', 'Flight ID') ?>:</b></div>
        <div class="col-sm-2"><b> <?= $model->id ?></b></div>
        <div class="col-md-12">
            <hr>
        </div>
        <div class="col-sm-2"><b><?= Yii::t('flights', 'Flight time') ?>:</b></div>
        <div class="col-sm-10"><?= (new \DateTime($model->landing_time))->diff(new \DateTime($model->dep_time))->format(
                '%h:%i'
            ) ?> </div>
        <div class="col-md-12">
            <hr>
        </div>
        <div class="col-sm-2"><b><?= Yii::t('flights', 'Distance') ?>:</b></div>
        <div class="col-sm-10"><?= $model->nm ?> nm.</div>
        <div class="col-md-12">
            <hr>
        </div>
        <div class="col-sm-2"><b><?= Yii::t('flights', 'Persons on board') ?>:</b></div>
        <div class="col-sm-10"><?= $model->pob ?></div>
        <div class="col-md-12">
            <hr>
        </div>
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
        <h4 class="panel-title">Departure</h4>
    </div>

    <div class="panel-body">
        <div class="col-sm-2"><b>Airport: </b></div>
        <div class="col-sm-10"><b><?= Html::img(Helper::getFlagLink($model->depAirport->iso)) ?> <?=
                Html::a(
                    Html::encode($model->from_icao),
                    Url::to(
                        [
                            '/airline/airports/view/',
                            'id' => $model->from_icao
                        ]
                    )
                );?> <?= Html::encode($model->depAirport->name) ?> (<?=
                Html::encode(
                    $model->depAirport->city
                ) ?>)</b>
        </div>
        <div class="col-md-12">
            <hr>
        </div>
        <div class="col-sm-2"><b>Departure time: </b></div>
        <div class="col-sm-10" style="font: 14px Courier New, Monospace"><?= $model->dep_time ?></div>
        <div class="col-md-12">
            <hr>
        </div>
        <div class="col-sm-2"><b>Weather: </b></div>
        <div class="col-sm-10" style="font: 14px Courier New, Monospace"><?= $model->metar_dep ?></div>
    </div>
</div>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">Destination</h4>
    </div>

    <div class="panel-body">
        <div class="col-sm-2"><b>Airport: </b></div>
        <div class="col-sm-10"><b><?= Html::img(Helper::getFlagLink($model->arrAirport->iso)) ?> <?=
                Html::a(
                    Html::encode($model->to_icao),
                    Url::to(
                        [
                            '/airline/airports/view/',
                            'id' => $model->to_icao
                        ]
                    )
                );?> <?= Html::encode($model->arrAirport->name) ?> (<?=
                Html::encode(
                    $model->arrAirport->city
                ) ?>)</b>
        </div>
        <?php if($model->landingAirport && $model->landing == $model->to_icao): ?>
        <div class="col-md-12">
            <hr>
        </div>
        <div class="col-sm-2"><b>Landing time: </b></div>
        <div class="col-sm-10" style="font: 14px Courier New, Monospace"><?= $model->landing_time ?></div>
        <div class="col-md-12">
            <hr>
        </div>
        <div class="col-sm-2"><b>Weather: </b></div>
        <div class="col-sm-10" style="font: 14px Courier New, Monospace"><?= $model->metar_landing ?></div>
        <?php endif; ?>
    </div>
</div>
<?php if($model->landingAirport && $model->landing != $model->to_icao): ?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">Landing airport</h4>
    </div>

    <div class="panel-body">
        <div class="col-sm-2"><b>Airport: </b></div>
        <div class="col-sm-10"><b><?= Html::img(Helper::getFlagLink($model->landingAirport->iso)) ?> <?=
                Html::a(
                    Html::encode($model->landing),
                    Url::to(
                        [
                            '/airline/airports/view/',
                            'id' => $model->landing
                        ]
                    )
                );?> <?= Html::encode($model->landingAirport->name) ?> (<?=
                Html::encode(
                    $model->landingAirport->city
                ) ?>)</b>
        </div>
        <div class="col-md-12">
            <hr>
        </div>
        <div class="col-sm-2"><b>Landing time: </b></div>
        <div class="col-sm-10" style="font: 14px Courier New, Monospace"><?= $model->landing_time ?></div>
        <div class="col-md-12">
            <hr>
        </div>
        <div class="col-sm-2"><b>Weather: </b></div>
        <div class="col-sm-10" style="font: 14px Courier New, Monospace"><?= $model->metar_landing ?></div>
    </div>
</div>
<?php endif; ?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">FPL</h4>
    </div>
    <div class="panel-body">
        <div class="col-sm-2"><b>Route</b></div>
        <div class="col-sm-10" style="font: 14px Courier New, Monospace"><?=
            str_replace(
                "\n",
                '<br>',
                $model->flightplan
            ) ?></div>
        <div class="col-md-12">
            <hr>
        </div>
        <div class="col-sm-2"><b>FPL By IVAO</b></div>
        <div class="col-sm-3" style="font: 14px Courier New, Monospace"><?=
            str_replace(
                "\n",
                '<br>',
                $model->fpl
            ) ?></div>
    </div>
</div>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">Suspensions</h4>
    </div>

    <div class="panel-body">
        <?=
        GridView::widget(
            [
                'options' => ['class' => 'grid-view striped condensed bordered'],
                'dataProvider' => $suspensions,
                'columns' => [
                    'content.name',
                    'description',
                    'issue_datetime',
                ],
            ]
        ); ?>
    </div>
</div>