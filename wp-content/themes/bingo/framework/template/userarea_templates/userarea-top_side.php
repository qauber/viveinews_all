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
    'count' => 8,
    'posts_per_page' => 8,
    'tax_query' => array(
        array(
            'taxonomy' => 'product_cat' ,
            'field' => 'id',
            'terms' => $default_view_settings['sub_category_top_side'] ? $default_view_settings['sub_category_top_side'] : $default_view_settings['category_top_side'] )),
    'auction_arhive' => TRUE,
    'meta_query' => array(
        array(
            'key' 		=> '_visibility',
            'value' 	=> array('catalog', 'visible'),
            'compare' 	=> 'IN'
        )
    )
);

//print_r($args);
$posts = get_posts($args);



//print_r($posts);

?>

<h3 class="title"><span><?php echo get_product_cat_name($default_view_settings['sub_category_top_side']) ?></span></h3>


<ul class="bxslider">

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


            <li>
                <a class="image_thumb_zoom" href="<?php echo mk_get_guid($post->guid); ?>" title="<?php echo $post->post_title; ?>" rel="bookmark">
                    <div class="top-side-img" style="background-image: url(<?php echo $box_image_url; ?>);" alt=""></div>
                </a>
                <h4 class="post-title clearfix">
                    <img class="post-icon" alt="Video post" src="<?php echo get_template_directory_uri() ?>/img/userarea/vid.png">
                    <a href="<?php echo mk_get_guid($post->guid); ?>" title="<?php echo $post->post_title; ?>" rel="bookmark"><?php echo $post->post_title; ?></a>
                </h4>
                <div class="meta clearfix">
                    <span class="date"><?php echo $post->post_date; ?></span>

                </div>
            </li>


                <?php

            $i++;
        } ?>



</ul>