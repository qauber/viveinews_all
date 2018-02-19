<?php


require(TEMPLATEPATH . '/framework/inc/custom-widgets.php');



//login action
add_action( 'wp_ajax_nopriv_bg_login', 'bg_login' ) ;
add_action( 'wp_ajax_bg_login', 'bg_login' ) ;

//registration action
add_action( 'wp_ajax_nopriv_bingo_registration', 'bingo_registration' ) ;
add_action( 'wp_ajax_bingo_registration', 'bingo_registration' ) ;



/***********************************************************************************************/
/* LOG */
/***********************************************************************************************/

 
if(!function_exists('_log')){
  function _log( $message ) {
    if( WP_DEBUG === true ){
      if( is_array( $message ) || is_object( $message ) ){
        error_log( print_r( $message, true ) );
      } else {
        error_log( $message );
      }
    }
  }
}
 
 
// use this as _log('your message');



/******************************************************
*				custom post type for partners  		 *
*******************************************************/

	if(class_exists('Cuztom_Post_Type')){
		$pages = new Cuztom_Post_Type('page');


		$args = array(

		    'post_type' => 'block',
		    'posts_per_page' => -1

	  	);

		$get_all_block_posts = new WP_Query($args);


		//wp_query for blocks
		$all_block_posts = array();
		foreach ($get_all_block_posts->posts as $key => $value) {
		  $all_block_posts[$value->ID] = $value->post_title;
		}


		$pages->add_meta_box(
	        'bingo_block_posts',
	        'Block posts',
	        array(
	            array(
			        'name'          => 'block_posts',
			        'label'         => 'Block posts',
			        'description'   => 'Please select the blocks you wanted to show',
			        'type'          => 'multi_select',
			        'options'       => $all_block_posts,
			        'default_value' => 'value2'
			     )
	          )
	       );

	   $partner  = new Cuztom_Post_Type( 'Home page section', array(
                'label' => 'home_page',
                'menu_position' => 50,
                'has_archive' => true,
                'supports' => array('title', 'editor', 'thumbnail', 'revisions')
	    ) );
           
	   $partner  = new Cuztom_Post_Type( 'Partner', array(
                'label' => 'partners',
                'menu_position' => 50,
                'has_archive' => true,
                'supports' => array('title', 'editor','thumbnail')
	    ) );

	   $block  = new Cuztom_Post_Type( 'Block', array(
                'label' => 'blocks',
                'menu_position' => 55,
                'has_archive' => true,
                'supports' => array('title', 'editor','thumbnail')
	    ) );

	   // add meta box to block post type
	   $block->add_meta_box(
		   'bingo_block_type',
		   'Block Type',
		    array(
		         array(
			        'name'          => 'block_type',
			        'label'         => 'Block Type',
			        'description'   => 'Please select the type of the block',
			        'type'          => 'select',
			        'options'       => array(
			            'theme_block'    => 'Theme Info',
			            'staff_picks'    => 'Staff Picks',
			            'testimonial'    => 'Testimonial',
			            'latest_project' => 'Latest Projects',
			            'partners'    	 => 'Our Partnres'
			        ),
			        'default_value' => 'value2'
			     )
		      )
		   );
           
           $team  = new Cuztom_Post_Type( 'Team', array(
	     'label' => 'team',
	     'menu_position' => 50,
	     'has_archive' => true,
	     'supports' => array('title', 'editor', 'thumbnail')
	    ) );
           
           // add meta box to team post type
	   $team->add_meta_box(
                'bingo_team_social',
                'Team Social',
                 array(
                      array(
                             'name'          => 'social_facebook',
                             'label'         => 'Facebook',
                             'description'   => 'Enter link to facebook account',
                             'type'          => 'text'
                          ),
                      array(
                             'name'          => 'social_twitter',
                             'label'         => 'Twitter',
                             'description'   => 'Enter link to Twitter account',
                             'type'          => 'text'
                          ),
                      array(
                             'name'          => 'social_gp',
                             'label'         => 'Google+',
                             'description'   => 'Enter link to Google+ account',
                             'type'          => 'text'
                          ),
                   )
                );
           
           $service  = new Cuztom_Post_Type( 'Service', array(
	     'label' => 'service',
	     'menu_position' => 50,
	     'has_archive' => true,
	     'supports' => array('title', 'editor', 'thumbnail')
	    ) );
           
	}



