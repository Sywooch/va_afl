<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Fleet Profiles');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fleet-profiles-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Fleet Profiles'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'pbn',
            'nav',
            // 'rvr',
            // 'equipment',
            // 'transponder',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
