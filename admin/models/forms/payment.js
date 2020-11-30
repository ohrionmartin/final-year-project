/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Vast Development Method 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			30th November, 2020
	@created		13th August, 2020
	@package		eClinic Portal
	@subpackage		payment.js
	@author			Oh Martin <https://vdm.io>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/

// [Interpretation 15644] Initial Script
jQuery(document).ready(function()
{
	var payment_category_vvvvvvv = jQuery("#jform_payment_category").val();
	vvvvvvv(payment_category_vvvvvvv);

	var payment_amount_vvvvvvw = jQuery("#jform_payment_amount").val();
	vvvvvvw(payment_amount_vvvvvvw);
});

// [Interpretation 15737] the vvvvvvv function
function vvvvvvv(payment_category_vvvvvvv)
{
	if (isSet(payment_category_vvvvvvv) && payment_category_vvvvvvv.constructor !== Array)
	{
		var temp_vvvvvvv = payment_category_vvvvvvv;
		var payment_category_vvvvvvv = [];
		payment_category_vvvvvvv.push(temp_vvvvvvv);
	}
	else if (!isSet(payment_category_vvvvvvv))
	{
		var payment_category_vvvvvvv = [];
	}
	var payment_category = payment_category_vvvvvvv.some(payment_category_vvvvvvv_SomeFunc);


	// [Interpretation 15806] set this function logic
	if (payment_category)
	{
		jQuery('#jform_nonpay_reason').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_nonpay_reason').closest('.control-group').hide();
	}
}

// [Interpretation 15784] the vvvvvvv Some function
function payment_category_vvvvvvv_SomeFunc(payment_category_vvvvvvv)
{
	// [Interpretation 15790] set the function logic
	if (payment_category_vvvvvvv == 1)
	{
		return true;
	}
	return false;
}

// [Interpretation 15737] the vvvvvvw function
function vvvvvvw(payment_amount_vvvvvvw)
{
	if (isSet(payment_amount_vvvvvvw) && payment_amount_vvvvvvw.constructor !== Array)
	{
		var temp_vvvvvvw = payment_amount_vvvvvvw;
		var payment_amount_vvvvvvw = [];
		payment_amount_vvvvvvw.push(temp_vvvvvvw);
	}
	else if (!isSet(payment_amount_vvvvvvw))
	{
		var payment_amount_vvvvvvw = [];
	}
	var payment_amount = payment_amount_vvvvvvw.some(payment_amount_vvvvvvw_SomeFunc);


	// [Interpretation 15806] set this function logic
	if (payment_amount)
	{
		jQuery('#jform_nonpay_reason').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_nonpay_reason').closest('.control-group').hide();
	}
}

// [Interpretation 15784] the vvvvvvw Some function
function payment_amount_vvvvvvw_SomeFunc(payment_amount_vvvvvvw)
{
	// [Interpretation 15790] set the function logic
	if (payment_amount_vvvvvvw == 1)
	{
		return true;
	}
	return false;
}

// the isSet function
function isSet(val)
{
	if ((val != undefined) && (val != null) && 0 !== val.length){
		return true;
	}
	return false;
} 
