jQuery(document).ready(function(){
	//All Form Validation is start here
	var home_url = $("#home_url").val();
	jQuery.validator.addMethod(
		"money",
		function(value, element) {
			var isValidMoney = /^\d{0,10}(\.\d{0,2})?$/.test(value);
			return this.optional(element) || isValidMoney;
			},
			""
	);

	jQuery.validator.addMethod("noSpace", function(value, element) { 
	     return value.indexOf(" ") < 0 && value != ""; 
	}, "Space are not allowed");
	
	jQuery('#login-form').validate(
	{
		rules:{
			'User[username]': {
				required: true
			},
			'User[password]': {
				required: true
			}

		},
		messages:{
			
		},
		highlight: function(element) {
			jQuery(element).closest('.loginbox').removeClass('valid signuptextbox form-control').addClass('error-textbox signuptextbox form-control');
			jQuery(element).closest('.logincheckbox').removeClass('valid').addClass('');
		},
		success: function(element) {
		element
	    /*.text('').addClass('ok')
		.closest('.control-group').removeClass('error').addClass('success');*/
		}
	});
});
