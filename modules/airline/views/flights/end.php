<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\rating\StarRating;

/* @var $this yii\web\View */
/* @var $model app\models\Airports */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="flight-end-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'atc_rating')->widget(StarRating::classname(), [
        'pluginOptions' => [
            'size'=>'lg'
        ]
    ]) ?>

    <?= $form->field($model, 'atc_comments')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(
            Yii::t('app', 'Finish flight'),
            ['class' => 'btn btn-success']
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
