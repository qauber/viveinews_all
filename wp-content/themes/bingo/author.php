<?php
global $wp_query;
get_header();
?>
<div id="page-content" class="woocommerce woocommerce-page">
    <div class="page-content">
        <div class="container my-mg">
            <div id="mobile-menu-toggle2"><span></span></div>
            <div class="col-xs-12 col-sm-2 page-sidebar myWidthSL"><?php get_sidebar(); ?></div>
                <div class="col-xs-8 col-sm-8 w1000 pr0" style="margin-bottom:30px;">
                    <div class="responsive-tabs project-list-tabs">
<?php
$paged = (get_query_var( 'page' )) ? get_query_var( 'page' ) : '1';
$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
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
    'author' => $curauth->ID,
    ) );
$max_num_pages = $my_posts->max_num_pages;
?>
    <div class="tab-pane active" id="project-list-tab-auction">
        <div class="row">
<?php $i = 1;
    foreach ($myposts as $single_product): 
        $blabla = get_post_meta($single_product->ID);
        $product_terms = get_the_terms( $single_product->ID, 'product_cat');
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
<?php echo mb_substr( strip_tags( stripcslashes( $single_product->post_title ) ), 0, 40 );?></a>
                </h2>
<?php if (has_post_thumbnail( $single_product->ID )) :

    $thumb_id = get_post_thumbnail_id( $single_product->ID );
    $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'product-thumb', true);
    $thumb_url = $thumb_url_array[0];
?>
                                                <div class="vd-block-height">
                                                    <a href="<?php echo mk_get_guid($single_product->guid); ?>">
                                                        <img class="post-image" src="<?php echo getEncodedimgString( "jpg", $thumb_url ); ?>">
                                                    </a>   
                                                </div>
                                                <?php else : ?>
                                                   <img class="post-image" src="<?php print IMAGES; ?>/no-image-big.jpg">
                                                <?php endif; ?>
                                                <div class="someWrrap" style="text-align:left;">
                                                <p class="posted">
                                                Posted on:  
                                                                    <?php 
                                                                        $temp_date = strtotime($single_product->post_date); 
                                                                        echo date("F j, Y", $temp_date);
                                                                    ?>
                                                </p>
                                                <p class="wb-loc-home">
                                                 <?php the_terms( $single_product->ID, 'product_tag', '<font color=#0091C9>Location:</font> ', mb_ucfirst(', ', "UTF-8") ); ?>
                                                </p>
                                                <div class="post-description">
                                                   <p><?php echo mb_substr( strip_tags( stripcslashes( $single_product->post_content ) ), 0, 80 ); ?></p>
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
                            	 if(!$myposts){
                                   ?>
                                   <p><?php _e( 'No products in this author. ', 'bingo' ); ?></p>
                                   <?php
                            	 }
                            	  ?>
                                </div>
                                <?php wpbeginner_numeric_posts_nav($paged, $max_num_pages); ?>
                            </div>
                        </div>
                    </div>
<!-- banner blok right-block.php -->
<?php get_template_part( 'right', 'block' ); ?>
<!-- banner blok right-block.php -->
                </div>
            </div>
        </div>
<?php get_footer(); ?>