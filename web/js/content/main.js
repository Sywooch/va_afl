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
        });
    }
}

function content_comment(content_id) {

}