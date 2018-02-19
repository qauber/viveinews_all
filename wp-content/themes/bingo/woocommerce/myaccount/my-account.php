<?php
/**
 * My Account page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$current_user = wp_get_current_user();

?>


<?php get_template_part( 'account', 'menu' );

if( isset($_POST["submit_acc"] ) ) {
	update_user_meta( $current_user->ID, '_us_phone', sanitize_text_field($_POST['phone']) );
	update_user_meta( $current_user->ID, '_us_address', sanitize_text_field($_POST['address']) );
	update_user_meta( $current_user->ID, '_us_zip_code', sanitize_text_field($_POST['zipcode']) );
	
	wp_update_user( array( 'ID' => $current_user->ID, 
					'first_name' => sanitize_text_field($_POST['first_name']) ,
					'last_name' => sanitize_text_field($_POST['last_name']) 
					));
					
	if( isset( $_POST["paypal"])) {
		if( is_email( $_POST["paypal"] ) ) {
		   $paypal = sanitize_email( $_POST["paypal"] );
		   update_user_meta( $current_user->ID, '_us_paypal', $paypal );
		   //$redirect_to = '/my-account/';
		   //wp_safe_redirect( $redirect_to );
		   //exit();
		}
	}
	
	if( isset( $_POST["company_name"])) {
		   $company = sanitize_text_field( $_POST["company_name"] );
		   update_user_meta( $current_user->ID, '_us_company', $company );
	}
	
	if( isset( $_POST["ein"])) {
		   $ein = sanitize_text_field( $_POST["ein"] );
		   update_user_meta( $current_user->ID, '_us_user_eid', $ein );
	}
	if( isset( $_POST["us_contact"])) {
		   $contact = sanitize_text_field( $_POST["us_contact"] );
		   update_user_meta( $current_user->ID, '_us_contact', $contact );
	}	
	if( isset( $_POST["us_legal"])) {
		   $legal = sanitize_text_field( $_POST["us_legal"] );
		   update_user_meta( $current_user->ID, '_us_user_legal', $legal );
	}	
}

global $reg_errors;
$reg_errors = new WP_Error;

$user_type_acc = get_metadata('user', $current_user->ID, 'user_type', true);
$user_paypal   = get_metadata('user', $current_user->ID, '_us_paypal', true);
$user_phone    = get_metadata('user', $current_user->ID, '_us_phone', true);
$user_address  = get_metadata('user', $current_user->ID, '_us_address', true);
$user_autoloc  = get_metadata('user', $current_user->ID, 'auto_location', true);
$user_country  = get_metadata('user', $current_user->ID, '_us_country', true);
$user_state    = get_metadata('user', $current_user->ID, '_us_state', true);
$user_city     = get_metadata('user', $current_user->ID, '_us_city', true);
$zipcode     = get_metadata('user', $current_user->ID, '_us_zip_code', true);
$company_name     = get_metadata('user', $current_user->ID, '_us_company', true);
$user_eid     = get_metadata('user', $current_user->ID, '_us_user_eid', true);
$user_contact     = get_metadata('user', $current_user->ID, '_us_contact', true);
$user_main_legal     = get_metadata('user', $current_user->ID, '_us_user_legal', true);

$user_info = get_userdata($current_user->ID);
$user_first_name = $current_user->first_name;
$user_last_name = $current_user->last_name;

if (isset($_POST["submit_loc"])) {
    $my_a_loc = isset($_POST['my_auto_location']) ? 1 : 0;
    update_user_meta($current_user->ID, 'auto_location', $my_a_loc);
    if ($my_a_loc == 0) {
        $user_autoloc = 0;
        if (strtolower($_POST["my_country"]) != "select country") {
            if (strtolower($_POST["my_state"]) != "select state") {
                /* if(strtolower($_POST["my_city"]) != "select city" || empty($_POST["my_city"])){ */
                if ($_POST["saved"] == 1) {
                    $p_country = explode(":", $_POST["my_country"]);
                    $p_state = explode(":", $_POST["my_state"]);

                    if (count($p_country) == 2) {
                        $p_country = sanitize_text_field($p_country[1]);
                    } else {
                        $p_country = sanitize_text_field($p_country[0]);
                    }
                    if (count($p_state) == 2) {
                        $p_state = sanitize_text_field($p_state[1]);
                    } else {
                        $p_state = sanitize_text_field($p_state[0]);
                    }
                    if (isset($_POST["my_city"])) {
                        $p_city = explode(":", $_POST["my_city"]);
                        if (count($p_city) == 2) {
                            $p_city = sanitize_text_field($p_city[1]);
                        } else {
                            $p_city = sanitize_text_field($p_city[0]);
                        }
                    }

                    if (preg_match("/^[aA-zZ0-9\-_'\s+]+$/", $p_country) && preg_match("/^[aA-zZ0-9\-_'\s+]+$/", $p_state)) {
                        update_user_meta($current_user->ID, '_us_country', $p_country);
                        update_user_meta($current_user->ID, '_us_state', $p_state);
                        if (isset($_POST["my_city"]) && strtolower($_POST["my_city"]) != "select city") {
                            update_user_meta($current_user->ID, '_us_city', $p_city);
                            $user_city = $p_city;
                        } else {
                            update_user_meta($current_user->ID, '_us_city', '');
                            $user_city = "";
                        }
                        $user_country = $p_country;
                        $user_state = $p_state;

                        echo '<div style="color:#1A9E25;font-size:18px;padding-top:20px;">Location saved</div>';
                        /* $redirect_to = '/my-account/';
                          wp_safe_redirect( $redirect_to );
                          exit(); */
                    } else {
                        $reg_errors->add('country', 'Entered invalid characters');
                    }
                }
                /* } else {
                  $reg_errors->add( 'city', 'City is required' );
                  } */
            } else {
                $reg_errors->add('state', 'State is required');
            }
        } else {
            $reg_errors->add('country', 'Country is required');
            $reg_errors->add('state', 'State is required');
            #$reg_errors->add( 'city', 'City is required' );
        }
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];

        function change_text_loc($text) {
            $text = str_replace("'", "", $text);
            $text = str_replace("yyi", "yi", $text);
            return $text;
        }

        /*$details = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip={$ip}"));
$user_country = sanitize_text_field( $details->geoplugin_countryName );
$user_state = sanitize_text_field( $details->geoplugin_region );
$user_city = sanitize_text_field( $details->geoplugin_city );*/
        
