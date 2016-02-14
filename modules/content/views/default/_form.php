<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use kartik\select2\Select2;

use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model app\models\Content */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="content-form">
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal form-bordered'],
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-sm-2',
                'offset' => 'col-sm-offset-4',
                'wrapper' => 'col-sm-10',
                'error' => '',
                'hint' => '',
            ],
        ],
    ]); ?>

    <?= $form->field($model, 'name_ru')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'name_en')->textInput(['maxlength' => true]) ?>
    <?php if (!isset($model->machine_name)) {
        echo $form->field($model, 'machine_name')->textInput(['maxlength' => true]);
    } ?>
    <?= $form->field($model, 'img_file')->fileInput() ?>
    <?= $form->field($model, 'preview_file')->fileInput() ?>
    <?=
    $form->field($model, 'text_ru')->widget(
        CKEditor::className(),
        [
            'options' => ['rows' => 6],
            'preset' => 'full'
        ]
    ) ?><?=
    $form->field($model, 'text_en')->widget(
        CKEditor::className(),
        [
            'options' => ['rows' => 6],
            'preset' => 'full'
        ]
    ) ?>

    <?= $form->field($model, 'description_ru')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'description_en')->textInput(['maxlength' => true]) ?>

    <?php //if (!isset($model->category))
    ?>
    <?= $form->field($model, 'category')->widget(
    /**
     * TODO: Видеть только те категории, которые доступны по ролям юзера.
     * @bth, можно так сделать?)
     */
        Select2::classname(),
        ['data' => \yii\helpers\ArrayHelper::map(\app\models\ContentCategories::find()->all(), 'id', 'name_en')]
    );?>

    <div class="form-group">
        <?=
        Html::submitButton(
            $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>