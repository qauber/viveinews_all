<?php
/*
 * Plugin Name: wb-login
 * Plugin URI: http://webbook.com.ua/
 * Description: login
 * Version: 0.1
 * Author: Web-Book
 */


class wb_login
{

    public function __construct(){
        add_shortcode( 'wb-login-form', array( $this, 'wb_get_login_form' ) );
    }

    public function wb_get_login_form($error_us = '', $error_p = '') {
      $action  = (isset($_GET['action']) ) ? $_GET['action'] : 0;

      if ( $action === md5("failedl") ) {
        $error_us = 'Invalid Username/Email or Password.';
      } elseif ( $action === md5("faileda") ) {
        $error_us = 'User is not activated.';
      } elseif ( $action === md5("failed") ) {
        $error_us = 'Email or username is required.';
      } elseif( $action === md5("empty") ) {
        $error_us = 'Email or username is required.';
        $error_p = 'Password is required.';
      } elseif ( $action === md5("username") ) {
        $error_us = 'Email or username is required.';
      } elseif ( $action === md5("password") ) {
        $error_p = 'Password is required.';
      } elseif ( $action === md5("false") ) {
        $error_p = 'You are logged out';
      }

      ?>
<div class="col-sm-5">
       <h1 class="h4">Sign in</h1>
       
        <form name="loginform" action=" <?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ) ?>" method="post" class="login">
            <div class="form-group">
                <label for="log">Username or email address <span class="required">*</span></label><br />
               <?php if($error_us!=''){ ?>
                        <span class="info-error"> <?php echo $error_us;  ?> </span><br />
              <?php } ?> 
                
                <input type="text" class="form-control" name="log" class="input-text" value="" size="20" />
            </div>
            
            <div class="form-group">
                <label for="pwd">Password <span class="required">*</span></label><br />
                <?php if($error_p !=''){ ?>
                <span class="info-error"> <?php echo $error_p; ?> </span><br />
               <?php } ?>
                <input type="password" class="form-control" name="pwd" class="input-text" value="" size="20" />
            </div>

            <div class="checkbox">
                <label>
                    <input name="rememberme" type="checkbox" value="forever" /> Remember Me
                </label>
            </div>
            
            
            <button type="submit" name="wp-submit" class="btn btn-default" > Log In </button>
                <input type="hidden" name="redirect_to" value="<?php echo $_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : '/my-account' ?>" />
                <span class="lost_password">
                <a href=" <?php echo esc_url( wc_lostpassword_url() ); ?>">Forgot your password?</a>
              </span>
          
        </form>
    </div>

<div class="col-sm-offset-2 col-sm-5">
    <?php echo do_shortcode('[wb_registration_fields]'); ?>
    
</div>
        <?php
    }
}


$login_cls = new wb_login();