jQuery(document).ready(function ($) {
    "use strict";

    var featured_item_type = $('[name="featured_item_type"]').val();
    toggle_featured_item_type(featured_item_type);

    $(document).on('change', '[name="featured_item_type"]', function() {
        var val = $(this).val();
        toggle_featured_item_type(val);
    });

    function toggle_featured_item_type(val) {
        if (current_page == 'view') return false;
        $('.featured_item_section, .featured_item_widget').hide();
        $(`#featured_item_section_${val}, .${val}_widget`).show();
    }
});