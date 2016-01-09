/**
 * Created by BTH on 06.01.16.
 */
/**
 * Routes map
 * Created by Nikita Fedoseev <agent.daitel@gmail.com>
 */


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

function showhidebookingform(){
    $('#booking-details').toggle();
}
setTimeout(function () {
    initialize();
    map.data.loadGeoJson('/site/mybookingdetails');
    map.data.setStyle(function(feature) {
        if(feature.getGeometry().getType()=='Point') {
            return {
                clickable: true,
                icon: {
                    path: (feature.getProperty('type')=='departure')?fontawesome.markers.ARROW_UP:fontawesome.markers.ARROW_DOWN,
                    scale: 0.2,
                    strokeWeight: 0.2,
                    strokeColor: 'black',
                    strokeOpacity: 1,
                    fillColor: (feature.getProperty('type')=='departure')?'green':'red',
                    fillOpacity: 1,
                    anchor: new google.maps.Point(30,-30)
                }
            };
        }
        else{
            return {
                strokeWeight: 1.3,
                strokeColor: 'red',
                geodesic: true,
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
}, 1000);
