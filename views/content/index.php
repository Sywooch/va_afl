<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Contents');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Content'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget(
        [
            'options' => ['class' => 'grid-view striped condensed bordered'],
            'dataProvider' => $dataProvider,
            'columns' => [
                Yii::$app->language == 'RU' ? 'name_ru' : 'name_en',
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]
    ); ?>

</div>
