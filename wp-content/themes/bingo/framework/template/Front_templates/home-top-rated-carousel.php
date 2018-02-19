<?php

$args = array(
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'meta_key'       => 'product_views',
        'orderby'        => 'meta_value_num',
        'order'          => 'DESC',
        'pagination'     => false,
        'offset'         => 4,
        'posts_per_page' => 20
);

$posts = get_posts($args);

?>

<div id="post-carousel-top" class = "owl-carousel owl-theme">
    
    <?php 
    foreach ($posts as $post) {
        if (has_post_thumbnail( $post->ID )){ 
            $thumb_id = get_post_thumbnail_id( $single_product->ID );
            $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'latest-thumb', true);
            $thumb_url = $thumb_url_array[0];
        }
                
        $content = $post->post_content;
        $trimmed_content = wp_trim_words( $content, 30 );

        $box_image_url = $thumb_url ? getEncodedimgString( "jpg", $thumb_url ) : IMAGES . "/no-image-big.jpg";


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
