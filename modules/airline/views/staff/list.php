<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 24.09.15
 * Time: 19:42
 */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = Yii::t('app', 'Staff');
$this->params['breadcrumbs'] = [
    ['label' => $this->title]
];
?>
<div class="airports-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        if (Yii::$app->user->can('edit_airport')) {
            echo Html::a(Yii::t('app', 'Create Position'), ['create'], ['class' => 'btn btn-success']);
        }
        ?>
    </p>

    <?php
    echo \yii\grid\GridView::widget(
        [
            'dataProvider' => $dataProvider,
            'columns' => [
                Yii::$app->language == 'RU' ? 'name_ru' : 'name_en',
                [
                    'attribute' => 'user.country',
                    'format' => 'raw',
                    'value' => function ($data) {
                            return "<img src='" . \app\components\Helper::getFlagLink(
                                $data->user->country
                            ) . "'> " . $data->user->full_name;
                        }
                ],
                ['class' => 'yii\grid\ActionColumn', 'visible' => Yii::$app->user->can('edit_staff')],
            ]
        ]
    );
    ?>
</div>
