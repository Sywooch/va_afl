<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\airline\models\FleetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Fleets');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fleet-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Fleet'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'regnum',
            'type_code',
            'full_type',
            'status',
            // 'user_id',
            // 'home_airport',
            // 'location',
            // 'image_path:ntext',
            // 'squadron_id',
            // 'max_pax',
             'max_hrs',
             'hrs',
             'need_srv',
            // 'profile',
            // 'selcal',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
