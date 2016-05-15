<?php

use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $user app\models\Users */
/* @var $form yii\widgets\ActiveForm */

$form = ActiveForm::begin([
    'action' => '/pilot/edit/' . $user->vid,
    'options' => ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal form-bordered'],
    'id' => 'profile_edit',
    'layout' => 'horizontal',
    'fieldConfig' => [
        'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
        'horizontalCssClasses' => [
            'label' => 'col-sm-4',
            'offset' => 'col-sm-offset-4',
            'wrapper' => 'col-sm-8',
            'error' => '',
            'hint' => '',
        ],
    ],
]); ?>

<?= $form->field($user, 'email')->textInput(['maxlength' => true]) ?>
<?= $form->field($user, 'language')->dropDownList(['EN' => 'English', 'RU' => 'Русский']) ?>
<?= $form->field($user, 'avatar')->fileInput() ?>
<?= $form->field($user, 'stream')->textInput(['maxlength' => true]) ?>
<?php ActiveForm::end(); ?>


