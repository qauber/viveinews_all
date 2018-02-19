<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$user_id = get_current_user_id();

$args = array(
    'post_type' => 'product',
    'posts_per_page' => 4,
    'count' => 4,
    'meta_query' => array(
        array(
            'key' 		=> '_visibility',
            'value' 	=> array('catalog', 'visible'),
            'compare' 	=> 'IN'
        ),
        array(
            'key' 		=> '_featured',
            'value' 	=> 'yes',
            'compare' 	=> 'IN'
        )
    )
);

$posts = get_posts($args);

?>

<div class="row-fluid">

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

            <div class="span3">
                <article class="post">
                    <a href="<?php echo mk_get_guid($post->guid); ?>" title="<?php echo $post->post_title; ?>" rel="bookmark">
                        <img width="225" height="136" src="<?php echo $box_image_url ?>" class="thumb" alt="" />
                    </a>
                    <div class="entry">
                        <h3><a href="<?php echo mk_get_guid($post->guid); ?>" title="<?php echo $post->post_title; ?>" rel="bookmark"><?php echo $post->post_title; ?></a></h3>
                        <p><?php echo $post->post_date; ?></p>
                    </div>
                    <div class="clearfix"></div>
                </article>
            </div>

                <?php

            $i++;
        } ?>

</div>