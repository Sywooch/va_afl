<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 13.01.16
 * Time: 2:54
 */

use yii\helpers\Html;
use yii\helpers\Url;

use app\components\Helper;

?>
<table class="table" style="color: #AFAFAF;">
    <tbody>
    <tr>
        <td align="right"> <?= Yii::t('flights', 'Callsign') ?>:</td>
        <td><b><?= $model->callsign ?></b></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td align="right"> <?= Yii::t('app', 'Pilot in Command') ?>:</td>
        <td><b> <?= Html::img(Helper::getFlagLink($model->user->country)) ?>  <?= Html::a(
                    $model->user->full_name,
                    Url::to(['/pilot/profile/' . $model->user->vid])
                ) ?></b></td>
        <td align="right"> <?= Yii::t('flights', 'Status') ?>:</td>
        <td><b> <?= $model->booking->statusName ?></b>
        </td>
    </tr>
    <tr>
        <td align="right"> <?= Yii::t('flights', 'Aircraft') ?>:</td>
        <td><b> <?= $model->fleet->full_type ?> (<?= $model->fleet->type_code ?>)</b></td>
        <td align="right"> <?= Yii::t('flights', 'Tail number') ?>:</td>
        <td><b> <?=
                Html::a(
                    $model->fleet->regnum,
                    Url::to(['/airline/fleet/view/' . $model->fleet->id])
                ) ?></b>
        </td>
    </tr>
    <tr>
        <td align="right"> <?= Yii::t('flights', 'Departure') ?>:</td>
        <td colspan="3"><b><?= Html::img(Helper::getFlagLink($model->depAirport->iso)) ?> <?=
                Html::a(
                    Html::encode($model->from_icao),
                    Url::to(
                        [
                            '/airline/airports/view/',
                            'id' => $model->from_icao
                        ]
                    )
                );?></b>  <?= Html::encode($model->depAirport->name) ?> (<?=
            Html::encode(
                $model->depAirport->city
            ) ?>)
        </td>
    </tr>
    <tr>
        <td align="right"> <?= Yii::t('flights', 'Destination') ?>:</td>
        <td colspan="3"><b><?= Html::img(Helper::getFlagLink($model->arrAirport->iso)) ?> <?=
                Html::a(
                    Html::encode($model->to_icao),
                    Url::to(
                        [
                            '/airline/airports/view/',
                            'id' => $model->to_icao
                        ]
                    )
                );?></b>  <?= Html::encode($model->arrAirport->name) ?> (<?=
            Html::encode(
                $model->arrAirport->city
            ) ?>)
        </td>
    </tr>
    <?php if($model->landingAirport && $model->landing != $model->to_icao) :?>
        <tr>
            <td align="right"> <?= Yii::t('flights', 'Landing') ?>:</td>
            <td colspan="3"><b> <?= Html::img(Helper::getFlagLink($model->landingAirport->iso)) ?> <?=
                    Html::a(
                        Html::encode($model->landing),
                        Url::to(
                            [
                                '/airline/airports/view/',
                                'id' => $model->landing
                            ]
                        )
                    );?></b>  <?= Html::encode($model->landingAirport->name) ?> (<?=
                Html::encode(
                    $model->landingAirport->city
                ) ?>)
            </td>
        </tr>
    <?php endif;?>
    <tr>
        <td align="right"> <?= Yii::t('app', 'Simulator') ?>:</td>
        <td colspan="3"><b> <?= $model->simulator ?> </b></td>
    </tr>
    <tr>
        <td align="right"> <?= Yii::t('flights', 'Departure date') ?>:</td>
        <td><b><?= (new \DateTime($model->first_seen))->format('d.m.Y') ?></b></td>
        <td align="right"> <?= Yii::t('flights', 'Departure time') ?>:</td>
        <td><b> <?= (new \DateTime($model->dep_time))->format('H:i') ?> </b></td>
    </tr>
    <tr>
        <td align="right"> <?= Yii::t('flights', 'Flight time') ?>:</td>
        <td><b> <?= (new \DateTime($model->landing_time))->diff(new \DateTime($model->dep_time))->format(
                    '%h:%i'
                ) ?> </b></td>
        <td align="right"> <?= Yii::t('flights', 'Arrival time') ?>:</td>
        <td><b> <?= (new \DateTime($model->landing_time))->format('H:i') ?> </b></td>
    </tr>
    <tr>
        <td align="right"> <?= Yii::t('flights', 'Distance') ?>:</td>
        <td><b> <?= $model->nm ?> nm.</b></td>
        <td align="right"> <?= Yii::t('flights', 'POB') ?>:</td>
        <td><b> <?= $model->pob ?> </b></td>
    </tr>
    <tr>
        <td colspan="4"><b><?= Yii::t('flights', 'Route') ?></b></td>
    </tr>
    <tr>
        <td colspan="4" class="border al"> <?= $model->flightplan ?>
        </td>
    </tr>
    <tr>
        <td colspan="4"><b><?= Yii::t('flights', 'Remarks') ?></b></td>
    </tr>
    <tr>
        <td colspan="4" class="border al"> <?= $model->remarks ?>
        </td>
    </tr>
    </tbody>
</table>
<script>
    $('[data-toggle="tooltip"]').tooltip({'placement': 'top'});
</script>