<?php
/**
 * Created by PhpStorm.
 * User: BTH
 * Date: 18.09.15
 * Time: 22:56
 */
$this->title = Yii::t('app', 'Profile editor');
$this->params['breadcrumbs'] = [
    ['label' => Yii::t('app', 'Pilot'), 'url' => '/pilot'],
    ['label' => Yii::t('app', 'Profile Editor')]
];
$form = \yii\widgets\ActiveForm::begin([
	'id' => 'profile'
]);
echo $form->field($model, 'email')->textInput();
echo \yii\helpers\Html::submitButton('Сохранить');
\yii\widgets\ActiveForm::end();