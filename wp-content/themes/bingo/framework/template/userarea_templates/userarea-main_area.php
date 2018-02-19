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
    'tax_query' => array(array('taxonomy' => 'product_cat' , 'field' => 'slug', 'terms' => 'breaking-news')),
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
if (!array_filter($posts)){
    $class =  "no-breaking";
    $text = "Sorry last hour no breaking news"; ?>

    <div class="<?php echo $class; ?>"  style="background-image: url('<?php echo get_template_directory_uri() ?>/img/breaking_news.jpg');">
        <p><?php echo $text; ?></p>
    </div>

<?php
}else{
?>

<ul class="slides <?php echo $class; ?>">
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
                <li data-thumb="<?php echo $box_image_url; ?>" class="flexslider-item">
                        <a href="<?php echo mk_get_guid($post->guid); ?>" title="<?php echo $post->post_title; ?>" rel="bookmark">
                        <img width="546" height="291" src="<?php echo $box_image_url; ?>" alt="" />
                        </a>
                        <div class="entry">
                                <h4><?php echo $post->post_title; ?></h4>
                                <p><?php echo $trimmed_content; ?></p>
                        </div>
                </li>
                
   <?php } ?>
            
</ul>

<?php } ?>