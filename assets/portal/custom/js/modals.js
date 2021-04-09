jQuery(document).ready(function ($) {
    "use strict";

    //Note: tm is short for trigger_modal 
    
    function confirm_actions(obj, ajax_url, title, msg, success_msg = 'Successful') {
        $('#m_confirm_action .modal-title').text(title); 
        $('#m_confirm_action .modal-body .msg').html(msg); 
        $('#m_confirm_action').modal('show');
        var id = $(obj).data('id'),
            tb = $(obj).data('tb'),
            mod = $(obj).data('mod'),
            md = $(obj).data('md'),
            cmm = $(obj).attr('data-cmm') ? $(obj).data('cmm') : '',
            files = $(obj).attr('data-files') ? $(obj).data('files') : {},
            where = $(obj).attr('data-where') ? $(obj).data('where') : {};
        var post_data = {mod: mod, md: md, tb: tb, id: id, cm: cmm, files: files, where: where};
        ajax_post_btn_data(ajax_url, post_data, 'confirm_btn', 'm_confirm_action', success_msg);
    }
    
    //trash record
    $(document).on( "click", ".trash_record", function() {
        confirm_actions(this, 'api/common/trash_ajax', 'Trash Record', 'Sure to trash this record?', 'Record trashed successfully');
    });

    //trash all records
    $(document).on( "click", ".tm_trash_all", function() {
        confirm_actions(this, 'api/common/trash_all_ajax', 'Trash all Records', 'Sure to trash all records? To trash only selected records, use the Bulk Action feature.', 'Records trashed successfully');
    });

    //restore trashed record
    $(document).on( "click", ".restore_record", function() {
        confirm_actions(this, 'api/common/restore_ajax', 'Restore Record', 'Sure to restore this record?', 'Record restored successfully');
    });

    //restore all records
    $(document).on( "click", ".tm_restore_all", function() {
        confirm_actions(this, 'api/common/restore_all_ajax', 'Restore all Records', 'Sure to restore all records? To restore only selected records, use the Bulk Action feature.', 'Records restored successfully');
    });

    //delete a trashed record permanently
    $(document).on( "click", ".delete_record", function() {
        confirm_actions(this, 'api/common/delete_ajax', 'Delete Record', 'Sure to delete this record? This action cannot be undone!', 'Record deleted successfully');
    });

    //delete all trashed records permanently
    $(document).on( "click", ".tm_clear_trash", function() {
        confirm_actions(this, 'api/common/clear_trash_ajax', 'Clear Trash', 'Sure to clear trash? This action cannot be undone! To permanently delete only selected records, use the Bulk Action feature.', 'Trash cleared successfully');
    });

    //view image
    $(document).on( "click", ".tm_image", function() {
        $('#m_img_view .modal-title').text($(this).attr('title')); 
        var img = $('<img/>').attr({src: $(this).attr('src'), title: $(this).attr('title'), class: 'modal_image img-responsive'});
        $('#m_img_view .modal-body').empty().html(img);
        $('#m_img_view').modal('show');
    });

    //ajax modal button
    $(document).on( "click", ".ajax_extra_modal_btn", function() {
        var id = $(this).data('id'),
            name = $(this).data('name'),
            modal = $(this).data('modal');
        $('[name="'+name+'"]').val(id);
        $(modal).modal('show'); //show the modal
    });

    //table row options
    $(document).on( "click", ".record_extra_options", function() {
        var id = $(this).data('id');
        var options = $(this).data('options'); 
        var butts = "";
        $.each(options, (i, opt) => {
            butts += modal_option_btn(id, opt.text, opt.type, opt.target, opt.icon);
        });
        $('#m_row_options .modal-title').text('More Options'); 
        $('#m_row_options .modal-body').empty().html(butts); 
        $('#m_row_options').modal('show'); //show the modal
    });

    function modal_option_btn(id, text, type, target, icon) {
        if (type == 'url') {
            const url = base_url + target + '/' + id;
            return '<p><a type="button" href="'+url+'" class="btn btn-outline-primary btn-sm btn-block action-btn"><i class="fa fa-'+icon+'"></i> '+text+'</a></p>';
        } else {
            return '<p><button type="button" data-toggle="modal" data-target="#'+target+'" class="btn btn-outline-primary btn-sm btn-block action-btn"><i class="fa fa-'+icon+'"></i> '+text+'</button></p>';
        }
    }

    //select department
    $(document).on("click", ".tm_dept", function() {
        var obj = $(this); 
        var title = $(this).attr('title'); 
        var type = $(this).attr('type') || 'query'; 
        $('#m_select_dept .modal-title').html(title); 
        $('#m_select_dept').modal('show'); //show the modal
        //append class and go to the page
        $(document).on("click", ".m_select_go", function() {
            var dept_id = $('#m_select_dept_id').val();
            if (!dept_id.length) return false;
            var resource = (type == 'query' ? '?dept_id=' : '/') + dept_id;
            modal_nav_target(obj, resource);
            $('#m_select_dept').modal('hide');
        });
    });

    //select department archive
    $(document).on("click", ".tm_archive_dept", function() {
        var obj = $(this); 
        var title = $(this).attr('title'); 
        var type = $(this).attr('type') || 'query'; 
        $('#m_select_archive_dept .modal-title').html(title); 
        $('#m_select_archive_dept').modal('show'); //show the modal
        //append class and go to the page
        $(document).on("click", ".m_select_go", function() {
            var dept_id = $('#m_select_archive_dept_id').val();
            var session = $('#m_select_archive_dept_session').val() || '';
            var semester = $('#m_select_archive_dept_semester').val() || '';
            if (!dept_id.length || !session.length || !semester.length) return false;
            var resource = (type == 'query' ? '?dept_id=' : '/') + dept_id;
            modal_nav_target(obj, resource);
            $('#m_select_archive_dept').modal('hide');
        });
    });

    //select class
    $(document).on("click", ".tm_class", function() {
        var obj = $(this); 
        var title = $(this).attr('title'); 
        $('#m_select_class .modal-title').html(title); 
        $('#m_select_class').modal('show'); //show the modal
        //append class and go to the page
        $(document).on("click", ".m_select_go", function() {
            var class_id = $('select.select_class_id').val() || '';
            if (!class_id.length) return false;
            var resource = `/${class_id}`;
            modal_nav_target(obj, resource);
            $('#m_select_class').modal('hide');
        });
    });

    //select archive
    $(document).on("click", ".tm_archive", function() {
        var obj = $(this); 
        var title = $(this).attr('title'); 
        $('#m_select_archive .modal-title').html(title); 
        $('#m_select_archive').modal('show'); //show the modal
        //append class and go to the page
        $(document).on( "click", ".m_select_go", function() {
            var session = $('#m_select_session').val() || '';
            var semester = $('#m_select_semester').val() || '';
            if (!session.length || !semester.length) return false;
            var resource = `?session=${session}&semester=${semester}`;
            modal_nav_target(obj, resource);
            $('#m_select_archive').modal('hide');
        });
    });

    function modal_nav_target(obj, resource) {
        var page = obj.data('page');
        var is_ajax = obj.data('is_ajax');
        var ajax_container = obj.data('ajax_container') || 'ajax_page_container';
        var url = page+resource;
        if (is_ajax) {
            load_page_ajax(url, null, 0, ajax_container, true);
        } else {
            window.location.href = url;
        }
    }


    //bulk action
    //bulk action: disable action button if no bulk action type is selected
    if ($('.ba_apply').length) $('.ba_apply').prop('disabled', true);
    $('[name="ba_option"]').change(function () {
        $('.ba_apply').prop('disabled', ! Boolean($(this).val()));
    });
    
    //bulk action: select all checkbox items if select all is checked
    $(document).on( "change", '.ba_check_all', function() {
        $('.ba_record').prop('checked', $(this).prop('checked'));
    });
    
    $(document).on( "change", '.ba_record', function() {
        if(false == $(this).prop('checked')){ 
            $('.ba_check_all').prop('checked', false); 
        }
        if ($('.ba_record:checked').length == $('.ba_record').length ){
            $('.ba_check_all').prop('checked', true);
        }
    });

    //bulk action: select all checkbox items if select all is checked
    $(document).on( "change", '.ba_check_all2', function() {
        $('.ba_record2').prop('checked', $(this).prop('checked'));
    });
    
    $(document).on( "change", '.ba_record2', function() {
        if(false == $(this).prop('checked')){ 
            $('.ba_check_all2').prop('checked', false); 
        }
        if ($('.ba_record2:checked').length == $('.ba_record2').length ){
            $('.ba_check_all2').prop('checked', true);
        }
    });

    var ba_modal = '',
        ba_val = '',
        selected = '';
    $(document).on( "change", '[name="ba_option"]', function() {
        selected = $('[name="ba_option"] option:selected');
        ba_modal = selected.data('modal');
        ba_val = $(this).val();
    });

    $(document).on( "click", '.ba_apply', function() {
        //get checked records
        var record_idx = checked_records();
        var _records = record_idx.length + ' ' + (record_idx.length == 1 ? 'record' : 'records');
        if (record_idx.length) {
            $('#ba_selected_msg').removeClass('text-danger').addClass('text-success').text(`${_records} selected`);
        } else {
            $('#ba_selected_msg').removeClass('text-success').addClass('text-danger').text('No record selected');
            return false;
        }
        
        //if trash, restore or delete, use common url to process form
        let ba_mod = $(this).data('mod'),
            ba_md = $(this).data('md'),
            ba_tb = $(this).data('tb'),
            m_title = '',
            m_msg = '';
        var post_data = {mod: ba_mod, md: ba_md, tb: ba_tb, id: record_idx.join()};
        switch (ba_val) {

            case 'Trash':
                m_title = 'Bulk Trash';
                m_msg = 'Sure to trash the selected records?';
                ajax_post_btn_data('api/common/bulk_trash_ajax', post_data, 'ba_confirm_btn', 'm_confirm_ba', 'Records trashed successfully');
                break;

            case 'Restore':
                m_title = 'Bulk Restore';
                m_msg = 'Sure to restore the selected records?';
                ajax_post_btn_data('api/common/bulk_restore_ajax', post_data, 'ba_confirm_btn', 'm_confirm_ba', 'Records trashed successfully');
                break;

            case 'Delete':
                //check files exist for the records. Files are same for all records, so we get for one.
                var files = $('.delete_record').eq(0).attr('data-files') ? {files: $('.delete_record').eq(0).data('files')} : {};
                post_data = {...post_data, ...files};
                m_title = 'Bulk Delete';
                m_msg = 'Sure to permanently delete the selected records? This action cannot be undone!';
                ajax_post_btn_data('api/common/bulk_delete_ajax', post_data, 'ba_confirm_btn', 'm_confirm_ba', 'Records trashed successfully');
                break;

            default:
                //custom
                m_title = 'Bulk Action';
                var id_field = selected.attr('data-id_field') ? selected.data('id_field') : 'id';
                $('[name="'+id_field+'"]').val(record_idx.join());
                break;

        }
        $('#'+ba_modal+ ' .modal-title').empty().text(`${m_title} (${_records})`);
        $('#'+ba_modal+ ' .modal-body .ba_msg').text(m_msg);
        $('#'+ba_modal).modal('show');
    });

    function checked_records() {
        //get checked records
        var record_idx = [];
        $.each($('[name="ba_record_idx[]"]:checked'), function(){
            record_idx.push($(this).val());
        });
        return record_idx;
    }

});
 

