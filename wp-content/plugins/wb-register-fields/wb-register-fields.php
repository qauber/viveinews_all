<?php
/*
 * Plugin Name: WB-register-fields
 * Plugin URI: http://webbook.com.ua/
 * Description: adding additional fields in the registration
 * Version: 0.1
 * Author: Web-Book
 */

date_default_timezone_set('US/Arizona');

    function wb_countries_js() {
       wp_enqueue_script(
        'countries',
        plugins_url( '/source/location.js', __FILE__ ),
        array('jquery')
       );
    }
    add_action('wp_enqueue_scripts', 'wb_countries_js');


function custom_registration_function( $steps = 0 ) {
    if ( isset($_POST['register'] ) ) {
        $p_country = explode(":", $_POST["country"]);
        $p_state = explode(":", $_POST["state"]);
        $p_city = explode(":", $_POST["city"]);
        registration_validation(
        trim($_POST['user_type']),
        trim($_POST['email']),
        trim($_POST['password']),
        trim($_POST['confirm_password']),
        trim($_POST['login']),
        $_POST['first_name'],
        $_POST['last_name'],
        $_POST['company_name'],
        $_POST['address'],
        $_POST['phone'],
        $_POST['zipcode'],
        $p_country[1],
        $p_state[1],
        $p_city[1],
        $_POST['paypal'],
        $_POST['user_eid'],
        $_POST['contact'],
        $_POST['legal_contact'],
        //$_POST['service'],
        $_POST['acceptterms']
        );
          
        global $user_type, $email, $pass, $pass2, $login, $first, $last, $company, $address, $phone, $zip, $country, $state, $city, $paypal, $eid, $contact, $legal/*, $service*/;
        $user_type  =   sanitize_text_field( $_POST['user_type'] );
        $email      =   sanitize_email( $_POST['email'] );
        $pass       =   esc_attr( $_POST['password'] );
        $login      =   sanitize_user( $_POST['login'] );
        $first      =   sanitize_text_field( $_POST['first_name'] );
        $last       =   sanitize_text_field( $_POST['last_name'] );
        $company    =   sanitize_text_field( $_POST['company_name'] );
        $address    =   sanitize_text_field( $_POST['address'] );
        $phone      =   sanitize_text_field( $_POST['phone'] );
        $zip        =   sanitize_text_field( $_POST['zipcode'] );
        $country    =   sanitize_text_field( $p_country[1] );
        $state      =   sanitize_text_field( $p_state[1] );
        $city       =   sanitize_text_field( $p_city[1] );
        $paypal     =   sanitize_text_field( $_POST['paypal'] );
        $eid        =   sanitize_text_field( $_POST['user_eid'] );
        $contact    =   sanitize_text_field( $_POST['contact'] );
        $legal      =   sanitize_text_field( $_POST['legal_contact'] );
        //$service      =   sanitize_text_field( $_POST['service'] );
        $rett = complete_registration( $user_type, $email, $pass, $pass2, $login, $first, $last, $company, $address, $phone, $zip, $country, $state, $city, $paypal, $eid, $contact, $legal/*, $service*/ );
        if( $rett == true ) {
        echo '<h1 class="h4">Registration is complete</h1>';
        
        if ($user_type == 'editor') {
			echo "<div style='color:#34BA3F;font-size: 20px;'>Currently your account is waiting approval. You will receive an email notification confirming your registration.</div>";
		} else {
			echo "<div style='color:#34BA3F;font-size: 20px;'>Activate your account and go to the page <a href='/login/'>Login</a></div>";	
		}
        
        
        $steps = 1;
        }
    }
    if( $steps == 0 ) {
    if( $rett == false ) {
    echo '<h1 class="h4">Create a New Account</h1>';
    }
    registration_form( $user_type, $email, $pass, $pass2, $login, $first, $last, $company, $address, $phone, $zip, $country, $state, $city, $paypal, $eid, $contact, $legal/*, $service*/ );
    }
}

