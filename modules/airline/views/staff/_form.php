<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Staff */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="airports-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'staff_position')->textInput() ?>

    <?= $form->field($model, 'name_ru')->textInput() ?>

    <?= $form->field($model, 'name_en')->textInput() ?>

    <?=
    $form->field($model, 'vid')->widget(
        Select2::classname(),
        ['data' => \yii\helpers\ArrayHelper::map(\app\models\Users::find()->all(), 'vid', 'full_name')]
    )
    ?>

    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
