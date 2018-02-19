		<div class="our-partners-section">
			<div class="container">
				<div class="title-lines">
					<h2><?php _e('Our Partners', 'bingo'); ?></h2>
				</div>

				<div class="our-partners-slider-container">
					<div class="row">
						<div class="our-partners-slider flexslider">
							<ul class="slides">
								<?php
								// the query
								$args = array( 'post_type' => 'partner' , 'posts_per_page' => -1 );
								$the_query = new WP_Query( $args ); ?>

								<?php if ( $the_query->have_posts() ) : ?>

								  <!-- pagination here -->

								  <!-- the loop -->
								  <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

								    <?php if (has_post_thumbnail()) : ?>

										<!-- <img class="image" src="holder.js/600x300/vine/auto"> -->

										<?php
											$thumb_id = get_post_thumbnail_id();
											$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'thumbnail-size', true);
											$thumb_url = $thumb_url_array[0];
										?>

										<!-- <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a> -->
										<li>
											<a href="<?php the_permalink(); ?>">
												<div class="css-table">
													<div class="css-table-cell">
														<img class="image" src="<?php echo $thumb_url; ?>">
													</div>
												</div>
											</a>
										</li>

									<?php endif; ?>

								  <?php endwhile; ?>

								  <?php wp_reset_postdata(); ?>

								<?php endif; ?>


							</ul>
						</div>
					</div>
				</div>
			</div>
		</div> <!-- end .our-partners-section -->