jQuery(document).ready(function ($) {
    "use strict";

    //load requested page
    load_page_ajax(ajax_requested_page, null, 0);

    //on click of sidebar ajax page link on mobile screen, close menu wrapper
    $(document).on( "click", ".tload_ajax", function() {
        if ($('body').hasClass('fixed-body')) {
            $('#sidebar-menu-toggle')[0].click();
        }
    });

});