$details = json_decode(file_get_contents("http://ip-api.com/json/{$ip}"));
$user_country = sanitize_text_field( $details->country );
$user_state = sanitize_text_field( $details->regionName );
$user_city = sanitize_text_field( $details->city );

update_user_meta( $current_user->ID, '_us_country', change_text_loc($user_country) );
update_user_meta( $current_user->ID, '_us_state', change_text_loc($user_state) );
update_user_meta( $current_user->ID, '_us_city', change_text_loc($user_city) );
$redirect_to = '/my-account/';
wp_safe_redirect( $redirect_to );
exit();
}
}



if (isset($_POST["old_pass"])) {
    $old_pass = esc_attr($_POST["old_pass"]);
    $new_pass = esc_attr($_POST["new_pass"]);
    $repeat_pass = esc_attr($_POST["repeat_pass"]);
    if ($old_pass != '' && wp_check_password($old_pass, $current_user->user_pass, $current_user->ID)) {
        if ($new_pass != '') {
            if ($repeat_pass != '' && $new_pass == $repeat_pass) {

                function change_my_password($id, $pass) {
                    wp_set_password($pass, $id);
                }

                change_my_password($current_user->ID, $new_pass);
                if (function_exists(wp_mail)) {
                    $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
                    $message = "<p>Your account password was changed.</p>";
                    $message .= "<p>Username: " . $current_user->user_login . "</p>";
                    $message .= "<p>New password: " . $new_pass . "</p>";
                    wp_mail($current_user->user_email, 'Activation on ' . $blogname, $message);
                }
                echo '<div style="color:#1A9E25;font-size:18px;padding-top:20px;">Your password was successfully changed and saved</div>';
            } else
                $reg_errors->add('password2', 'Password mismatch');
        } else
            $reg_errors->add('password1', 'Password is required');
    } else
        $reg_errors->add('password', 'Incorrect old password');
}

wc_print_notices();
/*
  if( $user_paypal == "" AND $user_type_acc == "cj" ) {
  $user_paypal = "<form action='' method='POST' style='text-align:right;'><input type='email' name='paypal' value='' placeholder='PayPal account'><input type='submit' value='Save' style='margin-top:5px;'></form>";
  }
 */
