<?php

/*
Template Name: Full Width without share and sidebar
*/


 get_header(); ?>


<div id="page-content">
    <div class="page-content">
        <div class="container my-mg">
            <?php the_title( "<h1 class='page-title'>", "</h1>" ); ?> 

            <?php echo do_shortcode( '[yith_woocommerce_ajax_search]'); ?>
            <?php echo do_shortcode( '[bingo_checkbox_available]'); ?>
            <p></p>
            <div class="woocommerce woocommerce-breadcrumb-block">
                        <?php   
                                woocommerce_breadcrumb();
                        ?>
                    </div>

            <div id="mobile-menu-toggle2"><span></span></div>
            
            <div class="col-xs-12 col-md-12 col-sm-12 w1000 pr0">

                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                        <article <?php post_class('blog-post'); ?> id="post-<?php the_ID(); ?>">

                            <?php if (has_post_thumbnail()) : ?>

                                <?php
                                    $thumb_id = get_post_thumbnail_id();
                                    $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'thumbnail-size', true);
                                    $thumb_url = $thumb_url_array[0];
                                ?>

                                <a href="<?php the_permalink(); ?>"><img class="image" src="<?php echo $thumb_url; ?>"></a>


                            <?php endif; ?>

                                    <!--<h1 class="h4"><?php the_title(); ?></h1>-->

                            <?php
//                            if (current_user_can('edit_post', $post->ID)) {
//                                edit_post_link(__('Edit This', 'bingo'), '<p class="page-admin-edit-this">', '</p>');
//                            }
                            ?>

                            <div class="content">
                                
                                
                                <?php echo do_shortcode(get_the_content());
//                                        the_content();?>
                            </div>

                            <!-- for social sharer -->
                            


                            <?php wp_link_pages(); ?> 

                            <!--								<div class="comments-section">
                            
                            <?php // wp_reset_query(); 
//                                                                        comments_template('', true ); 
                            ?>
                            
                                                                                            </div>-->
                        </article>

                    <?php endwhile;
                else : ?>
                    <article>
                        <h1><?php _e('No Posts were Found!', 'new-item'); ?></h1>
                    </article>
<?php endif; ?>

            </div>
            
        </div>
    </div>
</div>


<?php get_footer(); ?>