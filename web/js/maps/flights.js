/**
 * Created by BTH on 11.01.16.
 */

setTimeout(function(){
    initialize();
    map.data.loadGeoJson('/airline/flights/mapdata?id='+$('#map').data('flightid'));
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