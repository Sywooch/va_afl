/**
 * Routes map
 * Created by Nikita Fedoseev <agent.daitel@gmail.com>
 */

var user_id = 0;
var map;

function initialize(vid) {
    user_id = vid;

    var mapOptions = {
        zoom: 4,
        disableDefaultUI: true,
        center: new google.maps.LatLng(55, 35),
        styles: [
            {"featureType": "water", "elementType": "geometry", "stylers": [
                {"color": "#193341"}
            ]},
            {"featureType": "landscape", "elementType": "geometry", "stylers": [
                {"color": "#2c5a71"}
            ]},
            {"featureType": "road", "elementType": "geometry", "stylers": [
                {"color": "#29768a"},
                {"lightness": -37}
            ]},
            {"featureType": "poi", "elementType": "geometry", "stylers": [
                {"color": "#406d80"}
            ]},
            {"featureType": "transit", "elementType": "geometry", "stylers": [
                {"color": "#406d80"}
            ]},
            {"elementType": "labels.text.stroke", "stylers": [
                {"visibility": "on"},
                {"color": "#3e606f"},
                {"weight": 2},
                {"gamma": 0.84}
            ]},
            {"elementType": "labels.text.fill", "stylers": [
                {"color": "#ffffff"}
            ]},
            {"featureType": "administrative", "elementType": "geometry", "stylers": [
                {"weight": 0.6},
                {"color": "#1a3541"}
            ]},
            {"elementType": "labels.icon", "stylers": [
                {"visibility": "off"}
            ]},
            {"featureType": "poi.park", "elementType": "geometry", "stylers": [
                {"color": "#2c5a71"}
            ]}
        ],
        streetViewControl: false,
        geodesic: true
    };

    map = new google.maps.Map(document.getElementById('map'), mapOptions);
    loadData();
}

function loadData() {
    //TODO: путь приложение как-нибудь поправить
    var url = "http://daitel.va-aeroflot.su/site/getuserroutes/" + user_id;
    $.getJSON(url, function (response) {
        handleData(response)
    });
}

function handleData(response) {
    var n;

    for (n = 0; n < response.length; n++) {
        /*var routeCoordinates = [
            {lat: response[n].from.lat, lng: response[n].from.lon},
            {lat: response[n].to.lat, lng: response[n].to.lon}
        ];
        var routePath = new google.maps.Polyline({
            path: routeCoordinates,
            geodesic: true,
            strokeColor: '#FFFFFF',
            strokeOpacity: 1,
            strokeWeight: 1,
            map: map
        });*/

        var fromCoordinate = new google.maps.LatLng(response[n].from.lat, response[n].from.lon);
        var fromMarker = new google.maps.Marker({
            position: fromCoordinate,
            map: map,
            title: response[n].from.icao
        });

        var toCoordinate = new google.maps.LatLng(response[n].to.lat, response[n].to.lon);
        var toMarker = new google.maps.Marker({
            position: toCoordinate,
            map: map,
            title: response[n].to.icao
        });
    }
}
