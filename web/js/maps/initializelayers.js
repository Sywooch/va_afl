/**
 * Created by BTH on 08.01.16.
 */

function getShapeHeading(hdg) {
    hdg = parseInt(hdg / 10) * 10;
    if (hdg == 360)
        hdg = 0;
    var pt = parseInt(hdg / 10) * 21;
    pt += (hdg / 10);
    return new google.maps.Point(0, pt);
}

function initialize(zoom, lat, lon) {
    zoom = typeof zoom !== 'undefined' ? zoom : 4;
    lat = typeof lat !== 'undefined' ? lat : 55;
    lon = typeof lon !== 'undefined' ? lon : 35;
    var mapOptions = {
        zoom: zoom,
        disableDefaultUI: true,
        center: new google.maps.LatLng(lat, lon),
        styles: [
            {
                "featureType": "water", "elementType": "geometry", "stylers": [
                {"color": "#193341"}
            ]
            },
            {
                "featureType": "landscape", "elementType": "geometry", "stylers": [
                {"color": "#2c5a71"}
            ]
            },
            {
                "featureType": "road", "elementType": "geometry", "stylers": [
                {"color": "#29768a"},
                {"lightness": -37}
            ]
            },
            {
                "featureType": "poi", "elementType": "geometry", "stylers": [
                {"color": "#406d80"}
            ]
            },
            {
                "featureType": "transit", "elementType": "geometry", "stylers": [
                {"color": "#406d80"}
            ]
            },
            {
                "elementType": "labels.text.stroke", "stylers": [
                {"visibility": "on"},
                {"color": "#3e606f"},
                {"weight": 2},
                {"gamma": 0.84}
            ]
            },
            {
                "elementType": "labels.text.fill", "stylers": [
                {"color": "#ffffff"}
            ]
            },
            {
                "featureType": "administrative", "elementType": "geometry", "stylers": [
                {"weight": 0.6},
                {"color": "#1a3541"}
            ]
            },
            {
                "elementType": "labels.icon", "stylers": [
                {"visibility": "off"}
            ]
            },
            {
                "featureType": "poi.park", "elementType": "geometry", "stylers": [
                {"color": "#2c5a71"}
            ]
            }
        ],
        streetViewControl: false,
        geodesic: true
    };
    map = new google.maps.Map(document.getElementById('map'), mapOptions);
}
