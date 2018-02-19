<?php


function vendor_set_email_content_type(){
	return "text/html";
}

function vendor_ob_start_function(){
  ob_start();
}

function vendor_session(){
    if(!session_id()) {
        session_start();
    }
}

function vendor_session_end(){
    session_destroy();
}

//--------i18n--------
function vendor_plugin_textdomain() {
  load_plugin_textdomain( 'woocommerce-vendor-setup', FALSE, basename( dirname( __FILE__ ) ) . '/i18n/languages/' );
}

function add_admin_additional_script(){
	wp_enqueue_script( 'jsapi', 'https://www.google.com/jsapi' );
	
	wp_enqueue_style('wqo-css',WP_CUSTOM_PRODUCT_URL.'/vendor_resource/css/blue/style.css');
	wp_enqueue_style('colorbox-css',WP_CUSTOM_PRODUCT_URL.'/vendor_resource/js/jquery.tablesorter.pager.css');
  
  	//wp_enqueue_script('jquery');
  	wp_enqueue_script('wcp-jscolor', WP_CUSTOM_PRODUCT_URL.'/vendor_resource/js/jquery.tablesorter.js');
  	wp_enqueue_script('wqo-tooltip', WP_CUSTOM_PRODUCT_URL.'/vendor_resource/js/jquery.tablesorter.pager.js');
	//wp_enqueue_script( 'jsapi.js', plugins_url( '/vendor_resource/js/jsapi.js', __FILE__ ) );
	wp_enqueue_media();
}

function add_frontend_additional_script(){
	//wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
  	//wp_enqueue_script( 'jquery' );
  	//wp_enqueue_script( 'jquery-ui-core' );
  	//wp_enqueue_script( 'jquery-ui-dialog' );
  	//wp_enqueue_script( 'jquery-ui-tabs' );
	//wp_enqueue_style( 'demo_style', WP_CUSTOM_PRODUCT_URL.'/vendor_resource/css/demo_style.css');
	//wp_enqueue_script( 'demo_script', WP_CUSTOM_PRODUCT_URL.'/vendor_resource/js/demo_script.js');
	wp_enqueue_style('horizontal_tabs', WP_CUSTOM_PRODUCT_URL.'/vendor_resource/css/horizontal_tabs.css');
	wp_enqueue_script( 'jsapi', 'https://www.google.com/jsapi' );
	add_thickbox();
	
	wp_enqueue_style('wqo-css',WP_CUSTOM_PRODUCT_URL.'/vendor_resource/css/blue/style.css');
	wp_enqueue_style('colorbox-css',WP_CUSTOM_PRODUCT_URL.'/vendor_resource/js/jquery.tablesorter.pager.css');
  	wp_enqueue_script('wcp-jscolor', WP_CUSTOM_PRODUCT_URL.'/vendor_resource/js/jquery.tablesorter.js');
  	wp_enqueue_script('wqo-tooltip', WP_CUSTOM_PRODUCT_URL.'/vendor_resource/js/jquery.tablesorter.pager.js');
	//wp_enqueue_script( 'jsapi.js', plugins_url( '/vendor_resource/js/jsapi.js', __FILE__ ) );
}

/*add_action( 'woo_main_before', 'woo_sidebar' );
function woo_sidebar() {
if (is_woocommerce()) { 
    echo '<div class="primary"> ABCD </div>';
}
}*/

