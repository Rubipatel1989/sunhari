var csrfToken = $('meta[name="csrfToken"]').attr('content');
function getName(_this, fieldName){
	var intUserId = jQuery(_this).val();
	if(intUserId != ''){

		jQuery(".body-loader").show();
		var home_url = jQuery("#home_url").val();
		jQuery.ajax({
		    type: "GET",
		    url: home_url+"/ajax/get-user-details/"+intUserId,
		    dataType: 'text',  // what to expect back from the PHP script, if anything
		    cache: false,
		    contentType: false,
		    processData: false,
		    data: {},
		    headers:{
	          'X-CSRF-Token': csrfToken
	        },
		    success: function(responseText){
		      //alert(responseText);
		      jQuery('#'+fieldName).val(responseText);
		      jQuery(".body-loader").hide();
		    }
		});

	}
}

function FilterSateByCountry(country, stateContainer, fieldName, cls){
	if(country != ""){
	  var home_url = jQuery("#home_url").val();
	  jQuery(".body-loader").show();

		jQuery.ajax({
		type: "GET",
		url: home_url+"/ajax/filter_states/"+country+"/"+stateContainer+"/"+fieldName+"/"+cls,
		data: { },
		success: function( responseText ) 
			{
				//alert(responseText);
				jQuery("#"+stateContainer).html("");
				jQuery("#"+stateContainer).html(responseText);
				jQuery(".body-loader").hide();
			}
	   });
   }
}

function FilterSiteByProperty(property, siteContainer, fieldName, cls){
	if(property != ""){
	  var home_url = jQuery("#home_url").val();
	  jQuery(".body-loader").show();

		jQuery.ajax({
		type: "GET",
		url: home_url+"/ajax/filter_site/"+property+"/"+siteContainer+"/"+fieldName+"/"+cls,
		data: { },
		success: function( responseText ) 
			{
				//alert(responseText);
				jQuery("#"+siteContainer).html("");
				jQuery("#"+siteContainer).html(responseText);
				jQuery(".body-loader").hide();
			}
	   });
   }
}

function FilterBlockBySite(site,  blockContainer, fieldName, cls){
	if(site != ""){
	  var home_url = jQuery("#home_url").val();
	  jQuery(".body-loader").show();

		jQuery.ajax({
		type: "GET",
		url: home_url+"/ajax/filter_blocks/"+site+"/"+blockContainer+"/"+fieldName+"/"+cls,
		data: { },
		success: function( responseText ) 
			{
				//alert(responseText);
				jQuery("#"+blockContainer).html("");
				jQuery("#"+blockContainer).html(responseText);
				jQuery(".body-loader").hide();
			}
	   });
   }
}

function FilterPlotsByBlock(currObj,  plotContainer, fieldName, cls){
	var _this = currObj;
	if(jQuery(_this).parent("#block_container").attr("data-plot-filter").length > 0){
		var block = jQuery(_this).val();
		if(block != ""){
		  var home_url = jQuery("#home_url").val();
		  jQuery(".body-loader").show();

			jQuery.ajax({
			type: "GET",
			url: home_url+"/ajax/filter_plots/"+block+"/"+plotContainer+"/"+fieldName+"/"+cls,
			data: { },
			success: function( responseText ) 
				{
					//alert(responseText);
					jQuery("#"+plotContainer).html("");
					jQuery("#"+plotContainer).html(responseText);
					jQuery(".body-loader").hide();
				}
		   });
	   }
	}
}

