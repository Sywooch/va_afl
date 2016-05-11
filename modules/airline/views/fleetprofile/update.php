<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FleetProfiles */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Fleet Profiles',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fleet Profiles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="fleet-profiles-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
