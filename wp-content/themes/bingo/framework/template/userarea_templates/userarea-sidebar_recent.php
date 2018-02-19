<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
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
<h3 class="title"><span>Recent Posts</span></h3>
<div class="latest-posts widget">

        <?php
        $i = 0;
        foreach($posts as $post){
            if (has_post_thumbnail( $post->ID )){
                $thumb_id = get_post_thumbnail_id( $post->ID );
                $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'latest-thumb', true);
                $thumb_url = $thumb_url_array[0];
            }

            $content = $post->post_content;
            $trimmed_content = wp_trim_words( $content, 30 );

            $box_image_url = $thumb_url ? getEncodedimgString( "jpg", $thumb_url ) : IMAGES . "/no-image-big.jpg";


                ?>

            <div class="latest-post clearfix">
                <a href="<?php echo mk_get_guid($post->guid); ?>">
                    <img width="225" height="136" src="<?php echo $box_image_url; ?>" class="thumb fl" alt="" title="" />
                </a>
                <h4><a href="<?php echo mk_get_guid($post->guid); ?>" rel="bookmark" title="<?php echo $post->post_title; ?>"><?php echo $post->post_title; ?></a></h4>
                <div class="post-time"><?php echo $post->post_date; ?></div>
                <p><?php echo $trimmed_content; ?></p>
            </div>

        <?php } ?>

    </div>