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
    input.form-control, .select2-selection, .select2-search,.select2-results__option{
        background-color: rgba(255,255,255,0.2) !important;
    }
    input.form-control, .select2-selection, .select2-selection__rendered, .select2-selection__placeholder{

        color: yellow !important;
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
