//selectfield params to update and refresh selectfield when a new item is added from another form
var selectfield_url = ''; 
var selectfield_name = ''; 
//save form type
var save_form_btn;
var save_form_type;

jQuery(document).ready(function ($) {
    "use strict"; 

    //load ajax page
    load_page_ajax_def();

    //onclick of save or save another button, show spinning guy
    $(document).on("click", ".save_form_button", function() {
        save_form_btn = this;
        save_form_type = $(this).data('type') || '';
    });

    //process ajax form
    $(document).on( "submit", ".ajax_form", function(e) {
        $(this).off("submit"); //unbind event to prevent multiple firing
        e.preventDefault();
        let obj = $(this);
        var url = obj.attr('action'),
            form_id = obj.attr('id'),
            type = obj.attr('data-type') ? obj.data('type') : 'none',
            msg = obj.attr('data-msg') ? obj.data('msg') : 'Successful',
            notice = obj.attr('data-notice') ? obj.data('notice') : 'status_msg',
            modal = obj.attr('data-modal') ? obj.data('modal') : null,
            reload = obj.attr('data-reload') ? Boolean(obj.data('reload')) : true,
            status_modal = obj.attr('data-status_modal') ? Boolean(obj.data('status_modal')) : false,
            loading_msg = obj.attr('data-loading_msg') ? obj.data('loading_msg') : 'Processing...Please wait',
            clear = obj.attr('data-clear') ? Boolean(obj.data('clear')) : false;
        let form_data = new FormData(this);
        if (url.length && form_id.length && type.length) {
            switch (type) {

                //modal datatables, with selectpicker
                case 'modal_dt':
                case 'modal_sp':
                    if (modal.length) {
                        ajax_post_form_refresh(form_id, form_data, url, modal, type, msg, reload, notice, status_modal, loading_msg, clear);
                    }
                    break;

                //none, alert, redirect
                case 'none':
                case 'js_alert':
                case 'redirect':
                    var redirect = obj.attr('data-redirect') ? obj.data('redirect') : '_self';
                    var ajax_container = obj.attr('data-container') ? obj.data('container') : 'ajax_page_container';
                    var ajax_callback = obj.attr('data-callback') ? obj.data('callback') : null;
                    var ajax_loading = obj.attr('data-loading') ? obj.data('loading') : 1;
                    var ajax_loading_text = obj.attr('data-loading_text') ? obj.data('loading_text') : 'Loading';
                    var ajax_delay = obj.attr('data-delay') ? obj.data('delay') : 3;
                    ajax_post_form(form_id, form_data, url, type, redirect, msg, notice, status_modal, loading_msg, clear, ajax_container, ajax_callback, ajax_delay, ajax_loading, ajax_loading_text);
                    break;
            }
        } else {
            console.error('Setup Error: url, form id or type missing');
        }
    });

    //Edit item: modal
    $(document).on( "click", ".edit_record", function() {
        var modal = $(this).data('x_modal'),
            form_id = $(this).data('x_form_id');
        //clear form
        $('#'+form_id)[0].reset();
        var inputs = $('form#'+form_id+' :input');
        $.each(inputs, (i, input) => {
            var name = $(input).attr('name');
            if (typeof name !== "undefined") {
                var val = $(this).data(name);
                var field = $('#'+form_id).find(':input[name="'+name+'"]');
                //get input type or tagname if type is undefined (eg select, textarea)
                var type = field.attr('type') || field.prop('tagName').toLowerCase();
                if (type == 'select' || type == 'checkbox' || type == 'radio') {
                    //we need to call change event on these guys
                    field.val(val).change();
                } else {
                    field.val(val);
                }
            }
        });
        $('#'+modal+ ' .modal-title').text('Edit Record');
        $('#'+modal).modal('show'); //show the modal
    });

    //set selectfield url and name
    $(document).on( "click", ".ajax_select_btn", function() {
        selectfield_url = $(this).data('url');
        selectfield_name = $(this).data('selectfield');
    });


    //Refresh captcha 
    $(document).on("click", '#refresh_captcha_image', function() {
        var success_callback = function(jres) {
            $('#captcha_image').empty(); 
            if (jres.status) { 
                $('#captcha_image').html(jres.body.msg);
            } else {
                $('#captcha_image').html('<span class="text-danger">Unable to reload captcha!</span>');
            }
        };
        var theme = JSON.parse($('.captcha_theme').val());
        fetch_data_ajax(base_url+'api/common/regenerate_captcha', {theme}, 'POST', success_callback);
    });
});

