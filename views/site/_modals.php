<?php
/**
 * Created by PhpStorm.
 * User: nfedoseev
 * Date: 17.09.2016
 * Time: 23:36
 */
use app\models\Content;
use app\models\Staff;
use app\models\UserPilot;
use app\models\Users;
use yii\bootstrap\Modal;
use yii\data\ActiveDataProvider;
use yii\widgets\Pjax;

?>
<?php Modal::begin([
    'header' => '<h2>'.(Yii::$app->request->get('lang') == 'RU' ? 'Правила' : 'Rules').'</h2>',
    'toggleButton' => [
        'tag' => 'button',
        'class' => 'btn btn-lg btn-info',
        'label' =>  (Yii::$app->request->get('lang') == 'RU' ? 'Правила' : 'Rules'),
    ]
]);

echo Yii::$app->request->get('lang') == 'RU' ? Content::findOne(1365)->text_ru : Content::findOne(1365)->text_en;

Modal::end(); ?>

<?php Modal::begin([
    'header' => '<h2>'.(Yii::$app->request->get('lang') == 'RU' ? 'Список пилотов' : 'Pilots roster').'</h2>',
    'toggleButton' => [
        'tag' => 'button',
        'class' => 'btn btn-lg btn-info',
        'label' =>  (Yii::$app->request->get('lang') == 'RU' ? 'Список пилотов' : 'Pilots roster'),
    ]
]);
Pjax::begin();
echo \yii\grid\GridView::widget(
    [
        'dataProvider' => (new ActiveDataProvider([
            'query' => Users::find()->joinWith('pilot')->andWhere(
                ['status' => UserPilot::STATUS_ACTIVE]
            ),
            'pagination' => array('pageSize' => 1000),
            'sort'=> ['defaultOrder' => ['created_date'=>SORT_ASC]]
        ])),
        'tableOptions' => [
            'class' => 'table table-bordered table-striped table-hover'
        ],
        'layout' => '{items}{pager}',
        'columns' => [
            [
                'attribute' => 'full_name',
                'format' => 'raw',
                'value' => function ($data) {
                    return "<img src=" . $data->flaglink . "> " .
                    $data->vid;
                }
            ],
            [
                'attribute' => 'created_date',
                'format' => ['date', 'php:d.m.Y']
            ],
        ]
    ]
);
Pjax::end();

Modal::end(); ?>

<?php Modal::begin([
    'header' => '<h2>'.(Yii::$app->request->get('lang') == 'RU' ? 'Команда' : 'Staff').'</h2>',
    'toggleButton' => [
        'tag' => 'button',
        'class' => 'btn btn-lg btn-info',
        'label' =>  (Yii::$app->request->get('lang') == 'RU' ? 'Команда' : 'Staff'),
    ]
]);

echo \yii\grid\GridView::widget(
    [
        'dataProvider' => (new ActiveDataProvider([
            'query' => Staff::find()->where('vid != 999999'),
            'sort' => false,
            'pagination' => false
        ])),
        'layout' => '{items}{pager}',
        'columns' => [
            Yii::$app->request->get('lang') == 'RU' ? 'name_ru' : 'name_en',
            [
                'attribute' => 'Name',
                'format' => 'raw',
                'value' => function ($data) {
                    return "<img src='" . \app\components\Helper::getFlagLink(
                        $data->user->country
                    ) . "'> " . $data->user->vid;
                }
            ],
        ]
    ]
);

Modal::end(); ?>