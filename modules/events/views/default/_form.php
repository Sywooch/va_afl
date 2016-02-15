<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Events */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="events-form">

    <?php $form = ActiveForm::begin(['id' => 'event']); ?>

    <?=
    $form->field($model, 'content')->widget(
        Select2::classname(),
        ['data' => \yii\helpers\ArrayHelper::map(\app\models\Content::find()->where(['category' => 7])->all(), 'id', 'name')]
    )
    ?>

    <?= $form->field($model, 'start')->widget(DateTimePicker::classname(), [
            'options' => ['placeholder' => Yii::t('app', 'Enter time').' ...'],
            'pluginOptions' => [
                'autoclose' => true
            ]
        ]); ?>

    <?= $form->field($model, 'stop')->widget(DateTimePicker::classname(), [
            'options' => ['placeholder' => Yii::t('app', 'Enter time').' ...'],
            'pluginOptions' => [
                'autoclose' => true
            ]
        ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
