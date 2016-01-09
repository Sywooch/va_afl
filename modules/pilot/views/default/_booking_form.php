<?php
/**
 * Created by PhpStorm.
 * User: BTH
 * Date: 09.01.16
 * Time: 16:14
 */

use \kartik\select2\Select2;
use \yii\web\JsExpression;
use \kartik\depdrop\DepDrop;
use \yii\helpers\Url;

$form = \yii\widgets\ActiveForm::begin(
    [
        'id' => 'booking',
        'validateOnSubmit'=>true,
    ]
);
//далее элементы формы
?>
<?= $form->field($model, 'callsign')->textInput(); ?>
<?=
$form->field($model, 'from_icao')->textInput(['readonly' => true]);
?>
<?=
$form->field($model, 'to_icao')->widget(
    Select2::classname(),
    [
        'options' => ['placeholder' => 'Search for an airport...'],
        'pluginOptions' => [
            'ajax' => [
                'url' => \yii\helpers\Url::to('/site/getairports'),
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {q:params.term}; }')
            ],
        ]
    ]
);
?>
<?=
$form->field($model, 'fleet_regnum')->widget(
    Select2::classname(),
    [
        'options' => ['placeholder' => 'Aircraft...'],
        'pluginOptions' => [
            'ajax' => [
                'url' => \yii\helpers\Url::to('/site/getacfregnums'),
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {q:params.term}; }')
            ],
        ]
    ]
);
?>

<?php
/*
$form->field($model, 'fleet_regnum')->widget(
    DepDrop::classname(),
    [
        'options' => [],
        'type' => DepDrop::TYPE_SELECT2,
        'pluginOptions' => [
            'depends' => ['booking-aircraft_type'],
            'placeholder' => 'Select regnum...',
            'url' => Url::to(['/site/getacfregnums'])
        ]
    ]
);
*/
?>
<?= \yii\helpers\Html::submitButton(Yii::t('booking', 'Book'), ['class' => 'btn btn-success']); ?>
<?php
\yii\widgets\ActiveForm::end();