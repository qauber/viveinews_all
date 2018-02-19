<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
        
	<meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta property="og:title" content="Vide" />
        <meta name="keywords" content="Frequent Flyer Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
        Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />

	<title><?php 
	
		if (is_front_page()) {
			echo 'LiveiNews';
		} else {
			wp_title( '|', true, 'right' );	
		}
	
		
	
	?></title>

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
    <div id="comm">
    <img src="/wp-content/themes/bingo/img/top.png" class="top-img" />
    to use these functions 
you have to login
    </div>
		<div class="header-top-bar">
			<div class="container">

				<!-- Header Login -->
				<?php

				if($bingo_option_data['bingo-login-option']){ ?>


					<?php if (is_user_logged_in()) { ?>
					<div class="header-login logout">
							<a href="<?php echo wp_logout_url( home_url() ); ?>" class="logout btn btn-default"><i class="fa fa-power-off"></i><?php _e('Logout', 'bingo'); ?></a>
					<?php } else { ?>
                    <div class="header-register">
						<a href="<?php echo wp_logout_url( home_url() ); ?>" class="btn btn-default"><i class="fa fa-plus-circle"></i><?php _e('Singup', 'bingo'); ?></a>
						<div>
							<form method="post" action="" id="bingo_registration_form">
								<p class="status-reg"></p>
								<input type="text" name="user_name" class="form-control" placeholder="<?php _e('Username', 'bingo'); ?>">
								<input type="email" name="email" class="form-control" placeholder="<?php _e('Email', 'bingo'); ?>">
								<input type="password" name="reg_password" class="form-control" placeholder="<?php _e('Password', 'bingo'); ?>">
								<input type="submit" class="btn btn-default" name="registration_submit" id="bingo_registration_form_submit" value="<?php _e('Register', 'bingo'); ?>">
							</form>
						</div>
					</div> <!-- end .header-register -->
					<div class="header-login">
						<a href="#" class="login btn btn-default"><i class="fa fa-power-off"></i><?php _e('Login', 'bingo'); ?></a>
						<div>
							<form id="bg-login-form" method="post" action="login" role="form">
								<p class="status"></p>
								<input type="text" name="login_username" value="" class="form-control" placeholder="<?php _e('Username', 'bingo'); ?>">
								<input type="password" name="login_password" value="" class="form-control" placeholder="<?php _e('Password', 'bingo'); ?>">
								<input type="submit" class="btn btn-default" id="bg-login" name="dlf_submit" value="<?php _e('Login', 'bingo'); ?>">
								<a href="<?php echo site_url('wp-login.php?action=lostpassword', 'login_post') ?>" class="btn btn-link"><?php _e('Forgot Password?', 'bingo'); ?></a>
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

				}?>

				<!-- Mobile Search Toggle -->
				<a href="#" id="mobile-search-toggle" class="btn btn-default fa fa-search"></a>

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
				<?php } ?>

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


									if( is_array( $products ) ){

										foreach ($products as $value) {

				                            $auction_cat = get_the_terms( $value->ID, 'product_cat' );


				                            if( is_array( $auction_cat ) ){

					                            foreach ($auction_cat as $single_cat ) {

					                                array_push( $all_cat_term, $single_cat->term_id );
					                            }

					                        }

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
<?php if ( is_user_logged_in() ) { 
	$current_user = wp_get_current_user();
?>
<div style="display: table; width:100%; padding: 5px 5px 5px 0;color: #0091C9;border-bottom: 1px solid #0091c9;background:#343434;">
<span class="wb-title-info-r">
  Welcome <?php echo ucfirst($current_user->user_login); ?>! 
</span>
</div>
<?php } ?>
		<div class="header-nav-bar">
			<div class="container">
<div class='logo-div'>
				<!-- Logo -->
				<a href="<?php echo home_url(); ?>" class="logo">
					<?php
                            if(isset($bingo_option_data['bingo-favicon']['url']) && $bingo_option_data['bingo-favicon']['url']){
                                $theme_logo = $bingo_option_data['bingo-favicon']['url'];
                            }
                            else{
                                $theme_logo = IMAGES . '/header-logo.png';
                            }
                    ?>
					<img src="<?php echo $theme_logo; ?>" alt="">
				</a> <!-- end .logo -->
</div>
<?php if( is_front_page() ) { ?>
<div class='header-custom-search'>
    <form action="<?php echo esc_url( home_url( '/' ) ); ?>search-tag/" method="POST">
    <input type="text" id="search-tags" class="wb-search-tags" name="tag" onchange="wb_clear_text(this.value);" onKeyUp="wb_clear_text(this.value);" style="border: 1px solid black !important; color: black; height: 40px !important; padding: 2px 10px; max-width: 300px;" />
    <input type="submit" value="Search" style="height:42px;">
    </form>
</div>
<?php } ?>
<div class="wb-nav-r">
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
							'walker'          => new uou_walker_nav_menu(),
							'echo'			  => false
						);
						echo wp_nav_menu( $defaults );
					?>

				</nav>
</div>		
			</div> <!-- end .container -->
			<div id="mobile-menu-container" class="container">
				<div class="login-register"></div>
				<div class="menu"></div>
			</div>
		</div> <!-- end .header-nav-bar -->
<script src="//maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places&language=en"></script>
<script>

function wb_clear_text( text ) {

var re = /а|б|в|г|д|е|ё|ж|з|и|й|к|л|м|н|о|п|р|с|т|у|ф|х|ц|ч|ш|щ|ъ|ы|ь|э|ю|я|і|!|#|$|%|<|>|\s{2,}|/gi;
if(re.test(text) ) {
text = text.replace(re, ''); 
$('#search-wb-tags').val( text ); 
}

}

//function search_location() {
//var input = document.getElementById('search-wb-tags');
//var options = {
// types: ['(regions)'],
//};
//var autocomplete = new google.maps.places.Autocomplete(input, options);
//google.maps.event.addListener(autocomplete, 'place_changed', function() {
//var place = autocomplete.getPlace();
//});
//}
//google.maps.event.addDomListener(window, 'load', search_location);
</script>
<?php
if( is_front_page() ){
?>
		<div class="header-page-title">
			<div class="container">
			<!--- <h1><?php
						if( !is_home() ){
							the_title();

						}else{
							echo "Blog";
						}
						?>
                        
				</h1>-->

				<?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>

			</div>
		</div> <!-- end .header-page-title -->
<?php
} else {
//echo "<div style='padding: 20px 0 50px;'></div>";
}

if( !is_front_page() ){
?>
<style>
.wb-top-search {
    background: #0091c9 none repeat scroll 0 0;
    margin: 10px auto;
    padding: 10px;
    text-align: center;
    width: 90%;
}
.wb-search-tags {
    width:450px;
    padding: 2px 10px;
    border: 0 none;
}
</style>
<div class="wb-top-search">
<div class="center">
    <form action="<?php echo esc_url( home_url( '/' ) ); ?>search-tag/" method="POST">
    <input type="text" id="search-tags" class="wb-search-tags" name="tag" onchange="wb_clear_text(this.value);" onKeyUp="wb_clear_text(this.value);" />
    <input type="submit" value="Search">
    </form>
     <div class="clear"></div>
</div>
</div>
<?php } ?>
</header> <!-- end #header -->