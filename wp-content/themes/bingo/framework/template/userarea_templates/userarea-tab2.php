<?php

$user_id = get_current_user_id();

//$default_view_ser = get_user_meta($user_id, 'view_settings',true);
//parse_str($default_view_ser, $default_view_settings);
$args = array(
        'post_type'	=> 'product',
        'post_status' => 'publish',
        'ignore_sticky_posts'	=> 1,
        'orderby' => 'date',
        'order' => 'desc',
        'count' => 4,
        'posts_per_page' => 4,
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat' ,
                'field' => 'id',
                'terms' => $default_view_settings['sub_category_tab2'] ? $default_view_settings['sub_category_tab2'] : $default_view_settings['category_tab2'])),
        'auction_arhive' => TRUE,
        'meta_query' => array(
            array(
                'key' 		=> '_visibility',
                'value' 	=> array('catalog', 'visible'),
                'compare' 	=> 'IN'
            )
        )
);

$posts = get_posts($args);

?>

<ul id="itemContainer2" class="recent-tab">

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

        ?>
        <li>
            <a href="<?php echo mk_get_guid($post->guid); ?>"><img width="225" height="136" src="<?php echo $box_image_url; ?>" class="thumb" alt="" /></a>
            <h4 class="post-title"><a href="<?php echo mk_get_guid($post->guid); ?>"><?php echo $post->post_title; ?></a></h4>
            <p><?php echo $trimmed_content; ?></p>
            <div class="clearfix"></div>
        </li>

    <?php
    }
    
    ?>
 
</ul>