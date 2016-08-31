<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\airline\models\ScheduleSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="schedule-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'flight') ?>

    <?= $form->field($model, 'dep') ?>

    <?= $form->field($model, 'arr') ?>

    <?= $form->field($model, 'aircraft') ?>

    <?php // echo $form->field($model, 'dep_utc_time') ?>

    <?php // echo $form->field($model, 'arr_utc_time') ?>

    <?php // echo $form->field($model, 'dep_lmt_time') ?>

    <?php // echo $form->field($model, 'arr_lmt_time') ?>

    <?php // echo $form->field($model, 'eet') ?>

    <?php // echo $form->field($model, 'day_of_weeks') ?>

    <?php // echo $form->field($model, 'start') ?>

    <?php // echo $form->field($model, 'stop') ?>

    <?php // echo $form->field($model, 'added') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
