<?php

/*
Template Name: Home Page
*/

get_header('homepage');

global $woocommerce, $product, $post;
?>
<!-- banner-bottom -->
	<div class="banner-bottom">
		<div class="container">
			<div class="col-md-6 banner-bottom-left animated wow bounceInLeft" data-wow-delay="700ms">
				<div class="banner-bottom-text">
					<h2>Breaking</h2>
					<div class="banner-bottom-text-pos">
						<h3>News</h3>
					</div>
				</div>
				<div class="bar1 bar-con">
					<div class="bar" data-percent="70"></div>
				</div>
				<p><?php the_content(); ?></p>
				<div class="social">
					<ul class="social-nav model-8">
						<li><a href="#" class="facebook"><i></i></a></li>
						<li><a href="#" class="twitter"><i> </i></a></li>
						<li><a href="#" class="g"><i></i></a></li>
						<li><a href="#" class="p"><i></i></a></li>
					</ul>
				</div>
			</div>
			<?php get_template_part( 'framework/template/Front_templates/home-breaking-news', '' ); ?>
			<div class="clearfix"> </div>
                        <?php get_template_part( 'framework/template/Front_templates/home-breaking-carousel', '' ); ?>
                        
		</div>
	</div>
<!-- //banner-bottom -->
        <!-- about -->
        <?php 
            $page_slug = 'about-us';
            $page_data = get_page_by_path($page_slug, $output = OBJECT, $post_type = 'home_page_section');
            $page_id = $page_data->ID;
            $thumb = get_the_post_thumbnail( $page_id, 'full', array( 'class' => 'img-responsive' ) );
            $thumb_id = get_post_thumbnail_id($page_id);
            if ($thumb_id){
                $attachment_meta = wp_get_attachment($thumb_id);
            }
            
//            print_r($attachment_meta);
        ?>
        <div class="about" id="about">
            <div class="container">
                <div class="about-grids animated wow lightSpeedIn" data-wow-delay="700ms">
                    <div class="col-md-6 about-grid-left">
                        <div class="grid">
                            <figure class="effect-moses">
                                <?php echo $thumb; ?>
                                <?php if ($attachment_meta){ ?>
                                <figcaption>
                                    <h3><?php echo $attachment_meta['caption']; ?></h3>
                                    <p><?php echo $attachment_meta['description']; ?></p>
                                </figcaption>		
                                <?php  } ?>
                            </figure>
                        </div>
                    </div>
                    <div class="col-md-6 about-grid-right">
                        <div class="banner-bottom-text">
                            <h3>About</h3>
                            <div class="banner-bottom-text-pos banner-bottom-text-pos1">
                                <h3>Us</h3>
                            </div>
                        </div>
                        <div class="bar1 bar-con bar-con1">
                            <div class="bar2" data-percent="70"></div>
                        </div>

                        <?php echo apply_filters('the_content', $page_data->post_content); ?>
                    </div>
                    <div class="clearfix"> </div>
                </div>
            </div>
        </div>
        <!-- //about -->
        
        
        <!-- team -->
        
        <?php 
            $args = array(
                    'post_type'	=> 'team',
                    'post_status' => 'publish',
                    'ignore_sticky_posts'	=> 1,
                    'orderby' => 'date',
                    'order' => 'asc',
                    'count' => 4,
                    'offset' => 0,
                    'posts_per_page' => 4,
            );
            $teams = get_posts($args);
        ?>
        <div class="team">
		<div class="container">
                    <?php 
                        foreach($teams as $team){ 
                            if (has_post_thumbnail( $team->ID )){ 
                                $thumb_id = get_post_thumbnail_id( $team->ID );
                                $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'latest-thumb', true);
                                $thumb_url = $thumb_url_array[0];
                                
                                $content = $team->post_content;
                                $trimmed_content = wp_trim_words( $content, 30 );

                                $box_image_url = $thumb_url;
                                
                                $team_meta = get_post_meta($team->ID);
//                                print_r($team_meta);
                                
                            }
                            ?>
                            <div class="col-md-3 team-grid animated wow fadeInDown" data-wow-delay="500ms">
                                <div class="team-grid1">
                                    <img src="<?php echo $box_image_url; ?>" alt=" " class="img-responsive" />
                                    <div class="team-grid1-pos">
                                        <ul class="social-nav model-8 social-icons">
                                            <?php if ($team_meta['_bingo_team_social_social_facebook'][0]){?>
                                                <li><a href="<?php echo $team_meta['_bingo_team_social_social_facebook'][0]; ?>" class="facebook"><i></i></a></li>
                                            <?php } ?>
                                            <?php if ($team_meta['_bingo_team_social_social_twitter'][0]){?>
                                                <li><a href="<?php echo $team_meta['_bingo_team_social_social_twitter'][0]; ?>" class="twitter"><i> </i></a></li>
                                            <?php } ?>
                                            <?php if ($team_meta['_bingo_team_social_social_gp'][0]){?>
                                                <li><a href="<?php echo $team_meta['_bingo_team_social_social_gp'][0]; ?>" class="g"><i></i></a></li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                                <p><?php echo $content; ?></p>
                                <h3><?php echo $team->post_title; ?></h3>
                            </div>
                            
                            <?php
                        }
                    ?>
			
			
			<div class="clearfix"></div>
		</div>
	</div>
        
        <!-- //team -->
        
        <!-- about-bottom -->
        <?php 
            $page_slug = 'about-banner';
            $page_data = get_page_by_path($page_slug, $output = OBJECT, $post_type = 'home_page_section');
            $page_id = $page_data->ID;
            $thumb_id = get_post_thumbnail_id($page_id);
            $thumb_url = wp_get_attachment_image_src( $thumb_id,'full' );
            if ($thumb_url){
                $thumb_style = 'background: url('. $thumb_url[0] .') no-repeat 0px 0px; background-size: cover;';
            }
            
//            print_r($attachment_meta);
        ?>
        
	<div class="about-bottom animated wow bounceInDown" data-wow-delay="500ms" style='<?php echo $thumb_style; ?>'>
		<div class="container">
                    <?php echo $page_data -> post_content; ?>
			
		</div>
	</div>
        <!-- //about-bottom -->
        
        <?php get_template_part( 'framework/template/Front_templates/home-services-news', '' ); ?>
        
        <?php get_template_part( 'framework/template/Front_templates/home-video-gallery', '' ); ?>

        <?php get_template_part( 'framework/template/Front_templates/home-download-apps', '' ); ?>
        
        <?php get_template_part( 'framework/template/Front_templates/home-contact-info', '' ); ?>
        

<?php get_footer(); ?>


