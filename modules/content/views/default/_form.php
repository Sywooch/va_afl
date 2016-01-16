<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use kartik\select2\Select2;

use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model app\models\Content */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="content-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name_ru')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'name_en')->textInput(['maxlength' => true]) ?>
    <?=
    $form->field($model, 'text_ru')->widget(
        CKEditor::className(),
        [
            'options' => ['rows' => 6],
            'preset' => 'basic'
        ]
    ) ?><?=
    $form->field($model, 'text_en')->widget(
        CKEditor::className(),
        [
            'options' => ['rows' => 6],
            'preset' => 'basic'
        ]
    ) ?>

    <?=
    $form->field($model, 'category')->widget(
    /**
     * TODO: Видеть только те категории, которые доступны по ролям юзера.
     * @bth, можно так сделать?)
     */
        Select2::classname(),
        ['data' => \yii\helpers\ArrayHelper::map(\app\models\ContentCategories::find()->all(), 'id', 'name_en')]
    )
    ?>

    <div class="form-group">
        <?=
        Html::submitButton(
            $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
