jQuery(document).ready(function ($) {

    //send activation sms
    $(document).on("click", ".switch_language", function(){
    	var callback = function(jres) {
	        if (jres.status) {
	            location.reload();
	        } else {
				alert(jres.error);
			}
	    };
	    var language = $(this).data('lang');
    	post_data_ajax(base_url+'api/web/switch_language', {language}, false, callback);
    });

});