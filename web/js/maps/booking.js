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
function showDrillDownContent(to, from)
{
    closedrilldown();
    var url='/pilot/schedule';
    $.get(url, {to: to, from: from}, function (response) {
        $('#drilldownwindow').html(response).toggle();
    });
}

function showhidebookingform(){
    $('#booking-details').toggle();
}

function scheduleBook(callsign){
    $('#booking-callsign').val(callsign);
}

function smartbooking(icao)
{
    $.get('/site/smartbooking',{icao:icao},function(response){
        var obj=JSON.parse(response);
        $('#booking-to_icao').append('<option value="'+icao+'">'+icao+' - '+obj.aname+'</option>').val(icao).trigger('change');
        $('#booking-callsign').val(obj.callsign);
        $('#booking-details').show();
    });

}
setTimeout(function () {
    initialize();
    map.data.loadGeoJson('/site/paxdata');
    map.data.setStyle(function(feature) {
        var color = feature.getProperty('feeling');
        var ftype={'red':2,'orange':1,'green':0};
        var scale = 0.3;
        if(feature.getProperty('paxlist')[ftype[color]]>1000)
            scale = 0.5;
        if(feature.getProperty('paxlist')[ftype[color]]>10000)
            scale = 0.7;
        return {
            clickable: true,
            icon: {
                path: fontawesome.markers.CIRCLE,
                scale: scale,
                strokeWeight: 0.2,
                strokeColor: 'black',
                strokeOpacity: 1,
                fillColor: color,
                fillOpacity: 0.6,
                anchor: new google.maps.Point(30,-30)
            }
        };
    });

    var infowindow = new google.maps.InfoWindow();

    var from_airport = '';
    $.get('/pilot/location', function (response) {
        from_airport = JSON.parse(response);
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(from_airport.latitude, from_airport.longitude),
            map: map,
            title: from_airport.name,
            icon: 'https://maps.google.com/mapfiles/marker.png'
        });
    });


    var to_select = '';
    var to_line;
    var to_marker;

    map.data.addListener('click', function(event) {
        var paxlist=event.feature.getProperty('paxlist');
        var aptname=event.feature.getProperty('name');

        if (to_select == '') {
            $.get('/airline/airports/info/' + aptname, function (response) {
                var res = JSON.parse(response);

                to_line = new google.maps.Polyline({
                    path: [
                        new google.maps.LatLng(from_airport.latitude, from_airport.longitude),
                        new google.maps.LatLng(res.latitude, res.longitude)
                    ],
                    strokeOpacity: 1.0,
                    strokeWeight: 2,
                    strokeColor: '#00acac',
                    geodesic: true,
                    map: map
                });

                to_marker = new google.maps.Marker({
                    position: new google.maps.LatLng(res.latitude, res.longitude),
                    map: map,
                    title: res.name,
                    icon: 'https://maps.google.com/mapfiles/marker_green.png'
                });
            });
        }

        if (aptname != to_select) {
            to_select = aptname;
            $.get('/airline/airports/info/' + aptname, function (response) {
                var res = JSON.parse(response);

                $('#booking-details').show();
                $('#booking-to_icao').append('<option value="' + aptname + '">' + aptname + ' - ' + res.name + '</option>').val(aptname).trigger('change');

                to_line.setPath([
                    new google.maps.LatLng(from_airport.latitude, from_airport.longitude),
                    new google.maps.LatLng(res.latitude, res.longitude)
                ]);
                to_line.setMap(map);
                to_line.setMap(map);

                to_marker.setPosition(new google.maps.LatLng(res.latitude, res.longitude));
                to_marker.setMap(map);
            });
        }

        var contentString = '<div id="content">'+
            '<div id="siteNotice">'+
            '</div>'+
            '<h4 id="firstHeading" class="firstHeading">'+aptname+'</h4>'+
            event.feature.getProperty('bookthis')+
            '<div id="bodyContent">' +
            '<i class="fa fa-user" style="color: green"></i> <b style="cursor: pointer;" onclick="showDrillDownContent(\'' + aptname+'\', \'' + from_airport.icao + '\')">'+ ((paxlist[0])?paxlist[0]:0) + '</b><br>' +
            '<i class="fa fa-user" style="color: orange"></i> <b style="cursor: pointer;" onclick="showDrillDownContent(\''+aptname+'\', \'' + from_airport.icao + '\')">'+ ((paxlist[1])?paxlist[1]:0) + '</b><br>' +
            '<i class="fa fa-user" style="color: red"></i> <b style="cursor: pointer;" onclick="showDrillDownContent(\''+aptname+'\', \'' + from_airport.icao + '\')">'+ ((paxlist[2])?paxlist[2]:0) + '</b><br>' +
            '</div>'+
            '</div>';
        infowindow.setContent(contentString);
        infowindow.setPosition(event.feature.getGeometry().get());
        infowindow.open(map);
    });

    var $eventSelect = $("#booking-to_icao");
    $eventSelect.on("select2:select", function (e) {
        var aptname = e.params.data.id;
        if (to_select == '') {
            $.get('/airline/airports/info/' + aptname, function (response) {
                var res = JSON.parse(response);

                to_line = new google.maps.Polyline({
                    path: [
                        new google.maps.LatLng(from_airport.latitude, from_airport.longitude),
                        new google.maps.LatLng(res.latitude, res.longitude)
                    ],
                    strokeOpacity: 1.0,
                    strokeWeight: 2,
                    strokeColor: '#00acac',
                    geodesic: true,
                    map: map
                });

                to_marker = new google.maps.Marker({
                    position: new google.maps.LatLng(res.latitude, res.longitude),
                    map: map,
                    title: res.name,
                    icon: 'https://maps.google.com/mapfiles/marker_green.png'
                });
            });
        }

        if (aptname != to_select) {
            to_select = aptname;
            $.get('/airline/airports/info/' + aptname, function (response) {
                var res = JSON.parse(response);

                $('#booking-details').show();
                $('#booking-to_icao').append('<option value="' + aptname + '">' + aptname + ' - ' + res.name + '</option>').val(aptname).trigger('change');

                to_line.setPath([
                    new google.maps.LatLng(from_airport.latitude, from_airport.longitude),
                    new google.maps.LatLng(res.latitude, res.longitude)
                ]);
                to_line.setMap(map);
                to_line.setMap(map);

                to_marker.setPosition(new google.maps.LatLng(res.latitude, res.longitude));
                to_marker.setMap(map);
            });
        }
    });



    $('.sidebar-minify-btn').remove();
    $('#taxibtn').bind('click',function(){
        $('#taxiModal').modal('show');
        $('#taxi_to').bind('change',function(e){
            var reqTo=e.target.value;
            $.post('/site/calctaxiprice',{to:reqTo},function(response){
                var res = JSON.parse(response);
                var message = res.msg;
                if(!res.valid){
                    $('#letsfly').prop('disabled',true);
                    message+=" <b>You don't have enough VUC's</b>";
                }
                else{
                    $('#letsfly').prop('disabled',false).bind('click',function(){
                        $.post('/site/dotaxi',{to:reqTo},function(){
                            location.reload();
                        });
                    });
                }
                $('#taxi_price').html(message);
            })
        });
    })
}, 1000);
