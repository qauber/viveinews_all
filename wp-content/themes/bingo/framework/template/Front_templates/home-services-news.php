<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$args = array(
        'post_type'	=> 'service',
        'post_status' => 'publish',
        'ignore_sticky_posts'	=> 1,
        'orderby' => 'date',
        'order' => 'desc',
        'count' => 4,
        'posts_per_page' => 4,
);

$posts = get_posts($args);

//print_r($posts);



?>

<!-- services -->
	<div class="services" id="services">
		<div class="container">
			<div class="services-grids">
				<div class="col-md-6 services-grid-left animated wow bounceInLeft" data-wow-delay="500ms">
					<div class="banner-bottom-text">
						<h3>Offered</h3>
						<div class="banner-bottom-text-pos">
							<h3>Services</h3>
						</div>
					</div>
					<div class="bar1 bar-con bar-con1">
						<div class="bar3" data-percent="70"></div>
					</div>
				</div>
				<div class="col-md-12 services-grid-right">
                                    
                                    <?php 
                                        foreach ($posts as $post) {
                                        if (has_post_thumbnail( $post->ID )){ 
                                                $thumb_id = get_post_thumbnail_id( $single_product->ID );
                                                $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'latest-thumb', true);
                                                $thumb_url = $thumb_url_array[0];
                                        }

                                        $content = $post->post_content;
                                        $trimmed_content = wp_trim_words( $content, 30 );

                                        $box_image_url = $thumb_url ? $thumb_url : IMAGES . "/no-image-big.jpg";
                                    
                                    ?>
                                    
					<div class="col-md-3 services-grid-right-grid">
						<div class="services-grid-right-grid1">
							<img src="<?php echo $box_image_url; ?>" alt=" " class="img-responsive" />
							<!-- Button trigger modal -->
							<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#<?php echo $post->post_name; ?>">
							  <?php echo $post->post_title; ?>
							</button>

							<!-- Modal -->
							<div class="modal fade" id="<?php echo $post->post_name; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							  <div class="modal-dialog" role="document">
								<div class="modal-content">
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="myModalLabel"><?php echo $post->post_title; ?></h4>
								  </div>
								  <div class="modal-body">
									<?php echo $content; ?>
								  </div>
								</div>
							  </div>
							</div>
							<p><?php echo $trimmed_content; ?></p>
						</div>
					</div>
                                        <?php } ?>
					<div class="clearfix"> </div>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
<!-- //services -->