/******************************************************
*				Excerpt length   				  *
*******************************************************/

function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

/******************************************************
*				Sidebar Register    				  *
*******************************************************/

if (function_exists('register_sidebar')) {
	register_sidebar(
		array(
			'name' => __('Main Sidebar', 'bingo'),
			'id' => 'unique-main-sidebar',
			'description' => __('The main sidebar area', 'bingo'),
			'class'		=> 'page-sidebar',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div> <!-- end main sidebar-widget -->',
			'before_title' => '<div class="title-lines-left"><h4>',
			'after_title' => '</h4></div>'
		)
	);
	register_sidebar(
		array(
			'name' => __('Footer sidebar 1', 'bingo'),
			'id' => 'footer-sidebar-1',
			'description' => __('The Footer sidebar 1 area', 'bingo'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>'
		)
	);
	register_sidebar(
		array(
			'name' => __('Footer sidebar 2', 'bingo'),
			'id' => 'footer-sidebar-2',
			'description' => __('The Footer sidebar 2 area', 'bingo'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>'
		)
	);
	register_sidebar(
		array(
			'name' => __('Footer sidebar 3', 'bingo'),
			'id' => 'footer-sidebar-3',
			'description' => __('The Footer sidebar 3 area', 'bingo'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>'
		)
	);
	register_sidebar(
		array(
			'name' => __('Footer sidebar 4', 'bingo'),
			'id' => 'footer-sidebar-4',
			'description' => __('The Footer sidebar 4 area', 'bingo'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>'
		)
	);

}



/******************************************************
*				Callback comments    				  *
*******************************************************/
function bingo_comments($comment, $args, $depth){
	$GLOBALS['comment'] = $comment;

	if (get_comment_type() == 'pingback' || get_comment_type() == 'trackback') : ?>

		<li class="pingback" id="comment-<?php comment_ID(); ?>">
			<div <?php comment_class('comment'); ?>>

				<div class="meta">
					<strong><?php _e('Pingback:', 'bingo'); ?></strong>
					<?php edit_comment_link(); ?>
				</div>

				<p><?php comment_author_link(); ?></p>
			</div>
		</li>

	<?php elseif (get_comment_type() == 'comment') : ?>

		<li id="comment-<?php comment_ID(); ?>">
			<div <?php comment_class('comment'); ?>>

				<!-- <img src="img/content/avatar.png" alt="" class="avatar"> -->

				<?php echo get_avatar($comment, 100); ?>

				<div class="meta">
					<strong><?php comment_author_link(); ?></strong>
					<?php _e('on', 'bingo') ?> <a href="<?php echo get_comment_link(); ?>"><?php comment_date(); ?> - <?php comment_time(); ?></a> -
					<!--<a href="<?php echo get_comment_reply_link(); ?>" class="reply">Reply</a> -->
					<?php comment_reply_link( array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth'])) ); ?>
				</div>

				<?php if ($comment->comment_approved == '0') : ?>

					<p><?php _e('Your comment is awaiting moderation.', 'bingo'); ?></p>

				<?php endif; ?>

				<div class="content">
					<?php comment_text(); ?>
				</div>
			</div>


	<?php endif;
}

/***********************************************************************************************/
/* Custom Comment Form */
/***********************************************************************************************/
function bingo_custom_comment_form($defaults){
	$defaults['comment_notes_before'] = '';
	$defaults['comment_notes_after'] = '<button type="submit" class="btn btn-default"><i class="fa fa-pencil-square-o"></i> Post Comment</button>';
	$defaults['class_form'] = 'comment-form';
	$defaults['comment_field'] = '<textarea rows="5" name="comment" class="form-control" placeholder="Your Comments ..."></textarea>';

	return $defaults;

}
add_filter('comment_form_defaults', 'bingo_custom_comment_form');

function bingo_custom_comment_fields(){
	$commenter = wp_get_current_commenter();
	$req = get_option('require_name_email');
	$aria_req = ($req ? " aria-required='true'" : '');

	$fields = array(
		'author'  => '<div class="row"><div class="col-md-4">'.
					 '<input type="text" name="author" id="author" class="form-control" placeholder="' . __('Name', 'bingo') . ' '. ($req ? '*' : '') . ' " value="' . esc_attr($commenter['comment_author']) . '" ' . $aria_req . '/>'.
					 '</div>',
		'email'  => '<div class="col-md-4">'.
					 '<input type="text" name="email" id="email" class="form-control" placeholder="' . __('Email', 'bingo') . ' '. ($req ? '*' : '') . ' " value="' . esc_attr($commenter['comment_author_email']) . '" ' . $aria_req . '/>'.
					 '</div>',
		'url'  => '<div class="col-md-4">'.
					 '<input type="text" name="url" id="url" class="form-control" placeholder="' . __('Website', 'bingo').'" value="' . esc_attr($commenter['comment_author_url']) . '" />'.
					 '</div></div>',

	);

	return $fields;
}

add_filter('comment_form_default_fields', 'bingo_custom_comment_fields');








/***********************************************************************************************/
/* Avatar URL instead of embed img HTML */
/***********************************************************************************************/

function uou_get_avatar_url($id_or_email, $size = '96', $default = '', $alt = false) {
	if (! get_option('show_avatars')) {	return false; }

	if (false === $alt) { $safe_alt = ''; }
	else { $safe_alt = esc_attr($alt); }

	if (!is_numeric($size)) { $size = '96'; }

	$email = '';
	if (is_numeric($id_or_email)) {
		$id = (int) $id_or_email;
		$user = get_userdata($id);
		if ($user) { $email = $user->user_email; }
	}

	elseif (is_object($id_or_email)) {
		// No avatar for pingbacks or trackbacks
		$allowed_comment_types = apply_filters('get_avatar_comment_types', array( 'comment'));
		if (!empty($id_or_email->comment_type) && ! in_array($id_or_email->comment_type, (array) $allowed_comment_types)) { return false; }

		if (!empty($id_or_email->user_id)) {
			$id = (int) $id_or_email->user_id;
			$user = get_userdata($id);
			if ($user) { $email = $user->user_email; }
		}

		elseif ( !empty($id_or_email->comment_author_email) ) { $email = $id_or_email->comment_author_email; }
	}

	else { $email = $id_or_email; }

	if (empty($default)) {
		$avatar_default = get_option('avatar_default');
		if (empty($avatar_default)) { $default = 'mystery'; }
		else { $default = $avatar_default; }
	}

	if (!empty($email)) { $email_hash = md5(strtolower($email)); }

	if (is_ssl()) { $host = 'https://secure.gravatar.com'; }
	else {
		if (!empty($email)) { $host = sprintf( "http://%d.gravatar.com", ( hexdec( $email_hash{0} ) % 2 ) ); }
		else { $host = 'http://0.gravatar.com'; }
	}

	if ('mystery' == $default) {
		$default = "$host/avatar/ad516503a11cd5ca435acc9bb6523536?s={$size}"; // ad516503a11cd5ca435acc9bb6523536 == md5('unknown@gravatar.com')
	}
	elseif ('blank' == $default) { $default = includes_url('images/blank.gif'); }
	elseif (!empty($email) && 'gravatar_default' == $default) { $default = ''; }
	elseif ('gravatar_default' == $default) { $default = "$host/avatar/s={$size}"; }
	elseif (empty($email)) { $default = "$host/avatar/?d=$default&amp;s={$size}"; }
	elseif (strpos($default, 'http://') === 0) { $default = add_query_arg('s', $size, $default); }

	if (!empty($email)) {
		$out = "$host/avatar/";
		$out .= $email_hash;
		$out .= '?s='.$size;
		$out .= '&amp;d=' . urlencode($default);

		$rating = get_option('avatar_rating');
		if (!empty($rating)) { $out .= "&amp;r={$rating}"; }

		//$avatar = "<img alt='{$safe_alt}' src='{$out}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
		$avatar = $out;
	}

	else {
		//$avatar = "<img alt='{$safe_alt}' src='{$default}' class='avatar avatar-{$size} photo avatar-default' height='{$size}' width='{$size}' />";
		$avatar = $default;
	}

	return $avatar;
}









/***********************************************************************************************/
/* Pagination */
/***********************************************************************************************/

function kriesi_pagination($pages = '', $range = 2)
{
     $showitems = ($range * 2)+1;

     global $paged;
     if(empty($paged)) $paged = 1;

     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }

     if(1 != $pages)
     {
         echo "<div class='text-center'><ul class='pagination pagination-lg text-center'>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<li><a href='".get_pagenum_link(1)."'>&laquo;</a></li>";
         if($paged > 1 && $showitems < $pages) echo "<li><a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a></li>";

         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<li><span class='current'>".$i."</span></li>":"<li><a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a></li>";
             }
         }

         if ($paged < $pages && $showitems < $pages) echo "<li><a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a></li>";
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<li><a href='".get_pagenum_link($pages)."'>&raquo;</a></li>";
         echo "</ul></div>\n";
     }
}






function wpc_pagination($pages = '', $range = 2)
{
      $showitems = ($range * 2)+1;
     global $paged;
     if( empty($paged)) $paged = 1;
     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }

     if(1 != $pages)
     {
         echo '<div class="text-center"><ul class="pagination pagination-lg text-center">';
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo '<li><a href="'.get_pagenum_link(1).'">FIRST</a></li>';
         if($paged > 1 && $showitems < $pages) echo '<li><a href="' .get_pagenum_link($paged - 1). '" rel="prev">previous</a></li>';

         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? '<li class="active"><a href="#">'. $i .'</a></li>':'<li><a href="'.get_pagenum_link($i).'">'.$i.'</a></li>';
             }
         }

         if ($paged < $pages && $showitems < $pages) echo '<li><a href="'.get_pagenum_link($paged + 1).'" rel="next">next</a></li>';
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo '<li><a href="'.get_pagenum_link($pages).'">LAST</a></li>';
         echo '</ul></div>';
     }
}






