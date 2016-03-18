<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Fleet */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Fleet',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fleets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'regnum' => $model->regnum]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="fleet-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>