function getPlotDetails(_this){
	plotId = jQuery(_this).val();
	if(plotId != ''){

		var home_url = jQuery("#home_url").val();
	  	jQuery(".body-loader").show();
		jQuery.ajax({
			type: "GET",
			url: home_url+"/ajax/get_plot_details/"+plotId,
			data: { },
			success: function( responseText ) 
				{
					//alert(responseText);
					jQuery("#plot_fields_container").html("");
					jQuery("#plot_fields_container").html(responseText);

					/*var area = parseFloat(jQuery("#plot_area").val());
					var plc = parseFloat(jQuery("#plot_plc").val());
					var currentRate = parseFloat(jQuery("#current_rate").val());

					var totalAmount = area * currentRate;
					jQuery("#total_amount").val(totalAmount);

					var plcAmount = (totalAmount * plc)/100;
					jQuery("#plc_amount").val(plcAmount);

					var grandTotal = totalAmount + plcAmount;
					jQuery("#grand_total").val(grandTotal);*/

					jQuery("#plot_calculation_container").show();

					jQuery(".body-loader").hide();
				}
	   });
	}
}

function getCurrentRateByPlan(_this){
	planId = jQuery(_this).val();
	if(planId != ''){

		var home_url = jQuery("#home_url").val();
	  	jQuery(".body-loader").show();
		jQuery.ajax({
			type: "GET",
			url: home_url+"/ajax/get_current_rate_by_plan/"+planId,
			data: { },
			success: function( responseText ) 
				{
					//alert(responseText);
					
					/*jQuery("#plot_fields_container").html("");
					jQuery("#plot_fields_container").html(responseText);*/

					jQuery("#current_rate").val(responseText);

					var area = parseFloat(jQuery("#plot_area").val());
					var plc = parseFloat(jQuery("#plot_plc").val());
					var currentRate = parseFloat(jQuery("#current_rate").val());

					var totalAmount = area * currentRate;
					jQuery("#total_amount").val(totalAmount);

					var plcAmount = (totalAmount * plc)/100;
					jQuery("#plc_amount").val(plcAmount);

					var grandTotal = totalAmount + plcAmount;
					jQuery("#grand_total").val(grandTotal);

					//jQuery("#plot_calculation_container").show();

					jQuery(".body-loader").hide();
				}
	   });
	}
}

function filterPlotPaymentsByUser(user,  plotContainer, fieldName, cls){
	if(user != ""){
	  var home_url = jQuery("#home_url").val();
	  jQuery(".body-loader").show();

		jQuery.ajax({
		type: "GET",
		url: home_url+"/ajax/filter_plots_by_user/"+user+"/"+plotContainer+"/"+fieldName+"/"+cls,
		data: { },
		success: function( responseText ) 
			{
				//alert(responseText);
				jQuery("#"+plotContainer).html("");
				jQuery("#"+plotContainer).html(responseText);
				jQuery(".body-loader").hide();
			}
	   });
   }
}

function addEmiFields(number_of_emi, formId){

	var numberOfEmi = jQuery("#"+number_of_emi).val();

	if(numberOfEmi != ''){
		jQuery("#"+formId).submit();
	}

}

function showEmiDetails(_this){

	var userId = jQuery(_this).val();
	if(userId != ''){

		var pageUrl = jQuery("#user_dashboard_form").attr("action");
		location.href = pageUrl+'/'+userId;

	}

}

function convertAreaIn(_this, convertIn, continer){

	var converFrom = parseFloat(jQuery(_this).val());

	if(!isNaN(converFrom)){

		if(convertIn == 'sqft'){

			ConversionValue = converFrom*9;
			jQuery("#"+continer).val(ConversionValue);

		}else{

			ConversionValue = converFrom/9;
			jQuery("#"+continer).val(ConversionValue);

		}

	}else{
		jQuery("#"+continer).val('');
	}
}

/*function applyDiscount(_this){

	var discount = parseFloat(jQuery(_this).val());
	var grand_total = parseFloat(jQuery("#grand_total").val());
	var grandTotal = grand_total - discount;

}*/

function showPaymentsFields(_this){

	var paymentMode = jQuery(_this).val();

	jQuery(".payment-fields-container").hide();

	if(paymentMode == 'Cheque'){

		jQuery("#cheque_container").show();

	}
	else if(paymentMode == 'UPI'){

		jQuery("#upi_container").show();
		
	}

}