/***********************************************************************************************/
/* Get the first image of the post */
/***********************************************************************************************/

function echo_first_image( $postID ) {
	$args = array(
		'numberposts' => 1,
		'order' => 'ASC',
		'post_mime_type' => 'image',
		'post_parent' => $postID,
		'post_status' => null,
		'post_type' => 'attachment',
	);

	$attachments = get_children( $args );

	if ( $attachments ) {
		foreach ( $attachments as $attachment ) {
			$image_attributes = wp_get_attachment_image_src( $attachment->ID, 'thumbnail' )  ? wp_get_attachment_image_src( $attachment->ID, 'thumbnail' ) : wp_get_attachment_image_src( $attachment->ID, 'full' );

			echo '<img src="' . wp_get_attachment_thumb_url( $attachment->ID ) . '" class="current">';
		}
	}
}



/***********************************************************************************************/
/* Woocommerce Auction */
/***********************************************************************************************/

if ( ! function_exists( 'uou_woocommerce_auction_bid' ) ) {

	/**
	 * Output the to bid block.
	 *
	 * @access public
	 * @subpackage	Product
	 * @return void
     *
	 */
	function uou_woocommerce_auction_bid() {
		global $product;

		if ($product->product_type == 'auction')
			woocommerce_get_template( 'single-product/bid.php' );
	}
}





