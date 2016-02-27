<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Fleet */

$this->title = Yii::t('app', 'Create Fleet');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fleets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fleet-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
