<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 24.09.15
 * Time: 19:42
 */
$this->title = Yii::t('app', 'Staff');
$this->params['breadcrumbs'] = [
    ['label' => $this->title]
];

echo \yii\grid\GridView::widget(
    [
        'dataProvider' => $dataProvider,
        'columns' => [
            Yii::$app->language == 'RU' ? 'name_ru' : 'name_en',
            [
                'attribute' => 'user.country',
                'format' => 'raw',
                'value' => function ($data) {
                        return "<img src='".\yii\components\Helper::getFlagLink($data->user->country) . "'> " . $data->user->full_name;
                    }
            ]
        ]
    ]
);