if ( ! is_admin() || defined('DOING_AJAX') ) {

	add_action( 'uou_custom_templating', 'uou_woocommerce_auction_bid', 20);

}



/***********************************************************************************************/
/* Post password Form */
/***********************************************************************************************/


add_filter('the_password_form','get_the_password_form_we');

function get_the_password_form_we( $output ) {
	if(isset($post)){
		$post = get_post( $post );
	}
	$label = 'pwbox-' . ( empty($post->ID) ? rand() : $post->ID );
	$output = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" class="post-password-form" method="post">
	<p>' . __( 'This content is password protected. To view it please enter your password below:', 'bingo' ) . '</p>
	<p><label for="' . $label . '">' . __( 'Password:', 'bingo' ) . ' <input name="post_password" id="' . $label . '" type="password" class="form-control" size="20" /></label> <input type="submit" name="Submit" class="btn btn-gray" value="' . esc_attr__( 'Submit' ) . '" /></p></form>
	';

	/**
	 * Filter the HTML output for the protected post password form.
	 *
	 * If modifying the password field, please note that the core database schema
	 * limits the password field to 20 characters regardless of the value of the
	 * size attribute in the form input.
	 *
	 * @since 2.7.0
	 *
	 * @param string $output The password form HTML output.
	 */
	return $output ;
}






