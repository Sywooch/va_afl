<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ContentCategories */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Content Categories',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Content'), 'url' => ['/content']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->link]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="content-categories-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
