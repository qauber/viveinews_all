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
        $loc_terms = "";
        $i_loc = 0;
        foreach ($getting_tags as $value) {
          if($i_loc > 0) $loc_terms .= ", ";
          $loc_terms .= '<a href="/product-tag/'.$value->slug.'/" style="text-transform: capitalize;">'.str_replace('-', ' ', $value->name).'</a>';
          $i_loc++;
        }

            $terms_final = "";

            foreach ($product_terms as $terms) {
                
                $terms_final .= " cat-" . $terms->term_id;
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

            <div class="gallery-item <?php echo $terms_final; ?>">
                <div class="box" style="background-image: url( <?php echo $thumb_url ?>);">
                    <div class="cover top-left">
                        <a class="title" href= <?php echo mk_get_guid($single_product->guid); ?>><?php echo mb_substr( strip_tags( stripcslashes( $single_product->post_title ) ), 0, 40 ) ?></a>
                        <p class="intro"><?php echo wp_trim_words(stripcslashes($single_product->post_content), 18); ?>
                        </p>
                        <?php
                            $temp_date     = strtotime($single_product->post_date); 
                            $archive_year  = date('Y', $temp_date);
                            $archive_month = date('m', $temp_date);
                            $archive_day   = date('d', $temp_date);
                          ?>
                        <p class="date">  
                            <a href="/search-date/?years=<?php echo $archive_year .'&months='. $archive_month . '&days=' . $archive_day; ?>">
                                <?php 
                                    echo date("F j, Y", $temp_date);
                                ?>
                            </a>
                        </p>
                        <p class="location">
                          <?php 
                          //the_terms( $single_product->ID, 'product_tag', '<font color=#0091C9>Location:</font> ', mb_ucfirst(', ', "UTF-8") );
                            echo '<font color=#0091C9>Location:</font> '.$loc_terms;
                           ?>
                         </p>
                    </div>
                </div>
            </div>
        

<?php endforeach;?>

   