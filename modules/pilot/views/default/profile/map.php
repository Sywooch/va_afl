<?php
/**
 * Created by PhpStorm.
 * User: nfedoseev
 * Date: 27.09.2016
 * Time: 13:56
 */

use app\assets\PilotFlightsMapAsset;

PilotFlightsMapAsset::register($this);

?>
<div id="map" style="width: 1200px; height: 900px;"></div>
<script>
    setTimeout(function () {
        initialize(<?= $id ?>);
        $("a[href='#w4-tab2']").on('shown.bs.tab', function(){
            google.maps.event.trigger(map, 'resize');
        });
    },500);
</script>

