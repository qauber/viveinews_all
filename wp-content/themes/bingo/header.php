<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
        
	<meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta property="og:title" content="Vide" />
        <meta name="keywords" content="Frequent Flyer Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
        Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />

	<title>
            <?php 
		if (is_front_page()) {
			echo 'LiveiNews';
		} else {
			wp_title( '|', true, 'right' );	
		}
            ?>
        </title>

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
        <div class="center-container">
                <div class="navigation">
                    
                    <div class='logo-div'>
                        <!-- Logo -->
                        <a href="<?php echo home_url(); ?>" class="logo">
                            <?php
                            if (isset($bingo_option_data['bingo-favicon']['url']) && $bingo_option_data['bingo-favicon']['url']) {
                                $theme_logo = $bingo_option_data['bingo-favicon']['url'];
                            } else {
                                $theme_logo = IMAGES . '/header-logo.png';
                            }
                            ?>
                            <img src="<?php echo $theme_logo; ?>" alt="">
                        </a> <!-- end .logo -->
                    </div>
                    
                    <div class="navigation-left animated wow slideInLeft" data-wow-delay="700ms">
                        <ul>
                            <?php if ($bingo_option_data['bingo-phone-header']){ ?>
                                <li><span class="glyphicon glyphicon-earphone" aria-hidden="true"></span><?php echo $bingo_option_data['bingo-phone-header'] ?></li>
                            <?php } ?>
                            <?php if ($bingo_option_data['bingo-email-header']){ ?>
                                <li><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span><a href="mailto:<?php echo $bingo_option_data['bingo-email-header'] ?>"><?php echo $bingo_option_data['bingo-email-header'] ?></a></li>
                            <?php } ?>
                            
                        </ul>
                    </div>
                    
                    <div class="header-custom-search input-group">
                        <form action="/search-tag/" method="POST">
                            <input type="text" id="search-tags" class="form-control" placeholder="Search by location" name="tag" onchange="wb_clear_text(this.value);" onkeyup="wb_clear_text(this.value);">
                            <span class="input-group-btn">
                                 <button class="btn btn-info" type="submit">Search</button>
                            </span>
                        </form>
                     </div>
                    
                    <div class="navigation-right">
                        <span class="menu"><img src="<?php echo get_template_directory_uri() ?>/img/menu.png" alt=" " /></span>
                        <nav class="link-effect-4" id="link-effect-4">
                                <?php

                                        $defaults = array(
                                                'theme_location'  => 'primary-menu',
                                                'menu'            => 'primary-menu',
                                                'container'       => 'false',
                                                'menu_class'      => 'nav1 nav nav-wil',
                                                'fallback_cb'     => 'uou_walker_nav_menu::fallback',
                                                'depth'           => 0,
                                                'walker'          => new uou_walker_nav_menu(),
                                                'echo'            => false
                                        );
                                        echo wp_nav_menu( $defaults );
                                ?>
                        </nav>
                    </div>
                    
                    <div class="clearfix"></div>
                </div>
        </div>