<?php 

/*
Template Name: project default view
*/
global $wp_query;

    get_header();

$user_id = get_current_user_id();
  $allow_a_type = array("editor", "cj", "media");
  $user_type = get_user_meta( $user_ID, "user_type", true );
  
  $default_view_ser = get_user_meta($user_id, 'view_settings',true);
  
  $default_view_settings = array();
  
  parse_str($default_view_ser, $default_view_settings);

  
  if(!in_array($user_type, $allow_a_type)){
    wp_redirect( home_url() );
    die();
  }

//connect class for get category  
$wb_n_c 		= new wb_get_cat();
$wb_data_arr 	= $wb_n_c->wb_get_arr_cat();
$wb_sub_cat_arr = json_encode($wb_n_c->get_tree_sub($wb_data_arr));
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
                <div class="col-xs-12 col-md-12 col-sm-12 w1000 pr0">
                    <div class="responsive-tabs project-list-tabs">
                    <?php
                    $paged = (get_query_var( 'paged' )) ? get_query_var( 'paged' ) : '1';

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

                                <?php 
                                        if (have_posts()) : while (have_posts()) : the_post();

                                            the_content();

                                        endwhile; endif;

                                        ?>
                                        <div class="wb-content new-row">
                                            <form action="" method="POST" class="form-horizontal" enctype="multipart/form-data" id="view_settings" name='view_settings' autocomplete="off">
                                                <div class="col-sm-8">
                                                    <div class="panel panel-primary">
                                                        <div class="panel-heading">Main content</div>
                                                        <div class="panel-body">
                                                            <div class="col-sm-12">
                                                                <div class="panel panel-default">
                                                                    <div class="panel-heading">Main content. Main area</div>
                                                                    <div class="panel-body">
                                                                        <div class="col-sm-6">
                                                                            <select id="category_main_area" class="form-control" name='category_main_area' onchange="get_sub_cat(this.value, '_main_area'); return false;">
                                                                                <option value="0"><span style="color:#cccccc;">Select category</span></option>
                                                                                <?php
                                                                                $wb_n_c->wb_get_tree($wb_data_arr, 1, $default_view_settings['category_main_area']);
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <select id="sub_category_main_area" class="form-control" name="sub_category_main_area" data-category-id = "<?php echo $default_view_settings['sub_category_main_area']; ?>">
                                                                                <option value="0">Select subcategory</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="panel panel-default">
                                                                    <div class="panel-heading">Main content. Top side</div>
                                                                    <div class="panel-body">
                                                                        <div class="col-sm-6">
                                                                            <select id="category_top_side" class="form-control" name='category_top_side' onchange="get_sub_cat(this.value, '_top_side'); return false;">
                                                                                <option value="0"><span style="color:#cccccc;">Select category</span></option>
                                                                                <?php
                                                                                $wb_n_c->wb_get_tree($wb_data_arr, 1, $default_view_settings['category_top_side']);
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <select id="sub_category_top_side" class="form-control" name="sub_category_top_side" data-category-id = "<?php echo $default_view_settings['sub_category_top_side']; ?>">
                                                                                <option value="0">Select subcategory</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="panel panel-default">
                                                                    <div class="panel-heading">Main content. Left side</div>
                                                                    <div class="panel-body">
                                                                        <div class="col-sm-6">
                                                                            <select id="category_left_side" class="form-control" name='category_left_side' onchange="get_sub_cat(this.value, '_left_side'); return false;">
                                                                                <option value="0"><span style="color:#cccccc;">Select category</span></option>
                                                                                <?php
                                                                                $wb_n_c->wb_get_tree($wb_data_arr, 1, $default_view_settings['category_left_side']);
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <select id="sub_category_left_side" class="form-control" name="sub_category_left_side" data-category-id = "<?php echo $default_view_settings['sub_category_left_side']; ?>">
                                                                                <option value="0">Select subcategory</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="panel panel-default">
                                                                    <div class="panel-heading">Main content. Right side</div>
                                                                    <div class="panel-body">
                                                                        <div class="col-sm-6">
                                                                            <select id="category_right_side" class="form-control" name='category_right_side' onchange="get_sub_cat(this.value, '_right_side'); return false;">
                                                                                <option value="0"><span style="color:#cccccc;">Select category</span></option>
                                                                                <?php
                                                                                $wb_n_c->wb_get_tree($wb_data_arr, 1, $default_view_settings['category_right_side']);
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <select id="sub_category_right_side" class="form-control" name="sub_category_right_side" data-category-id = "<?php echo $default_view_settings['sub_category_right_side']; ?>">
                                                                                <option value="0">Select subcategory</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="panel panel-default">
                                                                    <div class="panel-heading">Main content. Bottom side</div>
                                                                    <div class="panel-body">
                                                                        <div class="col-sm-6">
                                                                            <select id="category_bottom" class="form-control" name='category_bottom' onchange="get_sub_cat(this.value, '_bottom'); return false;">
                                                                                <option value="0"><span style="color:#cccccc;">Select category</span></option>
                                                                                <?php
                                                                                $wb_n_c->wb_get_tree($wb_data_arr, 1, $default_view_settings['category_bottom']);
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <select id="sub_category_bottom" class="form-control" name="sub_category_bottom" data-category-id = "<?php echo $default_view_settings['sub_category_bottom']; ?>">
                                                                                <option value="0">Select subcategory</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="panel panel-primary">
                                                        <div class="panel-heading">Sidebar</div>
                                                        <div class="panel-body">
                                                            <div class="col-sm-12">
                                                                <div class="panel panel-default">
                                                                    <div class="panel-heading">Sidebar area. 2 tab</div>
                                                                    <div class="panel-body">
                                                                        <div class="col-sm-6">
                                                                            <select id="category_tab2" class="form-control" name='category_tab2' onchange="get_sub_cat(this.value, '_tab2'); return false;">
                                                                                <option value="0"><span style="color:#cccccc;">Select category</span></option>
                                                                                <?php
                                                                                $wb_n_c->wb_get_tree($wb_data_arr, 1, $default_view_settings['category_tab2']);
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <select id="sub_category_tab2" class="form-control" name="sub_category_tab2" data-category-id = "<?php echo $default_view_settings['sub_category_tab2']; ?>">
                                                                                <option value="0">Select subcategory</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="panel panel-default">
                                                                    <div class="panel-heading">Sidebar area. 3 tab</div>
                                                                    <div class="panel-body">
                                                                        <div class="col-sm-6">
                                                                            <select id="category_tab3" class="form-control" name='category_tab3' onchange="get_sub_cat(this.value, '_tab3'); return false;">
                                                                                <option value="0"><span style="color:#cccccc;">Select category</span></option>
                                                                                <?php
                                                                                $wb_n_c->wb_get_tree($wb_data_arr, 1, $default_view_settings['category_tab3']);
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <select id="sub_category_tab3" class="form-control" name="sub_category_tab3" data-category-id = "<?php echo $default_view_settings['sub_category_tab3']; ?>">
                                                                                <option value="0">Select subcategory</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="panel panel-default">
                                                                    <div class="panel-heading">Sidebar area. 1 block</div>
                                                                    <div class="panel-body">
                                                                        <div class="col-sm-6">
                                                                            <select id="category_side1" class="form-control" name='category_side1' onchange="get_sub_cat(this.value, '_side1'); return false;">
                                                                                <option value="0"><span style="color:#cccccc;">Select category</span></option>
                                                                                <?php
                                                                                $wb_n_c->wb_get_tree($wb_data_arr, 1, $default_view_settings['category_side1']);
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <select id="sub_category_side1" class="form-control" name="sub_category_side1" data-category-id = "<?php echo $default_view_settings['sub_category_side1']; ?>">
                                                                                <option value="0">Select subcategory</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="panel panel-default">
                                                                    <div class="panel-heading">Sidebar area. 2 block</div>
                                                                    <div class="panel-body">
                                                                        <div class="col-sm-6">
                                                                            <select id="category_side2" class="form-control" name='category_side2' onchange="get_sub_cat(this.value, '_side2'); return false;">
                                                                                <option value="0"><span style="color:#cccccc;">Select category</span></option>
                                                                                <?php
                                                                                $wb_n_c->wb_get_tree($wb_data_arr, 1, $default_view_settings['category_side2']);
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <select id="sub_category_side2" class="form-control" name="sub_category_side2" data-category-id = "<?php echo $default_view_settings['sub_category_side2']; ?>">
                                                                                <option value="0">Select subcategory</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                

                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="location" class="col-sm-2 control-label">Location *:</label>
                                                            <span id="loc-info" class="error-info"></span>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" id="add-location" name="location" value="<?php echo $default_view_settings['location']; ?>" />
                                                            </div>
                                                    </div>

                                                    <div class="new-row">
                                                        <span class="wb-first"></span><span class="wb-input">
                                                            * required fields
                                                        </span>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                            <span id="message" style = "display: none;"></span>
                                                            <span id="ajax-loader" style="display: none;"><img src="<?php echo get_template_directory_uri() ?>/img/ajax-loader.gif"></span>
                                                            <button type="submit" name="submit_acc" id="submit_acc" class="btn btn-default">Save</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </form>
                                        </div>


                                <script type="text/javascript">
                                    
                                    var $ = jQuery;

                                    function get_sub_cat(data, id){
                                        var $ = jQuery;
                                            var arr = <?php echo $wb_sub_cat_arr; ?>;
                                            $("#sub_category"+id).empty();
                                            $("#sub_category"+id).append( $('<option value="0">Select subcategory</option>'));
                                            var cat_id = $('#sub_category'+id).attr('data-category-id');
                                            var selected;
                                            if(data > 0){
                                                $('#sub_category'+id).show();
                                                    $.each(arr, function(i, val) {
                                                    if(data == i){
                                                            val.sort(function(a, b){return a-b}); 
                                                        $.each(val, function(s, d) {
                                                            if (cat_id == d.id){
                                                                selected = 'selected';
                                                            }else{
                                                                selected = '';
                                                            }
                                                            $("#sub_category"+id).append( $('<option value="'+d.id+'" '+selected+'>'+d.title+'</option>'));
                                                        });
                                                    }
                                                    });
                                            }
                                        }
                                        function valid_form(){
                                                $('.error-info').hide();
                                                var error = 0;

                                                if ( $('#category').val() == '0' ) { 
                                                    $('#cat-info').html('Category is required').show(); 
                                                    error += 1; 
                                                }
                                                else if( $('#sub_category').val() == '0' ) {
                                                      $('#cat-info').html('Sub category is required').show();
                                                      error += 1; 
                                                  }
                                                else { 
                                                    $('#cat-info').hide();
                                                }

                                                // location
                                                if ( $('#add-location').val() == '' ) { 
                                                    $('#add-location').focus(); $('#loc-info').html('Location is required').show(); 
                                                    error += 1; 
                                                } else {

                                                    var loc_error_message = 'Invalid location (eg. city, state, country). Please choose your location from the drop-down list';
                                                    var place = window.autocomplete.getPlace();


                                                    if (place) {
    //                                                                  if (!place.geometry) {
    //                                                                          $('#add-location').focus(); 
    //                                                                          $('#loc-info').html(loc_error_message).show(); 
    //                                                                          error += 1; 
    //                                                              } else {


                                                            var b_country = false;
                                                            var s_country = '';

                                                            var b_state = false;
                                                            var s_state = '';

                                                            if(place.address_components.length) {
                                                                for (var i = 0; i < place.address_components.length;i++) {

                                                                    if (place.address_components[i].types[0] == 'administrative_area_level_1') {
                                                                            b_state = true;		
                                                                    } else if (place.address_components[i].types[0] == 'country') {
                                                                            b_country = true;
                                                                    }
                                                                }

                                                                if (b_state && b_country) {

                                                                        var s_addr = '';

                                                                        for (var i = 0; i < place.address_components.length;i++) {						
                                                                                if (place.address_components[i].types[0] == 'postal_code') {
                                                                                        continue;
                                                                                }

                                                                                //alert(place.address_components[i].long_name);
                                                                                s_addr += place.address_components[i].long_name;
                                                                                //alert(s_addr);
                                                                                s_addr += ', ';
                                                                        }
                                                                        s_addr = s_addr.trim();
                                                                        s_addr = s_addr.substring(0, s_addr.length - 1);
                                                                        //alert(s_addr);
                                                                        $('#add-location').val(s_addr);

                                                                }else {
    //                                                                    $('#add-location').focus(); 
    //                                                                    $('#loc-info').html(loc_error_message).show(); 
    //                                                                    error += 1; 							
                                                                }

                                                            }else {
    //                                                                $('#add-location').focus(); 
    //                                                                $('#loc-info').html(loc_error_message).show(); 
    //                                                                error += 1; 					
                                                            }

                                                    }else {
    //                                                      $('#add-location').focus(); 
    //                                                      $('#loc-info').html(loc_error_message).show(); 
    //                                                      error += 1; 			
                                                    }
                                                }
        //                                                if( error > 0 ) {
        //                                                   return false;
        //                                                }
                                                return true;
                                        }

                                        function add_location() {
                                                var input = $('#add-location')[0];
                                                var options = {
                                                 types: ['(regions)']
                                                };
                                                window.autocomplete = new google.maps.places.Autocomplete(input, options);
                                                google.maps.event.addListener(autocomplete, 'place_changed', function() {
                                                var place = window.autocomplete.getPlace();
                                                });
                                           }
                                           google.maps.event.addDomListener(window, 'load', add_location);
                                    </script>
                                    
                                    <?php 
                                        wp_reset_postdata();
                                    ?>
                                </div>
                                <?php 

                                } else {
                                _e( '<p><b style="color: #000000;">This page is protected. Sign in to your account.</b></p>', 'bingo');
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
        get_footer(); 

        ?>