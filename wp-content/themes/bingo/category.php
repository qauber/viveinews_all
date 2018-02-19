<?php
/**
 * The default template for the theme
 *
 * @package CHANGE_THEME_NAME
 * @since CHANGE_THEME_NAME 1.0
 */

get_header();

?>


	<div id="page-content">
		<div class="page-content">
			<div class="container">
				<div class="row">
                <div class="col-xs-3 page-sidebar">

						<?php get_sidebar(); ?>

					</div>
					<div class="col-xs-9">
                        	<? $i = 1; ?>
                		<?php if(have_posts()) : ?>

						<!--	<h3><?php printf( __( 'Category Archives: %s', 'bingo' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?></h3> -->

	                        <?php if ( category_description() ) : // Show an optional category description ?>
	                            <div class="archive-meta"><?php echo category_description(); ?></div>
	                        <?php endif; ?>

                		<?php while(have_posts()) : the_post(); ?>

						<article <?php post_class('blog-post col-md-4 col-xs-12'); ?> id="post-<?php the_ID(); ?>">
 <h1 class="post-title title-small"><?php the_title(); ?></h1>
  <?php if (has_post_thumbnail()) : ?>
  
		<?php
        
			$thumb_id = get_post_thumbnail_id();
			$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'blog-thumb', true);
			$thumb_url = $thumb_url_array[0];
		?>

		<a href="<?php the_permalink(); ?>"><img class="post-image" src="<?php echo $thumb_url; ?>"></a>
  <?php endif; ?>

 <p class="posted">Posted: <?php the_time(get_option('date_format')); ?></p>

 <!-- <div class="post-meta">
    <ul>
      <li><i class="fa fa-calendar"></i> <?php the_time(get_option('date_format')); ?></li>
      <li><i class="fa fa-user"></i> <?php the_author_posts_link(); ?></li>
      <li><i class="fa fa-folder-open-o"></i> <?php the_category(',&nbsp; '); ?></li>
      <?php if (comments_open() && !post_password_required()) { ?>
      <li><i class="fa fa-comments-o"></i> <a href="#"><?php comments_popup_link('0 Comments', '1 Comment', '% Comments', ''); ?></a></li>
      <?php } ?>
    </ul>
  </div> -->

  <p class="textPost"><?php the_excerpt(); ?></p>

  <a href="<?php the_permalink(); ?>" class="btn btn-default read-more"><?php _e('Read More', 'bingo'); ?></a>
</article>
                            <?
                    			//echo ('x');
                    			if(($i%3) == 0){
                    				echo "<div class='clear'></div>";
                    			}
                    			$i++;
                			?>

				            <?php endwhile; ?>


							<!-- PAGINATION : begin -->
		                    <div class="e-pagination">

		                        <?php
		                        previous_posts_link('<i class="fa fa-chevron-left"></i> Newer Posts');
		                        next_posts_link('Older Posts <i class="fa fa-chevron-right"></i>');
		                        ?>

		                    </div>
		                    <!-- PAGINATION : end -->


				        <?php else : ?>

				            <article class="blog-post">

				                <h2><?php _e( 'No Posts were Found!', 'bingo' ); ?></h2>

				            </article>
				        <?php endif; ?>

							<?php
								if ($wp_query->max_num_pages > 1) :
									wpc_pagination();
								endif;
							?>

					</div>

					

				</div>
			</div>
		</div>
	</div> <!-- end #page-content -->




<?php get_footer(); ?>