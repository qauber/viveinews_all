<?php
/*
  Template Name: Project new listings
 */
global $wp_query;
get_header();
?>

<div id="page-content" class="woocommerce woocommerce-page">
    <div class="page-content">
        <div class="container my-mg">
            <?php the_title( "<h1 class='page-title'>", "</h1>" ); ?> 

            <?php echo do_shortcode( '[yith_woocommerce_ajax_search]'); ?>
            <p></p>
            <div class="woocommerce woocommerce-breadcrumb-block">
                        <?php   
                                woocommerce_breadcrumb();
                        ?>
                    </div>

            <div id="mobile-menu-toggle2"><span></span></div>
<!--            <div class="col-xs-12 col-sm-2 page-sidebar myWidthSL">
                <?php // get_sidebar(); ?>
            </div>-->
            <div class="col-xs-12 col-md-12 col-sm-12 w1000 pr0" style="margin-bottom:30px;">
                <div class="responsive-tabs project-list-tabs">
                    <?php
                    $paged = (get_query_var('paged')) ? intval(get_query_var('paged')) : '1';
                    $tags = (get_query_var('tag')) ? get_query_var('tag') : $wp_query->query_vars["tag"];
                    $wb_tags = explode(",+", $tags);
                    
//                    print_r($tags);
//                    print_r($wb_tags);
                    
                    $arr_tag = array();
                    foreach ($wb_tags as $value) {
# dell zipcode
                        if (strpos($value, '+') !== false) {
                            $new_val = "";
                            $valuearr = explode("+", $value);
                            foreach ($valuearr as $val) {
                                if (is_numeric($val))
                                    continue;
                                if ($new_val != "")
                                    $new_val .= "+";
                                $new_val .= $val;
                            }
                            $value = $new_val;
                        }
# end dell
                        $value = str_replace("+", " ", $value);
                        $value = preg_replace("/[\s]{2,}/", ' ', $value);
                        $value = str_replace("'", "", $value);
//                        $tag_tr = gtranslate($value, 'ru', 'en');
                        
//                        echo "value:"; print_r($value); echo "<br/>";
//                        echo "trans:"; print_r($tag_tr); echo "<br/>";
                        
//                        $value = $tag_tr->sentences['0']->trans;
//                        $value = $tag_tr;
                        $value = strtolower(trim($value));
                        $value = str_replace(" ", "-", $value);
                        $value = str_replace("-\-", "", $value);
                        $arr_tag[] = $value;
                    }
                    
//                    print_r($arr_tag);
                    
                    $tagsv = implode(",", $arr_tag);
                    if ($tagsv != '') {
                        $wb_tags = explode(",", $tagsv);
                        $count_wb_tag = count($wb_tags);
                        $wb_tag = array('relation' => 'AND');
                        for ($t = 0; $t < $count_wb_tag; $t++) {
                            $wb_tag_arr[$t] = array(
                                'taxonomy' => 'product_tag',
                                'field' => 'slug',
                                'terms' => $wb_tags[$t],
                                'operator' => 'IN',
                            );
                            array_push($wb_tag, $wb_tag_arr[$t]);
                        }
                    }
                    $args = array(
                        'post_type' => array('product'),
                        'tax_query' => $wb_tag_arr,
                        'post_status' => array('publish'),
                        'orderby' => 'date',
                        'order' => 'DESC',
                        'posts_per_page' => 9,
                        'paged' => $paged
                    );
                    
