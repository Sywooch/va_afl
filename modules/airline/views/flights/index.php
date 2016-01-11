<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

use app\components\Helper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Flights';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flights-index">
    <?php
    if (!$from_view) {
        ?>
        <h1><?= Html::encode($this->title) ?></h1>
        <?php
    }
    ?>
    <div id="flights">
        <?=
        GridView::widget(
            [
                'dataProvider' => $dataProvider,
                'layout' => (!$from_view)?'{items}{pager}':'{items}',
                'tableOptions' => ($from_view)?['class'=>'table table-bordered']:['class'=>'table table-bordered table-striped table-condensed'],
                'columns' => [
                    [
                        'attribute' => 'callsign',
                        'label' => Yii::t('flights', 'Callsign'),
                        'format' => 'raw',
                        'value' => function ($data) use ($from_view) {
                            if(!empty($data->track))
                            return Html::a(
                                Html::encode($data->callsign),
                                (!$from_view)?
                                Url::to(['/airline/flights/view/' . $data->id]):
                                'javascript:reload('.$data->id.',map)'
                            );
                            return Html::encode($data->callsign);
                        },
                    ],
                    'acf_type',
                    [
                        'attribute' => 'from_to',
                        'label' => Yii::t('flights', 'Route'),
                        'format' => 'raw',
                        'value' => function ($data) {
                            return Html::a(
                                Html::encode($data->from_icao),
                                Url::to(
                                    [
                                        '/airline/airports/view/',
                                        'id' => $data->from_icao
                                    ]
                                )
                            ) . '-' . Html::a(
                                Html::encode($data->to_icao),
                                Url::to(['/airline/airports/view/', 'id' => $data->to_icao])
                            );
                        },
                    ],
                    [
                        'attribute' => 'flight_time',
                        'label' => Yii::t('flights', 'Flight Time'),
                        'value' => function ($data) {
                            return Helper::getTimeFormatted($data->flight_time);
                        },
                        'visible' => !$from_view
                    ],
                    [
                        'attribute' => 'first_seen',
                        'label' => Yii::t('app', 'Date'),
                        'format' => ['date', 'php:d.m.Y'],
                        'visible' => !$from_view
                    ],
                ],
            ]
        ) ?>
    </div>
</div>