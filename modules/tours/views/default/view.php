<?php

use app\components\Helper;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tour') . ' ' . $tour->content->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tours'), 'url' => ['/tours']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title"><?= Html::encode($this->title) ?></h4>
    </div>
    <div class="panel-body">
        <h2 class="page-header">
            "<?= $tour->content->name ?>"
        </h2>

        <div class="row">
            <div class="col-md-12 col-lg-6">
                <img class="img-responsive" src="<?= $tour->content->imgLink ?>"></div>
            <div class="col-md-12 col-lg-6">
                <h2 style="margin-top: 0;"><?= $tour->content->name ?>!</h2>
                <div class="well">
                    <?= $tour->content->text ?>
                </div>
                <?php if ($tour->userAssign || $tour->userActive): ?>
                    <div class="col-md-9">
                        <div class="widget widget-stats bg-blue">
                            <div class="stats-icon stats-icon-lg"><i class="fa fa-tags fa-fw"></i></div>
                            <div class="stats-title"><?= Yii::t('flights', 'Next Leg') ?></div>
                            <div class="stats-number">
                                <div class="row">
                                    <div class="col-md-4">
                                        <a href="/pilot/booking" style="color: white;"><?= Yii::t('app', 'Go to booking') ?></a>
                                    </div>
                                    <div class="col-md-8">
                                        <?=
                                        Html::img(
                                            Helper::getFlagLink($tour->tourUser->nextLeg->depAirport->iso)
                                        ) . ' ' .
                                        Html::tag(
                                            'span',
                                            $tour->tourUser->nextLeg->depAirport->icao,
                                            [
                                                'title' => Html::encode(
                                                        "{$tour->tourUser->nextLeg->depAirport->name} ({$tour->tourUser->nextLeg->depAirport->city}, {$tour->tourUser->nextLeg->arrAirport->iso})"
                                                    ),
                                                'data-toggle' => 'tooltip1',
                                                'style' => 'cursor:pointer;'
                                            ]
                                        ) .
                                        ' — ' .
                                        Html::img(
                                            Helper::getFlagLink($tour->tourUser->nextLeg->arrAirport->iso)
                                        ) . ' ' .
                                        Html::tag(
                                            'span',
                                            $tour->tourUser->nextLeg->arrAirport->icao,
                                            [
                                                'title' => Html::encode(
                                                        "{$tour->tourUser->nextLeg->arrAirport->name} ({$tour->tourUser->nextLeg->arrAirport->city}, {$tour->tourUser->nextLeg->arrAirport->iso})"
                                                    ),
                                                'data-toggle' => 'tooltip1',
                                                'style' => 'cursor:pointer;'
                                            ]
                                        );?>
                                    </div>
                                </div>
                            </div>
                            <div class="stats-progress progress">
                                <div class="progress-bar" style="width: <?= $tour->tourUser->percent ?>%;"></div>
                            </div>
                            <div class="stats-desc">

                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="col-md-12">
                    <ul class="list-group">
                        <li class="list-group-item list-group-item-success">
                            <span class="badge"><?= $tour->exp ?></span>
                            <?= Yii::t('app', 'EXP') ?>
                        </li>
                        <li class="list-group-item list-group-item-success">
                            <span class="badge"><?= $tour->vucs ?></span>
                            <?= Yii::t('app', 'VUCs') ?>
                        </li>
                        <li class="list-group-item list-group-item-info">
                            <span class="badge"><?=
                                $tour->getToursUsers()->andWhere(
                                    ['status' => \app\models\Tours\ToursUsers::STATUS_COMPLETED]
                                )->count() ?></span>
                            <?= Yii::t('app', 'Completed') ?>
                        </li>
                        <li class="list-group-item list-group-item-warning">
                                <span class="badge"><?=
                                    $tour->getToursUsers()->andFilterWhere(
                                        [
                                            'or',
                                            [
                                                'status' => [
                                                    \app\models\Tours\ToursUsers::STATUS_ACTIVE,
                                                    \app\models\Tours\ToursUsers::STATUS_ASSIGNED
                                                ]
                                            ]
                                        ]
                                    )->count()  ?></span>
                            <?= Yii::t('app', 'In progress') ?>
                        </li>
                        <li class="list-group-item">
                            <span class="badge"><?= $tour->getToursLegs()->count() ?></span>
                            <?= Yii::t('app', 'Total Legs') ?>
                        </li>
                    </ul>
                </div>
                <?php if (!$tour->userNo): ?>
                    <div class="well col-md-12" style="background-color: transparent">
                        <?=
                        \yii\helpers\Html::button(
                            Yii::t('app', 'Join'),
                            ['class' => 'btn btn-success', 'onClick' => 'assign(0);']
                        ) ?>
                    </div>
                <?php endif ?>
                <?php if ($tour->userAssign): ?>
                    <div class="well col-md-12" style="background-color: transparent">
                        <?=
                        \yii\helpers\Html::button(
                            Yii::t('app', 'Exit'),
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
        <h4 class="panel-title"><?= Yii::t('tours', 'Legs overview') ?></h4>
    </div>
    <div class="panel-body">
        <?=
        GridView::widget(
            [
                'dataProvider' => new \yii\data\ActiveDataProvider([
                        'query' => $tour->getToursLegs()->orderBy(
                                'leg_id asc'
                            ),
                        'pagination' => [
                            'pageSize' => 100,
                        ],
                    ]),
                'layout' => '{items}',
                'tableOptions' => ['class' => 'table table-bordered table-condensed'],
                'rowOptions' => function ($model) {
                        if (\app\modules\tours\controllers\DefaultController::$tour->tourUser) {
                            if ($model->leg_id <= \app\modules\tours\controllers\DefaultController::$tour->tourUser->legs_finished) {
                                return ['class' => 'success'];
                            } elseif ($model->leg_id - 1 == \app\modules\tours\controllers\DefaultController::$tour->tourUser->legs_finished) {
                                return ['class' => 'warning'];
                            }
                        }

                        return ['class' => ''];

                    },
                'columns' => [
                    [
                        'attribute' => 'from_to',
                        'label' => '#',
                        'format' => 'raw',
                        'value' => function ($data) {
                                return $data->leg_id;
                            }
                    ],
                    [
                        'attribute' => 'Departure',
                        'label' => Yii::t('flights', 'Departure'),
                        'format' => 'raw',
                        'value' => function ($data) {
                                return Html::a(
                                    Html::img(Helper::getFlagLink($data->depAirport->iso)) . ' ' .
                                    Html::encode($data->depAirport->fullname),
                                    Url::to(
                                        [
                                            '/airline/airports/view/',
                                            'id' => $data->from
                                        ]
                                    )
                                );
                            }
                    ],
                    [
                        'attribute' => 'Arrival',
                        'label' => Yii::t('flights', 'Arrival'),
                        'format' => 'raw',
                        'value' => function ($data) {
                                return Html::a(
                                    Html::img(Helper::getFlagLink($data->arrAirport->iso)) . ' ' .
                                    Html::encode($data->arrAirport->fullname),
                                    Url::to(
                                        [
                                            '/airline/airports/view/',
                                            'id' => $data->to
                                        ]
                                    )
                                );
                            }
                    ],
                    [
                        'attribute' => 'Distance',
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
                            }
                    ],
                ],
            ]
        ) ?>
    </div>
