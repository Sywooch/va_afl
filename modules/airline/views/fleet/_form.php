<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\models\Fleet */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fleet-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'regnum')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'full_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'home_airport')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image_path')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'squadron_id')->widget(
        Select2::classname(),
        ['data' => \yii\helpers\ArrayHelper::map(\app\models\Squadrons::find()->all(), 'id', 'abbr')]
    ) ?>

    <?= $form->field($model, 'max_pax')->textInput() ?>

    <?= $form->field($model, 'max_hrs')->textInput() ?>

    <?= $form->field($model, 'hrs')->textInput() ?>

    <?= $form->field($model, 'need_srv')->textInput() ?>

    <?= $form->field($model, 'selcal')->textInput() ?>

    <?= $form->field($model, 'profile')->widget(
        Select2::classname(),
        ['data' => \yii\helpers\ArrayHelper::map(\app\models\FleetProfiles::find()->all(), 'id', 'name')]
    );?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
