<?php 
/*
Template Name: Project search date
*/
global $wp_query;
get_header();
?>

<div id="page-content" class="woocommerce woocommerce-page">
 <div class="page-content">
  <div class="container my-mg">
    <?php the_title( "<h1 class='page-title'>", "</h1>" ); ?> 

    <?php echo do_shortcode( '[yith_woocommerce_ajax_search]'); ?>
    <p></p>
    <div class="woocommerce woocommerce-breadcrumb-block">
                <?php   
                        woocommerce_breadcrumb();
                ?>
            </div>

    <div id="mobile-menu-toggle2"><span></span></div>
<!--    <div class="col-xs-12 col-sm-2 page-sidebar myWidthSL">
        <?php // get_sidebar(); ?>
    </div>-->
     <div class="col-xs-12 col-md-12 col-sm-12 w1000 pr0" style="margin-bottom:30px;">
    
     
       <div class="responsive-tabs project-list-tabs">
<?php
$paged = (get_query_var( 'paged' )) ? intval( get_query_var( 'paged' ) ) : '1';
$s_year = (get_query_var('years') && intval(get_query_var('years'))) ? intval(get_query_var('years')) : NULL;
$s_month = (get_query_var('months') && intval(get_query_var('months'))) ? intval(get_query_var('months')) : NULL;
$s_day = (get_query_var('days') && intval(get_query_var('days'))) ? intval(get_query_var('days')) : NULL;
$args = array(
 'post_type'      => array( 'product' ),
 'post_status'    => array( 'publish' ),
 'orderby'        => 'date',
 'order'          => 'DESC',
 'posts_per_page' => 9,
 'year'           => "$s_year",
 'monthnum'       => "$s_month",
 'day'            => "$s_day",
 'paged'          =>  $paged
);
$m_product = new WP_Query( $args );
$max_num_pages = isset( $m_product->max_num_pages ) ? intval($m_product->max_num_pages) : 1;
?>
  <div class="tab-pane active" id="project-list-tab-auction">
<?php
$i = 1;
if( $m_product->have_posts() AND $s_year != NULL ) {
?>
 <div class="row">
 <?php
while ($m_product->have_posts() ) {
  $m_product->the_post();
  $product_terms = get_the_terms( $m_product->ID, 'product_cat');
        $getting_tags = get_the_terms( $m_product->ID, 'product_tag' );
        $loc_terms = "";
        $i_loc = 0;
        foreach ($getting_tags as $value) {
          if($i_loc > 0) $loc_terms .= ", ";
          $loc_terms .= '<a href="/product-tag/'.$value->slug.'/" style="text-transform: capitalize;">'.str_replace('-', ' ', $value->name).'</a>';
          $i_loc++;
        }
  $terms_final = "";
  foreach ($product_terms as $terms) {
    $terms_final .= " cat-" . $terms->term_id;
  }
?>
  <div class="col-xs-12 col-md-4 col-sm-6 filter-item<?php echo $terms_final; ?>">
    <article class="project-list-post auction">
      <a href="<?php the_permalink(); ?>"><h2 class="title-small"><?php echo mb_substr( stripcslashes( the_title() ), 0, 40 ); ?></h2></a>
<?php if (has_post_thumbnail( $m_product->ID )) : 
$thumb_id = get_post_thumbnail_id( $m_product->ID );
$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'product-thumb', true);
    $thumb_url = wp_get_attachment_url($thumb_id); //$thumb_url_array[0];
?>
<div class="vd-block-height">
<a href="<?php the_permalink(); ?>">
<?php
  if($thumb_url){
    echo '<img class="post-image" src="' . getEncodedimgString( "jpg", $thumb_url ) . '">';
  }else{
    echo '<img class="post-image" src="' . IMAGES . '/no-image-big.jpg">';
  }
?>
</a>
</div>
<?php else : ?>

<img class="post-image" src="<?php print IMAGES; ?>/no-image-big.jpg">

<?php endif; ?>
<div class="someWrrap" style="text-align:left;">
<p class="posted">Posted on: 
<?php
  $temp_date = strtotime(get_the_date()); 
  $archive_year = date('Y', $temp_date);
  $archive_month = date('m', $temp_date);
  $archive_day = date('d', $temp_date);
?>
  <a href="/search-date/?years=<?php echo $archive_year .'&months='. $archive_month . '&days=' . $archive_day; ?>">
    <?php 
      echo date("F j, Y", $temp_date);
    ?>
  </a>
</p>
<p class="wb-loc-home">
<?php 
//the_terms( $m_product->ID, 'product_tag', '<font color=#0091C9>Location:</font> ', mb_ucfirst(', ', "UTF-8") ); 
echo '<font color=#0091C9>Location:</font> '.$loc_terms;
?></p>
<div class="post-description">
<p><?php echo mb_substr( stripcslashes( get_the_content() ), 0, 80 ); ?></p>
</div>
<a href="<?php the_permalink(); ?>"><div class="btn btn-default read-more"><?php _e('View Details', 'bingo');?></div></a>
<div class="clear"></div>
</div>
</a>
</article>
</div>
<?php 
//if(($i%3)==0) { echo "<div class='clear'></div>"; }
//$i++;
}
wp_reset_postdata();
?>
</div>
<?php 
wpbeginner_numeric_posts_nav( $paged, $max_num_pages );
} else {
 echo "<h4><span style='color:#000000;'>Enter date to search</span></h4>";
}
?>
</div>
</div>
</div>
<!-- banner blok right-block.php -->
<?php // get_template_part( 'right', 'block' ); ?>
<!-- banner blok right-block.php -->
</div>
</div>
</div>
</div>
<?php 
if( $bingo_option_data['bingo-partners-on-off'] == true ){
get_template_part( 'framework/template/partner', '' ); 
}

get_template_part( 'framework/template/twitter-template', '' );
get_footer(); ?>