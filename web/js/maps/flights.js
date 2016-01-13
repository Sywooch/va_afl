/**
 * Created by BTH on 11.01.16.
 */

var features = [];
var map;
function reload(flight_id) {
    window.history.pushState({}, window.title, "/airline/flights/view/" + flight_id);
    for (var i = 0; i < features.length; i++) {
        map.data.remove(features[i]);
    }
    $.getJSON('/airline/flights/mapdata?id=' + flight_id, function (djs) {
        features = map.data.addGeoJson(djs);
        $.get('/airline/flights/details', {id: flight_id}, function (response) {
            var details = JSON.parse(response);
            $('#details').html(details.html);
            $('#callsign').text(details.callsign);
        });
    });

}

setTimeout(function () {
    initialize();
    reload($('#map').data('flightid'));
    map.data.setStyle(function (feature) {
        if (feature.getGeometry().getType() == 'Point') {
            icon = (feature.getProperty('type') == 'start') ? "https://maps.google.com/mapfiles/marker.png" : "https://maps.google.com/mapfiles/marker_green.png";

            return{
                icon: icon,
                animation: google.maps.Animation.DROP,
                title: feature.getProperty('title')
            }
        }
        return {
            geodesic: true,
            strokeWeight: 3,
            strokeOpacity: 0.6,
            strokeColor: feature.getProperty('color')
        }
    });
    $('.title').bind('click', function () {
        var eid = $(this).data('toggle');
        $('#' + eid).toggle();
    });
}, 1000);