?>

<?php
/*
  $attachments = array( WP_CONTENT_DIR . '/uploads/file_to_attach.zip' );
  $headers = 'From: My Name <comjds1@ya.ru>' . "\r\n";
  $res = mail( 'webbook.com.ua@gmail.com', 'subject', 'message', $headers);

  echo 'asd2' . $res;
 */
?>

<div class="wb-content wb1">
    
        <form class="form-horizontal" role="form" method="POST">
            <fieldset disabled>
                <div class="form-group">
                    <label for="user_type" class="col-sm-2 control-label">Account type:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="user_type" name="user_type" value="<?php echo ($user_type_acc == "cj") ? "Citizen Journalist" : ucfirst($user_type_acc); ?>"  />
                    </div>
                </div>
                <div class="form-group">
                    <label for="user_login" class="col-sm-2 control-label">Username:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="user_login" name="user_login" value="<?php echo $current_user->user_login; ?>"  />
                    </div>
                </div>
                <div class="form-group">
                    <label for="user_email" class="col-sm-2 control-label">Email:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="user_email" name="user_email" value="<?php echo $current_user->user_email; ?>"  />
                    </div>
                </div>
                <div class="form-group">
                    <label for="user_registered" class="col-sm-2 control-label">Sign up:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="user_registered" name="user_registered" value="<?php echo $current_user->user_registered; ?>"  />
                    </div>
                </div>
            </fieldset>
    
                <?php
                //print_r($current_user);
                //print_r($user_info);

                if (($user_type_acc == "cj") || ($user_type_acc == "editor")) {
                    ?>
                    <div class="form-group">
                        <label for="first_name" class="col-sm-2 control-label">First name:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First name" value="<?php echo $user_first_name; ?>" />
                        </div>
                    </div>
            
                    <div class="form-group">
                        <label for="last_name" class="col-sm-2 control-label">Last name:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last name" value="<?php echo $user_last_name; ?>" />
                        </div>
                    </div>
            
                        <?php
                }

                if (($user_type_acc == "media")) {
                    ?>
                    <div class="form-group">
                        <label for="company_name" class="col-sm-2 control-label">Company name:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Company name" value="<?php echo $company_name; ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ein" class="col-sm-2 control-label">EIN:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="ein" name="ein" placeholder="EIN" value="<?php echo $user_eid; ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="us_contact" class="col-sm-2 control-label">Contact:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="us_contact" name="us_contact" placeholder="Contact" value="<?php echo $user_contact; ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="us_legal" class="col-sm-2 control-label">Main legal contact:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="us_legal" name="us_legal" placeholder="Main legal contact" value="<?php echo $user_main_legal; ?>" />
                        </div>
                    </div>
                    
                    <?php
                }

                if ($user_type_acc != "user") {
                    ?>
                    <div class="form-group">
                        <label for="phone" class="col-sm-2 control-label">Phone:</label>
                        <div class="col-sm-6">
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="000-000-0000" value="<?php echo $user_phone; ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-sm-2 control-label">Address:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="<?php echo $user_address; ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="zipcode" class="col-sm-2 control-label">Zip code:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="zipcode" name="zipcode" placeholder="Zip code" value="<?php echo $zipcode; ?>" />
                        </div>
                    </div>

                    <?php
                }
                ?>

                <?php if ($user_type_acc == "cj") { ?>
                    
                    <div class="form-group">
                        <label for="paypal" class="col-sm-2 control-label">PayPal:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="paypal" name="paypal" placeholder="PayPal account" value="<?php echo $user_paypal; ?>" />
                        </div>
                    </div>
                <?php } ?>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" name="submit_acc" id="submit_acc" class="btn btn-default">Save</button>
                    </div>
                </div>
        
    </form>



    <form action="" class="form-horizontal" method="POST">
        <input type="hidden" name="saved" value="0">
        
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" id="auto_location" name="my_auto_location" value="<?php if ($user_autoloc == 1) echo "checked"; ?>" /> Use my location
                    </label>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label for="country" class="col-sm-2 control-label">Country:</label>
            <div class="col-sm-6">
                <?php
                    if ($reg_errors->errors['country']) {
                        echo '<div class="alert alert-danger">' . $reg_errors->errors['country'][0] . '</div>';
                    }
                ?>
                <input type="text" class="form-control" value="<?php if (!empty($_POST["my_country"]) && $_POST["saved"] == 1) {
                                $country_p = explode(":", $_POST["my_country"]);
                                echo $country_p[1];
                        } else {
                            echo $user_country;
                        } 
                    ?>" disabled />
                
                <select id="countryId" name="my_country" class="inp_myacc sel-loc form-control" onchange="get_states();">
                    <option>Select country</option>
                </select>
                
            </div>
        </div>
        <div class="form-group">
            <label for="State" class="col-sm-2 control-label">State:</label>
            <div class="col-sm-6">
                <?php
                    if ($reg_errors->errors['state']) {
                        echo '<div class="alert alert-danger">' . $reg_errors->errors['state'][0] . '</div>';
                    }
                ?>
                <input type="text" class="form-control" value="<?php if (!empty($_POST["my_state"]) && $_POST["saved"] == 1) {
                                $state_p = explode(":", $_POST["my_state"]);
                                    echo $state_p[1];
                                } else {
                                    echo $user_state;
                        } 
                    ?>" disabled />
                
                <select id="stateId" name="my_state" class="inp_myacc sel-loc form-control" onchange="get_cities();">
                    <option>Select country</option>
                </select>
                
            </div>
        </div>
        <div class="form-group">
            <label for="State" class="col-sm-2 control-label">City:</label>
            <div class="col-sm-6">
                <?php
                    if ($reg_errors->errors['city']) {
                        echo '<div class="alert alert-danger">' . $reg_errors->errors['city'][0] . '</div>';
                    }
                ?>
                <input type="text" class="form-control" value="<?php if (!empty($_POST["my_city"]) && $_POST["saved"] == 1) {
                                $city_p = explode(":", $_POST["my_city"]);
                                    echo $city_p[1];
                                } else {
                                    echo $user_city;
                        } 
                    ?>" disabled />
                
                <select id="cityId" name="my_city" class="inp_myacc sel-loc form-control">
                    <option>Select city</option>
                </select>
                
            </div>
        </div>
        
        <span id="change_loc">
            <span class="wb-first-t"></span> 
            <span class="wb-last-t">
                <span onclick="change_loc();" class="btn-change">click to change location</span>
            </span>
        </span><br />
                
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" name="submit_loc" id="s_a_b" class="btn btn-default" style="display: none;" value="Save" />
            </div>
        </div>
    </form>
    
    <form action="" id="save_pass" class="form-horizontal" method="POST">
            
        <div class="form-group">
            <label for="old_pass" class="col-sm-2 control-label">Old password:</label>
            <div class="col-sm-6">
                <?php
                    if ($reg_errors->errors['password']) {
                        echo '<span class="info-errors">' . $reg_errors->errors['password'][0] . '</span>';
                    }
                ?>
                <input type="password" class="form-control" id="old_pass" name="old_pass"/>
            </div>
        </div>
        
        <div class="form-group">
            <label for="old_pass" class="col-sm-3 control-label">New password:*</label>
            <div class="col-sm-6">
                <?php
                    if ($reg_errors->errors['password1']) {
                        echo '<span class="info-errors">' . $reg_errors->errors['password1'][0] . '</span>';
                    }
                ?>
                <input type="password" class="form-control" id="new_pass" name="new_pass"/>
            </div>
        </div>
        <div class="form-group">
            <label for="old_pass" class="col-sm-3 control-label">Repeat new password:*</label>
            <div class="col-sm-6">
                <?php
                    if ($reg_errors->errors['password2']) {
                        echo '<span class="info-errors">' . $reg_errors->errors['password2'][0] . '</span>';
                    }
                ?>
                <input type="password" class="form-control" id="repeat_pass" name="repeat_pass"/>
            </div>
        </div>
        
        * is required<br />
        
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">Save</button>
            </div>
        </div>
    </form>
