<?php
/**
 * Created by PhpStorm.
 * User: BTH
 * Date: 18.09.15
 * Time: 22:56
 */
$form = \yii\widgets\ActiveForm::begin([
	'id' => 'profile'
]);
echo $form->field($model, 'email')->textInput();
echo \yii\helpers\Html::submitButton('Сохранить');
\yii\widgets\ActiveForm::end();