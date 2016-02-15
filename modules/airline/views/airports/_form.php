<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Airports */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="airports-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'icao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lat')->textInput() ?>

    <?= $form->field($model, 'lon')->textInput() ?>

    <?= $form->field($model, 'alt')->textInput() ?>

    <?= $form->field($model, 'iata')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'iso')->dropdownList(
        app\models\Isocodes::find()->select(['country', 'code'])->indexBy('code')->column(),
        ['prompt' => 'Select Country']
    ) ?>

    <?= $form->field($model, 'FIR')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
