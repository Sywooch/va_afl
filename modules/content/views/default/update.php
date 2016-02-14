<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Content */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
        'modelClass' => 'Content',
    ]) . ' ' . $model->id;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = [
    'label' => $model->categoryInfo->name,
    'url' => ['/content/categories/view/' . $model->categoryInfo->link]
];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="content-update">
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title"><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="panel-body panel-form" style="padding:10px !important;">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>