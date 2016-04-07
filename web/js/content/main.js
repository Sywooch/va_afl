/**
 * Created by Nikita Fedoseev on 07.04.16.
 */
function content_like(content_id) {
    var name = '#btn_like_' + content_id;
    var checked_status = $(name).checked;
    if (checked_status != true) {
        $.post('/content/like',{cid: content_id},function(){
            $(name).addClass("disabled");
            $(name).addClass("btn-success");

            var likes = parseInt($(name + '_num').text());
            $(name + '_num').html(likes + 1);
        });
    }
}

function content_comment(content_id) {
    var text = $('#message').val();

    $.post('/content/comment',{cid: content_id, text: text},function(){
        $("#comments").load("/content/comments/" + content_id);
    });
}