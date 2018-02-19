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

		<?php do_action( 'woocommerce_archive_description' ); ?>
                
                    <?php if ( have_posts() ) : ?>

			<?php
				/**
				 * woocommerce_before_shop_loop hook
				 *
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
//				do_action( 'woocommerce_before_shop_loop' );
			?>

			<?php woocommerce_product_loop_start(); ?>

				<?php woocommerce_product_subcategories(); ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php wc_get_template_part( 'content', 'product-breaking-news' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

			<?php
				/**
				 * woocommerce_after_shop_loop hook
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>
                            <?php
                            global $wp_query;
                            $new_noties = array("breaking-news", "international-breaking-news", "local");
                            ?>
                            <div id="page-content" class="woocommerce woocommerce-page">
                                <div class="page-content">
                                    <div class="container my-mg">
                                        <div id="mobile-menu-toggle2"><span></span></div>
                                        <div class="col-xs-12 col-sm-2 page-sidebar myWidthSL"><?php include(TEMPLATEPATH . '/sidebar.php'); ?></div>
                                        <div class="col-xs-8 col-sm-8 w1000 pr0">
                                            <div style="color:#000; font-size: 22px;padding-left: 20px">
                                                <?php
                                                if (in_array($wp_query->query_vars["product_cat"], $new_noties)) {
                                                    echo "Currently we have no breaking news at this time.";
                                                } else {
                                                    echo "No products in this category.";
                                                }
                                                ?>
                                            </div>
                                        </div>

                            <!-- banner blok right-block.php -->
                            <?php get_template_part( 'right', 'block' ); ?>
                            <!-- banner blok right-block.php -->
                                   </div>
                                  </div>
                                </div>
                                <?php 
                                //wc_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>
                                
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