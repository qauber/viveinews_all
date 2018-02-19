<?php 

/*
Template Name: project my-video
*/
global $wp_query;
get_header();
$user_id = get_current_user_id();
  $allow_a_type = array("editor", "cj", "media");
  $user_type = get_user_meta( $user_ID, "user_type", true );
  if(!in_array($user_type, $allow_a_type)){
    wp_redirect( home_url() );
  }
?>

        <div id="page-content" class="woocommerce woocommerce-page home">
            <div class="page-content">
                <div class="container my-mg">
                    <?php the_title( "<h1 class='page-title'>", "</h1>" ); ?> 

                    <?php echo do_shortcode( '[yith_woocommerce_ajax_search]'); ?>
                    <?php echo do_shortcode( '[bingo_checkbox_available]'); ?>
                    <p></p>
                    <div class="woocommerce woocommerce-breadcrumb-block">
                                <?php   
                                        woocommerce_breadcrumb();
                                ?>
                            </div>

                    <div id="mobile-menu-toggle2"><span></span></div>
<!--                    <div class="col-xs-12 col-sm-2 page-sidebar myWidthSL">
                        <?php // get_sidebar(); ?>
                    </div>-->
                    <div class="col-xs-12 col-md-12 col-sm-12 w1000 pr0" style="margin-bottom:30px;">
                        <div class="responsive-tabs project-list-tabs">
                            <?php
                            $paged = (get_query_var( 'paged' )) ? get_query_var( 'paged' ) : '1';
                                $my_posts = new WP_Query('cat=-209,-206,-203,-208');
                                $myposts = $my_posts->query( array(
                                    'post_type'           => 'product',
                                    'post_status'         => 'publish',
                                    'ignore_sticky_posts' => 1,
                                    'orderby'             => 'post_date',
                                    'order'               => 'desc',
                                    'posts_per_page'      => 9,
                                    'paged'               => $paged,
                                    'author'              => $user_id,
                                    'tax_query'           => array(array(
                                                'taxonomy' => 'product_cat',
                                                'field' => 'term_id',
                                                'terms' => array( '209' ),
                                                'operator' => 'NOT IN'
                                                ))
                                   ) );
                                $max_num_pages = $my_posts->max_num_pages;
                            ?>

                            <div class="active" id="project-list-tab-auction">
                                <?php
                                if ( is_user_logged_in() ) {
                                    ?>
                                
                                    <div class="row">
                                    <!-- account menu account-menu.php -->
                                    <?php get_template_part( 'account', 'menu' ); ?>
                                    <!-- account menu account-menu.php -->
                                    
                                    <div class="alert alert-info upload-block">
                                        <a href="/upload-video/">Upload new video</a>
                                    </div>
                                            
                                   
                                    <?php
                                            $i = 1;
                                            foreach ($myposts as $single_product): 
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
                                                if($product_terms) {
                                                    foreach ($product_terms as $terms) {
                                                        $terms_final .= " cat-" . $terms->term_id;
                                                    }
                                                }
                                                $class = '';
                                                if ($i%2 != 0){
                                                    $class = 'odd';
                                                }
                                                ?>

                                                <div class="col-xs-12 filter-item <?php echo $terms_final; ?> <?php echo $class; ?>" id="product_id_<?php echo $single_product->ID;?>">
                                                    <article class="my-project-list-post">
                                                        <div class="my-video-item">
                                                        <div class="my-video-img">
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
                                                            </a></div>
                                                            <span class="my-video-item-title">
                                                                <a href="<?php echo mk_get_guid($single_product->guid); ?>"><?php echo mb_substr( stripcslashes( $single_product->post_title ), 0, 48 ); ?></a></span>
                                                            <span class="posted" style="float:right;">Posted on: 
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
                                                            </span><br/>
                                                            <p class="video-control">
                                                                <span class="video-edit" alt="Edit" title="Edit" onclick="edit_product('<?php echo $single_product->ID; ?>');">Edit video</span>
                                                                <span class="video-delete" alt="Delete" title="Delete" onclick="dell_product('<?php echo $single_product->ID; ?>', '<?php echo $user_id;?>');">Delete video</span>
                                                            </p>
                                                            <p class="my-video-item-description" style="">
                                                                <?php echo wp_trim_words(stripcslashes( $single_product->post_content), 105); ?>
                                                            </p>
                                                            <span class="my-video-item-location" style="">
                                                                <?php 
                                                                //the_terms( $single_product->ID, 'product_tag', '<font color=#0091C9>Location:</font> ', mb_ucfirst(', ', "UTF-8") ); 
                                                                    echo '<font color=#0091C9>Location:</font> '.$loc_terms;
                                                                ?>
                                                            </span>
                                                        </div>
                                                            <div class="clear"></div>
                                                    </article>
                                                </div>
                                    <?php 
                                        $i++;
                                        if ($i>2){
                                            $i=1;
                                        }
                                     endforeach;
                                     wp_reset_postdata();
                                    ?>
                                    
                                            <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.3.js"></script>
                                            <script>
                                            var process = false;
                                            function edit_product(id_product){
                                               //alert('function in development');
                                               location.replace("/my-video-edit/?edit="+id_product);
                                            }

                                            function dell_product(id_product, id_user){
                                               if(confirm("Are you sure you want to delete the file?")) {
                                              $.ajax({
                                                       type: 'POST',
                                               //url: 'http://live.support-ss.ru/bootstrap.php?page=delete',
                                               url: 'http://liveinews.net/bootstrap.php?page=delete',
                                                   crossDomain: true,
                                               dataType: 'json',
                                               catche: 'false',
                                               data: { "id_product" : id_product, "id" : id_user },
                                               //processData: false,
                                               //contentType: false,
                                               success: function(data){
                                                //console.log(data);
                                                if(data.id == id_user){
                                                        $('#product_id_'+id_product).remove();
                                                }
                                               }
                                              });
                                             }
                                            }
                                            </script>

                                        

                                    </div>

                                    <?php 
                                    wpbeginner_numeric_posts_nav($paged, $max_num_pages);
                                } else {
                                        echo '<p>';
                                        _e( '<b style="color: #000000;">This page is protected. Sign in to your account.</b>', 'bingo');
                                        echo '</p>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
<!-- banner blok right-block.php -->
<?php // get_template_part( 'right', 'block' ); ?>
<!-- banner blok right-block.php -->
                </div>
            </div>
        </div>
<?php 
if( $bingo_option_data['bingo-partners-on-off'] == true ){
get_template_part( 'framework/template/partner', '' ); 
}

get_template_part( 'framework/template/twitter-template', '' );
get_footer(); ?>