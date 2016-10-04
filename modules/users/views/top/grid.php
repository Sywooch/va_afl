<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title"><?= $this->title ?></h4>
    </div>
    <div class="panel-body" style="display: block;">
        <?php Pjax::begin(); ?>    <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'label' => Yii::t('top', 'Position by Rating'),
                    'attribute' => 'rating_pos',
                    'format' => 'raw',
                    'value' => function ($data) {
                            return $data->rating_pos.' (<span style="color:'.($data->rating_pos_change_day >= 0 ? 'darkgreen;"> +' : '#8b0000;"> -').$data->rating_pos_change_day.'</span> / <span style="color:'.($data->rating_pos_change_week >= 0 ? 'darkgreen;"> +' : '#8b0000;"> -').$data->rating_pos_change_week.'</span>)';
                        }
                ],
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