function checkUserPayment(_this){

	var userId = jQuery(_this).val();

	if(userId != ""){
	  var home_url = jQuery("#home_url").val();
	  jQuery(".body-loader").show();

		jQuery.ajax({
		type: "GET",
		url: home_url+"/ajax/get_plot_payment_info/"+userId,
		data: { },
		success: function( responseText ) 
			{
				//alert(responseText);
				if(responseText == '0'){
					$("#number_of_unit_container").show();
				}else{
					$("#number_of_unit_container").hide();
				}
				jQuery(".body-loader").hide();
			}
	   });
   }

}

function getFullName(_this, roleId = 2){
	var username = jQuery(_this).val();
	if(username != ''){

		jQuery(".body-loader").show();
		var home_url = jQuery("#home_url").val();
		jQuery.ajax({
		    type: "GET",
		    url: home_url+"/ajax/get-full-name/"+username+"/"+roleId,
		    dataType: 'text',  // what to expect back from the PHP script, if anything
		    cache: false,
		    contentType: false,
		    processData: false,
		    data: {},
		    headers:{
	          'X-CSRF-Token': csrfToken
	        },
		    success: function(responseText){
		      //alert(responseText);
		      let referralName = responseText.trim();
		      if (referralName != '') {
		        jQuery('#referral_name').val(responseText);
		      } else {
		      	jQuery('#referral_name').val('');
		      	jQuery(_this).removeClass("valid");
		      	jQuery(_this).addClass("error-textbox");
		      	let message = 'Invalide referral code';
		      	if (roleId == 3) {
		      		message = 'Invalide username';
		      	}
		      	jQuery(_this).next(".error").text(message);
		      }
		      jQuery(".body-loader").hide();
		    }
		});

	}
}

function getCountryCode(_this){
	let arrCountryDetails = jQuery(_this).val().split("__");
    if (typeof arrCountryDetails[1] != 'undefined') {
    	$("#country_code").val(arrCountryDetails[1]);
	}
}

function pushFundRequestId(_this) {
	let fundRequestId = $(_this).attr("data-id");
	$("#fund_request_id").val(fundRequestId);
}

function pushFundRequestIdForReject(_this) {
	let fundRequestId = $(_this).attr("data-id");
	$("#rej_fund_request_id").val(fundRequestId);
}

function copyTextById(element) {
	var $temp = $("<input>");
  	$("body").append($temp);
  	$temp.val($("#"+element).text()).select();
  	document.execCommand("copy");
  	$temp.remove();
  	$("#btn-link-copied").trigger('click');
}

function showrankDetails(rankTitle, rankAmount, userId){
	if(rankTitle && rankAmount && userId){
		jQuery(".body-loader").show();
		var home_url = jQuery("#home_url").val();
		jQuery.ajax({
		    type: "GET",
		    url: home_url+"/ajax/get_rank_details/"+rankAmount+"/"+userId,
		    dataType: 'text', 
		    cache: false,
		    contentType: false,
		    processData: false,
		    data: {},
		    headers:{
	          'X-CSRF-Token': csrfToken
	        },
		    success: function(responseText){
		    	jQuery("#rank_title").text(rankTitle);
		      	jQuery("#tbl_rank_amount_container").html(responseText);
		      	jQuery("#rank_amount_link").trigger('click');
		      	jQuery(".body-loader").hide();
		    }
		});

	}
}

function showAmountDetails(amountTitle, amountType, userId, packageAmount=''){
	if(amountTitle && amountType && userId){
		jQuery(".body-loader").show();
		var home_url = jQuery("#home_url").val();
		jQuery.ajax({
		    type: "GET",
		    url: home_url+"/ajax/get_amount_details/"+amountType+"/"+userId+"/"+packageAmount,
		    dataType: 'text', 
		    cache: false,
		    contentType: false,
		    processData: false,
		    data: {},
		    headers:{
	          'X-CSRF-Token': csrfToken
	        },
		    success: function(responseText){
		    	jQuery("#amount_title").text(amountTitle);
		      	jQuery("#tbl_aojora_amount_container").html(responseText);
		      	jQuery("#amount_link").trigger('click');
		      	jQuery(".body-loader").hide();
		    }
		});

	}
}

