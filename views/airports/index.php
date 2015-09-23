<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Airports');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="airports-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Airports'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'icao',
            'name',
            'lat',
            'lon',
            // 'alt',
            // 'iata',
            // 'city',
            // 'iso',
            // 'FIR',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
