<?php

use app\components\Helper;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tour') . ' ' . $model->content->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tours'), 'url' => ['/tours']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title"><?= Html::encode($this->title) ?></h4>
    </div>
    <div class="panel-body">
        <h2 class="page-header">
            Tour description for "<?= $model->content->name ?>"
        </h2>

        <div class="row">
            <div class="col-md-12 col-lg-6">
                <img class="img-responsive" src="<?= $model->content->imgLink ?>"></div>
            <div class="col-md-12 col-lg-6">
                <h2 style="margin-top: 0;">Welcome to the <?= $model->content->name ?>!</h2>
                In addition to the general rules found <a href="rules" target="_blank">here</a>, you need to comply
                with these additional rules for this tour:<br><br>

                <div class="well">
                    <?= $model->content->text ?>
                </div>
                <ul class="list-group">
                    <li class="list-group-item list-group-item-success">
                            <span class="badge"><?=
                                $model->getToursUsers()->andWhere(
                                    ['status' => \app\models\Tours\ToursUsers::STATUS_COMPLETED]
                                )->count() ?></span>
                        <?= Yii::t('app', 'Completed') ?>
                    </li>
                    <li class="list-group-item list-group-item-warning">
                            <span class="badge"><?=
                                $model->getToursUsers()->andWhere(
                                    ['status' => \app\models\Tours\ToursUsers::STATUS_ACTIVE]
                                )->count() ?></span>
                        <?= Yii::t('app', 'In progress') ?>
                    </li>
                    <li class="list-group-item">
                        <span class="badge"><?= $model->getToursLegs()->count() ?></span>
                        <?= Yii::t('app', 'Total Legs') ?>
                    </li>
                </ul>
                <?php if (!$model->userNo): ?>
                    <div class="well" style="background-color: transparent">
                        <?=
                        \yii\helpers\Html::button(
                            Yii::t('app', 'Assign to me'),
                            ['class' => 'btn btn-success', 'onClick' => 'assign(0);']
                        ) ?>
                    </div>
                <?php endif ?>
                <?php if ($model->userAssign): ?>
                <div class="well" style="background-color: transparent">
                    <?= \yii\helpers\Html::button(
                            Yii::t('app', 'Unassign from me'),
                            ['class' => 'btn btn-danger', 'onClick' => 'assign(-1);']
                        ) ?>
                </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">Legs overview</h4>
    </div>
    <div class="panel-body">
        <?=
        GridView::widget(
        ['dataProvider' => new \yii\data\ActiveDataProvider(['query' => $model->getToursLegs()->orderBy(
        'leg_id asc'
        )]),
        'layout' => '{items}',
        'tableOptions' => ['class' => 'table table-bordered table-striped table-condensed'],
        'columns' => [['attribute' => 'from_to',
        'label' => '#',
        'format' => 'raw',
        'value' => function ($data) {
        return $data->leg_id;
        }],
        ['attribute' => 'Departure',
        'label' => Yii::t('flights', 'Departure'),
        'format' => 'raw',
        'value' => function ($data) {
        return Html::a(
        Html::img(Helper::getFlagLink($data->depAirport->iso)) . ' ' .
        Html::encode($data->depAirport->fullname),
        Url::to(
        ['/airline/airports/view/',
        'id' => $data->from]
        )
        );
        }],
        ['attribute' => 'Arrival',
        'label' => Yii::t('flights', 'Arrival'),
        'format' => 'raw',
        'value' => function ($data) {
        return Html::a(
        Html::img(Helper::getFlagLink($data->arrAirport->iso)) . ' ' .
        Html::encode($data->arrAirport->fullname),
        Url::to(
        ['/airline/airports/view/',
        'id' => $data->to]
        )
        );
        }],
        ['attribute' => 'Distance',
        'label' => Yii::t('flights', 'Distance'),
        'format' => 'raw',
        'value' => function ($data) {
        return round(
        Helper::calculateDistanceLatLng(
        $data->depAirport->lat,
        $data->arrAirport->lat,
        $data->depAirport->lon,
        $data->arrAirport->lon
        )
        ) . ' nM.';
        }],],]
        ) ?>
    </div>
</div>
<script>
    function assign(act) {
        $.post('/tours/assign', {act: act, tour_id:<?=$model->id ?>}, function (response) {
            location.reload();
        });
    }
</script>