function showWalletDetails(userId){
	if(userId){
		jQuery(".body-loader").show();
		var home_url = jQuery("#home_url").val();
		jQuery.ajax({
		    type: "GET",
		    url: home_url+"/ajax/get_wallet_details/"+userId,
		    dataType: 'text', 
		    cache: false,
		    contentType: false,
		    processData: false,
		    data: {},
		    headers:{
	          'X-CSRF-Token': csrfToken
	        },
		    success: function(responseText){
		      	jQuery("#tbl_aojora_amount_container").html(responseText);
		      	jQuery("#wallet_deduction_link").trigger('click');
		      	jQuery(".body-loader").hide();
		    }
		});

	}
}

function approvePayment(paymentId, amount){
	if(paymentId) {
		$(".payment_box_id").val(paymentId);
		$("#amount_container").text(amount);
		$("#approve_link").trigger('click');
	}
}

function rejectPayment(paymentId){
	if(paymentId) {
		$(".payment_box_id").val(paymentId);
		$("#reject_link").trigger('click');
	}
}

function calCulateTotalAmount(_this){
	let amount = $(_this).val();
	if (amount) {
		let intAmount = parseFloat(amount);
		if (intAmount % 500 !== 0) {
			$("#warning-msg").text("Amount should be in multiple of 500.");
			$(_this).val('');
			$("#btn-amount-warning").trigger('click');
			return;
		}
		let totalAmount = intAmount + ((intAmount/500)*110);
		$("#total_amount").val(totalAmount);
	}
}

function showHidePackage(_this){
	let paymentFor = $(_this).val();
	if (paymentFor == 2) {
		$("#package_container").show();
	} else {
		$("#package_container").hide();
	}
}

function getMBPackages(_this,) {
	let username = $(_this).val().trim();
	if(username){
		jQuery(".body-loader").show();
		var home_url = jQuery("#home_url").val();
		jQuery.ajax({
		    type: "GET",
		    url: home_url+"/ajax/get_mb_packages/"+username,
		    dataType: 'text', 
		    cache: false,
		    contentType: false,
		    processData: false,
		    data: {},
		    headers:{
	          'X-CSRF-Token': csrfToken
	        },
		    success: function(responseText){
		    	jQuery("#package_cotainer").html(responseText);
		      	jQuery(".body-loader").hide();
		    }
		});

	}
}

function getABPackages(_this, fieldName, isAmountFilter=0, planId=1) {
	let username = $(_this).val().trim();
	if(username){
		jQuery(".body-loader").show();
		var home_url = jQuery("#home_url").val();
		jQuery.ajax({
		    type: "GET",
		    url: home_url+"/ajax/get_ab_packages/"+username+'/'+fieldName+'/'+isAmountFilter+'/'+planId,
		    dataType: 'text', 
		    cache: false,
		    contentType: false,
		    processData: false,
		    data: {},
		    headers:{
	          'X-CSRF-Token': csrfToken
	        },
		    success: function(responseText){
		    	jQuery("#package_list_cotainer").html(responseText);
		      	jQuery(".body-loader").hide();
		    }
		});

	}
}

function getPackgeAmount(_this) {
	let packageId = $(_this).val().trim();
	if(packageId){
		jQuery(".body-loader").show();
		var home_url = jQuery("#home_url").val();
		jQuery.ajax({
		    type: "GET",
		    url: home_url+"/ajax/get_package_amount/"+packageId,
		    dataType: 'text', 
		    cache: false,
		    contentType: false,
		    processData: false,
		    data: {},
		    headers:{
	          'X-CSRF-Token': csrfToken
	        },
		    success: function(responseText){
		    	let responseData = responseText.trim();
		    	if (responseData) {
		    		$("#package_amount").val(responseData);
		    	}
		      	jQuery(".body-loader").hide();
		    }
		});

	}
}

