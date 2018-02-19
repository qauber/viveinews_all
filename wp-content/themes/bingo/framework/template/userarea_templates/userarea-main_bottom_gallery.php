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
    'count' => 30,
    'posts_per_page' => 30,
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
<h3 class="title"><span>All News Gallery</span></h3>
<ul class="gallery">

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

            $box_image_url = $thumb_url ? substr($thumb_url, 40)  : IMAGES . "/no-image-big.jpg";

        ?>

            <li>
                <a class="image_thumb_zoom" href="<?php echo mk_get_guid($post->guid); ?>" title="<?php echo $post->post_title; ?>" rel="bookmark">
                    <img width="225" height="136" src="<?php echo $box_image_url; ?>" alt="" />
                </a>
                <a href="<?php echo mk_get_guid($post->guid); ?>" title="<?php echo $post->post_title; ?>" rel="bookmark">
                    <h4 class="post-title clearfix"><img class="post-icon" alt="Video post" src="<?php echo get_template_directory_uri() ?>/img/userarea/vid.png"><?php echo $post->post_title; ?></h4>
                </a>
                <div class="meta clearfix">
                    <span class="date"><?php echo $post->post_date; ?></span>
                </div>
            </li>

        <?php } ?>

</ul>