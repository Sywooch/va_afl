<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 29.06.16
 * Time: 16:21
 */
?>

<?php echo \yii\grid\GridView::widget(
    [
        'dataProvider' => new \yii\data\ActiveDataProvider([
                'query' => $schedule,
                'sort' => false,
                'pagination' => false,
            ]),
        'tableOptions' => [
            'class' => '',
            'style' => 'border-spacing: 5px;border-collapse: inherit;'
        ],
        'layout' => '{items}{pager}',
        'columns' => [
            [
                'attribute' => 'flight',
                'format' => 'raw',
                'value' => function ($data) {
                        return '<a href="#" onclick="scheduleBook(\'' . $data->flight . '\', \''.$data->aircraft.'\')">' . $data->flight . '</a>';
                    }
            ],
            'dep',
            'arr',
            [
                'attribute' => 'dep_utc_time',
                'label' => 'EDT',
            ],
            [
                'attribute' => 'arr_utc_time',
                'label' => 'ETA',
            ],
            [
                'attribute' => 'eet',
                'label' => 'EET',
            ],
            [
                'attribute' => 'aircraft',
                'label' => 'ACF',
            ],
        ]
    ]
); ?>