function registration_form( $user_type, $email, $pass, $pass2, $login, $first, $last, $company, $address, $phone, $zip, $country, $state, $city, $paypal, $eid, $contact, $legal/*, $service*/ ) {
global $reg_errors;
echo '
<style>
::-webkit-input-placeholder { color: #6D6C6C !important;text-align: center; }
:-moz-placeholder { color: #6D6C6C !important;text-align: center; }
::-moz-placeholder { color: #6D6C6C !important;text-align: center; }
:-ms-input-placeholder { color: #6D6C6C !important;text-align: center; }
p.errors-p {
    font-size: 14px;
    color: #FF0000;
    line-height: 0.2em;
}


.modalDialog {
	position: fixed;
	font-family: Arial, Helvetica, sans-serif;
	top: 0;
	right: 0;
	bottom: 0;
	left: 0;
	background: rgba(0,0,0,0.4);
	z-index: 99999;
	opacity:0;
	-webkit-transition: opacity 400ms ease-in;
	-moz-transition: opacity 400ms ease-in;
	transition: opacity 400ms ease-in;
	pointer-events: none;
}
.modalDialog > div {
    background: #fff;
    border: 1px solid #000;
    border-radius: 10px;
    margin: 10% auto;
    padding: 5px 20px 13px;
    position: relative;
    width: 80%;
    height: 80%;
    overflow: auto;
}
.close {
	background: #D64644;
	color: #FFFFFF;
	line-height: 25px;
	position: absolute;
	right: 5px;
	text-align: center;
	top: 5px;
	width: 24px;
	text-decoration: none;
	font-weight: bold;
	-webkit-border-radius: 12px;
	-moz-border-radius: 12px;
	border-radius: 12px;
	-moz-box-shadow: 1px 1px 3px #000;
	-webkit-box-shadow: 1px 1px 3px #000;
	box-shadow: 1px 1px 3px #000;
}
.close:hover { background: #CE0300; cursor:pointer; }
.next-btn {
    background: #27b8ce none repeat scroll 0 0;
    border: 1px solid #ccc;
    border-radius: 5px;
    cursor: pointer;
    float: right;
    padding: 5px 15px;
}
.next-btn:hover {
    background: #21A8BC;
}
</style>
    <form action="' . $_SERVER['REQUEST_URI'] . '" method="post" id="registration-form">
    <div class="form-group">
        <label for="reg_user_type">Account type</label>';
    if( $reg_errors->errors["type_user"][0] != NULL ){
       echo "<p class='errors-p'>" . $reg_errors->errors["type_user"][0] . "</p>";
    }
echo '<select name="user_type" id="i-e-type" onchange="choise_type(this.value);" class="form-control">
         <option value="user"'; if( isset( $_POST['user_type'] ) && $_POST['user_type'] == "user" ) echo " selected";  echo '>User</option>
         <option value="editor"'; if( isset( $_POST['user_type'] ) && $_POST['user_type'] == "editor" ) echo " selected";  echo '>Editor</option>
         <option value="media"'; if( isset( $_POST['user_type'] ) && $_POST['user_type'] == "media" ) echo " selected";  echo '>Media</option>
         <option value="cj"'; if( isset( $_POST['user_type'] ) && $_POST['user_type'] == "cj" ) echo " selected"; echo '>Citizen Journalist</option>
        </select>
    </div>
    <div class="form-group">
        <label for="reg_email">Email address <span class="required">*</span></label>';
    if( $reg_errors->errors["email"][0] != NULL ){
       echo "<p class='errors-p'>" . $reg_errors->errors["email"][0] . "</p>";
    }
echo '<input type="email" class="form-control" name="email" id="reg_email" value="' . ( isset( $_POST['email'] ) ? $email : null ) . '" />
        </div>
        <div class="form-group">
          <label for="reg_password">Password <span class="required">*</span></label>';
    if( $reg_errors->errors["password"][0] != NULL ){
       echo '<p class="errors-p" id="e-pass">' . $reg_errors->errors["password"][0] . '</p>';
    }
echo '<input type="password" class="form-control" name="password" id="reg_password" value="' . ( isset( $_POST['password'] ) ? $pass : null ) . '" />
      </div>
      <div class="form-group">
        <label for="confirm_password">Confirm password <span class="required">*</span></label>';
    if( $reg_errors->errors["password2"][0] != NULL ){
       echo "<p class='errors-p'>" . $reg_errors->errors["password2"][0] . "</p>";
    }
echo '<input type="password" name="confirm_password" id="creg_password" class="form-control" value="' . ( isset( $_POST['confirm_password'] ) ? $pass2 : null ) . '">
    </div>
    <div class="form-group">
        <label for="login">User Name <span class="required">*</span></label>';
    if( $reg_errors->errors["login"][0] != NULL ){
       echo "<p class='errors-p'>" . $reg_errors->errors["login"][0] . "</p>";
    }

echo '<input type="text" name="login" id="i-e-name" class="form-control" value="' . ( isset( $_POST['login'] ) ? $login : null ) . '" />
        </div>

    <div id="user-type-data"></div>';
?>
<p>* required fields</p>
<?php
if( $reg_errors->errors["acceptterms"][0] != NULL ){
    echo "<p class='errors-p'>" . $reg_errors->errors["acceptterms"][0] . "</p>";
}
?>
<!--<span style="color:#2F5FBF;font-size:14px;text-decoration:underline; cursor:pointer;" onclick="get_terms();"> I have read and accept the terms of service.</span>-->
<div id="terms-modal" class="modalDialog">
	<div>
		<span title="Close" class="close" onclick="close_terms_window();">X</span>
        <h3>Terms of Service</h3>
         <p>
License Agreement:<br />
The following shall constitute the Agreement made between the below named ("Licensor") and KGO Television, Inc., located at ABC7 Broadcast Center, 900 Front Street, San Francisco, CA 94111 ("Licensee").<br />
1. Licensor hereby grants to Licensee a non-exclusive license to use still pictures and digital video files and such other materials as may be submitted by Licensor hereunder (collectively, "the Footage"). Licensor hereby grants to Licensee the right to include the Footage (as provided by Licensor and/or as edited by Licensee) as well as the name of the Licensor (and copyright owner, if different than Licensor) in all programming and on the websites produced by Licensee, ABC News, its affiliates and other entities licensed to distribute ABC News programming worldwide in all media now known and hereafter conceived or created, including, without limitation, home video and Internet, and on-air promotion and advertising relating thereto, in perpetuity. Licensee acknowledges that it will receive no compensation for the rights herein.<br />
2. In connection with the Footage, Licensor warrants and represents for the benefit of Licensee that:<br /><br />
    a. He or she is 18-years of age or older, and has the right to enter into and perform this Agreement and to grant Licensee all the rights granted herein in that he or she either owns the Footage or controls the exhibition and distribution rights thereto; and<br />
    b. There are no agreements, nor shall Licensor enter into any agreements, which would prevent the fulfillment of this Agreement or impair or conflict with the rights granted hereunder; and<br />
    c. Neither the Footage, nor the production or use of the Footage or any element of the Footage hereunder, will infringe on any trademark or trade name of, or violate any right of privacy or any other right of another person, firm, corporation or other entity; and<br />
    d. The events depicted in the Footage are real and not staged and are as described by Licensor, and the Licensor represents that he or she has not violated any law, rule, or regulation in connection with the creation or distribution of the Footage.
	     </p>
         <p style="border-top: 1px solid #ccc;padding: 10px;"><input type="checkbox" name="acceptterms" value="true" id="acceptterms"<?php if(isset($_POST["acceptterms"])) echo " checked";?> /> I accept the terms and conditions above <span class="btn btn-default" onclick="close_terms_window();">Next</span></p>
	</div>
</div>
<p class="form-row"><input type="submit" class="btn btn-default" name="register" value="Next" /></p>
</form>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.0.min.js"></script>
<script>
jQuery(function($){
	$(document).mouseup(function (e){
        if($('#terms-modal').css('opacity') == 1){
		var div = $("#terms-modal > div");
		 if (!div.is(e.target)
		    && div.has(e.target).length === 0) {
			close_terms_window();
		 }
        }
	});
});

$( document ).ready(function() {
elm = $('[name="user_type"]').val();
if( elm == null) elm = "user";
choise_type( elm );

$('#registration-form').submit(function(){
    $('.errors-p').remove();
var errors = 0;
var check = $('#acceptterms').is(':checked') ? 1 : 0;
var elm = $('[name="user_type"]').val();
var email = $('#reg_email').val();
var pass = $('#reg_password').val();
var cpass = $('#creg_password').val();
var name = $('#i-e-name').val();
if(elm == "media"){
   var company = $('#i-e-company').val();
}
if(elm == "editor" | elm == "cj"){
   var first = $('#i-e-first').val();
   var last = $('#i-e-last').val();  
}
if(elm == "editor" | elm == "media" | elm == "cj"){
   var address = $('#i-e-address').val();
   var zip = $('#i-e-zip').val();
   var country = $('#countryId').val();
   var state = $('#stateId').val();
   var phone = $('#i-e-phone').val();
}
if(elm == "cj"){
   var paypal = $('#i-e-paypal').val();
}
if(elm == "media"){
   var ein = $('#i-e-ein').val();
   var contact = $('#i-e-contact').val();
   var mlc = $('#i-e-mlc').val();
}
var chech_num = /^[0-9]+$/;
var check_phone = /^([0-9]{3})-([0-9]{3})-([0-9]{4})/;
var email_regex = /^(([^<>()[\]\\.,;:\s@*&\^%$#!"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

if(email == ''){ $('#reg_email').before('<p class="errors-p">Email address is required</p>'); errors++; }
else if (!email_regex.test(email)) {
	$('#reg_email').before('<p class="errors-p">Invalid email address</p>'); errors++;
}

if(pass == ''){ $('#reg_password').before('<p class="errors-p">Password is required</p>'); errors++; }
  else if(5 > pass.length){ $('#reg_password').before('<p class="errors-p">Password length must be greater than 5</p>'); errors++; }
if(cpass == ''){ $('#creg_password').before('<p class="errors-p">Password confirmation is required</p>'); errors++; }
  else if(5 > cpass.length){ $('#creg_password').before('<p class="errors-p">Confirm password length must be greater than 5</p>'); errors++; }
  else if(pass != cpass){ $('#creg_password').before('<p class="errors-p">Password mismatch</p>'); errors++; }
if(name == ''){ $('#i-e-name').before('<p class="errors-p">Username name is required</p>'); errors++; }
  else if(4 > name.length){ $('#i-e-name').before('<p class="errors-p">Username is too short. At least 4 characters are required</p>'); errors++; }
if(elm == "media"){
   if(company == ''){ $('#i-e-company').before('<p class="errors-p">Company name is required</p>'); errors++; }
}
if(elm == "editor" | elm == "cj"){
   if(first == ''){ $('#i-e-first').before('<p class="errors-p">First name is required</p>'); errors++; }
   if(last == ''){ $('#i-e-first').before('<p class="errors-p">Last name is required</p>'); errors++; }
}
if(elm == "editor" | elm == "media" | elm == "cj"){
   if(address == ''){ $('#i-e-address').before('<p class="errors-p">Address is required</p>'); errors++; }
   if(zip == ''){ $('#i-e-zip').before('<p class="errors-p">Zip code is required</p>'); errors++; }
   	else if(!chech_num.test(zip) || ((zip.length != 5) && (zip.length != 6))){ $('#i-e-zip').before('<p class="errors-p">Zip code not valid</p>'); errors++; }
   if(country == ''){ $('#countryId').before('<p class="errors-p">Country is required</p>'); errors++; }
   if(state == ''){ $('#stateId').before('<p class="errors-p">State is required</p>'); errors++; }
   if(phone == ''){ $('#i-e-phone').before('<p class="errors-p">Phone is required</p>'); errors++; }
   	else if(!check_phone.test(phone)){ $('#i-e-phone').before('<p class="errors-p">Phone not valid</p>'); errors++; }
}
if(elm == "cj"){
   if(paypal == ''){ $('#i-e-paypal').before('<p class="errors-p">Paypal is required</p>'); errors++; }
}
if(elm == "media"){
   if(ein == ''){ $('#i-e-ein').before('<p class="errors-p">EIN is required</p>'); errors++; }
   if(contact == ''){ $('#i-e-contact').before('<p class="errors-p">Contact is required</p>'); errors++; }
   if(mlc == ''){ $('#i-e-mlc').before('<p class="errors-p">Main legal contact is required</p>'); errors++; }
}
if(errors > 0){
    return false;
} else {
 if(check == 0){
    get_terms();
    return false;
}   
}
});

});
function get_terms(){
    $('#terms-modal').css({'opacity':'1','pointer-events':'auto'});
}
function close_terms_window(){
    var check = $('#acceptterms').is(':checked') ? 1 : 0;
    var type_us = $('#i-e-type').val();
    if(check == 0){
        $('input[type="text"]').prop("readonly",false).css('background','#FFFFFF');
        $('input[type="email"]').prop("readonly",false).css('background','#FFFFFF');
        $('input[type="password"]').prop("readonly",false).css('background','#FFFFFF');
        $('#i-e-type').prop("disabled",false).attr('name','user_type').css('background','#FFFFFF');
        $('input[type="submit"]').val('Next');
        alert("In order to use our services, you must agree to our Terms of Service.");
    }
        $('#terms-modal').css({'opacity':'0','pointer-events':'none'});
    if(check == 1){  
        $('input[type="text"]').prop("readonly",true).css('background','#E8E8E8');
        $('input[type="email"]').prop("readonly",true).css('background','#E8E8E8');
        $('input[type="password"]').prop("readonly",true).css('background','#E8E8E8');
        $('#i-e-type').prop("disabled",true).removeAttr('name').css('background','#E8E8E8');
        $('<input type="hidden" name="user_type" value="'+type_us+'" />').insertAfter($('#i-e-type'));
        $('input[type="submit"]').val('Submit');
        // document.getElementById('registration-form').submit();
    }
}

function choise_type( data ) {
var content = "";
if( data == "editor" | data == "cj" ) {
content = content + '<div class="form-group">' +
'<label for="first_name">Name <span class="required">*</span></label><br />' +
<?php if( $reg_errors->errors["first"][0] != NULL || $reg_errors->errors["last"][0] != NULL){ ?>
'<p class="errors-p"><?php echo $reg_errors->errors["first"][0] .' '.$reg_errors->errors["last"][0];?></p>' +
<?php } ?>
'<input type="text" name="first_name" id="i-e-first" class="form-control" placeholder="First" style="width:142px !important;display: inline-block;" value="<?php echo ( isset( $_POST['first_name'] ) ? $first : null ); ?>" />' +
'<input type="text" name="last_name" id="i-e-last" class="form-control" placeholder="Last" style="width:142px !important;margin-left:5px ; display: inline-block" value="<?php echo ( isset( $_POST['last_name'] ) ? $last : null ); ?>" /></div>';
}
/*
if( data == "editor" | data == "cj" ) {
content = content + '<div class="form-group">' +
'<label for="last_name">Last name <span class="required">*</span></label>' +
'<input type="text" name="last_name" class="form-control" value="<?php echo ( isset( $_POST['last_name'] ) ? $last : null ); ?>" /></div>';
}
*/
if( data == "media" ) {
content = content + '<div class="form-group">' +
'<label for="company_name">Company name <span class="required">*</span></label>' +
<?php if( $reg_errors->errors["company"][0] != NULL ){ ?>
'<p class="errors-p"><?php echo $reg_errors->errors["company"][0];?></p>' +
<?php } ?>
'<input type="text" name="company_name" id="i-e-company" class="form-control" value="<?php echo ( isset( $_POST['company_name'] ) ? $company : null ); ?>" /></div>';
}
if( data == "editor" | data == "cj" | data == "media" ) {
content = content + '<div class="form-group">' +
'<label for="address">Address <span class="required">*</span></label>' +
<?php if( $reg_errors->errors["address"][0] != NULL ){ ?>
'<p class="errors-p"><?php echo $reg_errors->errors["address"][0];?></p>' +
<?php } ?>
'<input type="text" name="address" id="i-e-address" class="form-control" value="<?php echo ( isset( $_POST['address'] ) ? $address : null ); ?>" /></div>';
}
if( data == "editor" | data == "cj" | data == "media" ) {
content = content + '<div class="form-group">' +
'<label for="phone">Phone <span class="required">*</span></label>' +
<?php if( $reg_errors->errors["phone"][0] != NULL ){ ?>
'<p class="errors-p"><?php echo $reg_errors->errors["phone"][0];?></p>' +
<?php } ?>
'<input type="tel" name="phone" id="i-e-phone" class="form-control" value="<?php echo ( isset( $_POST['phone'] ) ? $phone : null ); ?>" placeholder="000-000-0000" /></div>';
}
if( data == "editor" | data == "cj" | data == "media" ) {
content = content + '<div class="form-group">' +
'<label for="zipcode">Zip code <span class="required">*</span></label>' +
<?php if( $reg_errors->errors["zip"][0] != NULL ){ ?>
'<p class="errors-p"><?php echo $reg_errors->errors["zip"][0];?></p>' +
<?php } ?>
'<input type="text" name="zipcode" id="i-e-zip" class="form-control" value="<?php echo ( isset( $_POST['zipcode'] ) ? $zip : null ); ?>" /></div>';
}
if( data == "editor" | data == "cj" | data == "media" ) {
content = content + '<div class="form-group">' +
'<label for="country">Country <span class="required">*</span></label>' +
<?php if( $reg_errors->errors["country"][0] != NULL ){ ?>
'<p class="errors-p"><?php echo $reg_errors->errors["country"][0];?></p>' +
<?php } ?>
'<select id="countryId" name="country" class="form-control" onchange="get_states();">' +
<?php
if(isset( $_POST['country'] )){
    $savecountry = explode(':', $_POST['country']);
?>
'<option value="<?php echo $savecountry[0];?>"><?php echo $savecountry[1];?></option></select>';
<?php
}else{
?>
'<option value="">Select country</option></select>';
<?php } ?>
}
if( data == "editor" | data == "cj" | data == "media" ) {
<?php if(isset( $_POST['state'] )){ ?>
   content = content + '<p class="form-row form-row-wide" id="show-state">' +
<?php }else{ ?>
   content = content + '<p class="form-row form-row-wide" id="show-state" style="display:none;">' +
<?php } ?>
'<label for="state">State <span class="required">*</span></label>' +
<?php if( $reg_errors->errors["state"][0] != NULL ){ ?>
'<p class="errors-p"><?php echo $reg_errors->errors["state"][0];?></p>' +
<?php } ?>
'<select id="stateId" name="state" class="form-control" onchange="get_cities();">' +
<?php
if(isset( $_POST['state'] )){
    $savestate = explode(':', $_POST['state']);
?>
'<option value="<?php echo $savestate[0];?>"><?php echo $savestate[1];?></option></select>';
<?php
}else{
?>
'<option value="">Select state</option></select>';
<?php } ?>
}
if( data == "editor" | data == "cj" | data == "media" ) {
<?php if(isset( $_POST['city'] )){ ?>
    content = content + '<p class="form-row form-row-wide" id="show-city">' +
<?php }else{ ?>
    content = content + '<p class="form-row form-row-wide" id="show-city" style="display:none;">' +
<?php } ?>  
'<label for="city">City <span class="required">*</span></label>' +
<?php if( $reg_errors->errors["city"][0] != NULL ){ ?>
'<p class="errors-p"><?php echo $reg_errors->errors["city"][0];?></p>' +
<?php } ?>
'<select id="cityId" name="city" class="form-control">' +
<?php
if(isset( $_POST['city'] )){
    $savecity = explode(':', $_POST['city'])
?>
'<option value="<?php echo $savecity[0];?>"><?php echo $savecity[1];?></option></select>';
<?php
}else{
?>
'<option value="">Select city</option></select>';
<?php } ?>
}
if( data == "cj" ) {
content = content + '<div class="form-group">' +
'<label for="paypal">Paypal account <span class="required">*</span></label>' +
<?php if( $reg_errors->errors["paypal"][0] != NULL ){ ?>
'<p class="errors-p"><?php echo $reg_errors->errors["paypal"][0];?></p>' +
<?php } ?>
'<input type="text" name="paypal" id="i-e-paypal" class="form-control" value="<?php echo ( isset( $_POST['paypal'] ) ? $paypal : null ); ?>" /></div>';
}
if( data == "media" ) {
content = content + '<div class="form-group">' +
'<label for="user_eid">Employer Identification Number <span class="required">*</span></label>' +
<?php if( $reg_errors->errors["eid"][0] != NULL ){ ?>
'<p class="errors-p"><?php echo $reg_errors->errors["eid"][0];?></p>' +
<?php } ?>
'<input type="text" name="user_eid" id="i-e-ein" class="form-control" placeholder="EIN" value="<?php echo ( isset( $_POST['user_eid'] ) ? $eid : null ); ?>" /></div>';
}
if( data == "media" ) {
content = content + '<div class="form-group">' +
'<label for="contact">Contact <span class="required">*</span></label>' +
<?php if( $reg_errors->errors["contact"][0] != NULL ){ ?>
'<p class="errors-p"><?php echo $reg_errors->errors["contact"][0];?></p>' +
<?php } ?>
'<textarea name="contact" id="i-e-contact" style="padding-top: 8px;" class="form-control"><?php echo ( isset( $_POST['contact'] ) ? $contact : null ); ?></textarea></div>';
}
if( data == "media" ) {
content = content + '<div class="form-group">' +
'<label for="legal_contact">Main legal contact <span class="required">*</span></label>' +
<?php if( $reg_errors->errors["legal"][0] != NULL ){ ?>
'<p class="errors-p"><?php echo $reg_errors->errors["legal"][0];?></p>' +
<?php } ?>
'<textarea name="legal_contact" id="i-e-mlc" style="padding-top: 8px;" class="form-control"><?php echo ( isset( $_POST['legal_contact'] ) ? $legal : null ); ?></textarea></div>';
}
if( data == "editor" | data == "cj" | data == "media" ) {
/*content = content + '<div class="form-group">' +
'<label for="legal_contact">Term of Service <span class="required">*</span></label>' +
<?php if( $reg_errors->errors["service"][0] != NULL ){ ?>
'<p class="errors-p"><?php echo $reg_errors->errors["service"][0];?></p>' +
<?php } ?>
'<textarea name="service" style="padding-top: 8px;" class="form-control"><?php echo ( isset( $_POST['service'] ) ? $legal : null ); ?></textarea></div>';*/
  get_countries();
}
$('#user-type-data').html( content );
}
</script>
<?php
}

function registration_validation( $user_type, $email, $pass, $pass2, $login, $first, $last, $company, $address, $phone, $zip, $country, $state, $city, $paypal, $eid, $contact, $legal/*, $service*/, $acceptterms )  {
 global $reg_errors;
 $reg_errors = new WP_Error;
 $type_arr = array( "user", "editor", "cj", "media" );
 
 if ( !in_array( $user_type, $type_arr ) )
    $reg_errors->add('type_user', 'Incorrectly selected user type');
 
 if ( empty( $email ) ) {
    $reg_errors->add('email', 'Email address is required');
 
 } elseif ( !is_email( $email ) ) {
    $reg_errors->add( 'email', 'Invalid email' );
 
 }elseif ( email_exists( $email ) ) {
    $reg_errors->add( 'email', 'Email Already in use' );
    
 }
 
 if ( empty( $pass ) ) {
    $reg_errors->add( 'password', 'Password is required' );
 
 } elseif ( 5 > strlen( $pass ) ) {
    $reg_errors->add( 'password', 'Password length must be greater than 5' );
    
 }
   
 if ( empty( $pass2 ) ) {
    $reg_errors->add( 'password2', 'Password confirmation is required' );
 
 } elseif ( 5 > strlen( $pass2 ) ) {
    $reg_errors->add( 'password2', 'Confirm password length must be greater than 5' );
 
 } elseif ( $pass != $pass2 ) {
    $reg_errors->add('password2', 'Password mismatch');
    
 }
 
 if ( empty( $login ) ) {
    $reg_errors->add( 'login', 'Username name is required' );

 } elseif ( 4 > strlen( $login ) ) {
    $reg_errors->add( 'login', 'Username is too short. At least 4 characters are required' );
 
 } elseif ( username_exists( $login ) ) {
    $reg_errors->add('login', 'Sorry, that username already exists!');
    
 } elseif ( ! validate_username( $login ) ) {
    $reg_errors->add( 'login', 'Sorry, the username you entered is not valid' );
    
 }

 if ( $user_type == "editor" || $user_type == "cj" ) {
    if ( empty( $first ) ) 
       $reg_errors->add( 'first', 'First name is required' );
       
    if ( empty( $last ) ) 
       $reg_errors->add( 'last', 'Last name is required' );
 }
 
 if ( $user_type == "editor" || $user_type == "cj" || $user_type == "media" ) {
    if ( empty( $address ) ) 
       $reg_errors->add( 'address', 'Address is required' );
    
    if ( empty( $zip ) ) {
       $reg_errors->add( 'zip', 'Zip code is required' );
       
    } elseif ( !is_numeric( $zip ) || !preg_match('/^([0-9]{5,6})(-[0-9]{4})?$/i', $zip)) {
       $reg_errors->add( 'zip', 'Invalid zip code' );
    }
       
    if ( empty( $country ) ) {
       $reg_errors->add( 'country', 'Country is required' );
    } elseif ( empty( $state ) ) {
       $reg_errors->add( 'state', 'State is required' );
    }

    if ( empty( $phone ) ) {
       $reg_errors->add( 'phone', 'Phone is required' );
       
    } elseif ( preg_match("/^\D?(\d{3})?\D?\D?(\d{3})?\D?(\d{4,5})$/", $phone ) == 0 ) {
       $reg_errors->add( 'phone', 'Invalid phone number' );
    
    }

    //if ( empty( $service ) ) 
    //   $reg_errors->add( 'service', 'Term of Service is required' );
 }

 if ( $user_type == "cj" ) {
    if ( empty( $paypal ) ) {
       $reg_errors->add( 'paypal', 'PayPal is required' );
       
    } elseif ( !is_email( $paypal ) ) {
       $reg_errors->add( 'paypal', 'Invalid PayPal' );
    
    }
 }  
 
 if ( $user_type == "media" ) {
    if ( empty( $company ) ) 
       $reg_errors->add( 'company', 'Company is required' );
       
    if ( empty( $eid ) ) {
       $reg_errors->add( 'eid', 'EIN is required' );
    } elseif(!preg_match('#^\d{1,2}-\d{7,9}$#',$eid)){
       $reg_errors->add( 'eid', 'Invalid EIN' );
    }
       
    if ( empty( $contact ) ) 
       $reg_errors->add( 'contact', 'Contact is required' );
       
    if ( empty( $legal ) ) 
       $reg_errors->add( 'legal', 'Main legal contact is required' );
 } 
    if ( $acceptterms != true ) 
      $reg_errors->add( 'acceptterms', 'Terms of service is not exists yet.' );
}

function complete_registration() {
    global $reg_errors,$user_type, $email, $pass, $login, $first, $last, $company, $address, $phone, $zip, $country, $state, $city, $paypal, $eid, $contact, $legal/*, $service*/;
     if (is_wp_error($reg_errors) && count($reg_errors->get_error_messages()) > 0) {
       return false;
     } else {
        $date_reg = date('Y-m-d H:i:s');
        $userdata = array(
        'user_login'      =>   $login,
        'user_email'      =>   $email,
        'user_pass'       =>   $pass,
        'first_name'      =>   $first,
        'last_name'       =>   $last,
        'user_registered' =>   $date_reg
        );
        
        //$_REQUEST['action'] = 'createuser';
        
        $user_id = wp_insert_user( $userdata );
        
        if ($user_type != 'editor') {
			update_user_meta( $user_id, 'pw_user_status', 'approved' );	
		}
        
        
        update_user_meta($user_id, 'user_type', $user_type);
        update_user_meta($user_id, 'auto_location', '0');
        if( $user_type == "editor" ||  $user_type == "cj" || $user_type == "media" ) {
        update_user_meta($user_id, '_us_address', $address);
        update_user_meta($user_id, '_us_phone', $phone);
        update_user_meta($user_id, '_us_zip_code', $zip);
        update_user_meta($user_id, '_us_country', $country);
        update_user_meta($user_id, '_us_state', $state);
        update_user_meta($user_id, '_us_city', $city);
        }
        if( $user_type == "cj" ) {
        update_user_meta($user_id, '_us_paypal', $paypal);
        update_user_meta($user_id, 'become_a_vendor', 'vendor_approved' );
          update_user_meta($user_id, 'become_a_vendor_status', 'Approved' );
        }
        if( $user_type == "media" ) {
        update_user_meta($user_id, '_us_company', $company);
        update_user_meta($user_id, '_us_user_eid', $eid);
        update_user_meta($user_id, '_us_contact', $contact);
        update_user_meta($user_id, '_us_user_legal', $legal);
        }

        
        if ($user_type != 'editor') {
	        # send email
	        wb_new_user_notification($user_id, $pass);
		}
        
       return true;
    }
}


add_shortcode('wb_registration_fields', 'custom_registration_shortcode');

function custom_registration_shortcode() {
    ob_start();
    custom_registration_function();
    return ob_get_clean();
}

function wb_new_user_notification($user_id, $plaintext_pass = '') {
    $user = get_userdata( $user_id );
    $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
    $code = sha1( $user_id . time() );
    $activation_link = add_query_arg( array( 'key' => $code, 'user' => $user_id ), get_permalink( "2448" ));
    add_user_meta( $user_id, 'has_to_be_activated', $code, true );
    

    $message .= "Here is your activation link: " . $activation_link; 
    wp_mail($user->user_email, 'Activation on ' . $blogname, $message);
    /*
    $message   = sprintf(__('New registration %s:'), $blogname) . "\r\n\r\n";
    $message  .= sprintf(__('Username: %s'), $user->user_login) . "\r\n";
    if ( empty($plaintext_pass) ){
      $message .= sprintf(__('Password: %s'), $plaintext_pass) . "\r\n";
    }
    $message  .= "<a href='http://liveinews.com/login'>http://liveinews.com/login</a>\r\n";

    wp_mail($user->user_email, sprintf(__('[%s] New registration info: '), $blogname), $message);
    */
}