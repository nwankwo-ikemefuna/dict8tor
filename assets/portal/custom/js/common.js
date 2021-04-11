function initializePlugins() {
    $('.jq_input_tags').tagsInput({
        width: 'auto'
    });

    //sortable
    $("#sortable").sortable({
        cursor: 'move'
    });

    moment().format();
    // NB: These guys require moment.js
    $('#time_picker').datetimepicker({
        format: 'hh:mm A',
        ignoreReadonly: true
    });
    $('#date_picker').datetimepicker({
        format: 'DD/MM/YYYY',
        ignoreReadonly: true
    });
    $('#datetime_picker, #datetime_picker2, #datetime_picker3').datetimepicker({
        format: 'DD/MM/YYYY hh:mm A',
        ignoreReadonly: true
    });
}

$.ajax().done(function() {
    initializePlugins();
});

jQuery(document).ready(function ($) {
    "use strict";  
    initializePlugins();
});