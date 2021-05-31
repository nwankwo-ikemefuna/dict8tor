$(document).ready(function(){
	summernote_init(".summernote_simple", {picture: false}, {height: 380});
}).on("click", "#copy_note", function(){
    const note = $('#s2t_dict8_note').val();
    copyToClickboard(note);
}).on("click", ".note_action", function(){
    const action = $(this).data('action');
    const note = $('#dict8_form').find('#s2t_dict8_note').val();
    var success_callback = function(jres) {
        if (jres.status) {
            if (action == 'export_pdf') {
                window.open(base_url+'note', '_self');
            }
        } else {
            status_box('status_msg', jres.error, 'danger', 'class', 10000, 'dict8_form');
        }
    };
    post_data_ajax(base_url+'api/web/note_actions', {action, note}, false, success_callback);
});