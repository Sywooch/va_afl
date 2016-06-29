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
        'dataProvider' => new \yii\data\ActiveDataProvider(['query' => $schedule]),
        'tableOptions' => [
            'class' => ''
        ],
        'layout' => '{items}{pager}',
        'columns' => [
            'flight',
            'dep',
            'arr'
        ]
    ]
); ?>