function prep_question_answers(siblings, ans_field) {
    var selected = [];
    $.each(siblings, function(index) {
        if ($(this).prop('checked') == true) {
            selected.push(index);
        }
    });
    ans_field.val(selected.join(','));
}