<?php
/**
 * Login Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.6
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
wp_safe_redirect( '/login/' );
   exit();
?>
<style>
.input-text {
  width: 290px !important;
  color: #000000 !important;
}
label.inline {
    margin-left: 10px;
}
p.lost_password a {
  display: inline-block !important;
}
h4 {
  margin-top:-30px;
  color:#000;
}
.wb-reg-link a {
	font-size:18px;
	color:#0091C9;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
<?php 
wc_print_notices();
//$all_notices  = WC()->session->get( 'wc_notices', array() );
//$notice_types = apply_filters( 'woocommerce_notice_types', array( 'error', 'success', 'notice' ) );


do_action( 'woocommerce_before_customer_login_form' );
if( $_GET["act"] != "reg" ) {
?>
		<h1 class="h4"><?php _e( 'Sign in', 'woocommerce' ); ?></h1>
		<form method="post" class="login">

			<?php do_action( 'woocommerce_login_form_start' ); ?>

			<p class="form-row form-row-wide">
				<label for="username"><?php _e( 'Username or email address', 'woocommerce' ); ?> <span class="required">*</span></label>
				<input type="text" class="input-text" name="username" id="username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
			</p>
			<p class="form-row form-row-wide">
				<label for="password"><?php _e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
				<input class="input-text" type="password" name="password" id="password" value="" />
			</p>
<?php do_action( 'woocommerce_login_form' ); ?>

			<p class="form-row">
			<label for="rememberme" class="inline">
					<input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php _e( 'Remember me', 'woocommerce' ); ?>
				</label>
			</p>
			<p class="form-row">
			<?php wp_nonce_field( 'woocommerce-login' ); ?>
				<input type="submit" class="button" name="login" value="<?php _e( 'Login', 'woocommerce' ); ?>" /> 
				<span class="lost_password">
				<a href="<?php echo esc_url( wc_lostpassword_url() ); ?>"><?php _e( 'Forgot your password?', 'woocommerce' ); ?></a>
			  </span>
			    <div class="wb-reg-link">
			      <a href="/register">Don't have an account yet? Register now!</a>
			    </div>
			</p>

			<?php do_action( 'woocommerce_login_form_end' ); ?>

		</form>
<?php
} else {
	# new reg
custom_registration_function(); 
?>
<!---
	
		<form method="post" class="register">
      <p class="form-row form-row-wide">
        <label for="reg_user_type">User type</label>
        <select name="reg_user_type" onchange="choise_type(this.value);" class="input-text">
         <option value="user">User</option>
         <option value="editor">Editor</option>
         <option value="media">Media</option>
         <option value="cj">CJ</option>
        </select>
      </p>
			<?php do_action( 'woocommerce_register_form_start' ); ?>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

				<p class="form-row form-row-wide">
					<label for="reg_username"><?php _e( 'Username', 'woocommerce' ); ?> <span class="required">*</span></label>
					<input type="text" class="input-text" name="username" id="reg_username" value=" " />
				</p>

			<?php endif; ?>

			<p class="form-row form-row-wide">
				<label for="reg_email"><?php _e( 'Email address', 'woocommerce' ); ?> <span class="required">*</span></label>
				<input type="email" class="input-text" name="email" id="reg_email" value=" " />
			</p>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

				<p class="form-row form-row-wide">
					<label for="reg_password"><?php _e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
					<input type="password" class="input-text" name="password" id="reg_password" value="" />
				</p>
        <p class="form-row form-row-wide">
					<label for="confirm_password">Confirm password <span class="required">*</span></label>
					<input type="password" name="confirm_password" class="input-text">
        </p>
			<?php 
			endif;
 ?>
			<div style="<?php echo ( ( is_rtl() ) ? 'right' : 'left' ); ?>: -999em; position: absolute;"><label for="trap"><?php _e( 'Anti-spam', 'woocommerce' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>

			<?php 
			do_action( 'woocommerce_register_form' );
			do_action( 'register_form' ); 
			?>

			<p class="form-row">
				<?php wp_nonce_field( 'woocommerce-register' ); ?>
				<input type="submit" class="button" name="register" value="<?php _e( 'Register', 'woocommerce' ); ?>" />
			</p>

			<?php do_action( 'woocommerce_register_form_end' ); ?>

		</form>-->
<?php 
}
do_action( 'woocommerce_after_customer_login_form' ); ?>