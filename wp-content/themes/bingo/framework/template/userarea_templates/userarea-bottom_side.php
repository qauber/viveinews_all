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
    'tax_query' => array(
        array(
            'taxonomy' => 'product_cat' ,
            'field' => 'id',
            'terms' => $default_view_settings['sub_category_bottom'] ? $default_view_settings['sub_category_bottom'] : $default_view_settings['category_bottom'] )),
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

<h3 class="title"><span><?php echo get_product_cat_name($default_view_settings['sub_category_bottom']) ?></span></h3>
<div class="row-fluid">

    <?php
    $i = 0;
    foreach ($posts as $post) {
        if (has_post_thumbnail($post->ID)) {
            $thumb_id = get_post_thumbnail_id($post->ID);
            $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'latest-thumb', true);
            $thumb_url = $thumb_url_array[0];
        }

        $content = $post->post_content;
        $trimmed_content = wp_trim_words($content, 30);

        $box_image_url = $thumb_url ? getEncodedimgString( "jpg", $thumb_url ) : IMAGES . "/no-image-big.jpg";

        if ($i == 0) {
            ?>

            <div class="span6">
                <article class="post">
                    <a class="image_thumb_zoom" href="<?php echo mk_get_guid($post->guid); ?>" title="<?php echo $post->post_title; ?>" rel="bookmark">
                        <img width="371" height="177" src="<?php echo $box_image_url; ?>" alt=""/>
                    </a>
                    <h4 class="post-title">
                        <a href="<?php echo mk_get_guid($post->guid); ?>" title="<?php echo $post->post_title; ?>" rel="bookmark"><?php echo $post->post_title; ?></a>
                        <span class="date"><?php echo $post->post_date; ?></span>
                    </h4>
                    <p><?php echo $trimmed_content; ?></p>
                </article>
            </div>

        <?php }
        else {

            if ($i == 1) { ?>
                <div class="span6">
            <?php } ?>

                    <article class="post">
                        <div class="entry clearfix">
                            <a href="<?php echo mk_get_guid($post->guid); ?>" title="<?php echo $post->post_title; ?>" rel="bookmark">
                                <img width="225" height="136" src="<?php echo $box_image_url; ?>" class="thumb" alt=""/>
                                <h4 class="post-title"><?php echo $post->post_title; ?></h4>
                            </a>
                            <p><?php echo $trimmed_content; ?></p>
                            <div class="meta">
                                <span class="date"><?php echo $post->post_date; ?></span>
                            </div>
                        </div>
                    </article>

            <?php

            if ($i == count($posts)-1) { ?>
                </div>
            <?php }
            } ?>

        <?php

        $i++;
    } ?>


    <div class="clearfix"></div>

</div>