<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $user app\models\Airports */
/* @var $form yii\widgets\ActiveForm */
$this->title = Yii::t('app', 'Profile editor');
$this->params['breadcrumbs'] = [
	['label' => Yii::t('app', 'Pilot'), 'url' => '/pilot'],
	['label' => $this->title]
];?>
<div class="edit-form">

	<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

	<?= $form->field($user, 'email')->textInput(['maxlength' => true]) ?>

	<?= $form->field($user, 'language')->dropDownList(['EN'=>'English','RU'=>'Русский'])?>

	<?= $form->field($user, 'full_name')->textInput(['maxlength' => true]) ?>
	<?= $form->field($user, 'avatar')->fileInput() ?>

	<div class="form-group">
		<?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
