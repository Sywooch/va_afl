var map;
var marker = null;
var features = [];
var features_flight = [];

function closedrilldown()
{
    $('#drilldownwindow').css('display','none');
}
function showDrillDownContent(airport,paxtype)
{
    closedrilldown();
    var url='/site/getairportpaxdetail';
    $.get(url, {airport: airport, paxtype: paxtype}, function (response) {
        $('#drilldownwindow').html(response).toggle();
    });
}

function reload() {
    $.get('/airline/flights/booking', {}, function (response) {
        var booking = JSON.parse(response);
        if (booking.id > 0) {
            $.getJSON('/airline/flights/mapdata?id=' + booking.id, function (djs) {
                for (var i = 0; i < features_flight.length; i++) {
                    map.data.remove(features_flight[i]);
                }
                features_flight = map.data.addGeoJson(djs);

                $.get('/airline/flights/current', {id: booking.id}, function (response) {
                    var data = JSON.parse(response);
                    var mLatLng = new google.maps.LatLng(data.lat, data.lon);
                    var image = {
                        url: "/img/map/medium.png",
                        size: new google.maps.Size(21, 21),
                        //scaledSize: new google.maps.Size(21, 21),
                        origin: getShapeHeading(data.hdg),
                        anchor: new google.maps.Point(10, 10)
                    };
                    if (marker != null) {
                        marker.setPosition(mLatLng);
                        marker.setIcon(image);
                    } else {
                        marker = new google.maps.Marker({
                            position: mLatLng,
                            map: map,
                            icon: image
                        });
                    }
                });
            });
        }
    });
}

function update() {
    reload();
}

function showhidebookingform(){
    $('#booking-details').toggle();
}

setInterval(update, 60000);

setTimeout(function () {
    initialize();
    map.data.loadGeoJson('/site/mybookingdetails');
    map.data.setStyle(function(feature) {
        if(feature.getGeometry().getType()=='Point') {
            icon = (feature.getProperty('type') == 'start') ? "https://maps.google.com/mapfiles/marker.png" : "https://maps.google.com/mapfiles/marker_green.png";

            return{
                icon: icon,
                animation: google.maps.Animation.DROP,
                title: feature.getProperty('title')
            }
        }
        else{
            if (feature.getProperty('color') == 'green') {
                return {
                    strokeWeight: 1.3,
                    strokeOpacity: feature.getProperty('opacity'),
                    strokeColor: 'green',
                    geodesic: true
                }
            } else {
                return {
                    geodesic: true,
                    strokeWeight: 3,
                    strokeOpacity: 0.6,
                    strokeColor: feature.getProperty('color')
                }
            }
        }
    });
    var infowindow = new google.maps.InfoWindow();
    map.data.addListener('click', function(event) {
        var aptname=event.feature.getProperty('name');
        var contentString = '<div id="content">'+
            '<div id="siteNotice">'+
            '</div>'+
            '<h4 id="firstHeading" class="firstHeading">'+aptname+'</h4>';
        infowindow.setContent(contentString);
        infowindow.setPosition(event.feature.getGeometry().get());
        infowindow.open(map);
    });
    $('.sidebar-minify-btn').remove();
    reload();
}, 1000);
