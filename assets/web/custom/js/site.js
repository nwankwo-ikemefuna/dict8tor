jQuery(document).ready(function ($) {

    //send activation sms
    $(document).on("click", ".switch_language", function(){
    	const callback = function(jres) {
	        if (jres.status) {
	            location.reload();
	        } else {
				alert(jres.error);
			}
	    };
	    const language = $(this).data('lang');
    	post_data_ajax(base_url+'api/web/switch_language', {language}, false, callback);
    });

	//center responsive nav button if header donate button is not visible
	const donate_btn = $('.top-header .donate_btn');
	if (!donate_btn.length) {
		$('.responsive-nav-button').css({margin: 'auto'});
	}

	$(document).on("change", "select[name=ngo_registered]", function(){
		var val = $(this).val();
		if (val == 1) {
			$(".ngo_reg_section").show();
		} else {
			$(".ngo_reg_section").hide();
		}
	});

	//filter lgas by state
    $(document).on("change", "select[name=state]", function() {
    	var lga_field = $("select[name=lga]");
        var state_id = $(this).val();
		var success_callback = function(jres) {
    		var data = jres.body.msg || {};
        	set_select_options(lga_field, data, 'id', 'name', 'No LGA found for this state', false);
		};
		fetch_data_ajax(base_url+'api/common/get_state_lgas', {state: state_id}, 'POST', success_callback);
    });

	let hands_on_inputs = $('#hands_on_form :input');
	$.each(hands_on_inputs, (i, input) => {
		$(input).removeAttr('required');
	});

});