/*function theme_slug_filter_the_content( $content ) {
    $custom_content = 'YOUR CONTENT GOES HERE';
    $custom_content .= $content;                        //**********************  partialy working *****************
    return $custom_content;
}
add_filter( 'the_content', 'theme_slug_filter_the_content' );*/
function third_party_tab_content(){
	//echo 'This is tab content';
	global $post;
	//echo $post->ID;
	$vendor_id = get_post_meta( $post->ID, '_vendor_select', true );
	
	//*************************************************
	$vendor_name = get_post_meta( $vendor_id, '_vendor_name', true );
	$vendor_company = get_post_meta( $vendor_id, '_vendor_company', true );
	$vendor_email = get_post_meta( $vendor_id, '_vendor_email', true );
	
	$vendor_phone = get_post_meta( $vendor_id, '_vendor_phone', true );
	$vendor_fax = get_post_meta( $vendor_id, '_vendor_fax', true );
	$vendor_address = get_post_meta( $vendor_id, '_vendor_address', true );
	
	$vendor_zip = get_post_meta( $vendor_id, '_vendor_zip', true );
	$vendor_state = get_post_meta( $vendor_id, '_vendor_state', true );
	$vendor_country = get_post_meta( $vendor_id, '_vendor_country', true );
	
	?>
	<div class="wrap">
    	<table class="form-table">
        <tbody>
        <tr>
            <th scope="row"><label>Name</label></th>
            <td><?php echo $vendor_name;?></td>
        </tr>
        <tr>
            <th scope="row"><label>Company</label></th>
            <td><?php echo $vendor_company;?></td>
        </tr>
        <tr>
            <th scope="row"><label>Email</label></th>
            <td><?php echo $vendor_email;?></td>
        </tr>
        <tr>
            <th scope="row"><label>Phone</label></th>
            <td><?php echo $vendor_phone;?></td>
        </tr>
        <tr>
            <th scope="row"><label>Fax</label></th>
            <td><?php echo $vendor_fax;?></td>
        </tr>
        <tr>
            <th scope="row"><label>Address</label></th>
            <td><?php echo $vendor_address.', '.$vendor_zip.', '.$vendor_state.', '.$vendor_country;?></td>
        </tr>
        <tr>
            <th scope="row" valign="top" style="vertical-align:top"><label>Company Logo</label></th>
            <td><?php echo get_the_post_thumbnail( $vendor_id, array(100,100) );?></td>
        </tr>
        </tbody>
        </table>
    </div>
	<?php
	
	
	/*$myvals = get_post_meta($vendor_id);
	
	foreach($myvals as $key=>$val)
	{
		echo $key . ' : ' . $val[0] . '<br/>';
	}*/
}

function third_party_tab( $tabs ) {

//echo '<br>-->'.$vendor_id;
/*$some_check = $product ? third_party_check( $product->id ) : null;
if ( $product && ! $some_check ) {
return $tabs;
}*/
global $post;
//echo $post->ID;
$vendor_id = get_post_meta( $post->ID, '_vendor_select', true );
	$tabs['third_party_tab'] = array(
	'title' => __( 'Vendor', 'wc_third_party' ),
	'priority' => 20,
	'callback' => 'third_party_tab_content'
	);
	return $tabs;
	}
add_filter( 'woocommerce_product_tabs', 'third_party_tab' ); 



/*function theme_slug_filter_the_title( $title ) {
    $custom_title = 'YOUR CONTENT GOES HERE';
    $title .= $custom_title;
    return $title;
}
add_filter( 'the_title', 'theme_slug_filter_the_title' );*/

/*add_filter( 'wp_title', 'mytest_add_sitename_to_title', 10, 2 );

function mytest_add_sitename_to_title( $title, $sep ) {
$name = get_bloginfo( 'name' );
$title .= 'ABCD';
return $title;
}*/
/*function wpr_after_post_title() {
echo "eeeeeee";
}
add_action('wpr_after_post_title','wpr_after_post_title');*/
/*function theme_post_end() {
echo '<div class="custom-text">Custom Text at the end of the post</div>';
};
add_action('themify_post_end', 'theme_post_end');*/
/*add_action('init', 'init_theme_method');
 
function init_theme_method() {
   add_thickbox();
}*/
add_action( 'plugins_loaded', 'vendor_plugin_textdomain' );
add_action('init', 'vendor_ob_start_function');
add_action('init', 'vendor_session', 1);
add_action('init', 'vendor_add_front_sub_menu_function');
add_action('wp_logout', 'vendor_session_end');
add_action('wp_login', 'vendor_session_end');
add_filter( 'wp_mail_content_type','vendor_set_email_content_type' );
add_action( 'admin_enqueue_scripts', 'add_admin_additional_script' );
add_action( 'wp_enqueue_scripts', 'add_frontend_additional_script' );
