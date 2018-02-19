<?php
/*
  Template Name: project my-video-edit
 */
global $wp_query;
get_header();
$allow_a_type = array("editor", "cj", "media");
$allow_a_edit_type = array('editor', 'cj', 'administrator');
$allow_a_download = array('editor');

$user_type = get_user_meta($user_ID, "user_type", true);

//print_r($user_type);
if (!in_array($user_type, $allow_a_type)) {
    wp_redirect(home_url());
}

?>
<div id="page-content" class="woocommerce woocommerce-page home">
    <div class="page-content">
        <div class="container my-mg">
            <?php the_title("<h1 class='page-title'>", "</h1>"); ?> 

            <?php echo do_shortcode('[yith_woocommerce_ajax_search]'); ?>
            <?php echo do_shortcode( '[bingo_checkbox_available]'); ?>
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
                    <div class="tab-pane active" id="project-list-tab-auction">
                        <?php
                        if (is_user_logged_in()) {
                            ?>
                            <div class="row">
                                <?php
                                get_template_part('account', 'menu');
                                
                                $edit_id = (isset($_GET['edit']) && intval($_GET['edit'])) ? intval($_GET['edit']) : false;
                                
                                if ($edit_id !== false) {
                                    $user_id = get_current_user_id();
                                    $post_edit = get_post($edit_id);
                                    
                                    $thumb_id = get_post_thumbnail_id($edit_id);
                                    $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'product-thumb', true);
                                    $thumb_url = wp_get_attachment_url($thumb_id);
                                    
                                    
                                                            
                                    
                                    if ($post_edit->post_author == $user_id || in_array($user_type, $allow_a_edit_type)) {
                                        $product_cat = get_the_terms($edit_id, "product_cat");
                                        
                                        //saving form
                                        if (isset($_POST["np_id"])) {
                                            $post_id = intval($_POST["np_id"]);
                                            $my_post = array();
                                            $my_post['ID'] = $post_id;
                                            $my_post['post_title'] = sanitize_text_field($_POST["title"]);
                                            $my_post['post_name'] = sanitize_title_with_dashes($_POST["title"]);
                                            $my_post['post_content'] = wp_filter_kses($_POST["description"]);
                                            $my_post['post_status'] = 'publish';
                                            $my_post['post_type'] = 'product';
                                            
                                            # update post
                                            wp_update_post($my_post);
                                            wp_publish_post($post_id);
                                            
                                            # update category
                                            $category = (isset($_POST["category"]) && intval($_POST["category"])) ? intval($_POST["category"]) : false;
                                            
                                            if ($category !== false) {
                                                wp_remove_object_terms($post_id, $product_cat[0]->term_id, 'product_cat');
                                                wp_set_post_terms($post_id, $category, 'product_cat', true);
                                            }
                                            
                                            # update location
                                            $location = strtolower(trim($_POST["location"]));
                                            if ($location != "") {
                                                $location = explode(",", $location);
                                                wp_set_post_terms($post_id, $location, 'product_tag', $append);
                                            }
                                            
                                            # upload custom thumbnail
                                            if (file_exists($_FILES['custom_thumb']['tmp_name']) || is_uploaded_file($_FILES['custom_thumb']['tmp_name'])){
                                                $thumb_parse_url = parse_url($thumb_url);
                                                $thumb_base_name = basename($thumb_parse_url['path']);
                                                
                                                $fileName = $_FILES['custom_thumb']['tmp_name'];
                                                $fileSize = filesize($fileName);
                                                
                                                $type_array = array('jpg');
                                                $file_type = strtolower(substr(strrchr($_FILES["custom_thumb"]['name'], '.'), 1));
                                                $min_size = 1 * 1024;
                                                $max_size = 5 * 1024 * 1024;
                                                if (!in_array($file_type, $type_array))
                                                    die(json_encode(array("comment" => "Image type not supported", "status" => 500)));
                                                if ($fileSize < $min_size)
                                                    die(json_encode(array("comment" => "Your image must be greater than 1 KB", "status" => 500)));
                                                if ($fileSize >= $max_size)
                                                    die(json_encode(array("comment" => "Your image can not be over 5 MB", "status" => 500)));

                                                $data = array( 
                                                                "filedata"      => base64_encode(file_get_contents($fileName)), //file
                                                                "filename"      => basename($fileName), //upload file name
                                                                "base_filename" => $thumb_base_name, // original file name
                                                                "id"            => $edit_id, //post id
                                                                "id_s"          => $thumb_id, // thumb id
                                                                "idus"          => $user_id // user id. Top 3 parameter for update post image

                                                            );
                                                
//                                                $data = json_encode($datas);
                                                
                                                $cURL = curl_init("http://liveinews.net/bootstrap.php?page=upload_custom_thumb");
                                                curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);

                                                curl_setopt($cURL, CURLOPT_POST, true);
                                                curl_setopt($cURL, CURLOPT_POSTFIELDS, $data);
                                                curl_setopt($cURL, CURLOPT_INFILESIZE, $fileSize);
                                                curl_setopt($cURL, CURLOPT_CONNECTTIMEOUT, 0);
                                                curl_setopt($cURL, CURLOPT_TIMEOUT, 900000);
                                                curl_setopt($cURL, CURLOPT_FRESH_CONNECT, 1);

                                                $response = curl_exec($cURL);
                                                $info = curl_getinfo($cURL);
                                                
                                                
                                                curl_close($cURL);
                                                
                                                $data = json_decode($response);
                                                
                                                echo "answer:";
                                                print_r($data);
                                            }
                                            
                                            #Upload new file
                                            if(file_exists($_FILES['userfile']['tmp_name']) || is_uploaded_file($_FILES['userfile']['tmp_name'])) {
                                                $base_filename = $_POST['base_filename'];
                                                
                                                $fileName = $_FILES['userfile']['tmp_name'];
                                                $fileSize = filesize($fileName);
                                                
                                                $type_array = array('mp4', 'avi', 'flv', '3gp', '3gpp', 'mkv', 'mov');
                                                $file_type = strtolower(substr(strrchr($_FILES["userfile"]['name'], '.'), 1));
                                                $min_size = 10 * 1024;
                                                $max_size = 100 * 1024 * 1024;
                                                if (!in_array($file_type, $type_array)){
                                                    echo 'Video type not supported';
                                                    die();
                                                }
                                                if ($fileSize < $min_size){
                                                    echo 'Your video must be greater than 10 KB';
                                                    die();
                                                }
                                                if ($fileSize >= $max_size){
                                                    echo 'Your video can not be over 100 MB';
                                                    die();
                                                }

                                                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                                                $finfo = finfo_file($finfo, $fileName);

//                                                $cFile = new CURLFile($fileName, $finfo, basename($fileName));
                                                
                                                $data = array( 
                                                                "filedata"      => base64_encode(file_get_contents($fileName)), //file
                                                                "filename"      => basename($fileName), //upload file name
                                                                "base_filename" => $base_filename, // original file name
                                                                "id"            => $edit_id, //post id
                                                                "id_s"          => $thumb_id, // thumb id
                                                                "idus"          => $user_id // user id. Top 3 parameter for update post image

                                                            );
                                                
//                                                $data = json_encode($datas);
                                                
                                                $cURL = curl_init("http://liveinews.net/bootstrap.php?page=upload_edit");
                                                curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);

                                                curl_setopt($cURL, CURLOPT_POST, true);
                                                curl_setopt($cURL, CURLOPT_POSTFIELDS, $data);
                                                curl_setopt($cURL, CURLOPT_INFILESIZE, $fileSize);
                                                curl_setopt($cURL, CURLOPT_CONNECTTIMEOUT, 0);
                                                curl_setopt($cURL, CURLOPT_TIMEOUT, 900000);
                                                curl_setopt($cURL, CURLOPT_FRESH_CONNECT, 1);

                                                $response = curl_exec($cURL);
                                                $info = curl_getinfo($cURL);
                                                
                                                curl_close($cURL);
                                                
                                                $data = json_decode($response);
                                                
                                            }
                                            
                                            $redirect_to = '/my-videos/';
//                                            wp_safe_redirect($redirect_to);
                                            exit();
                                            
                                        } else {

                                            $cat_parent = $product_cat[0]->parent;

                                            $wb_n_c = new wb_get_cat();
                                            $wb_data_arr = $wb_n_c->wb_get_arr_cat();
                                            $wb_sub_cat_arr = json_encode($wb_n_c->get_tree_sub($wb_data_arr));
                                            ?>
                                            
                                            <form action="" method="POST" class="form-horizontal" enctype="multipart/form-data" id="wb-edit-form">
                                                <input type="hidden" name="np_id" value="<?php echo $edit_id; ?>" />

                                                                    
                                                            
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label" for="title">Screenshot:</label>
                                                        <span class="errors-info" id="error-title"></span>
                                                        <div class="col-sm-3">
                                                            <a class="" href="#">
                                                                
                                                                <?php
                                                                    if ("http://liveinews.com/wp-includes/images/media/default.png" != $thumb_url) {
                                                                        if ($thumb_url) {
                                                                            echo '<img id="thumb-img" class="media-object" src="' . getEncodedimgString("jpg", $thumb_url) . '" >';
                                                                        } else {
                                                                            echo '<img id="thumb-img" class="media-object" src="' . IMAGES . '/no-image-big.jpg" >';
                                                                        }
                                                                    }else{ 
                                                                ?>

                                                                <img id="thumb-img" class="post-image" src="<?php print IMAGES; ?>/no-image.png">
                                                                <?php } ?>    
                                                            </a>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label" for="title">Screenshot action:</label>
                                                        <span class="errors-info" id="error-title"></span>
                                                        <div class="col-sm-6">
                                                            <p>
                                                                You can take a new screenshot(random time set) from videofile
                                                            </p><br/>
                                                            <span class="btn btn-info" onclick="update_screen();" title="Update Thumbnail">Get new screen from video</span>
                                                            <span id="pre-load-thumb" style="display: none;"><img src="<?php echo get_template_directory_uri() ?>/img/ajax-loader.gif"></span><br/>
                                                            
                                                            <p>
                                                                Or upload a custom screenshot from your file
                                                            </p><br/>
                                                            <input type="file"  id="custom_thumb" name="custom_thumb">
                                                        </div>
                                                    </div>
                                                
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label" for="title">Title:</label>
                                                        <span class="errors-info" id="error-title"></span>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" name="title" placeholder="Title" value="<?php echo stripcslashes($post_edit->post_title); ?>" id="title" />
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label" for="title">Description:</label>
                                                        <span id="tit-info" class="error-info"></span>
                                                        <div class="col-sm-6">
                                                            <textarea type="text" class="form-control" rows="3" name="description" placeholder="Description" value="" id="description"><?php echo stripcslashes($post_edit->post_content); ?>
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label" for="title">Category:</label>
                                                        <span id="cat-info" class="error-info"></span>
                                                        <div class="col-sm-4">
                                                            <select id="category" class="form-control" onchange="get_sub_cat(this.value); return false;">
                                                                <?php
                                                                if ($product_cat[0]->parent == 0) {
                                                                    $active = $product_cat[0]->term_id;
                                                                } else {
                                                                    $active = $product_cat[0]->parent;
                                                                }
                                                                
                                                                $wb_n_c->wb_get_tree($wb_data_arr, 1, $active);
                                                                ?>
                                                            </select> 
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <select id="sub_category" class="form-control" name="category">
                                                                <option value="0">Select subcategory</option>
                                                                <?php
                                                                if ($product_cat[0]->parent > 0) {
                                                                    $wb_n_c->wb_get_tree_sub($wb_data_arr, $product_cat[0]->parent, $product_cat[0]->term_id);
                                                                }
                                                                ?>
                                                            </select>
                                                            
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label" for="title">Location: *</label>
                                                        <span id="loc-info" class="error-info"></span>
                                                        <div class="col-sm-6">
                                                            <span> <?php the_terms($edit_id, 'product_tag', '', mb_ucfirst(', ', "CP1251")); ?> </span>
                                                            <span class="change-location" onclick="change_loc();">change</span>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group" id="cng-loc" style="display:none;">
                                                        <label class="col-sm-3 control-label" for="title">New Location:</label>
                                                        <span id="loc-info" class="error-info"></span>
                                                        <div class="col-sm-6">
                                                            <input type="text" id="edit-location" class="form-control" name="location" />
                                                        </div>
                                                    </div>
                                                
                                                <?php 
//                                                    if (in_array($user_type, $allow_a_download)) {
                                                    
                                                ?>
                                                
                                                    <div class="form-group" id="upload-video">
                                                        <label class="col-sm-3 control-label" for="title">Download video for edit:</label>
                                                        <span id="loc-info" class="error-info"></span>
                                                        <div class="col-sm-6">
                                                            <?php $fileUrl = get_post_meta( $post_edit->ID, '_video_url', true ); ?>
                                                            
                                                            <a href = "<?php echo $fileUrl; ?>">Download</a>
                                                            
                                                            <?php 
                                                                $parts = parse_url($fileUrl); 
                                                                $filename = basename($parts["path"]);
                                                            ?>
                                                            <input type="hidden" id="base_filename" name="base_filename" value="<?php echo $filename; ?>"/>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="form-group" id="choise-file">
                                                    <label class="col-sm-3 control-label" for="userfile">Upload a new file:</label>
                                                        <span id="file-info" class="error-info"></span>
                                                        <div class="col-sm-8">
                                                            <input type="file" id="the-video-file-field" name="userfile" accept="video/mp4,video/x-m4v,.mkv,video/x-matroska,video/3gpp,.3gp,video/x-flv,video/*" max="1" value="" />
                                                            <p class="help-block">Supported video formats: mp4, avi, flv, 3gp, mkv, mov</p>
                                                            <p class="help-block">File size limit: 10KB to 100MB</p>
                                                        </div>
                                                        <span class="video-delete del-choos" alt="Delete" title="Delete file" onclick="delete_choose();"></span>
                                                  
                                                    <div id="wb-status-upload"></div>
                                                </div>
                                                
                                                    <?php // } ?>
                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-offset-3 col-sm-10">
                                                            <input type="submit" class="btn btn-default"  value="Save"/>
                                                        </div>
                                                    </div>
                                                    
                                            </form>
                                            <script type="text/javascript">
                                                var $ = jQuery;
                                                                function get_sub_cat(data) {
                                                                    var arr = <?php echo $wb_sub_cat_arr; ?>;
                                                                    $("#sub_category").empty();
                                                                    $("#sub_category").append($('<option value="0">Select subcategory</option>'));
                                                                    if (data > 0) {
                                                                        $('#sub_category').show();
                                                                        $.each(arr, function (i, val) {
                                                                            if (data == i) {
                                                                                val.sort(function (a, b) {
                                                                                    return a - b
                                                                                });
                                                                                $.each(val, function (s, d) {
                                                                                    $("#sub_category").append($('<option value="' + d.id + '">' + d.title + '</option>'));
                                                                                });
                                                                            }
                                                                        });
                                                                    }
                                                                }

                                                                function update_screen() {
                                                                    var id = '<?php echo $edit_id; ?>';
                                                                    var id_s = '<?php echo $thumb_id; ?>';
                                                                    var idus = '<?php echo $user_id; ?>';
                                                                    $.ajax({
                                                                        type: 'POST',
                                                                        url: 'http://liveinews.net/bootstrap.php?page=upd_creen',
                                                                        crossDomain: true,
                                                                        dataType: 'json',
                                                                        catche: 'false',
                                                                        data: {"id": id, "id_s": id_s, "idus": idus},
                                                                        beforeSend: function () {
                                                                            $('#pre-load-thumb').show();
                                                                            $('#update_screen').remove();
                                                                        },
                                                                        success: function (data) {
                                                                            var d = new Date();
                                                                            $("#thumb-img").attr("src",data.screen_url+"?"+d.getTime());
                                                                            $('#pre-load-thumb').hide();
                                                                        }
                                                                    });
                                                                }

                                                                function change_loc() {
                                                                    if ($('#cng-loc').is(":visible")) {
                                                                        $('#cng-loc').hide();
                                                                        $('#edit-location').val('');
                                                                    } else {
                                                                        $('#cng-loc').show();
                                                                    }
                                                                }

                                                                $("form#wb-edit-form").submit(function () {
                                                                    var title = $.trim($('input[name="title"]').val());
                                                                    var file = $('input[name="userfile"]').val();
                                                                    //console.log(title);
                                                                    if (title == '') {
                                                                        $('#error-title').html('Title is required').css('display', 'block').delay(5000).fadeOut(300);
                                                                        return false;
                                                                    }
                                                                    if (title.length < 4) {
                                                                        $('#error-title').html('Title too short. At least 4 characters is required').css('display', 'block').delay(5000).fadeOut(300);
                                                                        return false;
                                                                    }
                                                                    
                                                                    if(file != ''){
                                                                        return confirm('Do you realy want to replace video file?');
                                                                    }

                                                                    $("#wb-edit-form").submit();
                                                                });

                                                                function initialize() {
                                                                    var input = document.getElementById('edit-location');
                                                                    var options = {
                                                                        types: ['(regions)'],
                                                                    };
                                                                    var autocomplete = new google.maps.places.Autocomplete(input, options);
                                                                    google.maps.event.addListener(autocomplete, 'place_changed', function () {
                                                                        var place = autocomplete.getPlace();
                                                                    });
                                                                }
                                                                google.maps.event.addDomListener(window, 'load', initialize);
                                            </script>
                                        <?php
                                    }
                                } else {
                                    echo '<p>';
                                    _e('<b style="color: #000000;">Page not found.</b>', 'bingo');
                                    echo '</p>';
                                }
                            } else {
                                echo '<p>';
                                _e('<b style="color: #000000;">Page not found.</b>', 'bingo');
                                echo '</p>';
                            }
                            ?>
                            </div>
    <?php
} else {
    echo '<p>';
    _e('<b style="color: #000000;">This page is protected. Sign in to your account.</b>', 'bingo');
    echo '</p>';
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
<?php
if ($bingo_option_data['bingo-partners-on-off'] == true) {
    get_template_part('framework/template/partner', '');
}

get_template_part('framework/template/twitter-template', '');
get_footer();
?>