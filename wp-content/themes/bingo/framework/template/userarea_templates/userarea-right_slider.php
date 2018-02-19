<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$user_id = get_current_user_id();

//$default_view_ser = get_user_meta($user_id, 'view_settings',true);
//parse_str($default_view_ser, $default_view_settings);

$today = getdate();

//$args = array(
//    'year' => $today['year'],
//    'monthnum' => $today['mon'],
//    'day' => $today['mday']-10,
//    'post_type'      => 'product',
//    'post_status'    => 'publish',
//    'pagination'     => false,
//    'count'         => 4,
//    'auction_arhive' => TRUE,
//    'meta_key'       => 'product_views',
//    'orderby'        => 'meta_value_num',
//    'order'          => 'DESC',
//);

$args = array(
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'pagination'     => false,
    'count'         => 4,
    'auction_arhive' => TRUE,
    'order'          => 'DESC',
    'category__not_in' => (202),
);

$posts = get_posts($args);

?>
<h3>Last breaking news</h3>

<ul>
   <?php foreach($posts as $post){
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
                   <img src="<?php echo $box_image_url; ?>" class="thumb" alt="" />
                   <a href="<?php echo mk_get_guid($post->guid); ?>" title="<?php echo $post->post_title; ?>" rel="bookmark">
                       <h4 class="post-title"><?php echo $post->post_title; ?></h4>
                   </a>
               </li>

   <?php } ?>

</ul>
    <div class="clear"></div>
