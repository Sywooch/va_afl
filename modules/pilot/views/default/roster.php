<?php
use \yii\helpers\Html;
use \yii\helpers\Url;

/**
 * Created by PhpStorm.
 * User: BTH
 * Date: 23.09.15
 * Time: 20:32
 */
$this->title = Yii::t('app', 'Pilots roster');
$this->params['breadcrumbs'] = [
    ['label' => Yii::t('app', 'Pilot'), 'url' => '/pilot'],
    ['label' => $this->title]
];
echo \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'attribute' => 'full_name',
            'format' => 'raw',
            'value' => function ($data) {
                return Html::a($data->full_name, Url::to('/pilot/profile/' . $data->vid));
            }
        ],
        'full_name',
        Yii::$app->language == 'RU' ? 'pilot.rank.name_ru' : 'pilot.rank.name_en',
        [
            'attribute' => 'pilot.location',
            'format' => 'raw',
            'value' => function ($data) {
                return "<img src=" . $data->pilot->airport->flaglink . ">" .
                Html::a($data->pilot->location, Url::to('/airline/airports/view/' . $data->pilot->airport->icao));
            }
        ]
    ]
]);