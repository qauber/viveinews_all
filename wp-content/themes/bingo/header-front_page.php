<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title><?php wp_title( '|', true, 'right' );?></title>

	<meta name="description" content="<?php bloginfo('description'); ?>">
    <meta name="author" content="">

	<!--[if IE 9]>
		<script src="js/media.match.min.js"></script>
	<![endif]-->
	<?php

		global $bingo_option_data, $user_ID, $user_identity; get_currentuserinfo();

		if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
		wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php if (isset($bingo_option_data['bingo-pre-loader-button']) && $bingo_option_data['bingo-pre-loader-button'] == '1' ) { ?>

	<!-- Preloader -->
	<div id="preloader">
	    <div id="status">&nbsp;</div>
	</div>

<?php } ?>

<div id="main-wrapper">

	<header id="header">
		<div class="header-top-bar">
			<div class="container">

				<?php

				if($bingo_option_data['bingo-login-option']){ ?>

				<!-- Header Login -->
				<?php if (is_user_logged_in()) { ?>
					<div class="header-login logout">
							<a href="<?php echo wp_logout_url( home_url() ); ?>" class="logout btn btn-default"><i class="fa fa-power-off"></i><?php _e('Logout', 'bingo'); ?></a>
					<?php } else { ?>
                    	<div class="header-register">
					<a href="#" class="btn btn-default"><i class="fa fa-plus-circle"></i>Singup</a>
					<div>
						<form method="post" action="" id="bingo_registration_form">
							<p class="status-reg"></p>
							<input type="text" name="user_name" class="form-control" placeholder="Username">
							<input type="email" name="email" class="form-control" placeholder="Email">
							<input type="password" name="reg_password" class="form-control" placeholder="Password">
							<input type="submit" class="btn btn-default" name="registration_submit" id="bingo_registration_form_submit" value="<?php _e('Register', 'bingo'); ?>">
						</form>
					</div>
				</div> <!-- end .header-register -->
					<div class="header-login">
						<a href="#" class="login btn btn-default"><i class="fa fa-power-off"></i><?php _e('Login', 'bingo'); ?></a>
						<div>
							<form id="bg-login-form" method="post" action="login" role="form">
								<p class="status"></p>
								<input type="text" name="login_username" value="" class="form-control" placeholder="Username">
								<input type="password" name="login_password" value="" class="form-control" placeholder="Password">
								<input type="submit" class="btn btn-default" id="bg-login" name="dlf_submit" value="Login">
								<a href="<?php echo site_url('wp-login.php?action=lostpassword', 'login_post') ?>" class="btn btn-link"><?php _e('Forgot Password?', 'bingo'); ?><</a>
								<?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
							</form>
						</div>
					<?php } ?>

					</div> <!-- end .header-login -->

				<!-- Header Register -->
			

				<?php

				    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

				    if ( is_plugin_active('sitepress-multilingual-cms/sitepress.php') ){
				    	wpml_languages();
				    }else{
				    	?>
				    	<?php
				    	if($bingo_option_data['bingo-top-language']){ ?>
					    	<div class="header-language">
								<a href="#">
									<span><?php _e('EN', 'bingo'); ?></span>
									<i class="fa fa-chevron-down"></i>
								</a>

								<ul>
									<?php foreach ($bingo_option_data['bingo-language'] as $value) {
										?>
										<li><a href="#"><?php echo $value; ?></a></li>
										<?php
									} ?>

								</ul>
							</div> <!-- end .header-language -->
				<?php   }
					} 
				} ?>


				<!-- Mobile Search Toggle -->
				<a href="#" id="mobile-search-toggle" class="btn btn-default fa fa-search"></a>

				<!-- Call to Action -->
				<?php if($bingo_option_data['bingo-buy-button']) { ?>
					<!-- Call to Action -->
					<a href="<?php echo $bingo_option_data['bingo-buy-button-link']; ?>" class="btn btn-default header-call-to-action"><i class="fa fa-plus"></i><?php _e(' Buy Now', 'bingo'); ?></a>
				<?php } ?>

				<!-- Header Social -->
				<?php if($bingo_option_data['bingo-share-button']){ ?>
					<ul class="header-social">
						
						<?php if($bingo_option_data['bingo-facebook-link']){ ?>
							<li><a href="<?php echo $bingo_option_data['bingo-facebook-link']; ?>"><i class="fa fa-facebook-square"></i></a></li>
						<?php } ?>

						<?php if($bingo_option_data['bingo-twitter-link']){ ?>
							<li><a href="<?php echo $bingo_option_data['bingo-twitter-link']; ?>"><i class="fa fa-twitter-square"></i></a></li>
						<?php } ?>
						
						<?php if($bingo_option_data['bingo-google-link']){ ?>
							<li><a href="<?php echo $bingo_option_data['bingo-google-link']; ?>"><i class="fa fa-google-plus-square"></i></a></li>
						<?php } ?>

						<?php if($bingo_option_data['bingo-linkedin-link']){ ?>
							<li><a href="<?php echo $bingo_option_data['bingo-linkedin-link']; ?>"><i class="fa fa-linkedin-square"></i></a></li>
						<?php } ?>

						<?php if($bingo_option_data['bingo-pinterest-link']){ ?>
							<li><a href="<?php echo $bingo_option_data['bingo-pinterest-link']; ?>"><i class="fa fa-pinterest-square"></i></a></li>
						<?php } ?>
						
					</ul> <!-- end .header-social -->
				<?php } ?> <!-- end .header-social -->

				<!-- Header Search -->
                <div class="header-search" id="advanced_search">
                    <form method="get" class="search-form" id="search_form" action="<?php echo home_url(); ?>">
                        <div class="toggle">
                            <a href="#">
                                <span></span>
                            </a>

                            <?php 
                            	if (taxonomy_exists('product_cat')) {

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
			                        
			                    }

		                        if(isset($auction_cat_result) && is_array($auction_cat_result)){
                            ?>

                            <div class="header-search-dropdown">
                                <ul>
                                    <?php
				                        foreach ($auction_cat_result as $cat) { 

				                        	$term_name_by_ID = get_term_by( 'id', $cat, 'product_cat' );

				                         ?>
		                                    <li><label><input type="checkbox" name="term_list[]" class="term_check" value="<?php echo $term_name_by_ID->term_id; ?>"><?php echo $term_name_by_ID->name; ?></label></li> 
				                        <?php }
				                    ?>
                                </ul>
                            </div>
                            <?php } ?>
                        </div>
                        <input type="text" value="" name="s" id="s" onblur="if(this.value=='')this.value='search'" onfocus="if(this.value=='search')this.value=''" />
                        <input type="submit" name="submit" value="&#xf002;" id="search_submit">
                    </form>
                </div>
                <!-- end .header-search -->

                
			</div> <!-- end .container -->

			<div id="mobile-search-container" class="container"></div>
		</div> <!-- end .header-top-bar -->

		<div class="header-nav-bar">
			<div class="container">

				<!-- Logo -->
				<a href="<?php echo home_url();; ?>" class="logo">
					<?php
                        if($bingo_option_data['bingo-favicon']['url']){
                            $theme_logo = $bingo_option_data['bingo-favicon']['url'];
                        }
                        else{
                            $theme_logo = IMAGES . '/header-logo.png';
                        }
               		?>
					<img src="<?php echo $theme_logo; ?>" alt="">
				</a> <!-- end .logo --><!-- end .logo -->

				<!-- Mobile Menu Toggle -->
				<a href="#" id="mobile-menu-toggle"><span></span></a>

				<!-- Primary Nav -->
				<nav>
					<?php

						$defaults = array(
							'theme_location'  => 'primary-menu',
							'menu'            => 'primary-menu',
							'container'       => 'false',
							'menu_class'      => 'primary-nav',
							'fallback_cb'     => 'uou_walker_nav_menu::fallback',
							'depth'           => 0,
							'walker'          => new uou_walker_nav_menu()
						);

						wp_nav_menu( $defaults );

					?>

				</nav>
			</div> <!-- end .container -->

			<div id="mobile-menu-container" class="container">
				<div class="login-register"></div>
				<div class="menu"></div>
			</div>
		</div> <!-- end .header-nav-bar -->


		<?php get_template_part('slider', 'main' ); ?>



	</header> <!-- end #header -->