function post_data_ajax(url, data, is_form_data = false, success_callback, error_callback = null, status_modal = false, loading_msg = 'Processing... Please wait') { 
    var promise = new Promise(function(resolve, reject) {
        var ajax_setup = {
            url: url,
            type: 'POST',
            dataType: "json",
            data: secure_req_data(data, is_form_data),
            beforeSend: function() { ajax_loading_show(status_modal, loading_msg) },
            complete: function() { ajax_loading_hide() }
        };
        //if form data, add processdata and contenttype to setup
        ajax_setup = is_form_data ? {...ajax_setup, ...{processData: false, contentType: false}} : ajax_setup;
        $.ajax(ajax_setup)
        .done(function (jres) {
            if (typeof success_callback === 'function') {
                success_callback(jres);
            }
            resolve_promise(resolve, reject, jres);
        })
        .fail(function (error) {
            if (typeof error_callback === 'function') {
                error_callback();
            }
            reject_promise(reject, error);
        });
    });
    return promise;
}

function fetch_data_ajax(url, data, type = 'POST', success_callback, error_callback = null, status_modal = false, loading_msg = 'Processing... Please wait') { 
    var promise = new Promise(function(resolve, reject) {
        $.ajax({
            url: url,
            type: type,
            dataType: "json",
            data: secure_req_data(data, false),
            beforeSend: function() { ajax_loading_show(status_modal, loading_msg) },
            complete: function() { ajax_loading_hide() }
        })
        .done(function (jres) {
            if (typeof success_callback === 'function') {
                success_callback(jres);
            }
            resolve_promise(resolve, reject, jres);
        })
        .fail(function (error) {
            if (typeof error_callback === 'function') {
                error_callback(error);
            }
            reject_promise(reject, error);
        });
    });
    return promise;
}

function ajax_post_form(form_id, data, url, fm_type, redirect_url = '', success_msg = 'Successful', notice_elem = 'status_msg', status_modal = false, loading_msg = 'Processing... Please wait', clear = false, ajax_container = 'ajax_page_container', ajax_delay = 3, ajax_callback = null, ajax_loading = 1, ajax_loading_text = 'Loading') {
    var ajax_form_processing = $('#'+form_id).find('.ajax_form_processing');
    var promise = new Promise(function(resolve, reject) {
        $.ajax({
            url: url, 
            type: 'POST',
            data: data,
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('.'+notice_elem).empty();
                if (status_modal) {
                    ajax_loading_show(status_modal, loading_msg);
                } else {
                    $(save_form_btn).find('.ajax_spinner').removeClass('hide').addClass('fa-spin');
                    if (ajax_form_processing.length) {
                        ajax_form_processing.show();
                    }
                }
            },
            complete: function() {
                if (status_modal) {
                    ajax_loading_hide();
                } else {
                    $('.ajax_spinner').addClass('hide').removeClass('fa-spin');
                    if (ajax_form_processing.length) {
                        const persist = ajax_form_processing.data('persist') || '';
                        if (persist != 1) {
                            ajax_form_processing.hide();
                        }
                    }
                }
            }
        })
        .done(function(jres) {
            if (jres.status) {
                if (clear) {
                    $('#'+form_id)[0].reset();
                }
                if (fm_type == 'js_alert') {
                    alert(success_msg);
                    // alert(jQuery(success_msg).text());
                } else {
                    status_box(notice_elem, success_msg, 'success', 'class', 10000, form_id);
                }
                //is submit type save and add another? clear form fields
                if (save_form_type == 'save_more') {
                    clear_form_fields(form_id);
                }
                //get page query strings (if any)
                var q_string = $('.q_string').val() || '';

               //reload captcha?
                var recaptcha = $('#'+form_id).attr('data-recaptcha') ? Boolean($('#'+form_id).data('recaptcha')) : false;
                if (recaptcha) {
                    waitfor(2).then(() => {
                        $('#refresh_captcha_image').trigger('click');
                    });
                }

                setTimeout(function() { 
                    switch (redirect_url) {
                        case '_void':
                            //no redirect
                            //do nothing
                            break;
                        case '_self':
                            //self redirect
                            location.reload();
                            break;
                        case '_dynamic':
                            //dynamic redirect
                            $(location).attr('href', base_url+jres.body.msg.redirect+q_string);
                            break;
                        case '_ajax':
                            load_page_ajax(redirect_url+q_string, ajax_callback, ajax_delay, ajax_container, ajax_loading, ajax_loading_text);
                            break;
                        case '_ajax_dynamic':
                            //is submit type save and add another?
                            if (save_form_type != 'save_more') {
                                load_page_ajax(jres.body.msg.redirect+q_string, ajax_callback, ajax_delay, ajax_container, ajax_loading, ajax_loading_text);
                            }
                            break;
                        default:
                            //as provided
                            $(location).attr('href', redirect_url+q_string);
                            break;
                    }
                }, 3000);  
            } else {
                if (fm_type == 'js_alert') {
                    alert($(jres.error).text());
                } else {
                    status_box(notice_elem, jres.error, 'danger', 'class', 10000, form_id);
                }
            }
            resolve_promise(resolve, reject, jres);
        })
        .fail(function (error) {
            reject_promise(reject, error);
        });
    });
    return promise;
}

