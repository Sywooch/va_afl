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
                    path: fontawesome.markers.PLANE,
                    scale: 0.3,
                    strokeWeight: 0.2,
                    strokeColor: 'black',
                    strokeOpacity: 1,
                    fillColor: 'red',
                    fillOpacity: 1,
                }
            };
        }
        else{
            return {
                strokeColor: 'red',
                geodesic: true,
            }
        }
    });
    var infowindow = new google.maps.InfoWindow();
    map.data.addListener('click', function(event) {
        var paxlist=event.feature.getProperty('paxlist');
        var aptname=event.feature.getProperty('name');
        var contentString = '<div id="content">'+
            '<div id="siteNotice">'+
            '</div>'+
            '<h4 id="firstHeading" class="firstHeading">'+aptname+'</h4>'+
            event.feature.getProperty('bookthis')+
            '<div id="bodyContent">' +
            '<i class="fa fa-user" style="color: green"></i> <b style="cursor: pointer;" onclick="showDrillDownContent(\''+aptname+'\',0);">'+ ((paxlist[0])?paxlist[0]:0) + '</b><br>' +
            '<i class="fa fa-user" style="color: orange"></i> <b style="cursor: pointer;" onclick="showDrillDownContent(\''+aptname+'\',1);">'+ ((paxlist[1])?paxlist[1]:0) + '</b><br>' +
            '<i class="fa fa-user" style="color: red"></i> <b style="cursor: pointer;" onclick="showDrillDownContent(\''+aptname+'\',2);">'+ ((paxlist[2])?paxlist[2]:0) + '</b><br>' +
            '</div>'+
            '</div>';
        infowindow.setContent(contentString);
        infowindow.setPosition(event.feature.getGeometry().get());
        infowindow.open(map);
    });
    $('.sidebar-minify-btn').remove();
}, 1000);
