<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Events Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="events-categories-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Events Categories'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'event_id',
                'label' => Yii::t('app', 'Event'),
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a($data->event->contentInfo->name_en . ' (' . $data->event->startDT->format('Y-m-d') . ')',
                        '/events/' . $data->event_id, ['target' => '_blank']);
                }
            ],
            [
                'attribute' => 'category_id',
                'label' => Yii::t('app', 'Category'),
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a($data->category_id, '/events/categories/stats/' . $data->category_id, ['target' => '_blank']);
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ]
    ]); ?>
    <?php Pjax::end(); ?></div>
