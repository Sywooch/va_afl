<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Squads */

$this->title = Yii::$app->language == 'RU' ? $squad->name_ru : $squad->name_en;
$this->params['breadcrumbs'][] = ['label' => 'Squads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="squads-view">

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
