<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Schedule */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="schedule-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'flight')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dep')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'arr')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'aircraft')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dep_utc_time')->textInput() ?>

    <?= $form->field($model, 'arr_utc_time')->textInput() ?>

    <?= $form->field($model, 'dep_lmt_time')->textInput() ?>

    <?= $form->field($model, 'arr_lmt_time')->textInput() ?>

    <?= $form->field($model, 'eet')->textInput() ?>

    <?= $form->field($model, 'day_of_weeks')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'start')->textInput() ?>

    <?= $form->field($model, 'stop')->textInput() ?>

    <?= $form->field($model, 'added')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
