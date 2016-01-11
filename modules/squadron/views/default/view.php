<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Squads */

$this->title = Yii::$app->language == 'RU' ? $squad->name_ru : $squad->name_en;
$this->params['breadcrumbs'][] = ['label' => 'Squads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="squads-view">
    <div class="panel panel-inverse">
        <div class="panel-body">
            <h1><?= Html::encode($this->title) ?></h1>


            <?= DetailView::widget([
                'model' => $squad,
                'attributes' => [
                    'id',
                    'name_ru',
                    'name_en',
                    'abbr_ru',
                    'abbr_en',
                ],
            ]) ?>
            <div class="row">
                <div class="col-md-2">
                    <h2 style="text-align: center">Список пилотов</h2>
                    <?php Pjax::begin() ?>
                    <?= GridView::widget([
                        'dataProvider' => $membersProvider,
                        'columns' => [
                            [
                                'attribute' => 'member_name',
                                'label' => 'Member Name',
                                'value' => function ($data) {
                                    return $data->squadMember->full_name;
                                }
                            ]
                        ],
                    ]); ?>
                    <?php Pjax::end() ?>
                </div>
            </div>
        </div>
    </div>