function ajax_post_form_refresh(form_id, data, url, modal_id = '', fm_type = 'modal_dt', success_msg = 'Successful!', refresh = true, notice_elem = 'status_msg', status_modal = false, loading_msg = 'Processing... Please wait', clear = false) {
    var promise = new Promise(function(resolve, reject) {
        $.ajax({
            url: url, 
            type: 'POST',
            data: secure_req_data(data, true),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('.'+notice_elem).empty();
                if (status_modal) {
                    ajax_loading_show(status_modal, loading_msg);
                } else {
                    $('.ajax_spinner').removeClass('hide').addClass('fa-spin');
                }
            },
            complete: function() {
                if (status_modal) {
                    ajax_loading_hide();
                } 
            }
        })
        .done(function(jres) {
            if (jres.status) {
                if (clear) {
                    $('#'+form_id)[0].reset();
                }
                if (refresh) {
                    if (fm_type == 'modal_sp') {
                        //refresh selectfield
                        get_select_options(selectfield_url, selectfield_name);
                    } else {
                        $('.ajax_dt_table').DataTable().ajax.reload();
                    }
                }
                status_box(notice_elem, success_msg, 'success', 'class', 10000, form_id);
                if (modal_id.length) {
                    setTimeout(function() { 
                        $('#'+modal_id).modal('hide');
                    }, 3000);  
                }
            } else {
                status_box(notice_elem, jres.error, 'danger', 'class', 10000, form_id);
            }
            resolve_promise(resolve, reject, jres);
        })
        .fail(function (error) {
            reject_promise(reject, error);
        });
    });
    return promise;
}

function ajax_post_btn_data(url, data, btn_id, modal_id = '', success_msg = 'Successful', reload_table = true, status_modal = false, loading_msg = 'Processing... Please wait') {
    var promise = new Promise(function(resolve, reject) {
        $(document).off('click', '#'+btn_id); //unbind event to prevent multiple firing
        $(document).on('click', '#'+btn_id, function(e) {
            e.preventDefault();
            $.ajax({
                url: base_url+url, 
                type: 'POST',
                data: secure_req_data(data, false),
                dataType: 'json',
                beforeSend: function() {
                    $('.confirm_status').empty();
                    if (status_modal) {
                        ajax_loading_show(status_modal, loading_msg);
                    } else {
                        $(save_form_btn).find('.ajax_spinner').removeClass('hide').addClass('fa-spin');
                    }
                },
                complete: function() {
                    if (status_modal) {
                        ajax_loading_hide();
                    } else {
                        $('.ajax_spinner').addClass('hide').removeClass('fa-spin');
                    }
                }
            })
            .done(function(jres) {
                if (jres.status) {
                    if (modal_id.length) {
                        status_box('confirm_status', success_msg, 'success');
                        setTimeout(function() { 
                            $('#'+modal_id).modal('hide');
                        }, 3000);
                    }
                    if (reload_table) {
                        $('.ajax_dt_table').DataTable().ajax.reload();
                    }
                } else {
                    status_box('confirm_status', jres.error, 'danger');
                }
                resolve_promise(resolve, reject, jres);
            })
            .fail(function (error) {
                reject_promise(reject, error);
            });
        });
    });
    return promise;
}

