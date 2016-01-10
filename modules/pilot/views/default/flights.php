<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

use app\components\Helper;

$this->title = Yii::t('app', 'Flights') . ' ' . $id;
$this->params['breadcrumbs'] = [
    ['label' => Yii::t('app', 'Pilot'), 'url' => '/pilot'],
    ['label' => $this->title]
];
?>
    <h1><?= Html::encode($this->title) ?></h1>
<?=
GridView::widget(
    [
        'dataProvider' => $dataProvider,
        'filterModel' => $model,
        'layout' => '{items}{pager}',
        'options' => ['class' => 'table table-condensed'],
        'columns' => [
            'callsign',
            'acf_type',
            [
                'attribute' => 'from_to',
                'label' => Yii::t('flights', 'Route'),
                'value' => function ($data) {
                        return $data->from_icao . '-' . $data->to_icao;
                    },
            ],
            [
                'attribute' => 'flight_time',
                'label' => Yii::t('flights', 'Flight Time'),
                'value' => function ($data) {
                        return Helper::getTimeFormatted(
                            strtotime($data->landing_time) - strtotime($data->dep_time)
                        );
                    }
            ]
        ],
    ]
) ?>