jQuery(document).ready(function ($) {

	//fetch lecturers by department
    $(document).on("change", "#courses [name='dept_id']", function(){
        get_select_options('api/employees/get_by_dept', 'lecturers[]', $('[name="lecturers[]"]').val(), {dept_id: $(this).val()}, 'POST', 'full_name');
    });
    
});