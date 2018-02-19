<?php
/**
 * Content wrappers
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$template = get_option( 'template' );

switch( $template ) {
	case 'bingo' :
		echo '<div id="page-content"><div class="page-content"><div class="container"><div class="row"><h1 class="page-title">'. woocommerce_page_title(false) .'</h1>' . do_shortcode( '[yith_woocommerce_ajax_search]') . '<p></p>';
            break;
	case 'twentyeleven' :
		echo '<div id="primary"><div id="content" role="main">';
		break;
	case 'twentytwelve' :
		echo '<div id="primary" class="site-content"><div id="content" role="main">';
		break;
	case 'twentythirteen' :
		echo '<div id="primary" class="site-content"><div id="content" role="main" class="entry-content twentythirteen">';
		break;
	case 'twentyfourteen' :
		echo '<div id="primary" class="content-area"><div id="content" role="main" class="site-content twentyfourteen"><div class="tfwc">';
		break;
	default :
		echo '<div id="container"><div id="content" role="main">';
		break;
}