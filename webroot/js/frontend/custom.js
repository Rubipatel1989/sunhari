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
	/*jQuery.validator.addMethod(
		"password",
		function(value, element) {
			var isValidPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}/.test(value);
			return this.optional(element) || isValidPassword;
			},
			""
	);*/

	jQuery.validator.addMethod("noSpace", function(value, element) { 
	     return value.indexOf(" ") < 0 && value != ""; 
	}, "Space are not allowed");
	
	jQuery('#registration-form').validate(
	{
		rules:{
			'User[sponser_username]': {
				required: true
			},
			'User[sponsor_name]': {
				required: true
			},
			'User[position]': {
				required: true
			},
			'Detail[first_name]': {
				required: true
			},
			'Detail[last_name]': {
				required: true
			},
			'User[email]': {
				required: true,
				email:true
			},
			'Detail[contact_no]': {
				required: true
			},
			'User[username]': {
				required: true,
				noSpace : true
			},
			'User[password]': {
				required: true,
				password : true,
				noSpace : true
			},
			'User[confirm_password]': {
				equalTo: "#user-password"
			},
			'is_agree': {
				required: true
			}

		},
		messages:{
			'User[confirm_password]': {
				equalTo: "Password does not match."
			}
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


	jQuery('#login_form').validate(
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
			'User[password]': {
				required: 'This field is required.'
			}
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

	jQuery('#registrtion_otp_form').validate(
	{
		rules:{
			'User[otp]': {
				//required: true
			}

		},
		messages:{
			'User[password]': {
				required: 'This field is required.'
			}
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

	//All Form Validation is end here
	
	jQuery('[type="checkbox"]').click(function(){
		var _this = this;
		if($(_this).is(':checked')){
			jQuery(_this).next(".error").next(".custom-checkbox-icon").css({'opacity' : '1'});
		}else{
			jQuery(_this).next(".error").next(".custom-checkbox-icon").css({'opacity' : '0'});
		}
	})

	jQuery("#sponser_username").change(function(){
		var _this = this;
		var sponser_username = jQuery(_this).val();
		if(sponser_username != ''){
			$(".loader").show();
			jQuery.ajax({
				type: "POST",
				url: home_url+"/ajax/get_sponser_details/",
				data: { "username" : sponser_username},
				success: function( responseText ) {
					if(responseText != ''){
						$("#sponsor_name").val(responseText);
						$(".loader").hide();
					}else{
						$(_this).val('');
						$(_this).next(".error").remove();
						$(_this).removeClass("valid");
						$(_this).addClass("error-textbox");
						$("#sponsor_name").val('');
						$(_this).parent(".input").append('<label for="sponser_username" generated="true" class="error">Entered referral id : "'+sponser_username+'" does not exist in our database.</label>');
						$(".loader").hide();
					}
				}
			});
		}
	});

	/*jQuery("#email").change(function(){
		var _this = this;
		var email = jQuery(_this).val();
		if(email != ''){
			jQuery.ajax({
				type: "POST",
				url: home_url+"/ajax/check_email/",
				data: { "email" : email},
				success: function( responseText ) {
					if(responseText != ''){
						$(_this).val('');
						$(_this).next(".error").remove();
						$(_this).removeClass("valid");
						$(_this).addClass("error-textbox");
						$(_this).parent(".input").append('<label for="sponser_username" generated="true" class="error">Entered email : "'+email+'" already exist in our database.</label>');

					}
				}
			});
		}
	});*/

	jQuery("#registration-form").submit(function(){
		var _this = this;
		if(jQuery(_this).valid()){
			$(".loader").show(); 
			return true;
		}
	});

	jQuery("#login_form").submit(function(){
		var _this = this;
		if(jQuery(_this).valid()){
			$(".loader").show(); 
			return true;
		}
	});
});
