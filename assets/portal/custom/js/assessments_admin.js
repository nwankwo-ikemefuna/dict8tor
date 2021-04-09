$(document).ready(() => {

    //leave open toggle
    toggle_elem_prop('#leave_open', '#close_date_box', 'checked', true);
    toggle_elem_prop_trigger('#leave_open', '#close_date_box', true);

    //check score feedback if full feedback is allowed
    $(document).on('change', '#feedback', function(){
        if ($(this).prop('checked')) {
            $('#score_feedback').prop('checked', true);
        }
    });
    $(document).on('change', '#score_feedback', function(){
        if ($('#feedback').prop('checked')) {
            $(this).prop('checked', true);
        }
    });

    // get candidates by classes
    $(document).on("click", '#fetch_class_candidates', function() {
        var ass_id = $('[name="ass_id"]').val() || '';
        var class_id = $('[name="class_id"]').val() || '';
        if (!ass_id.length || !class_id.length) return false;

        var success_callback = function(jres) {
            $('#class_candidates').empty(); 
            if (jres.status) { 
                var trow = '';
                var result = jres.body.msg;
                if (result.length) {
                    $.each(result, (i, row) => {
                        trow += '<tr>';
                        trow += `<td>${i+1}</td>`;
                        trow += `<td><input type="checkbox" name="candidates[]" value="${row.id}" class="ba_record" ${(row.registered == 1) ? 'checked' : ''}></td>`;
                        trow += `<td>${row.student_name}</td>`;
                        trow += `<td>${row.username}</td>`;
                        trow += `<td>${row.department}</td>`;
                        trow += `<td>${row.class}</td>`;
                        trow += `<td>${(row.registered == 1) ? '<i class="fa fa-check text-success"></i>' : ''}</td>`;
                        trow += '</tr>';
                    });
                } else {
                    trow = `<tr><td colspan="6" style="color: red">No student found for the selected class. Ensure this class has active students and offers the course tied to this assessment.</td></tr>`;
                }
            } else {
                trow += `<tr><td colspan="6" style="color: red">${jres.error}</td></tr>`;
            }
            $('#class_candidates').html(trow);
        };
        fetch_data_ajax(base_url+'api/assessments/get_class_candidates', {ass_id, class_id}, 'POST', success_callback, null, true, 'Fetching candidates');
    });

    /* ====== Questions ====== */
    //type toggle for assessment questions
    function type_toggle() {
        var selected = $('[name="type"]').find('option:selected');
        var id = selected.data('id'),
            label = selected.data('label');
        $('.qtype_container').hide();
        $('#'+id).show();
        $('#type_label').text(label);
    }
    type_toggle();
    $(document).on("change", '[name="type"]', function() {
        type_toggle();
    });

    //question options and answers
    $(document).on("click", '.add_opt_ans', function(e) {
        var fam = $(this).closest('.qtype_container');
        var opt_ans_area = fam.find('.opt_ans_area');
        var clone = fam.find('.opt_ans:last').clone();
        //clear inputs
        clone.find('input[type="text"]').val('');
        clone.find('input[type="radio"], input[type="checkbox"]').prop('checked', false);
        clone.appendTo(opt_ans_area);
    });

    //on answer select, get index and update
    $(document).on("change", '.answer_check', function(e) {
        var fam = $(this).closest('.qtype_container');
        var siblings = fam.find('.opt_ans_area').find('.answer_check');
        prep_question_answers(siblings, $('[name="answer_obj"]'));
    });

    //remove opts and ans
    $(document).on('click', '.remove_opt_ans', function() {
        //ensure there's at least 1 left
        var fam = $(this).closest('.qtype_container');
        var siblings = fam.find('.opt_ans_area').find('.remove_opt_ans');
        var total_rows = siblings.length;
        if (total_rows == 1) return false; 
        //remove index from siblings
        var ind = $(this).closest('.opt_ans').index();
        delete siblings[ind];
        $(this).closest('.opt_ans').remove();
        //update selected indices
        var chk_siblings = fam.find('.opt_ans').find('.answer_check');
        prep_question_answers(chk_siblings, $('[name="answer_obj"]'));
    });

    //Bulk action submissions
    $(document).on('change', '[name="type"]', function() {
        var type = $(this).val();
        //if re-opening or giving extra time, show extra time field
        if (['reopen', 'xtime'].includes(type)) {
            $('#extra_time_area').show();
            //if only giving extra time, make extra time field required
            if (type == 'xtime') {
                $('[name="extra_time"]').prop('required', true);
            }
        } else {
            $('[name="extra_time"]').prop('required', false);
            $('#extra_time_area').hide();
        }
    });

    //filter submissions
    $(document).on("click", '#filter_submissions', function(e) {
        e.stopImmediatePropagation();
        var wrapper = $('.class_dept_wrapper'),
            ass_id = wrapper.find('[name="ass_id"]').val(),
            trashed = wrapper.find('[name="trashed"]').val(),
            dept_id = wrapper.find('[name="dept_id"]').val() || '',
            class_id = wrapper.find('[name="class_id"]').val() || '';
        if (dept_id || class_id) {
            var url = `assessment_submissions?ass_id=${ass_id}&trashed=${trashed}`;
            if (dept_id) url += `&dept_id=${dept_id}`;
            if (class_id) url += `&class_id=${class_id}`;

            $('#m_filter_subs').modal('hide');
            $(".modal-backdrop").remove();
            load_page_ajax(url, null, 0);
        }
    });

});