jQuery(document).ready(function ($) {

	var form = $("#hands_on_form");
	form.validate({
		errorPlacement: function errorPlacement(error, element) { 
			element.before(error); 
		},
		rules: {}
	});
	form.children("#hands_on_form_wizard").steps({
		headerTag: "h3",
		bodyTag: "section",
		transitionEffect: "slideLeft",
		stepsOrientation: "horizontal",
		onStepChanging: function (event, currentIndex, newIndex)
		{
			form.validate().settings.ignore = ":disabled,:hidden";
			return form.valid();
		},
		onFinishing: function (event, currentIndex)
		{
			form.validate().settings.ignore = ":disabled";
			return form.valid();
		},
	});

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

});