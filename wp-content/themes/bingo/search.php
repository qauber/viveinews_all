<?php get_header(); ?>

	<div id="page-content">
		<div class="page-content">
			<div class="container">
				<?php 
					$gets = $_GET; 
					if(!empty($gets)) : 
					extract($gets);

					if( isset( $term_list ) ){
						// echo "advanced";

						$args = array(
	                        'post_type' => 'product',
	                        's'         => $s,
	                        'tax_query' => array(
	                            'relation' => 'OR',
	                            array(
	                                'taxonomy' => 'product_cat',
	                                'field'    => 'id',
	                                'terms'    => $term_list,
	                                'operator' => 'IN'
	                            ),
	                            array(
	                                'taxonomy' => 'product_type' ,
	                                'field' => 'slug',
	                                'terms' => 'auction',
	                                'operator' => 'IN'
	                            ),
	                        ),
	                    );

	                    $products = get_posts( $args );

                        $couting = count($products);

	                    ?>
	                    	<header class="well">
								<h1><?php printf( __( 'Search Results for: %s', 'bingo' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
								<?php 

									$terms_final = "";
									foreach ($term_list as $term) {
										// print_r($term);
										$terms_ss = get_term_by( 'id', $term ,'product_cat' );
										$terms_final .= $terms_ss->name . ", ";
									}

								?>
								<h5><?php _e('You have selected these categories : ', 'bingo'); echo $terms_final; ?></h5>
							</header>

                            <?php 
                                
                                if(!$couting) {
                                    ?>
                                        <div class="entry-content">
                                            <p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'bingo' ); ?></p>
                                            <?php get_search_form(); ?>
                                        </div><!-- .entry-content -->
                                    <?php
                                }   

                            ?>

							<div class="responsive-tabs project-list-tabs">

                            	<div class="tab-pane active" id="project-list-tab-auction">

                                	<div class="row">

	                    <?php

										foreach ($products as $single_product): ?>

                                            <?php //print_r($single_product); ?>

                                            <?php $blabla = get_post_meta($single_product->ID); //print_r($blabla); ?>

                                            <?php $product_terms = get_the_terms( $single_product->ID, 'product_cat'); //print_r($product_terms); 

                                            ?>

          							<div class="col-lg-3 filter-item">
                                        <article class="project-list-post auction">
                                            <a href="<?php echo mk_get_guid($single_product->guid); ?>">

                                            <?php if (has_post_thumbnail( $single_product->ID )) : ?>

                                                <?php
                                                    $thumb_id = get_post_thumbnail_id( $single_product->ID );
                                                    $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'product-thumb', true);
                                                    $thumb_url = $thumb_url_array[0];
                                                ?>

                                                    <img class="post-image" src="<?php echo $thumb_url; ?>">

                                                <?php else : ?>
                                                    <img class="post-image" src="<?php print IMAGES; ?>/content/category-image-1.png">
                                                <?php endif; ?>


                                            </a>
                                            <div class="post-inner">
                                                <div class="post-price">
                                                    <span><?php echo get_woocommerce_currency_symbol(); ?> <?php echo $blabla['_price']['0']; ?></span>
                                                </div>

                                                <div class="post-description">
                                                    <h2><a href="<?php echo mk_get_guid($single_product->guid); ?>"><?php echo $single_product->post_title ?></a>
                                                    </h2>

                                                    <p><?php echo wp_trim_words($single_product->post_content, 20); ?></p>
                                                </div>

                                                <ul class="post-meta">
                                                    <li><!-- <strong>967</strong>Bids -->
                                                        <strong>
                                                        <?php
                                                            if(isset($blabla['_auction_bid_count']['0'])){
                                                                echo $blabla['_auction_bid_count']['0'] . ' ';
                                                                ?>
                                                                </strong><?php _e('Bids', 'bingo'); ?>
                                                                <?php
                                                            }
                                                            else{
                                                                echo "No";
                                                                ?>
                                                                </strong><?php _e('Bids', 'bingo'); ?>
                                                                <?php
                                                            }
                                                        ?>
                                                    </li>
                                                    <li><strong><?php echo $blabla['_auction_item_condition']['0']; ?></strong><?php _e(' Condition', 'bingo'); ?></li>

                                                    <?php
                                                        $now = time(); // or your date as well
                                                        $your_date = strtotime($blabla['_auction_dates_to']['0']);
                                                        $datediff = $your_date - $now;
                                                    ?>

                                                    <li>
                                                        <strong>
                                                            <?php
                                                                if( $datediff > 0 ){
                                                                    echo floor($datediff/(60*60*24));
                                                                    ?>
                                                                    </strong>
                                                                    <?php _e('Days to go', 'bingo');
                                                                }else{
                                                                    echo "Auction Expired";
                                                                    ?>
                                                                    </strong>
                                                                    <?php
                                                                }
                                                            ?>
                                                    </li>
                                                </ul>

                                                <div class="post-overlay">
                                                    <div class="css-table">
                                                        <div class="css-table-cell">
                                                            <h2><a href="<?php echo mk_get_guid($single_product->guid); ?>"><?php echo $single_product->post_title ?></a>
                                                            </h2>

                                                            <ul>
                                                                <li><i class="fa fa-user"></i> <?php the_author_meta('display_name', $single_product->post_author); ?></a></p></li>
                                                                <li><i class="fa fa-flag"></i> 
                                                                    <?php 

                                                                        if( isset($blabla['_auction_current_bid']['0'] )){
                                                                            _e('Current Bid : ', 'bingo');
                                                                            echo get_woocommerce_currency_symbol(); 
                                                                            echo " " . $blabla['_auction_current_bid']['0']; 
                                                                        }else{
                                                                            _e('Starting Bid : ', 'bingo');
                                                                            echo get_woocommerce_currency_symbol(); 
                                                                            echo " " . $blabla['_auction_start_price']['0'];
                                                                        }

                                                                    ?>
                                                                </li>
                                                                <li><i class="fa fa-calendar"></i> <?php echo $single_product->post_date; ?></li>
                                                            </ul>

                                                            <a href="<?php echo mk_get_guid($single_product->guid); ?>"><div class="btn btn-default"><i class="fa fa-arrow-right"></i> <?php _e(' Bid Now', 'bingo'); ?></div></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                

                                    <?php
                                    endforeach; ?>

                                    </div>
                            </div>
                        </div>

                        <?php

        // _log($the_query);

	                    // print_r($the_query);
	                    // exit();
					}else{
						//normal search start
						?>



				<div class="row">
					<div class="col-sm-8">

                		<?php if(have_posts()) : ?>

	                		<header class="well">
								<h1><?php printf( __( 'Search Results for: %s', 'bingo' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
							</header>


	                		<?php while(have_posts()) : the_post(); ?>

	                			<?php get_template_part( 'framework/template/format/content', get_post_format() ); ?>

				            <?php endwhile; ?>

				        <?php else : ?>

				            <article class="post no-results not-found blog-post" id="post-0">

								<header class="well">
									<h1><?php _e( 'Nothing Found', 'bingo' ); ?></h1>
								</header>

								<div class="entry-content">
									<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'bingo' ); ?></p>
									<?php get_search_form(); ?>
								</div><!-- .entry-content -->

							</article>

				        <?php endif; ?>

				        <div class="e-pagination">
							<br>
					        <?php
					            ?><p class="prev_post"><?php previous_post_link('<i class="fa fa-chevron-left"></i> %link','Previous Post');
					            ?></p><p class="next_post"><?php next_post_link('%link <i class="fa fa-chevron-right"></i>','Next Post');
					        ?></p>
					    </div>

					</div>

					<div class="col-sm-4 page-sidebar">

						<?php get_sidebar(); ?>

					</div>

					<?php
					}
				endif; 
				//normal search end

				?>


				</div>
			</div>
		</div>


<?php get_footer(); ?>