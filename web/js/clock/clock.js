$(document).ready(function () {
    $.post('/site/getservertime',{},function(response){
        var newDate = new Date(response);
        newDate.setDate(newDate.getDate());
        setInterval(function () {
            newDate.setSeconds(newDate.getSeconds() + 1);
            var seconds = newDate.getSeconds();
            $("#sec").html(( seconds < 10 ? "0" : "" ) + seconds);
        }, 1000);
        setInterval(function () {
            var minutes = newDate.getMinutes();
            $("#min").html(( minutes < 10 ? "0" : "" ) + minutes);
        }, 1000);
        setInterval(function () {
            var hours = newDate.getHours();
            $("#hours").html(( hours < 10 ? "0" : "" ) + hours);
        }, 1000);
    });

});