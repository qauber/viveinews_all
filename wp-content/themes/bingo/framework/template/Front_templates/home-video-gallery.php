<!-- gallery -->
<?php 
            $page_slug = 'top-rated-block';
            $page_data = get_page_by_path($page_slug, $output = OBJECT, $post_type = 'home_page_section');
            $page_id = $page_data->ID;
            $thumb = get_the_post_thumbnail( $page_id, 'full', array( 'class' => 'img-responsive' ) );
            $thumb_id = get_post_thumbnail_id($page_id);
            if ($thumb_id){
                $attachment_meta = wp_get_attachment($thumb_id);
            }
            
//            print_r($attachment_meta);
        ?>

<div class="gallery" id="gallery">
    <div class="container">
        <div class="gallery-grids">
            <div class="col-md-5 gallery-grid-left animated wow bounceInLeft" data-wow-delay="500ms">
                <h3><?php echo $page_data -> post_content; ?></h3>
            </div>
            <div class="col-md-7 gallery-grid-right animated wow bounceInRight" data-wow-delay="500ms">
                <div class="banner-bottom-text">
                    <h3>Video</h3>
                    <div class="banner-bottom-text-pos banner-bottom-text-pos2">
                        <h3>Top Rated</h3>
                    </div>
                </div>
                <div class="bar1 bar-con bar-con1">
                    <div class="bar3" data-percent="70"></div>
                </div>
            </div>
            <div class="clearfix"> </div>
        </div>
        <div class="gallery-grids1">
<?php
$my_posts = new WP_Query;
$myposts = $my_posts->query( array(
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'meta_key'       => 'product_views',
    'orderby'        => 'meta_value_num',
    'order'          => 'DESC',
    'pagination'     => false,
    'posts_per_page' => 4
    ) );
foreach ($myposts as $single_product):
    $blabla = get_post_meta($single_product->ID);
    $product_terms = get_the_terms( $single_product->ID, 'product_cat');
    $getting_tags = get_the_terms( $single_product->ID, 'product_tag' );
    $content = $single_product->post_content;
    $trimmed_content = wp_trim_words( $content, 30 );
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
        
if (has_post_thumbnail( $single_product->ID )) {

    $thumb_id = get_post_thumbnail_id( $single_product->ID );
    $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'product-thumb', true);
    $thumb_url = wp_get_attachment_url($thumb_id); //$thumb_url_array[0];

    $thumb_url = getEncodedimgString( "jpg", $thumb_url );
}else{
    $thumb_url = IMAGES . '/no-image-big.jpg';
}
?>

            <div class="gallery-item">
                <div class="box" style="background-image: url( <?php echo $thumb_url ?>);">
                    <div class="cover top-left">
                        <a class="title" href= <?php echo mk_get_guid($single_product->guid); ?>><?php echo $single_product->post_title; ?></a>
                        <p class="intro"><?php echo $trimmed_content; ?>
                        </p>
                        <p class="date"><?php echo date("F j, Y", strtotime($single_product->post_date)); ?></p>
                    </div>
                </div>
            </div>
            
    <?php endforeach; ?>
            
            <div class="clearfix"> </div>
        </div>
    <?php get_template_part( 'framework/template/Front_templates/home-top-rated-carousel', '' ); ?>
    </div>
</div>
<!-- //gallery -->

