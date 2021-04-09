$(document).ready(() => {

    //on answer select, get index and update
    $(document).on("change", '.response_check', function(e) {
        var fam = $(this).closest('.ass_item');
        var siblings = fam.find('.response_check');
        var ans_field = fam.find('.response_obj');
        prep_question_answers(siblings, ans_field);
    });

    //submit question response    
    $(document).on("click", ".submit_response", function(e) {
        e.stopImmediatePropagation();
        var msg_box = $(this).data('msg_box') || 'status_msg',
            s_type = $(this).data('s_type'),
            url = $(this).data('url');
        submit_test(s_type, url, msg_box);
    });

});

function serve_question() {
    var auto_submit = function() {
        ajax_loading_show(true, 'Time exhausted, submitting test');
        waitfor(3).then(() => {
            submit_test('auto_submit');
        });
    },
    end_time = $('[name="end_time"]').val(),
    current_time = $('[name="current_time"]').val(),
    is_exhausted = $('[name="is_exhausted"]').val() || 0,
    has_submitted = $('[name="has_submitted"]').val() || 0,
    time_labels = ['h', 'm', 's'];
    //submit if exhausted
    if (is_exhausted == 1 || has_submitted == 1) {
        auto_submit();
    }
    var finish_callback = function() {
        //trigger submit
        auto_submit();
    };
    //show clock
    show_clock("#test_rem_time", end_time, current_time, time_labels, finish_callback);
    //retrieve and render rough work saved in session storage
    var ass_id = $('[name="ass_id"]').val(),
        q_id = $('[name="q_id"]').val(),
        ass_rough_works = get_rough_works(),
        rough_work = ass_rough_works[q_id];
    $('#rough_work').val(rough_work);
}

function submit_test(s_type, next_url = '', msg_box = 'status_msg') {
    var ass_id = $('[name="ass_id"]').val(),
        q_id = $('[name="q_id"]').val(),
        q_type = $('[name="q_type"]').val(),
        response = $('[name="response"]').val(),
        session = $('[name="session"]').val(),
        semester = $('[name="semester"]').val(),
        ass_page = `assessments/view/${ass_id}?session=${session}&semester=${semester}`;

   var callback = function (jres) {
        if (jres.status) {
            switch (s_type) {
                //we are just saving...
                case 'save':
                    //save rough work in session storage
                    if (typeof Storage !== "undefined") {
                        var rough_work = $('#rough_work').val();
                            //get saved rough work if exists 
                            ass_rough_works = get_rough_works();
                        ass_rough_works = {...ass_rough_works, ...{[q_id]: rough_work}};
                        sessionStorage.setItem('ass_rough_works', JSON.stringify(ass_rough_works));
                    }
                    //run to next/previous question depending on which nav button was clicked
                    load_page_ajax(next_url, null, 0);
                    break;
                //submitting
                case 'submit':
                    status_box('status_msg', 'Test submitted successfully');
                    //clear session storage data
                    sessionStorage.removeItem('ass_rough_works');
                    //all done, run to assessment view page
                    load_page_ajax(ass_page);
                    break;
                //assisted submitting after elapsed time
                case 'auto_submit':
                    //clear session storage data
                    sessionStorage.removeItem('ass_rough_works');
                    //all done, run to assessment view page
                    load_page_ajax(ass_page, null, 0);
                    break;
            }
        } else {
            status_box(msg_box, jres.error, 'danger');
            //clear session storage data
            sessionStorage.removeItem('ass_rough_works');
            //we can't help you here, so run to assessment view page
            load_page_ajax(ass_page);
        }
    }
    var data = {ass_id, q_id, q_type, response, s_type};
    post_data_ajax('api/assessment_submissions/submit', data, false, callback);
}

function get_rough_works() {
    if ('ass_rough_works' in sessionStorage) {
        var rough_works = sessionStorage.getItem('ass_rough_works');
        return JSON.parse(rough_works);
    } 
    return {}; 
}