</div>
<script>

var $ = jQuery;

$( "#auto_location" ).change(function() {
var input = $( this ).is( ":checked" );

if (input != window.auto_loc) {
	$('input[name="submit_loc"]').show();
}

if (!input && window.new_loc) {
	$('input[name="submit_loc"]').show();
}

if ((input == window.auto_loc) && (!window.new_loc)) {
	$('input[name="submit_loc"]').hide();
}

if (!input && (window.auto_loc)) {
    $('#countryId').show();
  	$('.inp-loc').hide();
  	$('input[name="saved"]').val('1');
  	get_countries();
  	$('input[name="submit_loc"]').show();
  	window.new_loc = true;	
}

if( input == true ) {
$('#change_loc').hide();
} else {
$('#change_loc').show();
}
}).change();

function change_loc(){
  if($('#countryId').is(':visible')){
  	$('.inp-loc').show();
  	$('.sel-loc').hide();
  	$('input[name="saved"]').val('0');
  	$('input[name="submit_loc"]').hide();	
  	window.new_loc = false;
  }else{
    $('#countryId').show();
  	$('.inp-loc').hide();
  	$('input[name="saved"]').val('1');
  	get_countries();
  	$('input[name="submit_loc"]').show();
  	window.new_loc = true;
  }
}

$( document ).ready(function() {
	
$( "body" ).on( "click", "#submit_acc", function(event) {
	
	$( ".errors-p" ).remove();
	var errors = false;
	
	
	var user_type = $("#user_type").val();





	
	if (user_type=='cj' || user_type=='editor') {
		var first_name = $.trim($('#first_name').val());
		var last_name = $.trim($('#last_name').val());
		
		if (first_name == '') {
			$('#first_name').before('<p class="errors-p">First name is required</p>');
			errors = true;
		}
		if (last_name == '') {

			$('#last_name').before('<p class="errors-p">Last name is required</p>');
			errors = true;
		}			
	}
	if (user_type=='media') {	
		var company_name = $.trim($('#company_name').val());
		var ein = $.trim($('#ein').val());
		var us_contact = $.trim($('#us_contact').val());
		var us_legal = $.trim($('#us_legal').val());
		
		if (company_name == '') {
			$('#company_name').before('<p class="errors-p">Company name is required</p>');
			errors = true;
		}
		if (ein == '') {
			$('#ein').before('<p class="errors-p">EIN is required</p>');
			errors = true;
		}
		if (us_contact == '') {
			$('#us_contact').before('<p class="errors-p">Contact is required</p>');
			errors = true;
		}
		if (us_legal == '') {
			$('#us_legal').before('<p class="errors-p">Main legal contact is required</p>');
			errors = true;
		}
		
	}
	
	if (user_type!='user') {
		var phone = $.trim($('#phone').val());
		var address = $.trim($('#address').val());
		var zipcode = $.trim($('#zipcode').val());
		
		if (phone == '') {
			$('#phone').before('<p class="errors-p">Phone is required</p>');
			errors = true;
		}
		if (address == '') {
			$('#address').before('<p class="errors-p">Address is required</p>');
			errors = true;
		}
		if (zipcode == '') {
			$('#zipcode').before('<p class="errors-p">Zip code is required</p>');
			errors = true;
		}
	}
	if (user_type=='cj') {
			var paypal = $.trim($('#paypal').val());
			
			if (paypal == ''){
				$('#paypal').before('<p class="errors-p">Paypal account is required</p>');
				errors = true;				
			}
	}
	
	if (errors) {
		event.stopPropagation();
		return false;
	}
});
	
  	$('input[name="submit_loc"]').hide();	
	window.auto_loc = $( "#auto_location" ).is( ":checked" );

	
var us_country = '<?php echo $user_country; ?>';
if(us_country.length == 0){
  change_loc();
}

$('#save_pass').submit(function(e){
var old = $('#old_pass').val();
var new_p = $('#new_pass').val().trim();
var repeat = $('#repeat_pass').val().trim();
if(old == "") { alert("Old password is required"); return false; }
if(new_p == "") { 
	$('#new_pass').val('');
	alert("New password is required"); return false; 
}
if(repeat == "") { 
	$('#repeat_pass').val('');
	alert("Repeat password is required"); return false; 
}
if(new_p != repeat) { alert("Password mismatch"); return false; }
});

});
</script>
<?php //do_action( 'woocommerce_before_my_account' ); ?>

<?php //wc_get_template( 'myaccount/my-downloads.php' ); ?>

<?php //wc_get_template( 'myaccount/my-orders.php', array( 'order_count' => $order_count ) ); ?>

<?php //wc_get_template( 'myaccount/my-address.php' ); ?>

<?php //do_action( 'woocommerce_after_my_account' ); ?>