//                    print_r($args);
                    
                    $query = new WP_Query;
                    $m_products = $query->query($args);
                    
                    $max_num_pages = isset($m_product->max_num_pages) ? intval($m_product->max_num_pages) : 1;
                    ?>
                    <div class="active" id="project-list-tab-auction">
                        <?php
                        $i = 1;
                        if ($m_products AND $tags != "") {
                            ?>
                            <div class="row">
                                <?php
                                foreach ($m_products as $m_product) {
//                                    $m_product->the_post();
                                    $product_terms = get_the_terms($m_product->ID, 'product_cat');
                                    $getting_tags = get_the_terms($m_product->ID, 'product_tag');
                                    $loc_terms = "";
                                    $i_loc = 0;
                                    foreach ($getting_tags as $value) {
                                        if ($i_loc > 0)
                                            $loc_terms .= ", ";
                                        $loc_terms .= '<a href="/product-tag/' . $value->slug . '/" style="text-transform: capitalize;">' . str_replace('-', ' ', $value->name) . '</a>';
                                        $i_loc++;
                                    }
                                    $terms_final = "";
                                    foreach ($product_terms as $terms) {
                                        $terms_final .= " cat-" . $terms->term_id;
                                    }
                                    ?>
                                    <div class="col-xs-12 filter-item <?php echo $terms_final; ?>">
                                        <article class="my-project-list-post">
                                            <div class="my-video-item">
                                            <div class="my-video-img">
                                            <a href="<?php echo mk_get_guid($m_product->guid); ?>">
                                            <?php if (has_post_thumbnail( $m_product->ID )) : ?>

                                                <?php
                                                    $thumb_id = get_post_thumbnail_id( $m_product->ID );
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
                                                </a></div>
                                                <div class="my-video-item-title">
                                                    <a href="<?php echo mk_get_guid($m_product->guid); ?>"><?php echo mb_substr( stripcslashes( $m_product->post_title ), 0, 48 ); ?></a></div>
                                                <div class="posted" style="float:right;">Posted on:
                                                    <?php
                                                      $temp_date     = strtotime($m_product->post_date);
                                                      $archive_year  = date('Y', $temp_date);
                                                      $archive_month = date('m', $temp_date);
                                                      $archive_day   = date('d', $temp_date);
                                                    ?>
                                                    <a href="/search-date/?years=<?php echo $archive_year .'&months='. $archive_month . '&days=' . $archive_day; ?>">
                                                        <?php
                                                            echo date("F j, Y", $temp_date);
                                                        ?>
                                                    </a>
                                                    <span class="video-edit" alt="Edit" title="Edit" onclick="edit_product('<?php echo $m_product->ID; ?>');"></span>
                                                    <span class="video-delete" alt="Delete" title="Delete" onclick="dell_product('<?php echo $m_product->ID; ?>', '<?php echo $user_id;?>');"></span>
                                                </div>
                                                <br/>

                                                <p class="my-video-item-description" style="">
                                                    <?php echo wp_trim_words(stripcslashes( $m_product->post_content), 70); ?>
                                                </p>

                                                <div class="my-video-item-location" style="">
                                                    <?php 
                                                    //the_terms( $m_product->ID, 'product_tag', '<font color=#0091C9>Location:</font> ', mb_ucfirst(', ', "UTF-8") ); 
                                                        echo '<font color=#0091C9>Location:</font> '.$loc_terms;
                                                    ?>
                                                </div>
                                            </div>
                                                <div class="clear"></div>
                                        </article>
                                    </div>
                                    <?php
//if(($i%3)==0) { echo "<div class='clear'></div>"; }
//$i++;
                                }
                                wp_reset_postdata();
                                ?>
                            </div>
                            <?php
                            wpbeginner_numeric_posts_nav($paged, $max_num_pages);
                        } else {
                            if ($tags == "") {
                                echo "<h4><span style='color:#000000;'>Enter location to search</span></h4>";
                            } else {
                                $tags = str_replace("+", " ", $tags);
                                echo "<h4><span style='color:#000000;word-wrap:break-word;'>No results found for $tags</span></h4>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <!-- banner blok right-block.php -->
<?php // get_template_part('right', 'block'); ?>
            <!-- banner blok right-block.php -->
        </div>
    </div>
</div>
</div>
<?php
if ($bingo_option_data['bingo-partners-on-off'] == true) {
    get_template_part('framework/template/partner', '');
}

get_template_part('framework/template/twitter-template', '');
get_footer();
?>