/******************************************************
*				login ajax request 		 *
*******************************************************/


function bg_login(){

         // First check the nonce, if it fails the function will break
        check_ajax_referer( 'ajax-login-nonce', 'security' );

        // Nonce is checked, get the POST data and sign user on
        $info = array();
        $info['user_login'] = $_POST['login_username'];
        $info['user_password'] = $_POST['login_password'];
        $info['remember'] = true;

        $user_signon = wp_signon( $info, false );
        if ( is_wp_error($user_signon) ){

                echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.', 'bingo')));
        } else {

               echo json_encode(array(
                            'loggedin'=>true,
                            'message'=>__('Login successful, redirecting...', 'bingo'),
                             'url'  =>  get_site_url()."/wp-admin"
                ));


        }

        wp_die();
}



/******************************************************
*				Bingo Registration 		 *
*******************************************************/

function bingo_registration(){

	global $wpdb, $user_ID;

	if(isset($_POST)){

		// print_r($_POST['form_data']);

		$form_data = $_POST['form_data'];

		parse_str($form_data,$user_info);

		$username = $user_info['user_name'];
		// echo $username;
		$user_exists = username_exists( $username );
		// echo $user_exists . "\n"; 

		$email = $user_info['email'];
		// echo $email;
		$e_exists = email_exists( $email );
		// echo $e_exists;

		$password = $user_info['reg_password'];
		// echo $password;
	}

    if( $user_exists ){
    	_e('Username Alreday exists, please choose another', 'bingo');
    }elseif( $e_exists ){
    	_e('This e-mail is already registered, please use another to register', 'bingo');
    }elseif( strpos($username, ' ') !== false ){
    	_e('Sorry, no spaces are allowed in usernames', 'bingo');
    }elseif( empty($username) ){
    	_e('Please enter a username', 'bingo');
    }elseif( empty( $password ) ){
    	_e('Please enter a password for your account', 'bingo');
    }elseif( !is_email( $email ) ){
    	_e('Please enter a valid email', 'bingo');
    }else{

    	$new_user = wp_create_user($username,$password,$email);
        _e('Registration Successfull');

        wp_mail( $email, 'Welcome!', 'Your Password: ' . $password );
        
    }

    die();
}





/******************************************************
*				Twitter ajax request 		 *
*******************************************************/

add_action( 'wp_ajax_bingo_tweets_fun', 'bingo_tweets_fun' );
add_action("wp_ajax_nopriv_bingo_tweets_fun", "bingo_tweets_fun");

