<?php
/*
Plugin Name: WooCommerce Vendor Setting
Plugin URI: http://www.solvercircle.com
Description: This plugin is for vendor setting for product.  
Version: 1.0.1
Author: SolverCircle
Author URI: http://www.solvercircle.com
Text Domain: woocommerce-vendor-setup
Domain Path: /i18n/languages/
*/
define('WP_CUSTOM_PRODUCT_URL', plugins_url('',__FILE__));
define('WP_CUSTOM_PRODUCT_PATH',plugin_dir_path( __FILE__ ));
$upload = wp_upload_dir();

//Upload Path
$get_upload_dir=$upload['basedir'].'/vendor_uploads/';
define('UPLOADS__BASE_PATH',$get_upload_dir);

//Upload URL
$get_upload_url=$upload['baseurl'].'/vendor_uploads/';
define('UPLOADS__BASE_URL',$get_upload_url);

include('vendor_core/vendor_core.php');
include('vendor_core/vendor_init.php');
include('vendor_admin/admin_init/vendor_product.php');
include('vendor_admin/admin_init/custom_product.php');
include('vendor_admin/admin_init/vendor_payment.php');
include('vendor_admin/admin_init/vendor_front_view_list.php');
include('vendor_admin/become_vendor/become_vendor.php');
include('vendor_frontend/vendor_frontend.php');


register_activation_hook(__FILE__, 'product_vendor_plugin_install');
register_deactivation_hook(__FILE__, 'product_vendor_plugin_uninstall');
