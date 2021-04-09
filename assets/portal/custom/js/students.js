jQuery(document).ready(function ($) {

    //send activation sms
    $(document).on("click", "#send_activation_sms", function(e){
    	e.stopImmediatePropagation();
    	var callback = function(jres) {
	        if (jres.status) {
	            status_box('ib_msg_box', jres.body.msg);
	        } else {
	        	status_box('ib_msg_box', jres.error, 'danger');
	        }
	    };
	    var type = $(this).data('type') || 'all';
	    var id = $(this).data('id') || '';
    	post_data_ajax(base_url+'api/messaging/send_activation_sms', {type, id}, false, callback, null, true, 'Sending SMS...Please wait');
    });

});