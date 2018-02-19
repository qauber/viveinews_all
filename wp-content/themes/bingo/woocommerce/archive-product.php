<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header( 'shop' );
?>

	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

<?php


     ?>

     <?php do_action('woocommerce_archive_description'); ?>

     <div id="page-content" class="woocommerce woocommerce-page">
         <div class="page-content">
             <div class="container my-mg">
                 <div id="mobile-menu-toggle2"><span></span></div>
                 <div class="col-xs-12 col-sm-2 page-sidebar myWidthSL">
                     <?php // include(TEMPLATEPATH . '/sidebar.php');
                     get_sidebar();

                     ?>
                 </div>
                 <div class="col-lg-8 col-md-12 col-sm-12 w1000 pr0">
                     <?php if(is_search()){

                         if (isset($_GET['filter_name']) && !empty($_GET['filter_name'])){
                             $filter = get_advanced_filter($_GET['filter_name']);
                         }else{
                             $filter = $_GET;
                         }

                         $meta_query = array(
                                 'relation' => 'AND',
                         );

                         if (isset($filter['breaking']) && array_filter($filter['breaking'])){
                             foreach($filter['breaking'] as $breaking) {
                                 $meta_query_br[] = array(
                                                             'key' => 'breaking_tags',
                                                             'value' => ':"'.$breaking.'";',
                                                             'compare' => 'LIKE'
                                                         );
                             }
                             $meta_query[] = array(
                                                             'relation' => 'OR',
                                                            $meta_query_br,
                                                     );
                         }

                         $tax_query = array();
                         if (isset($filter['category']) && !empty($filter['category'])){
                             $tax_query[] = array(
                                                 'taxonomy'      => 'product_cat',
                                                 'field' => 'term_id', //This is optional, as it defaults to 'term_id'
                                                 'terms'         => $filter['category'],
                                                 'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
                                             );

                         }

                         $tag_query = '';

                         if (isset($filter['location']) && !empty($filter['location'])){
                             $tag_query .= $filter['location'];
                         }

                         if (isset($filter['tags']) && !empty($filter['tags'])){
                             $tag_query .= $filter['location'];
                         }

                         $sorting = 'date';
                         if (isset($filter['sorting']) && !empty($filter['sorting'])) {
                             if ($filter['sorting'] == 'popular') {
                                 $sorting = 'popular';
                                 $meta_query['popular'] = array(
                                     'key' => 'product_views',
                                     'compare' => 'EXISTS',
                                     'type' => 'NUMERIC'
                                 ); 
                             }
                         }


                         if (isset($filter['time']) && !empty($filter['time'])){
                             if ($filter['time'] == 'now'){
                                 $data_query = array(
                                     'after' => '5 minutes ago',
                                 );
                             }
                             if ($filter['time'] == 'last_hour'){
                                 $data_query = array(
                                     'after' => '1 hour ago',
                                 );
                             }
                             if ($filter['time'] == 'today'){
                                 $data_query = array(
                                     'after' => 'today',
                                 );
                             }
                             if ($filter['time'] == 'this_week'){
                                 $data_query = array(
                                     'after' => 'this week',
                                 );
                             }
                             if ($filter['time'] == 'this_month'){
                                 $data_query = array(
                                     'after' => 'this month',
                                 );
                             }
                             if ($filter['time'] == 'other_date' && isset($filter['other_time_from']) && !empty($filter['other_time_from']) && isset($filter['other_time_to']) && !empty($filter['other_time_to'])){
                                 $from = $filter['other_time_from'];
                                 $to = $filter['other_time_to'];
                                 $data_query = array(
                                     array(
                                         'after'     => $from,
                                         'before'    => $to,
                                         'inclusive' => true,
                                     ),
                                 );
                             }
                         }




                         $args = array(
                             'cat'          => $cat,
                             'orderby'      => $sorting,
                             'order'        => 'DESC',
                             'posts_per_page' => 5,
                             'paged'        => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : '1',

                             'post_type'   => 'product',
                             'suppress_filters' => true,
                             'meta_query'  => $meta_query,
                             'tax_query'    => $tax_query,
                             'tag'          => $tag_query,
                             'date_query'   => $data_query
                         );

//                         print_r($wp_query);

                         query_posts($args);

                             ?>

                             <nav class="col-xs-12 navbar navbar-default" role="search">
                                 <div class="form-group">


                                     <?php
                                     /**
                                      * woocommerce_before_shop_loop hook
                                      *
                                      * @hooked woocommerce_result_count - 20
                                      * @hooked woocommerce_catalog_ordering - 30
                                      */
                                     remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
                                     do_action('woocommerce_before_shop_loop');
                                     ?>
                                 </div>
                             </nav>

                             <?php woocommerce_product_loop_start(); ?>

                             <?php woocommerce_product_subcategories(); ?>

                             <?php
                                     while (have_posts()) : the_post();
                             ?>

                                 <?php wc_get_template_part('content', 'product'); ?>


                             <?php endwhile;// end of the loop.


                             ?>

                             <?php woocommerce_product_loop_end();

                             ?>

                             <?php
                             /**
                              * woocommerce_after_shop_loop hook
                              *
                              * @hooked woocommerce_pagination - 10
                              */
                             do_action('woocommerce_after_shop_loop');

                         wp_reset_query();


                         ?>

                     <?php }elseif (have_posts()) { ?>

                         <nav class="col-xs-12 navbar navbar-default" role="search">
                             <div class="form-group">


                                 <?php
                                 /**
                                  * woocommerce_before_shop_loop hook
                                  *
                                  * @hooked woocommerce_result_count - 20
                                  * @hooked woocommerce_catalog_ordering - 30
                                  */
                                 remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
                                 do_action('woocommerce_before_shop_loop');
                                 ?>
                             </div>
                         </nav>

                         <?php woocommerce_product_loop_start(); ?>

                         <?php woocommerce_product_subcategories(); ?>

                         <?php while (have_posts()) : the_post(); ?>

                             <?php wc_get_template_part('content', 'product'); ?>

                         <?php endwhile; // end of the loop. ?>

                         <?php woocommerce_product_loop_end(); ?>

                         <?php
                         /**
                          * woocommerce_after_shop_loop hook
                          *
                          * @hooked woocommerce_pagination - 10
                          */
                         do_action('woocommerce_after_shop_loop');
                         ?>

                     <?php }elseif (!woocommerce_product_subcategories(array('before' => woocommerce_product_loop_start(false), 'after' => woocommerce_product_loop_end(false)))) { ?>
                         <?php
                         global $wp_query;
                         $new_noties = array("breaking-news", "international-breaking-news", "local");
                         ?>

                         <div style="color:#000; font-size: 22px;padding-left: 20px">
                             <?php
                             if (in_array($wp_query->query_vars["product_cat"], $new_noties)) {
                                 echo "Currently we have no breaking news at this time.";
                             } else {
                                 echo "No products in this category.";
                             }
                             ?>
                         </div>

                     <?php } ?>

                 </div>

                 <!-- banner blok right-block.php -->
                 <?php get_template_part('right', 'block'); ?>
                 <!-- banner blok right-block.php -->
             </div>
         </div>
     </div>

     <?php

		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

	<?php
		/**
		 * woocommerce_sidebar hook
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action( 'woocommerce_sidebar' );
	?>

<?php get_footer( 'shop' ); ?>