function bingo_tweets_fun() {
    require_once(TEMPLATEPATH . '/js/twitter/index.php');

    global $bingo_option_data;

    $credentials = array(
        'consumer_key'    => array_key_exists('bingo-twitter-consumer-key',$bingo_option_data)?$bingo_option_data['bingo-twitter-consumer-key']:'',
        'consumer_secret' => array_key_exists('bingo-twitter-consumer-secret',$bingo_option_data)?$bingo_option_data['bingo-twitter-consumer-secret']:'',
        'user_token'      => array_key_exists('bingo-twitter-user-token',$bingo_option_data)?$bingo_option_data['bingo-twitter-user-token']:'',
        'user_secret'     => array_key_exists('bingo-twitter-user-secret',$bingo_option_data)?$bingo_option_data['bingo-twitter-user-secret']:''
    );

    $ezTweet = new ezTweet;
    $ezTweet->setCredentials($credentials);
    $ezTweet->fetch();

    die();
}

/***********************************************************************************************/
/* LANGUAGE SETUP */
/***********************************************************************************************/

add_action('after_setup_theme', 'my_theme_setup');
function my_theme_setup(){
    load_theme_textdomain('bingo', get_template_directory() . '/lang');
}


/***********************************************************************************************/
/* WPML LANGUAGE SETUP */
/***********************************************************************************************/

function wpml_languages(){

		global $bingo_option_data;

    	$languages = icl_get_languages('skip_missing=0');

    	$wpml_select = $bingo_option_data['bingo-wpml-select'];
    	// print_r($wpml_select);
    	// print_r($languages);
    	?>
    	<div class="header-language">

			<?php
			if($wpml_select == "name"){

				foreach ($languages as $language) {
					if($language['active']){
						?>
						<a href="<?php echo $language['url']; ?>">
							<span><?php echo $language['translated_name'] ?></span>
							<i class="fa fa-chevron-down"></i>
						</a>
				<?php
					}
				}
				?>

				<ul>
					<?php foreach ($languages as $language) {
						// print_r($language);
						if( !$language['active'] ){
							?>
							<li><a href="<?php echo $language['url']; ?>"><?php echo $language['translated_name']; ?></a></li>
							<?php
						}
					}
					?>

				</ul>
		<?php }elseif ($wpml_select == "code") {

			foreach ($languages as $language) {
					if($language['active']){
						?>
						<a href="<?php echo $language['url']; ?>">
							<span><?php echo $language['language_code'] ?></span>
							<i class="fa fa-chevron-down"></i>
						</a>
				<?php
					}
				}
				?>

				<ul>
					<?php foreach ($languages as $language) {
						// print_r($language);
						if( !$language['active'] ){
							?>
							<li><a href="<?php echo $language['url']; ?>"><?php echo $language['language_code']; ?></a></li>
							<?php
						}
					}
					?>

				</ul>
		<?php
			}else{

				foreach ($languages as $language) {
					if($language['active']){
						?>
						<a href="<?php echo $language['url']; ?>">
							<span><img src="<?php echo $language['country_flag_url']; ?>"></span>
							<i class="fa fa-chevron-down"></i>
						</a>
				<?php
					}
				}
				?>

				<ul style="margin-left:-12px">
					<?php foreach ($languages as $language) {
						// print_r($language);
						if( !$language['active'] ){
							?>
							<li><a href="<?php echo $language['url']; ?>" style="width:45px;"><img src="<?php echo $language['country_flag_url']; ?>"></a></li>
							<?php
						}
					}
					?>

				</ul>
			<?php
			} ?>
		</div> <!-- end .header-language -->
<?php
}



/***********************************************************************************************/
/* Adding class to next and previous button */
/***********************************************************************************************/

add_filter('next_post_link', 'post_link_attributes');
add_filter('previous_post_link', 'post_link_attributes');
 
function post_link_attributes($output) {
    $code = 'class="btn btn-default"';
    return str_replace('<a href=', '<a '.$code.' href=', $output);
}

function register_my_menus() {
    register_nav_menus(
        array(
            'userarea-menu' => __( 'Header Menu User area' ),
            'userarea-footer-menu' => __( 'Footer Menu User area' )
        )
    );
}
add_action( 'init', 'register_my_menus' );