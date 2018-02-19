<?php

get_header(); ?>


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

								<?php

									if (current_user_can('edit_post', $post->ID)) {
										edit_post_link(__('Edit This', 'bingo'), '<p class="page-admin-edit-this">', '</p>');
									}
								?>

								<div class="post-meta">
									<ul>
										<li><i class="fa fa-calendar"></i> <a href="#"><?php the_time(get_option('date_format')); ?></a></li>
										<li><i class="fa fa-user"></i> <?php the_author_posts_link(); ?></li>
										<li><i class="fa fa-folder-open-o"></i> <?php the_category(' &nbsp;/&nbsp; '); ?></li>

										<?php if (has_tag()) : ?>

											<li><i class="fa fa-tag"></i> <?php the_tags('', ',' ,''); ?></li>

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

								<div class="content">
									<?php echo do_shortcode(get_the_content()); ?>
								</div>

								<!-- for social sharer -->
								<?php get_template_part( 'framework/template/sharer', '' ); ?>

								<?php

									$user_ID = get_the_author_meta('ID');
									$user_mail = get_the_author_meta('user_email');

								?>

								<div class="about-author">
									<img src="<?php echo uou_get_avatar_url(get_the_author_meta( 'ID' ), 60); ?>" alt="" class="thumb">
									<h6><?php _e('About the Author', 'bingo'); ?></h6>
									<p><?php the_author_posts_link(); ?>, <?php printf( __( '%d posts created', 'bingo' ), count_user_posts( $user_ID ) ) ?></p>
									<p><a href="mailto:<?php echo $user_mail; ?>"><?php _e('Contact Author', 'bingo'); ?></a></p>
								</div>


								<div class="e-pagination">
									<br>
							        <?php
							            ?><p class="prev_post"><?php previous_post_link('<i class="fa fa-chevron-left"></i> %link','Previous Post');
							            ?></p><p class="next_post"><?php next_post_link('%link <i class="fa fa-chevron-right"></i>','Next Post');
							        ?></p>
							    </div>



								<div class="comments-section">

									<?php wp_reset_query(); comments_template('', true ); ?>

								</div>
							</article>

		                <?php endwhile; else : ?>
		                    <article>
		                      <h1 class="h4"><?php _e( 'No Posts were Found!', 'new-item' ); ?></h1>
		                    </article>
		                <?php endif; ?>

					</div>

					<div class="col-sm-4 page-sidebar">

						<?php get_sidebar(); ?>

					</div>
				</div>
			</div>
		</div>
	</div> <!-- end #page-content -->





<?php get_footer(); ?>