function checkPackgeDetails(_this) {
	let packageId = $(_this).val().trim();
	if(packageId){
		jQuery(".body-loader").show();
		var home_url = jQuery("#home_url").val();
		jQuery.ajax({
		    type: "GET",
		    url: home_url+"/ajax/check_package_details/"+packageId,
		    dataType: 'text', 
		    cache: false,
		    contentType: false,
		    processData: false,
		    data: {},
		    headers:{
	          'X-CSRF-Token': csrfToken
	        },
		    success: function(responseText){
		    	let responseData = responseText.trim();
		    	if (responseData) {
		    		$("#bill_amount").val('');
		    		let splitReponse = responseData.split('__');
		    		if(splitReponse[0] == '2' || splitReponse[0] == '3') {
			    		jQuery('#dll_package').val("");
			    		let msg = null;
				      	if (splitReponse[0] == '2') {
						   msg = 'Limit is over for selected package';
						} else if (splitReponse[0] == '3') {
						   msg = 'Current month limit is over for selected package';
						}
						$("#warning-msg").html(msg);
						jQuery("#btn-amount-warning").trigger('click');
				    } else {
				    	$("#bill_amount").attr('data-remaining-amount', splitReponse[1]);
				    }
		    	}
		      	jQuery(".body-loader").hide();
		    }
		});

	}
}

function checkAmountLimit(_this)
{
	let amount = parseFloat($(_this).val());
	let remainingAmount = $(_this).attr("data-remaining-amount");
	let remainingLimit = parseFloat(remainingAmount);

	if (amount > remainingLimit) {
		jQuery(_this).val("");
		let msg = 'You can not submitted bill of more than Rs '+remainingAmount;
		$("#warning-msg").html(msg);
		jQuery("#btn-amount-warning").trigger('click');
	}
}

function showHidePaymentDetails(_this)
{
	let paymentMode = $(_this).val();

	if (paymentMode == 'net_banking') {
		$("#bank_details_container").show();
		$("#voucher_code_container").hide();
	} else {
		$("#bank_details_container").hide();
		$("#voucher_code_container").show();
	}
}

function getUserDetails(_this) {
	let username = $(_this).val();

	if(username){
		jQuery(".body-loader").show();
		var home_url = jQuery("#home_url").val();
		jQuery.ajax({
		    type: "GET",
		    url: home_url+"/ajax/get_user_details/"+username,
		    dataType: 'json', 
		    cache: false,
		    contentType: false,
		    processData: false,
		    data: {},
		    headers:{
	          'X-CSRF-Token': csrfToken
	        },
		    success: function(responseText){
		    	let responseData = responseText;
		    	if (responseData) {
		    		$("#name").val(responseData.name);
		    		$("#bank_name").val(responseData.bank_name);
		    		$("#account_number").val(responseData.account_number);
		    		$("#ifsc_code").val(responseData.ifsc_code);
		    	} else {
		    		$(_this).val("");
		    		let msg = 'Entered does not exist in our database.';
					$("#warning-msg").html(msg);
					jQuery("#btn-amount-warning").trigger('click');
		    	}
		      	jQuery(".body-loader").hide();
		    }
		});
	}
}

function blockUser(userId) {
	$("#user_id").val(userId);
	$("#block_user_link").trigger('click');
}

function showAmountWithGST(_this) {
	let planId = $(_this).val();
	let planAmount = 0;
	if (planId == 1) {
        planAmount = 2950;
    } else if (planId == 2) {
        planAmount = 5900;
    } else if (planId == 3) {
        planAmount = 8850;
    } else if (planId == 4) {
        planAmount = 11800;
    } else {
        planAmount = 0;
    }

    $("#package_with_gst_amount").val(planAmount);
}