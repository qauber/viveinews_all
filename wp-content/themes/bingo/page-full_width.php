<?php

/*
Template Name: Full Width Page
*/


get_header(); ?>


	<div id="page-content">
		<div class="page-content">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">

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

								<hr>

								<div class="content">
									<?php echo do_shortcode(get_the_content()); ?>
								</div>

								<!-- for social sharer -->
								<?php get_template_part( 'framework/template/sharer', '' ); ?>


								<?php wp_link_pages( ); ?>

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

				</div>
			</div>
		</div>
	</div>


<?php get_footer(); ?>