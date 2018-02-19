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
					<div class="col-sm-8">

                		<?php if(have_posts()) : while(have_posts()) : the_post(); ?>

							<article <?php post_class('blog-post'); ?> id="post-<?php the_ID(); ?>">

								<?php if (has_post_thumbnail()) : ?>

									<?php
										$thumb_id = get_post_thumbnail_id();
										$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'thumbnail-size', true);
										$thumb_url = $thumb_url_array[0];
									?>

									<a href="<?php the_permalink(); ?>"><img class="image" src="<?php echo $thumb_url; ?>"></a>

								<?php endif; ?>


								<h1 class="h4"><?php the_title(); ?></h1>

								<div class="post-meta">
									<ul>
										<li><i class="fa fa-calendar"></i> <a href="#"><?php the_time(get_option('date_format')); ?></a></li>
										<li><i class="fa fa-user"></i> <?php the_author_posts_link(); ?></li>
										<li><i class="fa fa-folder-open-o"></i> <?php the_category(' &nbsp;/&nbsp; '); ?></li>

										<?php if (has_tag()) : ?>

											<li><i class="fa fa-tag"></i> <?php the_tags('', ',', ''); ?></li>

										<?php endif; ?>

										<li><i class="fa fa-comment-o"></i>
										<?php
												// Only show the comments link if comments are allowed and it's not password protected
												if (comments_open() && !post_password_required()) {
													comments_popup_link('0 Comment', '1 Comment', '% Comments', '');
												}
										?>

										</li>
									</ul>
								</div>

								<p><?php the_excerpt(); ?></p>

								<a href="<?php the_permalink(); ?>" class="btn btn-default"><?php _e('Read More', 'bingo'); ?></a>
							</article>


				            <?php endwhile; endif; ?>


							<!-- PAGINATION : begin -->
		                    <div class="e-pagination">

		                        <?php
		                        previous_posts_link('<i class="fa fa-chevron-left"></i> Newer Posts');
		                        next_posts_link('Older Posts <i class="fa fa-chevron-right"></i>');
		                        ?>

		                    </div>
		                    <!-- PAGINATION : end -->

					</div>

					<div class="col-sm-4 page-sidebar">

						<?php get_sidebar(); ?>

					</div>

				</div>
			</div>
		</div>
	</div> <!-- end #page-content -->




<?php get_footer(); ?>