<?php

$args = array(
        'post_type'	=> 'product',
        'post_status' => 'publish',
        'ignore_sticky_posts'	=> 1,
        'orderby' => 'meta_value_num',
        'order' => 'desc',
        'count' => 10,
        'offset' => 6,
        'posts_per_page' => 10,
        'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_cat' , 
                                    'field' => 'slug', 
                                    'terms' => 'breaking-news'
                                    )
                                ),
        'auction_arhive' => TRUE,
        'meta_query' => array(
                array(
                        'key' 		=> '_visibility',
                        'value' 	=> array('catalog', 'visible'),
                        'compare' 	=> 'IN'
                ),
                array(
                            'key'     => 'wcmvp_product_view_count',
                            'value'   => '0',
                            'type'    => 'numeric',
                            'compare' => '>',
                    ),
                
        )
);

$posts = get_posts($args);
if ($posts){
?>

<div id="post-carousel" class = "owl-carousel owl-theme">
    
    <?php 
    foreach ($posts as $post) {
        if (has_post_thumbnail( $post->ID )){ 
            $thumb_id = get_post_thumbnail_id( $single_product->ID );
            $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'latest-thumb', true);
            $thumb_url = $thumb_url_array[0];
        }
                
        $content = $post->post_content;
        $trimmed_content = wp_trim_words( $content, 30 );

        $box_image_url = $thumb_url ? $thumb_url : IMAGES . "/no-image-big.jpg";


        $post_html = '<div class="banner-bottom-right-left1">
                            <div class="box" style="background-image: url('.$box_image_url.');">
                                <div class="cover top-left">
                                    <a class="title" href='.mk_get_guid($post->guid).'>'. $post->post_title .'</a>
                                    <p class="intro">'. $trimmed_content.'
                                    </p>
                                    <p class="date">'. $post->post_date .'</p>
                                </div>
                            </div>
                        </div>';
        ?>
            <div class="item"><?php echo $post_html; ?></div>
    <?php
    }
    
    ?>
 
<div class="clearfix"> </div>
</div>
<?php } ?>