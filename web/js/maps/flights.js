/**
 * Created by BTH on 11.01.16.
 */

var features = [];
var map;
function reload(flight_id)
{
    window.history.pushState({}, window.title, "/airline/flights/view/"+flight_id);
    for (var i = 0; i < features.length; i++) {
        map.data.remove(features[i]);
    }
    $.getJSON('/airline/flights/mapdata?id='+flight_id, function (djs) {
        features = map.data.addGeoJson(djs);
        $.get('/airline/flights/details',{id:flight_id},function(response){
            var details = JSON.parse(response);
            $('#details').html(details.html);
            $('#callsign').text(details.callsign);
        });
    });

}

setTimeout(function(){
    initialize();
    reload($('#map').data('flightid'));
    map.data.setStyle(function(feature) {
        if(feature.getGeometry().getType()=='Point'){
            color = (feature.getProperty('type')=='start')?'green':'orange';
            icon = (feature.getProperty('type')=='start')?fontawesome.markers.ARROW_UP:fontawesome.markers.ARROW_DOWN;
            return{
                icon:{
                    path: icon,
                    strokeColor: 'black',
                    fillColor: color,
                    fillOpacity: 0.6,
                    scale: 0.3,
                    anchor: new google.maps.Point(30,-30)
                }
            }
        }
        return {
            geodesic: true,
            strokeColor: feature.getProperty('color'),
        }
    });
    $('.title').bind('click',function(){
        var eid = $(this).data('toggle');
        $('#'+eid).toggle();
    });
},1000);