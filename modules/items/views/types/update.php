<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Items\ItemsTypes */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Items Types',
]) . $model->type_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Items Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->type_id, 'url' => ['view', 'id' => $model->type_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="items-types-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
