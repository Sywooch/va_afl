<?php
/**
 * Created by PhpStorm.
 * User: BTH
 * Date: 06.01.16
 * Time: 21:15
 */

use \app\assets\MapAsset;
use \app\assets\BookingAsset;
use \app\assets\BookingDetailsAsset;

MapAsset::register($this);

$this->title = Yii::t('app', 'Booking');
?>
<style>
    .content {
        padding: 0px !important;
    }
    .control-label {
        color: #ffffff;
    }

    label {
        color: #ffffff;
    }

    input.form-control, .select2-selection{
        background-color: rgba(255,255,255,0.2) !important;
    }
    input.form-control, .select2-selection, .select2-selection__rendered, .select2-selection__placeholder{

        color: yellow !important;
    }
    .modal-body .select2-selection, .modal-body .select2-selection__rendered, .modal-body .select2-selection__placeholder{

        color: black !important;
    }
</style>
<div id="map" style="height: 90vh;"></div>
<div id="drilldownwindow"
     style="display: none; padding: 10px;  z-index: 10; color: white; background-color: rgba(0,0,0,0.8); height: 300px; width: 200px; position: absolute; top: 70px; right: 5px">
</div>
<div id="booking_form"
     style="position: absolute; top: 70px; left: 250px; z-index: 10; background-color: rgba(0,0,0,0.8); color: white; width: 300px;">
    <div class="text-center" style="display: block; height: 40px; padding: 10px; cursor: pointer; color: yellow; font-weight: bold;" onclick="showhidebookingform();"><?=Yii::t('booking','Booking details')?></div>
    <div id="booking-details" style="padding: 10px; display: none;">
    <?php
    if(!isset($model->status)){
        BookingAsset::register($this);
        echo $this->render('_booking_form',['model'=>$model]);
    }
    else{
        BookingDetailsAsset::register($this);
        echo $this->render('_booking_details',['model'=>$model]);
    }
    ?>
    </div>
</div>
<?php
\yii\bootstrap\Modal::begin([
    'header' => '<h2>Request AirTaxi</h2>',
    'toggleButton' => ['label' => 'Close'],
    'options' => ['id'=>'taxiModal','tabindex' => false,'style'=>'background-color: rgba(0,0,0,0.5); color: black !important'],

]);
echo \kartik\select2\Select2::widget([
        'name'=>'from_icao_taxi',
        'options' => ['placeholder' => 'Search for an airport...','id'=>'taxi_to'],
        'pluginOptions' => [
            'ajax' => [
                'url' => \yii\helpers\Url::to('/site/getairports'),
                'dataType' => 'json',
                'data' => new \yii\web\JsExpression('function(params) { return {q:params.term}; }')
            ],
        ]
]);
echo "<hr><span id='taxi_price' style='padding: 5px;'>&nbsp;</span><hr>";
echo \yii\helpers\Html::button('Lets fly',['class'=>'btn-success btn','id'=>'letsfly']);
\yii\bootstrap\Modal::end();

