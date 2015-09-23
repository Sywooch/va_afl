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
   'options' => ['class'=>'grid-view striped condensed bordered'],
   'dataProvider' => $dataProvider,
   'columns' => [
       'full_name',
       Yii::$app->language=='RU'?'pilot.rank.name_ru':'pilot.rank.name_eng',
       'pilot.location'
   ]
]);