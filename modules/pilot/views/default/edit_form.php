<?php

use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $user app\models\Users */
/* @var $form yii\widgets\ActiveForm */

$form = ActiveForm::begin([
    'action' => '/pilot/edit/' . $pilot->user_id,
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

<?= $form->field($pilot, 'avatar')->fileInput() ?>
<?= $form->field($pilot, 'user_comments')->textArea(['rows' => '6']) ?>
<?php if (Yii::$app->user->can('user_pilot/staffcomments/edit')): ?>
    <?= $form->field($pilot, 'staff_comments')->textArea(['rows' => '6']) ?>
<?php endif; ?>
<?= $form->field($pilot, 'stream_link')->textInput(['maxlength' => true]) ?>
<?php ActiveForm::end(); ?>


