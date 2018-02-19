 <?php
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;

?>                            

    <?php $i = 1;
    
    foreach ($product as $single_product):
    
    	//print_r($single_product);
    
      if($single_product->ID == '') continue;
        $blabla = get_post_meta($single_product->ID);

        $product_terms = get_the_terms( $single_product->ID, 'product_cat');
        $getting_tags = get_the_terms( $single_product->ID, 'product_tag' );
        $breaking_tags = get_post_meta($single_product->ID, 'breaking_tags',true);

        $breaking_tags_final = implode(', ', $breaking_tags);


        $loc_terms = "";
        $i_loc = 0;
        foreach ($getting_tags as $value) {
          if($i_loc > 0) $loc_terms .= ", ";
          $loc_terms .= '<a href="/product-tag/'.$value->slug.'/" style="text-transform: capitalize;">'.str_replace('-', ' ', $value->name).'</a>';
          $i_loc++;
        }

            $terms_final = "";


        if( is_array( $product_terms ) ){
            foreach ($product_terms as $category) {
                if($category->parent > 0){
                    $parent_term = get_term_by("id", $category->parent, "product_cat");
                    $terms .=  "<a href='/product-category/". $parent_term->slug . "/" . $category->slug ."/'>" . $parent_term->name . "/" . $category->name . "</a>";
                } else {
                    $terms .=  "<a href='/product-category/". $category->slug ."/'>" . $category->name . "</a>";
                }


                $terms_final .= " cat-" . $category->term_id;
            }
        }

            
        ?>
        <?php if (has_post_thumbnail( $single_product->ID )) {

            $thumb_id = get_post_thumbnail_id( $single_product->ID );
            $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'product-thumb', true);
            $thumb_url = wp_get_attachment_url($thumb_id); //$thumb_url_array[0];

        $thumb_url = getEncodedimgString( "jpg", $thumb_url );
        }else{
            $thumb_url = IMAGES . '/no-image-big.jpg';
        }
        ?>

        <div class="col-xs-12 no-padding filter-item <?php echo $terms_final; ?>
                <?php echo $class; ?>" id="product_id_<?php echo $single_product->ID;?>">
            <article class="my-project-list-post">
                <div class="my-video-item">
                    <div class="col-lg-3 col-md-12 col-sm-12 no-padding my-video-img">
                    <a href="<?php echo mk_get_guid($single_product->guid); ?>">
                    <?php if (has_post_thumbnail( $single_product->ID )) : ?>

                        <?php
                            $thumb_id = get_post_thumbnail_id( $single_product->ID );
                            $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'product-thumb', true);
                            $thumb_url = wp_get_attachment_url($thumb_id); //$thumb_url_array[0];
                        ?>
                                        <?php
                                     if($thumb_url){
                                        echo '<img class="my-post-image" src="' . getEncodedimgString( "jpg", $thumb_url ) . '">';
                                     }else{
                                        echo '<img class="my-post-image" src="' . IMAGES . '/no-image-big.jpg">';
                                     }
                                ?>
                        <?php else : ?>
                            <img class="my-post-image" src="<?php print IMAGES; ?>/no-image-big.jpg">
                        <?php endif; ?>
                        </a>
                    </div>
                    <div class="video-data">
                            <?php echo $terms; ?>
                        <span>
                            <?php echo $breaking_tags_final; ?>
                        </span>

                        <?php
                        $temp_date     = strtotime($single_product->post_date);
                        $archive_year  = date('Y', $temp_date);
                        $archive_month = date('m', $temp_date);
                        $archive_day   = date('d', $temp_date);
                        ?>
                        <a href="/search-date/?years=<?php echo $archive_year .'&months='. $archive_month . '&days=' . $archive_day; ?>">
                            <?php
                            echo date("F j, Y", $temp_date);
                            ?>
                        </a>
                        <span>
                            <?php echo date("G:i", $temp_date); ?>
                        </span>

                    </div>
                    <div class="video-location">
                        <span>
                            <?php echo 'Location: '. $loc_terms; ?>
                        </span>
                    </div>
                    <div class="my-video-item-title">
                        <a href="<?php echo mk_get_guid($single_product->guid); ?>"><?php echo mb_substr( stripcslashes( $single_product->post_title ), 0, 48 ); ?></a>
                    </div>
    <!--                <div class="posted" style="float:right;">Posted on:

                        <span class="video-edit" alt="Edit" title="Edit" onclick="edit_product('<?php echo $single_product->ID; ?>');">

                        </span>
                        <span class="video-delete" alt="Delete" title="Delete" onclick="dell_product('<?php echo $single_product->ID; ?>', '<?php echo $user_id;?>');">

                        </span>
                    </div>-->

                    <div class="my-video-item-description">
                        <p class="" style="">
                            <?php echo wp_trim_words(stripcslashes( $single_product->post_content), 70, ' <a href="'. mk_get_guid($single_product->guid) .'#tab-description"> >>> Read More</a>'); ?>
                        </p>
                    </div>
                    <div class="my-video-item-action" style="">
                        <a href="#" >Share</a>
                        <a href="#" >Close</a>
                        <a href="#" >Alerts</a>
                        <a href="#" >Related</a>
                        <a href="#" >Prior</a>
                        <a href="#" >Translate</a>
                        <a href="#" >Comment</a>
                        <a href="#" >Save</a>
                    </div>
                </div>
                    <div class="clear"></div>
            </article>
    </div>
        

<?php endforeach;?>

   