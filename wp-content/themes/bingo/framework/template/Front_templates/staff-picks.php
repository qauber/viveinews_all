	<div class="staff-picks-section white-bg">
			<div class="container">
				<div class="title-lines">
					<h3><?php _e('Staff Picks', 'bingo'); ?></h3>
				</div>

				<div class="responsive-tabs vertical">
					<?php

						$args = array(
							'post_type'	=> 'product',
							'post_status' => 'publish',
							'ignore_sticky_posts'	=> 1,
							'orderby' => 'title',
							'order' => 'asc',
							'posts_per_page' => -1,
							'tax_query' => array(array('taxonomy' => 'product_type' , 'field' => 'slug', 'terms' => 'auction')),
							'auction_arhive' => TRUE,
							'meta_query' => array(
								array(
									'key' 		=> '_visibility',
									'value' 	=> array('catalog', 'visible'),
									'compare' 	=> 'IN'
								)
							)
						);

						$products = get_posts($args);

						$all_cat_term = array();

						foreach ($products as $value) {

                            $auction_cat = get_the_terms( $value->ID, 'product_cat' );

                            foreach ($auction_cat as $single_cat ) {

                                array_push( $all_cat_term, $single_cat->term_id );
                            }

                        }

                        $auction_cat_result = array_unique($all_cat_term);

						?>

					<ul class="nav nav-tabs">
						<?php
						$first = true;
						foreach ($auction_cat_result as $cat) {

							$term_name_by_ID = get_term_by( 'id', $cat, 'product_cat' );

							if ($first)
						    {
						        ?>
						        <li class="active"><a href="#cat-<?php echo $term_name_by_ID->term_id; ?>"><?php echo $term_name_by_ID->name; ?></a></li>
						        <?php
						        $first = false;
						    }
						    else{
						    	?>
						    	<li><a href="#cat-<?php echo $term_name_by_ID->term_id; ?>"><?php echo $term_name_by_ID->name; ?></a></li>
						    	<?php
						    }
							?>


					<?php
						}
						?>
					</ul>

					<div class="tab-content unstyled">

						<?php

							$first = true;
							?>

							<?php foreach ($products as $single_product): ?>

								<?php $blabla = get_post_meta($single_product->ID);	?>

								<?php $post_category = get_the_terms( $single_product->ID, 'product_cat' );
								foreach ($post_category as $value) :

									if($first){
										?>
											<div class="tab-pane active" id="cat-<?php echo $value->term_id; ?>">
										<?php
										$first = false;
									}else{
										?>
										<div class="tab-pane" id="cat-<?php echo $value->term_id; ?>">
										<?php
									}
									?>

										<!-- <div class="tab-pane" id="cat-<?php echo $value->term_id; ?>"> -->
											<div class="row">
												<div class="col-md-4 small-col">

													<?php if (has_post_thumbnail( $single_product->ID )) : ?>

														<?php
															$thumb_id = get_post_thumbnail_id( $single_product->ID );
															$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'thumbnail-size', true);
															$thumb_url = $thumb_url_array[0];
														?>

														<!-- <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a> -->
														<a href="<?php echo mk_get_guid($single_product->guid); ?>"><img src="<?php echo $thumb_url; ?>" alt=""></a>

													<?php else : ?>
														<a href="<?php echo mk_get_guid($single_product->guid); ?>"><img src="<?php print IMAGES; ?>/no-image-big.jpg" alt=""></a>
													<?php endif; ?>

													<hr>
													<a href="<?php echo get_term_link( $value->term_id, 'product_cat' ); ?>" class="btn btn-default"><i class="fa fa-heart-o"></i><?php _e('See All Projects in Category', 'bingo'); ?></a>
												</div>

												<div class="col-md-8 big-col">
													<h4><?php echo $single_product->post_title; ?></h4>
														<?php $user_ID = $single_product->post_author;

														?>
													<ul class="list-unstyled">
														<li><i class="fa fa-user"></i><?php _e('Auction by ', 'bingo'); ?><a href="#"><?php echo get_the_author_meta('display_name', $user_ID ); ?></a></li>
														<li><i class="fa fa-flag"></i><?php _e('From ', 'bingo'); ?><a href="#"><?php echo $single_product->post_date; ?></a></li>
													</ul>

													<p>
													<?php 
														//echo $single_product->post_content; 
														$content = $single_product->post_content;;
														$trimmed_content = wp_trim_words( $content, 30 );
														echo $trimmed_content;
													?>
													</p>

													<div class="project-meta-table auction">
														<ul>
															<li>
																<span>
																	<?php
																		if(isset($blabla['_auction_bid_count']['0'])){
																			echo $blabla['_auction_bid_count']['0'] . ' ';
																			?>
																			</span><?php _e('Bids', 'bingo'); ?>
																			<?php
																		}
																		else{
																			echo "No";
																			?>
																			</span><?php _e('Bids', 'bingo'); ?>
																			<?php
																		}
																	?>
															</li>
															<li><span class="capital_first"><?php echo $blabla['_auction_item_condition']['0'] ?></span><?php _e('Condition', 'bingo'); ?></li>
															<li><span><?php echo get_woocommerce_currency_symbol(); ?> <?php echo $blabla['_price']['0']; ?></span><?php _e('Buy Now Prize', 'bingo'); ?></li>
															<?php
																$now = time(); // or your date as well
															    $your_date = strtotime($blabla['_auction_dates_to']['0']);
															    $datediff = $your_date - $now;
															?>
															<li><span>
																	<?php
																		if( $datediff > 0 ){
																			echo floor($datediff/(60*60*24)); ?>
																			</span>
																			<?php _e('Days to go', 'bingo');
																		}else{
																			echo "Auction"; ?>
																			</span>
																			<?php _e('Expired', 'bingo');

																		}
																	?>
															</li>
														</ul>

														<div class="bid">

																<?php
																	if(isset($blabla['_auction_current_bid']['0'])){
																		_e('Current Bid:', 'bingo'); 
																		?> 
																		<span> 
																		<?php
																		echo get_woocommerce_currency_symbol() . ' ';
																		echo $blabla['_auction_current_bid']['0'];
																	}else{
																		_e('Starting Bid: ', 'bingo');
																		?>
																		<span>
																		<?php
																		echo get_woocommerce_currency_symbol() . ' ';
																		echo " " . $blabla['_auction_start_price']['0'];
																		// _e('No Bids for this auction', 'bingo');
																	}
																?>
															</span>
														</div>

														<div class="buttons">
															<a href="<?php echo mk_get_guid($single_product->guid); ?>" class="btn btn-default"><i class="fa fa-plus"></i><?php _e('Bid Project', 'bingo'); ?></a>
														</div>
													</div>
												</div>
											</div>
										</div>
									<?php endforeach; ?>
							<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div> <!-- end .crowdfunding-section -->