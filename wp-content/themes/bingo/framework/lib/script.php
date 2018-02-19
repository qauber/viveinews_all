<?php

function uou_scripts() {


	wp_enqueue_script( 'jquery' );

	wp_register_script( 'outside-events', UOU_JS .'jquery.ba-outside-events.min.js', array('jquery'), $ver = false, true );

	wp_register_script( 'flexslider', UOU_JS .'jquery.flexslider-min.js', array('jquery'), $ver = false, true );

	wp_register_script( 'inview', UOU_JS .'jquery.inview.min.js', array('jquery'), $ver = false, true );

	wp_register_script( 'responsive-tabs', UOU_JS .'jquery.responsive-tabs.js', array('jquery'), $ver = false, true );

	wp_register_script( 'fitvids-js', UOU_JS .'jquery.fitvids.js', array('jquery'), $ver = false, true );

	wp_register_script( 'mediaelement-js', UOU_JS .'mediaelement-and-player.min.js', array('jquery'), $ver = false, true );

	wp_register_script('twitter', UOU_JS .'/twitter/jquery.tweet.js', array(), $ver = true, true);

        wp_register_script('isotope', UOU_JS .'isotope.pkgd.min.js', array('jquery'), $ver = false, true);

        wp_register_script('cycle2', UOU_JS .'jquery.cycle2.min.js', array('jquery'), $ver = false, true);

        wp_register_script('jflickr', UOU_JS .'jflickrfeed.min.js', array('jquery'), $ver = false, true);

	wp_register_script( 'custom-script-new', UOU_JS .'script-custom.js', array('jquery'), $ver = false, true );

	wp_register_script( 'custom-script', UOU_JS .'scripts.js', array('jquery'), $ver = false, true );
        
	wp_register_script( 'bingo-script', UOU_JS .'script-new.js', array('jquery'), $ver = false, true );
	wp_register_script( 'bingo-vide', UOU_JS .'jquery.vide.min.js', array('jquery'), $ver = false, true );
	wp_register_script( 'bingo-wow', UOU_JS .'wow.min.js', array('jquery'), $ver = false, true );
	wp_register_script( 'bingo-owl', UOU_JS .'owl.carousel.min.js', array('jquery'), $ver = false, true );
	wp_register_script( 'bingo-bootstrap', UOU_JS .'bootstrap.min.js', array('jquery'), $ver = false, true );
	wp_register_script( 'bingo-swipebox', UOU_JS .'jquery.swipebox.min.js', array('jquery'), $ver = false, true );
	wp_register_script( 'ifvisible', UOU_JS .'ifvisible.min.js', array('jquery'), null, true );
	wp_register_script( 'bingo-location', 'https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&language=en', array('jquery'), $ver = false, false );

        wp_localize_script( 'custom-script', 'ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
        
        //only for user area page
        if ( is_page( 'userarea' ) ) {
            wp_register_script( 'flexslider-init', UOU_JS .'userarea/jquery.flexslider.init.js', array('jquery'), $ver = false, true );
            wp_register_script( 'bxslider', UOU_JS .'userarea/jquery.bxslider.js', array('jquery'), $ver = false, true );
            wp_register_script( 'bxslider-init', UOU_JS .'userarea/jquery.bxslider.init.js', array('jquery'), $ver = false, true );
            wp_register_script( 'jquery-rating', UOU_JS .'userarea/jquery.rating.js', array('jquery'), $ver = false, true );
            wp_register_script( 'jquery-tabs', UOU_JS .'userarea/jquery.idTabs.min.js', array('jquery'), $ver = false, true );
            wp_register_script( 'jquery-simplyscroll', UOU_JS .'userarea/jquery.simplyscroll.js', array('jquery'), $ver = false, true );
            wp_register_script( 'fluidvids', UOU_JS .'userarea/fluidvids.min.js', array('jquery'), $ver = false, true );
            wp_register_script( 'jpages', UOU_JS .'userarea/jPages.js', array('jquery'), $ver = false, true );
            wp_register_script( 'sidr', UOU_JS .'userarea/jquery.sidr.min.js', array('jquery'), $ver = false, true );
            wp_register_script( 'touchswipe', UOU_JS .'userarea/jquery.touchSwipe.min.js', array('jquery'), $ver = false, true );
            wp_register_script( 'userarea-script', UOU_JS .'userarea/custom.js', array('jquery'), $ver = false, true );
        
            wp_enqueue_script( 'flexslider-init');
            wp_enqueue_script( 'bxslider');
            wp_enqueue_script( 'bxslider-init');
            wp_enqueue_script( 'jquery-rating');
            wp_enqueue_script( 'jquery-tabs');
            wp_enqueue_script( 'jquery-simplyscroll');
            wp_enqueue_script( 'fluidvids');
            wp_enqueue_script( 'jpages');
            wp_enqueue_script( 'sidr');
            wp_enqueue_script( 'touchswipe');
            wp_enqueue_script( 'userarea-script');
        }
        
        

	wp_enqueue_script( 'outside-events' );
	wp_enqueue_script( 'flexslider' );
	wp_enqueue_script( 'inview' );
	wp_enqueue_script( 'responsive-tabs' );
	wp_enqueue_script( 'fitvids-js' );
	wp_enqueue_script( 'mediaelement-js' );
        wp_enqueue_script('twitter');
        wp_enqueue_script('isotope');
        wp_enqueue_script('cycle2');
        wp_enqueue_script('jflickr');
	wp_enqueue_script( 'custom-script-new' );
	wp_enqueue_script( 'custom-script' );
	wp_enqueue_script( 'ifvisible' );
	wp_enqueue_script( 'bingo-script' );
	wp_enqueue_script( 'bingo-vide' );
	wp_enqueue_script( 'bingo-wow' );
	wp_enqueue_script( 'bingo-owl' );
	wp_enqueue_script( 'bingo-bootstrap' );
	wp_enqueue_script( 'bingo-swipebox' );
	wp_enqueue_script( 'bingo-location' );
}


add_action( 'wp_enqueue_scripts', 'uou_scripts' );


