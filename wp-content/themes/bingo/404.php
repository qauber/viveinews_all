<?php
/**
 * The default template for the theme v
 *
 * @package CHANGE_THEME_NAME
 * @since CHANGE_THEME_NAME 1.0
 */

get_header();

?>
<div id="page-content" class="woocommerce woocommerce-page">
    <div class="page-content">
        <div class="container my-mg">
            <div id="mobile-menu-toggle2"><span></span></div>
            <div class="col-xs-12 col-sm-2 page-sidebar myWidthSL"><?php get_sidebar(); ?></div>
                <div class="col-xs-8 col-sm-8 w1000 pr0" style="margin-bottom:30px;">
                    <div class="responsive-tabs project-list-tabs">
    <div class="tab-pane active" id="project-list-tab-auction">
        <div class="row">
            <div class="col-xs-8 col-md-4 col-sm-6 filter-item">
							<article <?php post_class('blog-post'); ?> id="post-<?php the_ID(); ?>">

								<h1 class="h4"><?php _e('404', 'bingo'); ?></h1>

                    			<p><?php _e( 'No products in this category. ', 'bingo' ); ?></p>

							</article>
			</div>				
        </div>
    </div>
                            </div>
                        </div>
<!-- banner blok right-block.php -->
<?php get_template_part( 'right', 'block' ); ?>
<!-- banner blok right-block.php -->
                </div>
            </div>
        </div>
<?php get_footer(); ?>