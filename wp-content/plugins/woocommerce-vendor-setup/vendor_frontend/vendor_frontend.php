<?php
//Adding Registration fields to the form   woocommerce_register_form_start

//add_filter( 'register_form', 'adding_custom_registration_fields' );
//add_filter( 'woocommerce_register_form', 'adding_custom_registration_fields' );
function adding_custom_registration_fields( ) {

	//lets make the field required so that i can show you how to validate it later;
	//echo '<div class="form-row form-row-wide"><label for="reg_become_a_vendor"><input type="checkbox"  name="become_a_vendor" id="reg_become_a_vendor" size="30" value="vendor" />&nbsp;'.__('Become a CJ', 'woocommerce').'</label></div>';

}

//Validation registration form  after submission using the filter registration_errors
add_filter('registration_errors', 'registration_errors_validation', 10,3);
function registration_errors_validation($reg_errors, $sanitized_user_login, $user_email) {
		global $woocommerce;
		extract($_POST); // extracting $_POST into separate variables
		if($become_a_vendor == '' ) {
			$woocommerce->add_error( __( 'Please, fill in all the required fields.', 'woocommerce' ) );
		}
		return $reg_errors;
}

//Updating use meta after registration successful registration
add_action('woocommerce_created_customer','adding_extra_reg_fields');

function adding_extra_reg_fields($user_id) {
	//die('ooooooooooo');
	extract($_POST);
	$vendor_status = '';
	if($become_a_vendor!=''){
		$vendor_status = 'Pending';
	}
	update_user_meta($user_id, 'become_a_vendor', $become_a_vendor);
	update_user_meta($user_id, 'become_a_vendor_status', $vendor_status);

    // can also do multiple fields like that
    //update_user_meta($user_id, 'first_name', $firstname);
	//update_user_meta($user_id, 'billing_first_name', $firstname);
	//update_user_meta($user_id, 'shipping_first_name', $firstname);
}
?>