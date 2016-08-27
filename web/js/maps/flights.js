var features = [];
var map;
var marker = null;
var id_global = 0;

function reload(flight_id) {
    id_global = flight_id;
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

        $.get('/airline/flights/current', {id: flight_id}, function (response) {
            var data = JSON.parse(response);
            var mLatLng = new google.maps.LatLng(data.lat, data.lon);
            if(marker != null){
                marker.setPosition(mLatLng);
            }else{
                var image = {
                    url: "/img/map/medium.png",
                    size: new google.maps.Size(21, 21),
                    //scaledSize: new google.maps.Size(21, 21),
                    origin: getShapeHeading(data.hdg),
                    anchor: new google.maps.Point(10, 10)
                };
                marker = new google.maps.Marker({
                    position: mLatLng,
                    map: map,
                    icon: image
                });
            }
        });
    });
}

function load() {
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
}

function update() {
    if(id_global > 0){
        reload(id_global);
    }
}

setInterval(update, 60000);

setTimeout(function () {
    if (typeof init !== 'undefined') {
        if (init == true) {
            setTimeout(function () {
                initialize();
                load();
            }, 500);
        }
    }
}, 1000);