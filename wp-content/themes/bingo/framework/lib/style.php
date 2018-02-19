<?php

function uou_style(){

  	// wp_register_style('flexslider', UOU_CSS.'flexslider.css', array(), $ver = false, $media = 'all');
  	// wp_enqueue_style('flexslider');

//    wp_register_style('bingo-main-style', get_template_directory_uri().'/style.css', array(), $ver = false, $media = 'all');
//    wp_enqueue_style('bingo-main-style');
//    wp_register_style('main-style', UOU_CSS.'style.css', array(), $ver = false, $media = 'all');
//    wp_enqueue_style('main-style');
//    wp_register_style('custom-style', UOU_CSS.'style-custom.css', array(), $ver = false, $media = 'all');
//    wp_enqueue_style('custom-style');
    if ( !is_page( 'userarea' ) ) {
        wp_register_style('bingo-bootstrap', get_template_directory_uri().'/css/bootstrap.min.css', array(), $ver = false, $media = 'all');
        wp_enqueue_style('bingo-bootstrap');
        wp_register_style('bingo-new-style', get_template_directory_uri().'/css/style-new.css', array(), $ver = false, $media = 'all');
        wp_enqueue_style('bingo-new-style');
        wp_register_style('bingo-swipebox', get_template_directory_uri().'/css/swipebox.css', array(), $ver = false, $media = 'all');
        wp_enqueue_style('bingo-swipebox');
        wp_register_style('bingo-animate', get_template_directory_uri().'/css/animate.min.css', array(), $ver = false, $media = 'all');
        wp_enqueue_style('bingo-animate');
        wp_register_style('bingo-owl', get_template_directory_uri().'/css/owl.carousel.css', array(), $ver = false, $media = 'all');
        wp_enqueue_style('bingo-owl');
        wp_register_style('bingo-swipebox', get_template_directory_uri().'/css/swipebox.css', array(), $ver = false, $media = 'all');
        wp_enqueue_style('bingo-swipebox');
    }
    
//for userarea page template          
    if ( is_page( 'userarea' ) ) {
        wp_register_style('bingo-bootstrap', get_template_directory_uri().'/css/bootstrap.min.css', array(), $ver = false, $media = 'all');
        wp_enqueue_style('bingo-bootstrap');
    wp_register_style('userarea-style', get_template_directory_uri().'/css/userarea/style.css', array(), $ver = false, $media = 'all');
    wp_register_style('swipemenu', get_template_directory_uri().'/css/userarea/swipemenu.css', array(), $ver = false, $media = 'all');
    wp_register_style('flexslider', get_template_directory_uri().'/css/userarea/flexslider.css', array(), $ver = false, $media = 'all');
    wp_register_style('bootstrap-responsive', get_template_directory_uri().'/css/userarea/bootstrap-responsive.css', array(), $ver = false, $media = 'all');
    wp_register_style('jquery-simplyscroll', get_template_directory_uri().'/css/userarea/jquery.simplyscroll.css', array(), $ver = false, $media = 'all');
    wp_register_style('jpages', get_template_directory_uri().'/css/userarea/jPages.css', array(), $ver = false, $media = 'all');
    wp_register_style('jquery-rating', get_template_directory_uri().'/css/userarea/jquery.rating.css', array(), $ver = false, $media = 'all');
    wp_register_style('ie', get_template_directory_uri().'/css/userarea/ie.css', array(), $ver = false, $media = 'all');
    wp_register_style('userarea-bootstrap', get_template_directory_uri().'/css/userarea/bootstrap.css', array(), $ver = false, $media = 'all');
    wp_register_style('bingo-new-style', get_template_directory_uri().'/css/style-new.css', array(), $ver = false, $media = 'all');
    
    wp_enqueue_style('userarea-style');
    wp_enqueue_style('swipemenu');
    wp_enqueue_style('flexslider');
    wp_enqueue_style('jquery-simplyscroll');
    wp_enqueue_style('jpages');
    wp_enqueue_style('jquery-rating');
    wp_enqueue_style('ie');
    wp_enqueue_style('userarea-bootstrap');
    wp_enqueue_style('bootstrap-responsive');
    wp_enqueue_style('bingo-new-style');
    }
  

    $protocol = is_ssl() ? 'https' : 'http';
    wp_enqueue_style( 'bingo-roboto', "$protocol://fonts.googleapis.com/css?family=Roboto+Slab:400,700" );
    wp_enqueue_style( 'bingo-vollkorn', "$protocol://fonts.googleapis.com/css?family=Vollkorn:400,400italic,700,700italic" );
    wp_enqueue_style( 'bingo-cabin', "$protocol://fonts.googleapis.com/css?family=Cabin:400,400italic,500,500italic,600,600italic,700,700italic" );

}

