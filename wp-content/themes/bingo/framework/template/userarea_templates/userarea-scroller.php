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

$posts = get_posts($args);

if (isset($posts) && array_filter($posts)){
?>

<div class="brnews span9">
    <h3>Breaking News</h3>
    <ul id="scroller">
   <?php foreach($posts as $post){

                $content = $post->post_content;
                $trimmed_content = wp_trim_words( $content, 30 );
                
                ?>

               <li>
                   <p>
                       <a href="<?php echo mk_get_guid($post->guid); ?>" title="<?php echo $post->post_title; ?>" rel="bookmark">
                           <span class="title"><?php echo $post->post_title; ?>...</span> <?php echo $trimmed_content; ?>...</a>
                   </p>
               </li>

                
   <?php } ?>

   </ul>
</div>

<?php } ?>