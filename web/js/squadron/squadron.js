$("#rules_agree").click(function () {
    var checked_status = this.checked;
    if (checked_status == true) {
        $("#join_button").removeClass('disabled');
    } else {
        $("#join_button").addClass("disabled");
    }
});