add_action( 'wp_enqueue_scripts','uou_style' );




/**
*######################################################################
*#  add cutom style from redux
*######################################################################
*/



function bingo_custom_style(){

  global $bingo_option_data;

  ?>

  <style type="text/css">

  body {
      color:  <?php echo $bingo_option_data['bingo-body-color']; ?>;

  }
  a:hover, a:focus {
    color: <?php echo $bingo_option_data['bingo-color-secondary']; ?>;
  }
  .links-widget li a:hover {
    color: <?php echo $bingo_option_data['bingo-color-primary']; ?>;
  }
  .btn-default{
      color: <?php echo $bingo_option_data['bingo-button-text-color']; ?>;
      border-bottom: 2px solid <?php echo $bingo_option_data['bingo-color-secondary']; ?>;
      background-color: <?php echo $bingo_option_data['bingo-color-primary']; ?>;
      border-color: <?php echo $bingo_option_data['bingo-color-secondary']; ?>;
  }
  .btn-default:hover,
  .btn-default:focus,
  .btn-default:active,
  .btn-default.active {
    color: <?php echo $bingo_option_data['bingo-button-text-color']; ?>;
    border-color: <?php echo $bingo_option_data['bingo-button-hover-secondary']; ?>;
    background-color: <?php echo $bingo_option_data['bingo-button-hover-primary']; ?>;
  }

    .auction-widget .price p span, .selling-widget .price p span, .starting-bid span, .curent-bid span, .auction-end span{
    color: <?php echo $bingo_option_data['bingo-color-primary'] . " !important"; ?>;
  }
  .woocommerce #content div.product p.price, .woocommerce #content div.product span.price, .woocommerce div.product p.price, .woocommerce div.product span.price, .woocommerce-page #content div.product p.price, .woocommerce-page #content div.product span.price, .woocommerce-page div.product p.price, .woocommerce-page div.product span.price{
    color: <?php echo $bingo_option_data['bingo-color-primary'] . " !important"; ?>;
  }


.woocommerce #review_form #respond .form-submit input, 
.woocommerce-page #review_form #respond .form-submit input,
.woocommerce ul.products li.product a.product_type_auction, 
.woocommerce-page ul.products li.product a.product_type_auction,
.woocommerce li.product a.add_to_cart_button {
  background: <?php echo $bingo_option_data['bingo-color-primary'] . " !important"; ?>;
}

.woocommerce #review_form #respond .form-submit input:hover, 
.woocommerce-page #review_form #respond .form-submit input:hover
.woocommerce ul.products li.product a.product_type_auction:hover, 
.woocommerce-page ul.products li.product a.product_type_auction:hover,
.woocommerce li.product a.add_to_cart_button:hover {
  background: <?php echo $bingo_option_data['bingo-color-secondary'] . " !important"; ?>;
}


.marker-ribbon .ribbon-text:before, .marker-ribbon .ribbon-text:after{
  background-color: <?php echo $bingo_option_data['bingo-color-primary'] . " !important"; ?>;
}

.marker-ribbon .ribbon-banner:after, .marker-ribbon .ribbon-banner:before{
    background-color: <?php echo $bingo_option_data['bingo-color-secondary'] . " !important"; ?>;
}

.marker-ribbon .ribbon-banner{
  color: <?php echo $bingo_option_data['bingo-button-text-color']; ?>;
}

  <?php echo $bingo_option_data['bingo-custom-css'];  ?>


  </style>



  <?php

} // custom style





add_action( 'wp_head', 'bingo_custom_style', 400 );


