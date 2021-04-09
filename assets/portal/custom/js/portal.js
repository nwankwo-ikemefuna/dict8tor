jQuery(document).ready(function ($) {
    "use strict";

    /*window.addEventListener('popstate', function(e) {
        var location = e.state;
        console.log('location', location);
        if (location != null) {
            load_page_ajax(location, null, 0, 'ajax_page_container', true, 'Going back', false);
            $('.addedMenuNavBarItem').remove();
        } else {
            window.history.back();
        }
    });*/

    //load requested page
    load_page_ajax(ajax_requested_page, null, 0);

    //on click of sidebar ajax page link on mobile screen, close menu wrapper
    $(document).on( "click", ".tload_ajax", function() {
        if ($('body').hasClass('fixed-body')) {
            $('#sidebar-menu-toggle')[0].click();
        }
    });

    //set persistent menu data
    // classes by department
    $(document).on("change", "select.select_dept_id", function() {
        var wrapper = $(this).closest('.class_dept_wrapper');
    	var selectfield = wrapper.find('select.select_class_id');
        var dept_id = $(this).val();
    	var data = JSON.parse(_dept_classes)[dept_id] || {};
        set_select_options(selectfield, data, 'id', 'class_full', 'No class found for this department');
    });

    // states by country
    $(document).on("change", "select.select_country_id", function() {
        var wrapper = $(this).closest('.state_country_wrapper');
    	var selectfield = wrapper.find('select.select_state_id');
        var country_id = $(this).val();
    	var data = JSON.parse(_country_states)[country_id] || {};
        set_select_options(selectfield, data, 'id', 'name', 'No state found for this country');
    });

});

