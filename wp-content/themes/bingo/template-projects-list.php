<?php 

/*
Template Name: Project listings
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
<!--                <div class="col-xs-12 col-sm-2 page-sidebar myWidthSL">
                    <?php // get_sidebar(); ?>
                </div>-->
                <div class="col-xs-12 col-md-12 col-sm-12 w1000 pr0" style="margin-bottom:30px;">
                    <div class="responsive-tabs project-list-tabs">
<?php
$paged = (get_query_var( 'page' )) ? get_query_var( 'page' ) : '1';
$autor = (isset($_GET['autor'] )) ? intval($_GET['autor']) : '';
$my_posts = new WP_Query;
$myposts = $my_posts->query( array(
    'post_type' => 'product',
    'post_status' => 'publish',
    //'ignore_sticky_posts' => 1,
    //'orderby' => 'post_date',
    'meta_key' => 'product_views',
    'orderby' => 'meta_value_num',
    'order' => 'DESC',
    'posts_per_page' => 9,
    'paged' =>  $paged,
    'author' => $autor,
    ) );
$max_num_pages = $my_posts->max_num_pages;
?>
    <div class="tab-pane active" id="project-list-tab-auction">
        <div class="row">
<?php $i = 1;
    foreach ($myposts as $single_product): 
        $blabla = get_post_meta($single_product->ID);
        $product_terms = get_the_terms( $single_product->ID, 'product_cat');
        $getting_tags = get_the_terms( $single_product->ID, 'product_tag' );
        $loc_terms = "";
        $i_loc = 0;
        foreach ($getting_tags as $value) {
          if($i_loc > 0) $loc_terms .= ", ";
          $loc_terms .= '<a href="/product-tag/'.$value->slug.'/" style="text-transform: capitalize;">'.str_replace('-', ' ', $value->name).'</a>';
          $i_loc++;
        }
        $terms_final = "";
        if( $product_terms ) {
            foreach ($product_terms as $terms) {
                $terms_final .= " cat-" . $terms->term_id;
            }
        }
?>
    <div class="col-xs-8 col-md-4 col-sm-6 filter-item <?php echo $terms_final; ?>">
        <article class="project-list-post auction">
            <a href="<?php echo mk_get_guid($single_product->guid); ?>">
                <h2 class="title-small">
<?php echo mb_substr( stripcslashes( $single_product->post_title ), 0, 40 );?></a>
                </h2>
<?php if (has_post_thumbnail( $single_product->ID )) :

    $thumb_id = get_post_thumbnail_id( $single_product->ID );
    $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'product-thumb', true);
    $thumb_url = wp_get_attachment_url($thumb_id); //$thumb_url_array[0];
?>
                                                <div class="vd-block-height">
                                                    <a href="<?php echo mk_get_guid($single_product->guid); ?>">
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
                                                <p class="posted">
                                                <?php
                                                  $temp_date     = strtotime($single_product->post_date); 
                                                  $archive_year  = date('Y', $temp_date);
                                                  $archive_month = date('m', $temp_date);
                                                  $archive_day   = date('d', $temp_date);
                                                ?>
                                                Posted on:  <a href="/search-date/?years=<?php echo $archive_year .'&months='. $archive_month . '&days=' . $archive_day; ?>">
                                                                    <?php 
                                                                        echo date("F j, Y", $temp_date);
                                                                    ?>
                                                            </a>
                                                </p>
                                                <p class="wb-loc-home">
                                                 <?php 
                                                    //the_terms( $single_product->ID, 'product_tag', '<font color=#0091C9>Location:</font> ', mb_ucfirst(', ', "UTF-8") );
                                                    echo '<font color=#0091C9>Location:</font> '.$loc_terms;
                                                  ?>
                                                </p>
                                                <div class="post-description">
                                                   <p><?php echo mb_substr( stripcslashes( $single_product->post_content ), 0, 80 ); ?></p>
                                                </div>
                                                
                                                <a href="<?php echo mk_get_guid($single_product->guid); ?>">
                                                    <div class="btn btn-default read-more">
                                                    <?php _e('View Details', 'bingo'); //_e(' Bid Now', 'bingo'); ?></div>
                                                </a>
                                                <div class="clear"></div>
                                                </div>
                                            </a>
                                        </article>
                                    </div>
                                    <?php 
                            	//	if(($i%3)==0)
                            	//	{
                            	//		echo "<div class='clear'></div>";
                            	//	}
                            	//	$i++;
                            	 endforeach;
                            	 wp_reset_postdata();
                            	  ?>
                                </div>
                                <?php wpbeginner_numeric_posts_nav($paged, $max_num_pages); ?>
                            </div>
                        </div>
                    </div>
<!-- banner blok right-block.php -->
<?php // get_template_part( 'right', 'block' ); ?>
<!-- banner blok right-block.php -->
                </div>
            </div>
        </div>
<?php 
if( $bingo_option_data['bingo-partners-on-off'] == true ){
get_template_part( 'framework/template/partner', '' ); 
}

get_template_part( 'framework/template/twitter-template', '' );
get_footer(); ?>