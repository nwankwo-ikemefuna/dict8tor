jQuery(document).ready(function ($) {

    //back button
    $(document).on("click", "#btn_goback", function() {
        // history.go(-1);
        var prevUrl = document.referrer;
        console.log('previous_url: ', prevUrl);
    });

    //update document title
    document.title = $('#ajax_page_title').html()+' :: '+$('#ajax_page_title').data('site_title');

	//ajax datatables trigger
	//bs select wraps select in a div, and this class is applied to the div too, so we target the selectfield, which is at odd index ie 1, 3, 5, etc
	var ajxs = $('.ajax_select'); 
	if ($(ajxs).length) {
	    $.each($(ajxs), (i, obj) => {
	        if (i % 2 !== 0) { //at every odd position
	            if (typeof $(obj).attr('data-url') !== "undefined") {
	                var url = $(obj).data('url'),
	                    selectfield = $(obj).attr('name'),
	                    selected = $(obj).attr('data-selected') ? $(obj).data('selected') : '';
	                get_select_options(url, selectfield, selected);
	            }
	        }
	    });
	}

	//selectpicker multiple items render on edit
    var select_mult = $('.select_mult'); 
    if ($(select_mult).length) {
        $.each($(select_mult), (i, obj) => {
            if (i % 2 !== 0) { //at every odd position
                console.log($(obj));
                if (typeof $(obj).attr('data-selected') !== "undefined") {
                    var selectfield = $(obj).attr('name'),
                        selected = $(obj).data('selected');
                    $('[name="'+selectfield+'"]').selectpicker('val', selected).change();
                }
            }
        });
    }

	//ajax datatables trigger
    var dt = $('.ajax_dt_table');
    if (dt.length) {
        var table = dt.attr('id'),
            custom = dt.data('custom'),
            url = dt.data('url'),
            cols = dt.data('cols'),
            col_defs = dt.attr('data-col_defs') || '',
            per_page = dt.attr('data-per_page') ? dt.data('per_page') : 50;
        if ( ! custom) {
            ajax_data_table(table, url, cols, col_defs, per_page);
        }
    }
    
    summernote_init(".summernote_simple", {picture: false}, {height: 300});

});