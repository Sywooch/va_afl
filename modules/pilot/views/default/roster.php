<?php
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
       'full_name',
       Yii::$app->language=='RU'?'pilot.rank.name_ru':'pilot.rank.name_en',
       ['attribute'=>'pilot.location','format'=>'raw','value'=>function($data){
               return "<img src=" . $data->pilot->airport->flaglink . ">" .
               \yii\helpers\Html::a($data->pilot->location,\yii\helpers\Url::to('/airline/airports/view/' . $data->pilot->airport->icao));
           }
       ]
   ]
]);