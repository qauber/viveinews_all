	<div class="latest-campaigns-section white-bg">
			<div class="container">
				<div class="title-lines">
					<h3><?php _e('Latest Auctions', 'bingo'); ?></h3>
				</div>

				<!-- <div class="responsive-tabs"> -->
<!-- 					<ul class="nav nav-tabs">
						<li class="active"><a href="#latest-campaigns-auctions-of-projects"><?php _e('Auctions of Projects', 'bingo'); ?></a></li>
					</ul> -->

					<div class="tab-content unstyled">

						<div class="tab-pane active" id="latest-campaigns-auctions-of-projects">
							<div class="cycle-slideshow" data-cycle-slides="> ul > li" data-cycle-paused="true">
								<ul>

									<?php

										$args = array(
											'post_type'	=> 'product',
											'post_status' => 'publish',
											'ignore_sticky_posts'	=> 1,
											'orderby' => 'title',
											'order' => 'asc',
											'posts_per_page' => 3,
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

										foreach ($products as $single_product):
											// print_r($single_product);
											$blabla = get_post_meta($single_product->ID);
											?>

											<li>
												<div class="row campaigns-item">
													<div class="col-md-5 col-lg-6">

														<?php if (has_post_thumbnail( $single_product->ID )) : ?>

															<?php
																$thumb_id = get_post_thumbnail_id( $single_product->ID );
																$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'latest-thumb', true);
																$thumb_url = $thumb_url_array[0];
															?>

															<!-- <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a> -->
															<a href="<?php echo mk_get_guid($single_product->guid); ?>"><img src="<?php echo $thumb_url; ?>" alt=""></a>

														<?php else : ?>
															<a href="<?php echo mk_get_guid($single_product->guid); ?>"><img src="<?php print IMAGES; ?>/no-image-big.jpg" alt=""></a>
														<?php endif; ?>

													</div>

													<div class="col-md-7 col-lg-6 col-sm-12">
														<h4><?php echo $single_product->post_title; ?></h4>

														<p>
														<?php 

															// echo $single_product->post_content;
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
																<li><span><?php echo get_woocommerce_currency_symbol(); ?> <?php echo $blabla['_price']['0']; ?></span><?php _e('Buy Now Price', 'bingo'); ?></li>
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
											</li>
										<?php endforeach; ?>
								</ul>
								<div class="cycle-pager"></div>
							</div>
						</div>
					<!-- </div> -->
				</div>
			</div>
		</div> <!-- end .crowdfunding-section -->