function get_select_options(url, selectfield, current_val, data = {}, type = 'GET', text_col = 'name') {
    var success_callback = function(jres) {
        $('[name="'+selectfield+'"]').empty(); //empty selectfield
        var options = '<option value="">Select</option>';
        if (jres.status) { 
            var result = jres.body.msg;
            if (result.length) {
                $.each(result, (i, row) => {
                    options += `<option ${row.id == current_val ? 'selected' : ''} value="${row.id}">${row[text_col]}</option>`;
                });
            } else {
                options += `<option value="" style="color: red">No data to render</option>`;
            }
        } else {
            //status is false, show error message in red
            options += `<option value="" style="color: red">${jres.error}</option>`;
        }
        //append the options to the select field and refresh
        $('[name="'+selectfield+'"]').append(options).selectpicker('refresh');
    };
    fetch_data_ajax(base_url+url, data, type, success_callback);
}

function paginate_data(url, elem, row_render, paginate_elem = 'pagination', page_num = 0, data = {}, final_callback = null, error_callback = null, status_modal = false, loading_msg = 'Processing... Please wait', delay = 0) {
    var success_callback = function(jres) {
        //create pagination links
        $('#'+paginate_elem).html(jres.body.msg.pagination);
        $('#'+elem).empty();
        if (jres.status) {
            var accum = '';
            $.each(jres.body.msg.records, (i, row) => {
                if ( typeof row_render == "function" )
                    accum += row_render(row);
            });
            $('#'+elem).html(accum);
            if ( typeof final_callback == "function" ) {
                final_callback(jres);
            }
        } 
    };
    waitfor(delay).then(() => {
        post_data_ajax(base_url+url+'/'+page_num, data, false, success_callback,  error_callback, status_modal, loading_msg);
    });
}

function ci_paginate(url, elem, row_render, pagination = 'pagination', data = {}, scroll_to = '', succ_callbk = null, err_callbk = null) {
    $('#'+pagination).on('click', 'ul li a', function(e){
        e.preventDefault();
        var page_num = $(this).attr('data-ci-pagination-page');
        paginate_data(url, elem, row_render, pagination, page_num, data, succ_callbk, err_callbk, true, 'Navigating');
        //jump to beginning of item list
        var top = $('#'+scroll_to).position().top;
        $('html').scrollTop(top);
    });
}

function load_page_ajax_def() {
    $(document).on('click', '.tload_ajax', function(e) {
        e.preventDefault();
        var container = $(this).attr('data-container') ? $(this).data('container') : 'ajax_page_container',
            url = $(this).data('url'),
            callback = $(this).attr('data-callback') ? $(this).data('callback') : null,
            loading = $(this).attr('data-loading') ? Boolean($(this).data('loading')) : true,
            loading_text = $(this).attr('data-loading_text') ? $(this).data('loading_text') : 'Loading';
        if (!container.length || !url.length) {
            console.error('Setup Error: container or url not specified');
            return false;
        }
        if (loading) {
            ajax_loading_show(true, loading_text);
        }
        $('#'+container).load(base_url+url, function() {
            if (typeof window[callback] === 'function') {
                window[callback]();
            }
            ajax_loading_hide();
        });
    });
}

function load_page_ajax(url, callback = null, delay = 3, container = 'ajax_page_container', loading = true, loading_text = 'Loading', add_to_history = true) {
    if (!url.length) {
        console.error('Setup Error: url not specified');
        return false;
    }
    setTimeout(function(){
        if (loading) {
            ajax_loading_show(true, loading_text);
        }
        $('#'+container).load(base_url+url, function() {
            if (typeof window[callback] === 'function') {
                window[callback]();
            }
            ajax_loading_hide();
        });

        if (add_to_history != false) {
            history.pushState(url, null, null);
        }
        
    }, delay*1000);
}

function regenerate_csrf_token() { 
    //make non-promised based request to regenerate and get new csrf on fail so that subsequent non-chained requests can run unhindered
    $.ajax({
        url: base_url+'api/common/regenerate_csrf',
        type: 'GET',
        dataType: "json"
    })
    .done(function (jres) {
        var curr_csrf_hash = $('.'+csrf_token_name).val();
        var csrf_hash = jres[csrf_token_name] || '';
        // console.log('New token:', csrf_hash);
        if ( ! csrf_hash.length) {
            //log for debugging
            console.error('CSRF: CSRF token not set!');
            return false;
        }
        //update
        $('.'+csrf_token_name).val(csrf_hash);
        //ensure the new token has been updated
        return ($('.'+csrf_token_name).val() != curr_csrf_hash && $('.'+csrf_token_name).val() == csrf_hash);
    });
}
