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

});