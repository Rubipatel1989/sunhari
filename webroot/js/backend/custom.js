jQuery(document).ready(function(){
	//All Form Validation is start here
	var home_url = $("#home_url").val();
	jQuery.validator.addMethod(
		"money",
		function(value, element) {
			var isValidMoney = /^\d{0,10}(\.\d{0,9})?$/.test(value);
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
			"Please enter the password of length 8 containing atleast one capital letter, one small letter, one special character, one digit."
	);*/

	jQuery.validator.addMethod("noSpace", function(value, element) { 
	     return value.indexOf(" ") < 0 && value != ""; 
	}, "Space are not allowed");
	
	jQuery('#add_package_form').validate(
	{
		rules:{
			'Package[name]': {
				required: true
			},
			'Package[package_bv]': {
				required: true,
				money: true
			},
			'Package[package_amount]': {
				required: true,
				money: true
			},
			'Package[direct_amount]': {
				required: true,
				money: true
			},
			'Package[roi_amount]': {
				required: true,
				money: true
			},
			'Package[business_point]': {
				required: true,
				money: true
			},
			'Package[booster_time]': {
				required: true,
				money: true
			},
			'Package[booster_amount]': {
				required: true,
				money: true
			},
			'Package[allowed_links]': {
				required: true,
				number: true
			},
			'Package[position]': {
				required: true
			},
			'Package[status]': {
				required: true
			}
		},
		messages:{
			'Package[package_bv]': {
				money: 'Please enter value like 545.89'
			},
			'Package[package_amount]': {
				money: 'Please enter value like 545.89'
			},
			'Package[direct_amount]': {
				money: 'Please enter value like 545.89'
			},
			'Package[roi_amount]': {
				money: 'Please enter value like 545.89'
			},
			'Package[business_point]': {
				money: 'Please enter value like 545.89'
			},
			'Package[booster_time]': {
				money: 'Please enter value like 545.89'
			},
			'Package[booster_amount]': {
				money: 'Please enter value like 545.89'
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

	jQuery('#add_payment_account_form').validate(
	{
		rules:{
			'Payment[account_number]': {
				required: true
			},
			'Payment[bank_name]': {
				required: true
			},
			'Payment[ifsc_code]': {
				required: true
			},
			'Payment[upi_id]': {
				required: true
			},
			'Payment[remark]': {
				required: true
			},
			'Payment[status]': {
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

	jQuery('#add_product_form').validate(
	{
		rules:{
			'Product[name]': {
				required: true
			},
			'Product[description]': {
				required: true
			},
			'Product[price]': {
				required: true,
				money: true
			},
			'Product[discount]': {
				money: true
			},
			'Product[discount_price]': {
				money: true
			},
			'Product[business_volume]': {
				required: true,
				money: true
			},
			'Product[business_point]': {
				required: true,
				money: true
			},
			'Product[quantity]': {
				required: true,
				money: true
			},
			'Product[position]': {
				required: true
			},
			'Product[status]': {
				required: true
			}
		},
		messages:{
			'Product[price]': {
				money: 'Please enter value like 545.89'
			},
			'Product[discount]': {
				money: 'Please enter value like 545.89'
			},
			'Product[discount_price]': {
				money: 'Please enter value like 545.89'
			},
			'Product[business_volume]': {
				money: 'Please enter value like 545.89'
			},
			'Product[business_point]': {
				money: 'Please enter value like 545.89'
			},
			'Product[quantity]': {
				money: 'Please enter value like 545.89'
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

	jQuery('#add_bonanza_form').validate(
	{
		rules:{
			'Bonanza[title]': {
				required: true
			},
			'Bonanza[direct_users]': {
				required: true,
				money: true
			},
			'Bonanza[matching_users]': {
				required: true,
				money: true
			},
			'Bonanza[reward]': {
				required: true
			},
			'Bonanza[amount]': {
				required: true
			},
			'Bonanza[start_date]': {
				required: true
			},
			'Bonanza[end_date]': {
				required: true
			},
			'Bonanza[status]': {
				required: true
			}
		},
		messages:{
			'Bonanza[direct_users]': {
				money: 'Please enter value like 15.5'
			},
			'Bonanza[matching_users]': {
				money: 'Please enter value like 15.5'
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

	jQuery('#add_link_form').validate(
	{
		rules:{
			'Link[title]': {
				required: true
			},
			'Link[link]': {
				required: true
			},
			'Link[status]': {
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

	jQuery('#transfer_fund_form').validate(
	{
		rules:{
			'Wallet[username]': {
				required: true
			},
			'Wallet[name]': {
				required: true
			},
			'Wallet[amount]': {
				required: true,
				money: true
			},
			'Wallet[remark]': {
				required: true
			},
			'Wallet[status]': {
				required: true
			}
		},
		messages:{
			'Wallet[amount]': {
				money: 'Please enter value like 545.89'
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

	jQuery('#transaction_password_form').validate(
	{
		rules:{
			'User[transaction_password]': {
				required: true
			},
			'User[cofirm_password]': {
				equalTo: "#transaction_password"
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

	jQuery('#otp_form').validate(
	{
		rules:{
			'User[otp]': {
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

	jQuery('#add_ticket_form').validate(
	{
		rules:{
			'Ticket[subject]': {
				required: true
			},
			'Ticket[description]': {
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

	jQuery('#reply-form').validate(
	{
		rules:{
			'Reply[description]': {
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

	jQuery('#add_binary_form').validate(
	{
		rules:{
			'Binary[title]': {
				required: true
			},
			'Binary[type]': {
				required: true
			},
			'Binary[amount]': {
				required: true,
				money: true
			},
			'Binary[percentage]': {
				required: true,
				money: true
			},
			'Binary[remark]': {
				required: true
			}

		},
		messages:{
			'Binary[amount]': {
				money: 'Please enter value like 545.89'
			},
			'Binary[percentage]': {
				money: 'Please enter value like 545.89'
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

	jQuery('#add_roi_form').validate(
	{
		rules:{
			'Roi[title]': {
				required: true
			},
			'Roi[type]': {
				required: true
			},
			'Roi[amount]': {
				required: true,
				money: true
			},
			'Roi[percentage]': {
				required: true,
				money: true
			},
			'Roi[remark]': {
				required: true
			}

		},
		messages:{
			'Roi[amount]': {
				money: 'Please enter value like 545.89'
			},
			'Roi[percentage]': {
				money: 'Please enter value like 545.89'
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

	jQuery('#edit_profile_form').validate(
	{
		rules:{
			'Detail[first_name]': {
				required: true
			},
			'Detail[last_name]': {
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

	jQuery('#account_password_form').validate(
	{
		rules:{
			'User[password]': {
				required: true
			},
			'User[new_password]': {
				required: true
			},
			'User[confirm_password]': {
				equalTo: "#user_new_password"
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

	jQuery('#change_transaction_password_form').validate(
	{
		rules:{
			'User[transaction_password]': {
				required: true,
			},
			'User[new_transaction_password]': {
				required: true,
			},
			'User[confirm_password]': {
				equalTo: "#new_password"
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

	jQuery('#add_bitcoin_form').validate(
	{
		rules:{
			'Bitcoin[title]': {
				required: true
			},
			'Bitcoin[address]': {
				required: true
			},
			'Bitcoin[status]': {
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

	jQuery('#request_fund_form').validate(
	{
		rules:{
			'Fundrequest[transaction_id]': {
				required: true
			},
			'Fundrequest[btc_value]': {
				required: true,
      			digits: true
			},
			'Fundrequest[self_btc_address]': {
				required: true
			},
			'Fundrequest[company_btc_address]': {
				required: true
			},
			'Fundrequest[remark]': {
				required: true
			}
		},
		messages:{
			'Fundrequest[btc_value]': {
				money: 'Please enter value like 545.89'
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

	jQuery('#fund_request_bulk_form').validate(
	{
		rules:{
			'Fundrequest[bulk_action]': {
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

	jQuery('#tax_commission_form').validate(
	{
		rules:{
			'Commission[tax]': {
				required: true,
				money:true
			},
			'Commission[amount]': {
				required: true,
				money:true
			},
			'Commission[remark]': {
				required: true
			}
		},
		messages:{
			'Commission[tax]': {
				money: 'Please enter value like 545.89'
			},
			'Commission[commission]': {
				money: 'Please enter value like 545.89'
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

	jQuery('#user_upgrade_form').validate(
	{
		rules:{
			'Upgrade[upgraded_id]': {
				required: true
			},
			'Upgrade[package_id]': {
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

	jQuery('#request_payout_form').validate(
	{
		rules:{
			'Payment[requested_amount]': {
				required: true,
				money: true,
				min:10
			},
			'Payment[remark]': {
				required: true
			}
		},
		messages:{
			'Payment[requested_amount]': {
				money: 'Please enter value like 545.89'
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

	jQuery('#add_user_form').validate(
	{
		rules:{
			'User[sponsor_username]': {
				required: true
			},
			'User[sponsor_name]': {
				required: true
			},
			'User[email]': {
				required: true,
				email: true
			},
			'User[sponser_username]': {
				required: true
			},
			'User[name]': {
				required: true
			},
			'User[aadhar_number]': {
				required: true
			},
			'User[pan_number]': {
				required: true,
				rangelength: [10, 10]
			},
			'User[country_id]': {
				required: true
			},
			'User[country_code]': {
				required: true
			},
			'User[contact_number]': {
				required: true,
				rangelength: [10, 10]
			},
			'User[password]': {
				required: true
			},
			'User[confirm_password]': {
				equalTo: "#password"
			},
			'User[status]': {
				required: true
			},
			'User[current_rank]': {
				required: true
			},
			'User[bank_name]': {
				required: true
			},
			'User[account_number]': {
				required: true
			},
			'User[ifsc_code]': {
				required: true
			},
			'user_file': {
				required: true,
				extension: "xls|xlsx"
			}
		},
		messages:{
			'User[pan_number]': {
				rangelength: "PAN Number length should be of 10 character."
			},
			'User[contact_number]': {
				rangelength: "Mobile length should be of 10 character."
			},
			'user_file': {
				extension: "Please upload only xls|xlsx file."
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
	jQuery('#add_staff_form').validate(
	{
		rules:{
			
			'Detail[first_name]': {
				required: true
			},
			'User[username]': {
				required: true
			},
			'User[password]': {
				required: true
			},
			'User[role_id]': {
				required: true
			},
			'User[confirm_password]': {
				equalTo: "#password"
			},
			'User[status]': {
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

	jQuery('#add_roi_and_royalty_form').validate(
	{
		rules:{
			'Payout[month]': {
				required: true
			},
			'Payout[business_value]': {
				required: true
			},
			'Payout[percentage]': {
				required: true
			},
			'Payout[percentage]': {
				required: true,
				money: true
			},
			'Payout[above_50_lakhs]': {
				required: true,
				money: true
			},
			'Payout[above_2_crore]': {
				required: true,
				money: true
			},
			'Payout[above_5_crore]': {
				required: true,
				money: true
			},
			'Payout[above_10_crore]': {
				required: true,
				money: true
			},
			'Payout[above_25_crore]': {
				required: true,
				money: true
			},
			'Payout[above_50_crore]': {
				required: true,
				money: true
			}
		},
		messages:{
			'Payout[percentage]': {
				money: 'Please enter value like 15.5'
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

	jQuery('#add_club_income_form').validate(
	{
		rules:{
			'Payout[month]': {
				required: true
			},
			'Payout[business_value]': {
				required: true
			},
			'Payout[mobile_club]': {
				required: true,
				money: true
			},
			'Payout[laptop_club]': {
				required: true,
				money: true
			},
			'Payout[bike_club]': {
				required: true,
				money: true
			}
		},
		messages:{
			'Payout[mobile_club]': {
				money: 'Please enter value like 15.5'
			},
			'Payout[laptop_club]': {
				money: 'Please enter value like 15.5'
			},
			'Payout[bike_club]': {
				money: 'Please enter value like 15.5'
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

	jQuery('#add_profile_form').validate(
	{
		rules:{
			'User[name]': {
				required: true
			},
			'User[aadhar_number]': {
				required: true
			},
			'User[email]': {
				required: true,
				email: true
			},
			'User[contact_number]': {
				required: true
			},
			'User[current_rank]': {
				required: true
			},
			'User[aadhar_number]': {
				required: true
			},
			'User[bank_name]': {
				required: true
			},
			'User[account_number]': {
				required: true
			},
			'User[ifsc_code]': {
				required: true
			},
			'User[confirm_password]': {
				equalTo: "#password"
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


	jQuery('#add_matching_amount_form').validate(
	{
		rules:{
			'Payout[from_date]': {
				required: true
			},
			'Payout[to_date]': {
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

	jQuery('#order_form').validate(
	{
		rules:{
			'Order[first_name]': {
				required: true
			},
			'Order[last_name]': {
				required: true
			},
			'Order[contact_no]': {
				required: true
			},
			'Order[email]': {
				required: true,
				email: true
			},
			'Order[delivery_address]': {
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

	jQuery('#add_property_form').validate(
	{
		rules:{
			'Property[title]': {
				required: true
			},
			'Property[remark]': {
				required: true
			},
			'Property[status]': {
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

	jQuery('#add_site_form').validate(
	{
		rules:{
			'Site[property_id]': {
				required: true
			},
			'Site[title]': {
				required: true
			},
			'Site[remark]': {
				required: true
			},
			'Site[status]': {
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

	jQuery('#add_block_form').validate(
	{
		rules:{
			'Block[property_id]': {
				required: true
			},
			'Block[site_id]': {
				required: true
			},
			'Block[title]': {
				required: true
			},
			'Block[remark]': {
				required: true
			},
			'Block[status]': {
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

	jQuery('#add_plot_form').validate(
	{
		rules:{
			'Plot[property_id]': {
				required: true
			},
			'Plot[site_id]': {
				required: true
			},
			'Plot[block_id]': {
				required: true
			},
			'Plot[plot_number]': {
				required: true
			},
			'Plot[name]': {
				required: true
			},
			'Plot[length]': {
				required: true
			},
			'Plot[width]': {
				required: true
			},
			'Plot[area]': {
				required: true
			},
			'Plot[location]': {
				required: true
			},
			'Plot[east]': {
				required: true
			},
			'Plot[west]': {
				required: true
			},
			'Plot[north]': {
				required: true
			},
			'Plot[south]': {
				required: true
			},
			'Plot[plc]': {
				required: true
			},
			'Plot[edc]': {
				required: true
			},
			'Plot[ifmc]': {
				required: true
			},
			'Plot[bsp]': {
				required: true
			},
			'Plot[status]': {
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

	jQuery('#add_multiple_plot_form').validate(
	{
		rules:{
			'Plot[property_id]': {
				required: true
			},
			'Plot[site_id]': {
				required: true
			},
			'Plot[block_id]': {
				required: true
			},
			'Plot[plot_number]': {
				required: true
			},
			'plot_file': {
				required: true,
				extension: "xls|xlsx"
			}
		},
		messages:{
			'plot_file': {
				extension: "Please upload only xls|xlsx file"
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

	jQuery('#pair_rate_form').validate(
	{
		rules:{
			'PairRate[amount_per_id]': {
				required: true,
				money:true
			},
			'PairRate[no_of_emi]': {
				required: true,
				number:true
			}
		},
		messages:{
			'PairRate[amount_per_id]': {
				money: 'Please enter value like 545.89'
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

	jQuery('#add_current_rate_form').validate(
	{
		rules:{
			'CurrentRate[plan]': {
				required: true,
				money: true
			},
			'CurrentRate[rate]': {
				required: true,
				money: true
			},
			'CurrentRate[remark]': {
				required: true
			}
		},
		messages:{
			'CurrentRate[rate]': {
				money: 'Please enter value like 545.89'
			},
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

	jQuery('#assign_plot_form').validate(
	{
		rules:{
			'AssignPlot[user_id]': {
				required: true
			},
			'AssignPlot[property_id]': {
				required: true
			},
			'AssignPlot[site_id]': {
				required: true
			},
			'AssignPlot[block_id]': {
				required: true
			},
			'Plot[block_id]': {
				required: true
			},
			'AssignPlot[plot_id]': {
				required: true
			},
			'AssignPlot[plan]': {
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

	jQuery('#plot_payment_form').validate(
	{
		rules:{
			'PlotPayment[user_id]': {
				required: true
			},
			/*'PlotPayment[assign_plot_id]': {
				required: true
			},*/
			'PlotPayment[amount]': {
				required: true,
				money: true
			},
			'PlotPayment[payment_mode]': {
				required: true
			},
			'PlotPayment[bank]': {
				required: true
			},
			'PlotPayment[cheque_number]': {
				required: true
			},
			'PlotPayment[transaction_id]': {
				required: true
			},
			'PlotPayment[amount_date]': {
				required: true
			},
			'PlotPayment[number_of_unit]': {
				required: true
			}
		},
		messages:{
			'PlotPayment[amount]': {
				money: 'Please enter value like 545.89'
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

	jQuery('#generate_epins_form').validate(
	{
		rules:{
			'Epin[number_of_pins]': {
				number: true,
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

	jQuery('#status_reason_form').validate(
	{
		rules:{
			'Plot[remark]': {
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
	jQuery('#add_role').validate(
	{
		rules:{
			'Role[title]': {
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
	jQuery('#calculate_roi_form').validate(
	{
		rules:{
			'roiCalculationAmount': {
				required: true,
				number: true
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
	jQuery('#activate_user_form').validate(
	{
		rules:{
			'Upgrade[username]': {
				required: true
			},
			'Upgrade[sponsor_name]': {
				required: true
			},
			'Upgrade[package_amount]': {
				required: true,
				money: true,
				min: 50
			},
			'Upgrade[roi_amount]': {
				required: true
			}
		},
		messages:{
			'Upgrade[package_amount]': {
				money: 'Please enter value like 50.89'
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

	jQuery('#add_airdrop_form').validate(
	{
		rules:{
			'Airdrop[name]': {
				required: true
			},
			'Airdrop[wallet_address]': {
				required: true
			},
			'Airdrop[amount]': {
				required: true,
				money: true
			},
			'Airdrop[remark]': {
				required: true
			},
		},
		messages:{
			'Airdrop[amount]': {
				money: 'Please enter value like 50.89'
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

	jQuery('#salary_bonus_form').validate(
	{
		rules:{
			'Payout[username]': {
				required: true
			},
			'Payout[sponsor_name]': {
				required: true
			},
			'Payout[salary_bonus]': {
				required: true,
				money: true
			},
			'Payout[remark]': {
				required: true
			},
		},
		messages:{
			'Airdrop[amount]': {
				money: 'Please enter value like 50.89'
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

	jQuery('#royalty_bonus_form').validate(
	{
		rules:{
			'Payout[monthly_business]': {
				required: true
			},
			'Payout[amount]': {
				required: true,
				money: true
			},
			'Payout[remark]': {
				required: true
			},
		},
		messages:{
			'Payout[monthly_business]': {
				money: 'Please enter value like 50.89'
			},
			'Payout[monthly_business]': {
				money: 'Please enter value like 50.89'
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

	jQuery('#withdraw_approve_reject_form').validate(
	{
		rules:{
			'Fundrequest[transaction_id]': {
				required: true
			},
			'Fundrequest[reject_reason]': {
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

	jQuery('#payment_form').validate(
	{
		rules:{
			'PendingUpgrade[amount]': {
				required: true,
				money: true
			},
			'PendingUpgrade[transaction_id]': {
				required: true
			},
			'PendingUpgrade[payment_for]': {
				required: true
			},
			'PendingUpgrade[package_id]': {
				required: true
			}
		},
		messages:{
			'PendingUpgrade[amount]': {
				money: 'Please enter value like 545.89'
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

	jQuery('#payment_approve_form').validate(
	{
		rules:{
			'PendingUpgrade[used_for]': {
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

	jQuery('#payment_reject_form').validate(
	{
		rules:{
			'PendingUpgrade[rejection_remark]': {
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

	jQuery('#plan_ab_form').validate(
	{
		rules:{
			'Package[username]': {
				required: true,
			},
			'Package[customer_name]': {
				required: true,
			},
			'Package[amount]': {
				required: true,
			},
			'Package[total_amount]': {
				required: true,
			},
			'Package[return_amount]': {
				required: true,
				money: true
			},
			'Package[number_of_month]': {
				required: true,
				digits:true
			}
		},
		messages:{
			'Package[return_amount]': {
				money: 'Please enter value like 545.89'
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

	jQuery('#add_bill_form').validate(
	{
		rules:{
			'Bill[username]': {
				required: true,
			},
			'Bill[customer_name]': {
				required: true,
			},
			'Bill[package_id]': {
				required: true,
			},
			'Bill[package_id]': {
				required: true,
			},
			'Bill[package_id]': {
				required: true,
			},
			'Bill[amount]': {
				required: true,
				money: true
			},
			'Bill[bank_name]': {
				required: true,
			},
			'Bill[account_number]': {
				required: true,
			},
			'Bill[ifsc_code]': {
				required: true,
			},
			'Bill[shop_keeper_name]': {
				required: true,
			},
			'Bill[mobile_number]': {
				required: true,
			}
		},
		messages:{
			'Bill[amount]': {
				money: 'Please enter value like 545.89'
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

	jQuery('#user_emi_form').validate(
	{
		rules:{
			'PendingUpgrade[username]': {
				required: true,
			},
			'PendingUpgrade[name]': {
				required: true,
			},
			'PendingUpgrade[package_id]': {
				required: true,
			},
			'PendingUpgrade[amount]': {
				required: true,
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

	jQuery('#add_lesar_form').validate(
	{
		rules:{
			'Lesar[username]': {
				required: true,
			},
			'Lesar[username]': {
				required: true,
			},
			'Lesar[payment_type]': {
				required: true,
			},
			'Lesar[payment_mode]': {
				required: true,
			},
			'Lesar[bank_name]': {
				required: true,
			},
			'Lesar[account_number]': {
				required: true,
			},
			'Lesar[ifsc_code]': {
				required: true,
			},
			'Lesar[transaction_id]': {
				required: true,
			},
			'Lesar[voucher_code]': {
				required: true,
			},
			'Lesar[amount]': {
				required: true,
				money: true
			},
			'Lesar[remark]': {
				required: true,
			}
			
		},
		messages:{
			'Lesar[amount]': {
				money: 'Please enter value like 545.89'
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

	jQuery('#block_user_form').validate(
	{
		rules:{
			'User[block_reason_remark]': {
				required: true,
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

	jQuery('#promotion_form').validate(
	{
		rules:{
			'Promotion[username]': {
				required: true,
			},
			'Promotion[customer_name]': {
				required: true,
			},
			'Promotion[plan_id]': {
				required: true,
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

	jQuery('#remove_package_form').validate(
	{
		rules:{
			'Package[username]': {
				required: true,
			},
			'Package[customer_name]': {
				required: true,
			},
			'Package[id]': {
				required: true,
			},
			'Package[amount]': {
				required: true,
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

	jQuery("#epin_bulk_action").change(function(){

		var _this = this;
		var bulkAction = jQuery(_this).val();
		if(bulkAction == '1'){
			$("#users_container").show();
		}else{
			$("#users_container").hide();
		}

	});

	jQuery("#btn_calulate_pair_rate").click(function(){

		var _this = this;
		if(jQuery("#pair_rate_form").valid()){

			var total_upgraded_users = jQuery("#total_upgraded_users").val();
			var amount_per_id = jQuery("#amount_per_id").val();

			var total_amount  = total_upgraded_users * amount_per_id;

			jQuery("#total_amount").val(total_amount);

			var total_pair = jQuery("#total_pair").val();
			var pair_rate = total_amount/total_pair;

			jQuery("#pair_rate").val(pair_rate);

			var no_of_emi = jQuery("#no_of_emi").val();

			var emi_rate = pair_rate/no_of_emi;

			jQuery("#emi_rate").val(emi_rate);

			jQuery("#btn_pair_rate").show();


		}

	});

	jQuery(".edit-reply-icon").click(function(e){
		e.preventDefault();
		var _this = this;
		jQuery(_this).parent(".col-xs-12").next(".col-xs-12").slideToggle();
	});

	jQuery('input[name="Binary[type]"]').change(function(){
		var _this = this;
		var type = jQuery(_this).val();
		if(type == 0){
			jQuery("#amount-container").show();
			jQuery("#percentage-container").hide();
		}else{
			jQuery("#amount-container").hide();
			jQuery("#percentage-container").show();
		}
	});

	jQuery('input[name="Roi[type]"]').change(function(){
		var _this = this;
		var type = jQuery(_this).val();
		if(type == 0){
			jQuery("#amount-container").show();
			jQuery("#percentage-container").hide();
		}else{
			jQuery("#amount-container").hide();
			jQuery("#percentage-container").show();
		}
	});

	jQuery(".fancybox").fancybox();

	jQuery(".view_package_details_link").fancybox({
		width : '500px'
	});

	jQuery(".chk-check-uncheck").click(function(){
		var _this = this;
		if(jQuery(_this).is(':checked')){
			jQuery(".chk-ids").prop('checked', true);
		}else{
			jQuery(".chk-ids").prop('checked', false);
		}
	});

	jQuery("#user_upgrade_form").submit(function(){
		var _this = this;
		if(jQuery(_this).valid()){
			jQuery(".body-loader").show();
		}
	});

	jQuery("#bulk-payment-closing-form").submit(function(){
		var _this = this;
		if(jQuery(_this).valid()){
			jQuery(".body-loader").show();
		}
	});

	jQuery("#payment_by_username").change(function(){
		var _this = this;
		var username = jQuery(_this).val();
		var backend_url = jQuery("#backend_url").val();
		if(username != ''){
			jQuery(".body-loader").show();
			location.href = backend_url+'/payments/calculation/'+username;
		}
	});

	jQuery("#bulk-payment-calculation-form").submit(function(){
		var _this = this;
		if(jQuery(_this).valid()){
			jQuery(".body-loader").show();
		}
	});

	jQuery(".network-user-icon")
	.mouseover(function(){
		var _this = this;
		jQuery(_this).next(".network-user-details").show();
	})
	.mouseout(function(){
		var _this = this;
		jQuery(_this).next(".network-user-details").hide();
	});

	jQuery(".network-user-details")
	.mouseover(function(){
		var _this = this;
		jQuery(_this).show();
	})
	.mouseout(function(){
		var _this = this;
		jQuery(_this).hide();
	});

	jQuery("#roi_and_rolaylty_by_month").change(function(){
		var _this = this;
		var home_url = jQuery("#home_url").val();
		var month = jQuery(_this).val();
		if(month != ''){
			jQuery(".body-loader").show();
			jQuery.ajax({
			    type: "GET",
			    url: home_url+"/ajax/get_roi_and_rolalty_by_month/"+month,
			    dataType: 'text',  // what to expect back from the PHP script, if anything
			    cache: false,
			    contentType: false,
			    processData: false,
			    data: {},
			    success: function(responseText){
			      //alert(responseText);
			      data = responseText.split('_^_');
			      jQuery('#total_bv').val(data[0]);
			      jQuery('#total_business_point').val(data[1]);
			      jQuery(".body-loader").hide();
			    }
			});
		}
	});

	jQuery(".onhold-link").click(function(){

		var _this = this;
		var formAction = jQuery(_this).attr("data-action");
		jQuery("#status_reason_form").attr("action", formAction);
	});

	jQuery("form").submit(function(){
		let formId = $(this).attr("id");
		if($("#"+formId).valid()){
			jQuery(".body-loader").show();
		}
	});
});