<?php
/**
 * Description tab
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

global $woocommerce, $post, $product;
?>

<!-- <div class="summary entry-summary" style="float:left"> -->
<div class="summary entry-summary" style="float:left">
</div><!-- .summary -->

<div style="clear:both">


<?php
	$getting_categories = get_the_terms( $post->ID, 'product_cat' );
    $getting_tags = get_the_terms( $post->ID, 'product_tag' );
    $loc_terms = "";
    $i_loc = 0;
    foreach ($getting_tags as $value) {
      if($i_loc > 0) $loc_terms .= ", ";
      $loc_terms .= '<a href="/product-tag/'.$value->slug.'/" style="text-transform: capitalize;">'.str_replace('-', ' ', $value->name).'</a>';
      $i_loc++;
    }
    
		$terms_final = "";
		$i = 0;
		$len = count($getting_categories);

		if( is_array( $getting_categories ) ){
			foreach ($getting_categories as $category) {
				if($category->parent > 0){
					$parent_term = get_term_by("id", $category->parent, "product_cat");
					$terms_final .=  "<a href='/product-category/". $parent_term->slug . "/" . $category->slug ."/'>" . $parent_term->name . "/" . $category->name . "</a>";
				} else {
					$terms_final .=  "<a href='/product-category/". $category->slug ."/'>" . $category->name . "</a>";
				}
				if ($i == $len - 1){
					$terms_final .=  "";
				}else{
					$terms_final .=  ", ";
				}
				$i++;
			}
		}
$blabla = get_post_meta($post->ID);
		?>
		<style>
		.new-meta-post {
    list-style: outside none none;
    margin: 0;
    padding-left: 0;
    text-align: center;
    }
    .new-meta-post li {
    float: left;
    font-size: 14px;
    line-height: 1.25em;
    padding: 5px 0;
    width: 33.3333%;
    color:#000;
    }
    .new-meta-post li {
    border-left: 0 solid !important;
    border-right: 0 solid !important;
    float: none !important;
    text-align: left;
    width: 100% !important;
    }
		</style>
		
        <ul class="new-meta-post">
          <?php if( $product->product_type == "auction" ){ ?>
          <li><i class="fa fa-calendar"></i> <?php _e('Launched on', 'bingo'); ?> <a href=""> <?php echo  date_i18n( get_option( 'date_format' ),  strtotime( $blabla['_auction_dates_from']['0'] ) ) . " ";  ?><?php echo  date_i18n( get_option( 'time_format' ),  strtotime( $blabla['_auction_dates_from']['0'] ) );  ?></a><?php _e(' and ends on ', 'bingo'); ?><a href="#"><?php echo  date_i18n( get_option( 'date_format' ),  strtotime( $blabla['_auction_dates_to']['0'] ) ) . " ";  ?><?php echo  date_i18n( get_option( 'time_format' ),  strtotime( $blabla['_auction_dates_to']['0'] ) );  ?></a></li>
          <?php }
          if ( is_super_admin() ) { ?>
          <li><i class="fa fa-user"></i> <?php _e('Author: ', 'bingo');?> <b style="text-transform: capitalize;color:#0091C9;"><a href="/?author=<?php echo $post->post_author;?>"><?php the_author_meta( 'display_name', $post->post_author );?></a></b></li>
          <?php } else { ?>
          <li><i class="fa fa-user"></i> <?php _e('Author: ', 'bingo');?> <b style="text-transform: capitalize;color:#0091C9;"><a href="/?author=<?php echo $post->post_author;?>">Agent-<?php echo $post->post_author;?></a></b></li>
          <?php } ?>
          <li style="text-transform: capitalize;"><i class="fa fa-flag"></i> Categories: <?php echo $terms_final; ?></li>
  <?php
  $temp_date = strtotime(get_the_date()); 
  $archive_year = date('Y', $temp_date);
  $archive_month = date('m', $temp_date);
  $archive_day = date('d', $temp_date);
  ?>
          <li><i class="fa fa-info-circle"></i> Published: 
          <a href="/search-date/?years=<?php echo $archive_year .'&months='. $archive_month . '&days=' . $archive_day; ?>">
          <?php

           the_date( 'F j, Y , H:i'); 
          ?>
          </a></li>
          <!--<li><i class="fa fa-tags"></i> <?php the_terms( $post->ID, 'product_tag', 'Location: ', str_replace('-', ' ', mb_ucfirst(', ', "CP1251")) ); ?></li>-->
          <li><i class="fa fa-tags"></i>Location:  <?php echo $loc_terms; ?></li>
        </ul>
        
<span style="border-top:1px solid #cdcdcd;display:block;"></span>
<p style="color:#000;word-wrap: break-word;"><?php echo stripcslashes( strip_tags( $post->post_content ) ); ?></p>
</div>