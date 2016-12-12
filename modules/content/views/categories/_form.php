<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ContentCategories */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="content-categories-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'link_to')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name_ru')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'access_read')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'access_edit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'access_feed')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'news')->dropDownList(['1' => 'News','0' => 'Content']) ?>

    <?= $form->field($model, 'notifications')->dropDownList(['1' => 'On','0' => 'Off']) ?>

    <?= $form->field($model, 'documents')->dropDownList(['1' => 'On','0' => 'Off']) ?>

    <?= $form->field($model, 'feed')->dropDownList(['1' => 'On','0' => 'Off']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
