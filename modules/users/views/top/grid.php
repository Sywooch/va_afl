<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = Yii::t('app', 'Top');
?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title"><?= $this->title ?></h4>
    </div>
    <div class="panel-body" style="display: block;">
        <?php Pjax::begin(); ?>    <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'rating_pos',
                [
                    'attribute' => 'user_id',
                    'format' => 'raw',
                    'value' => function ($data) {
                        return "<img src=" . $data->user->flaglink . "> " .
                        Html::a($data->user->full_name, Url::to('/pilot/profile/' . $data->user->vid),
                            ['target' => '_blank']);
                    }
                ],
                'rating_count',
                'exp_count',
                'exp_pos',
                'flights_count',
                'flights_pos',
                'hours_count',
                'hours_pos',
                'pax_count',
                'pax_pos',
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
