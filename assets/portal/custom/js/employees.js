jQuery(document).ready(function ($) {
    "use strict";

    var super_user_checked = $('[name="is_super_user"]').is(':checked');
    toggle_roles_box(super_user_checked);

    $(document).on('change', '[name="is_super_user"]', function() {
        var is_checked = $(this).is(':checked');
        toggle_roles_box(is_checked);
    });

    function toggle_roles_box(is_checked) {
        $('#roles_section').toggle(!is_checked);
    }
});