</div>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title"><?= Yii::t('app', 'Users') ?></h4>
    </div>
    <div class="panel-body">
        <div class="col-md-12">
            <?php Pjax::begin() ?>
            <?=
            GridView::widget(
                [
                    'dataProvider' => new \yii\data\ActiveDataProvider([
                            'query' => $tour->getToursUsers()->where(
                                    'status > ' . \app\models\Tours\ToursUsers::STATUS_UNASSIGNED
                                )->orderBy(
                                        'id asc'
                                    ),
                            'pagination' => [
                                'pageSize' => 20,
                            ],
                        ]),
                    'columns' => [
                        [
                            'attribute' => 'Name',
                            'format' => 'raw',
                            'value' => function ($data) {
                                    return "<img src='" . \app\components\Helper::getFlagLink(
                                        $data->user->country
                                    ) . "'> " . Html::a(
                                        Html::encode($data->user->full_name),
                                        Url::to(
                                            [
                                                '/pilot/profile/',
                                                'id' => $data->user->vid
                                            ]
                                        )
                                    );
                                }
                        ],
                        [
                            'attribute' => 'status',
                            'label' => Yii::t('app', 'Status'),
                            'format' => 'raw',
                            'value' => function ($data) {
                                    switch ($data->status) {
                                        case 0:
                                            return '<i class="fa fa-eye"></i> ' . Yii::t('app', 'Assigned');
                                            break;
                                        case 1:
                                            return '<i class="fa fa-paper-plane"></i> ' . Yii::t('app', 'Active');
                                            break;
                                        case 2:
                                            return '<i class="fa fa-thumbs-up"></i> ' . Yii::t('app', 'Completed');
                                            break;
                                        default:
                                            return '<i class="fa fa-lock"></i> ' . Yii::t('app', 'No info');
                                    }
                                },
                        ],
                        'legs_finished',
                    ],
                ]
            ); ?>
            <?php Pjax::end() ?>
        </div>
    </div>
    <script>
        function assign(act) {
            $.post('/tours/assign', {act: act, tour_id:<?=$tour->id ?>}, function (response) {
                location.reload();
            });
        }
        setTimeout(function () {
            $('span[data-toggle="tooltip1"]').tooltip({
                animated: 'fade',
                placement: 'top',
                container: 'body'
            });
        }, 400);
    </script>