<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Logs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'id',
                'label' => Yii::t('app', 'ID'),
                'format' => 'raw',
                'value' => function ($data) {
                        return Html::a(Html::encode($data->id), Url::to(['/airline/log/view/', 'id' => $data->id]));
                    },
            ],
            'author',
            'subject',
            'action',
            'type',
            'sub_type',
            'datetime'
            // 'old:ntext',
            // 'new:ntext',
        ],
    ]); ?>
    <?php Pjax::end(); ?>

</div>
