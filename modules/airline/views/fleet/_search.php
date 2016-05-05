<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\airline\models\FleetSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fleet-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'regnum') ?>

    <?= $form->field($model, 'type_code') ?>

    <?= $form->field($model, 'full_type') ?>

    <?= $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'home_airport') ?>

    <?php // echo $form->field($model, 'location') ?>

    <?php // echo $form->field($model, 'image_path') ?>

    <?php // echo $form->field($model, 'squadron_id') ?>

    <?php // echo $form->field($model, 'max_pax') ?>

    <?php // echo $form->field($model, 'max_hrs') ?>

    <?php // echo $form->field($model, 'profile') ?>

    <?php // echo $form->field($model, 'selcal') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
