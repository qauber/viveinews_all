<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$args = array(
        'post_type'	=> 'product',
        'post_status' => 'publish',
        'ignore_sticky_posts'	=> 1,
        'orderby' => 'date',
        'order' => 'desc',
        'count' => 6,
        'posts_per_page' => 6,
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

$posts = get_posts($args);

//print_r($posts);
if(!array_filter($posts)){
    $class =  "no-breaking";
    $text = "Sorry last hour no breaking news";

?>

<div class="<?php echo $class; ?> col-md-6 banner-bottom-right animated wow bounceInRight"  style="background-image: url('<?php echo get_template_directory_uri() ?>/img/breaking_news.jpg');">
    <p><?php echo $text; ?></p>
</div>

<?php }else{
?>

<div class="col-md-6 banner-bottom-right animated wow bounceInRight" data-wow-delay="700ms">
        <?php 
            $columns = array();
            $i_max = 2; //3 columns
            $i = 0;
            
            for ($index = 0; $index <= $i_max; $index++) {
                $columns[$index] = '<div class="banner-bottom-right-left">';
            }
            foreach($posts as $post){
                if (has_post_thumbnail( $post->ID )){ 
                    $thumb_id = get_post_thumbnail_id( $post->ID );
                    $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'latest-thumb', true);
                    $thumb_url = $thumb_url_array[0];

                    $thumb_url = getEncodedimgString( "jpg", $thumb_url );
                }
                
                $content = $post->post_content;
                $trimmed_content = wp_trim_words( $content, 30 );
                
                $box_image_url = $thumb_url ? $thumb_url : IMAGES . "/no-image-big.jpg";
                                                    
                
                $columns[$i] .= '<div class="banner-bottom-right-left1">
                                    <div class="box" style="background-image: url('.$box_image_url.');">
                                        <div class="cover top-left">
                                            <a class="title" href='.mk_get_guid($post->guid).'>'. $post->post_title .'</a>
                                            <p class="intro">'. $trimmed_content.'
                                            </p>
                                            <p class="date">'. $post->post_date .'</p>
                                        </div>
                                    </div>
                                </div>';
                $i++;
                if ($i >$i_max){
                    $i=0;
                }
            }
            for ($index = 0; $index <= $i_max; $index++) {
                $columns[$index] .= '</div>';
            }
            foreach ($columns as $column) {
                echo $column;
            }
        ?>
    
    <div class="clearfix"> </div>
</div>

<?php } ?>