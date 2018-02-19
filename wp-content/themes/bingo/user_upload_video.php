<?php 
/*
Template Name: user video uploads
*/

global $wp_query;
get_header();
  $allow_a_type = array("editor", "cj", "media");
  $user_type 	= get_user_meta( $user_ID, "user_type", true );
  if(!in_array($user_type, $allow_a_type)){
    wp_redirect( home_url() );
  }
  
  set_time_limit(0);
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
                            <div class="active" id="project-list-tab-auction">
                                <?php
                                if ( is_user_logged_in() ) {
                                    echo '<div class="row">';
                                    ?>
                                    <!-- account menu account-menu.php -->
                                    <?php get_template_part( 'account', 'menu' ); ?>
                                    <!-- account menu account-menu.php -->
                                    <?php
                                    # id user
                                    $wb_user_id = get_current_user_id();
                                    if (!session_id())
                                    session_start();
                                    $_SESSION["id_user"] = $wb_user_id;


                                    $wb_n_c 		= new wb_get_cat();
                                    $wb_data_arr 	= $wb_n_c->wb_get_arr_cat();
                                    $wb_sub_cat_arr = json_encode($wb_n_c->get_tree_sub($wb_data_arr));
                                    ?>
                                    <!--- content-->


                                        <div class="wb-content new-row">
                                            <div class="form-group">
                                                <div class="col-sm-offset-3 col-sm-10">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" id="use_default_view" />Use my default view 
                                                        </label>
                                                        <span id="use_default_message" style = "display: none;"></span>
                                                        <span id="use_default_ajax-loader" style="display: none;">
                                                            <img src="<?php echo get_template_directory_uri() ?>/img/ajax-loader.gif">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <form action="" method="POST" class="form-horizontal" enctype="multipart/form-data" id="wb-upload-form" onsubmit="if(valid_form()==false) {return false;}" autocomplete="off">
                                                
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label" for="title">Title: *</label>
                                                        <span id="tit-info" class="error-info"></span>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" name="title" placeholder="Title" value="" id="title" />
                                                        </div>
                                                </div>
                                                
                                                
                                                
                                                <div class="form-group" id="choise-file">
                                                    <label class="col-sm-3 control-label" for="userfile">Choose file: *</label>
                                                        <span id="file-info" class="error-info"></span>
                                                        <div class="col-sm-8">
                                                            <input type="file" id="the-video-file-field" name="userfile" accept="video/mp4,video/x-m4v,.mkv,video/x-matroska,video/3gpp,.3gp,video/x-flv,video/*" max="1" value="" />
                                                            <p class="help-block">Supported video formats: mp4, avi, flv, 3gp, mkv, mov</p>
                                                            <p class="help-block">File size limit: 10KB to 100MB</p>
                                                        </div>
                                                        <span class="video-delete del-choos" alt="Delete" title="Delete file" onclick="delete_choose();"></span>
                                                  
                                                    <div id="wb-status-upload"></div>
                                                </div>
                                                <!--<div class="new-row" id="next_step" style="display:none;">-->
                                                
                                                <div class="form-group">
                                                    <div class="col-sm-offset-3 col-sm-10">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" name="preview" id="list" onclick="drop_list();" />Add preview 
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <div id="preview_list"></div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label" for="title">Description: *</label>
                                                        <span id="tit-info" class="error-info"></span>
                                                        <div class="col-sm-6">
                                                            <textarea type="text" class="form-control" rows="3" name="description" placeholder="Description" value="" id="description"></textarea>
                                                        </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                        <label class="col-sm-3 control-label" for="title">Category: *</label>
                                                        <span id="cat-info" class="error-info"></span>
                                                        <div class="col-sm-4">
                                                            <select id="category" class="form-control" onchange="get_sub_cat(this.value); return false;">
                                                                <option value="0"><span style="color:#cccccc;">Select category</span></option>
                                                                <?php
                                                                $wb_n_c->wb_get_tree($wb_data_arr, 1);
                                                                ?>
                                                            </select> 
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <select id="sub_category" class="form-control" name="category">
                                                                <option value="0">Select subcategory</option>
                                                            </select>
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <label class="col-sm-3 control-label" for="title">Location: *</label>
                                                        <span id="loc-info" class="error-info"></span>
                                                        <div class="col-sm-6">
                                                            <input type="text" id="add-location" class="form-control" name="location" />
                                                        </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <div class="col-sm-offset-3 col-sm-10">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" id="emergency" value='Emergency' name="breaking[]" />Emergency 
                                                            </label>
                                                        </div>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" id="natural_disaster" value="Natural Disaster" name="breaking[]" />Natural Disaster 
                                                            </label>
                                                        </div>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" id="accident" value="Accident" name="breaking[]" />Accident 
                                                            </label>
                                                        </div>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" id="health" value="Health" name="breaking[]" />Health 
                                                            </label>
                                                        </div>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" id="disturbance" value="Disturbance" name="breaking[]" />Disturbance
                                                            </label>
                                                        </div>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" id="crime" value="Crime" name="breaking[]" />Crime
                                                            </label>
                                                        </div>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" id="politics" value="Politics" name="breaking[]" />Politics
                                                            </label>
                                                        </div>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" id="public_event" value="Public Event" name="breaking[]" />Public Event
                                                            </label>
                                                        </div>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" id="business_commerce" value="Business/Commerce" name="breaking[]" />Business/Commerce
                                                            </label>
                                                        </div>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" id="famous_person" value="Famous Person" name="breaking[]" />Famous Person
                                                            </label>
                                                        </div>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" id="other" value="" name="" />Other
                                                            </label>
                                                            <input id="other-breaking" name="breaking[]" disabled />
                                                            <input type = "hidden" id="source" name="source" value="desktop"/>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                
                                                <div class="new-row">
                                                    <span class="wb-first"></span><span class="wb-input">
                                                        * required fields
                                                    </span>
                                                </div>
                                                
                                                
                                                <div class="form-group">
                                                    <div class="col-sm-offset-3 col-sm-10">
                                                        <input type="submit" class="btn btn-default"  value="Submit"/>
                                                    </div>
                                                </div>
                                                
                                                <!--</div>-->
                                            </form>
                                    </div> 
                            </div>
                                    <!--- end content-->
                                    <?php 
                                } else {
  wp_redirect(home_url( '/login/' ));
/*echo '<p>';
_e( '<b style="color: #000000;">This page is protected. Sign in to your account.</b>', 'bingo');
return;
echo '</p>';*/
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
    
    <script type="text/javascript">
        var $ = jQuery;
        
        $('#other').on('change', function(){
           if (this.checked){
               $('#other-breaking').attr('disabled', false);
           }else{
               $('#other-breaking').attr('disabled', true);
               
           }
        });
        
    function change_page() {
    	var myEvent = window.attachEvent || window.addEventListener;
        var chkevent = window.attachEvent ? 'onbeforeunload' : 'beforeunload';
        myEvent(chkevent, function(e) { 
          	if($("input").is('#title') == true ) {
            	var confirmationMessage = ' '; 
            	(e || window.event).returnValue = confirmationMessage;
            	return confirmationMessage;
          	}
    	});
    }

    function delete_choose(){
       $('#the-video-file-field').val('').show();
       $('#new_name_file').remove();
       $('.video-delete').hide();
    }

    function get_sub_cat(data){
    	var arr = <?php echo $wb_sub_cat_arr;?>;
    	$("#sub_category").empty();
    	$("#sub_category").append( $('<option value="0">Select subcategory</option>'));
        var cat_id = $('#sub_category').attr('data-category-id');
        var selected;
    	if(data > 0){
    	    $('#sub_category').show();
    	        $.each(arr, function(i, val) {
    	        if(data == i){
    	        	val.sort(function(a, b){return a-b}); 
    	    	    $.each(val, function(s, d) {
                        if (cat_id == d.id){
                            selected = 'selected';
                        }else{
                            selected = '';
                        }
    	    	        $("#sub_category").append( $('<option value="'+d.id+'" '+selected+'>'+d.title+'</option>'));
    	            });
    	        }
                });
        }
    }

    window.onload = function() {
    $('#title').val('');
    }
    
    function valid_form(){
      $('.error-info').hide();
      var error = 0;
      var check = ( $("#list").is(':checked') ) ? 1 : 0;
      
      if ( $('#title').val() == '' ) { 
          $('#title').focus(); 
          $('#tit-info').html('Video title is required').show(); 
          error += 1; 
      }
      
      if ( $('#title').val().length < 4 ) { 
          $('#title').focus(); 
          $('#tit-info').html('The title is too short. At least 4 characters are required').show(); 
          error += 1; 
      }
      
      if ( $('#the-video-file-field').val() == '' ) { 
          $('#file-info').html('Please check the attachment').show(); 
          error += 1; 
      }else if ( $('#the-video-file-field')[0].files[0].size/(1024*1024) >= 100 ) { 
          $('#file-info').html('Your video can not be over 100 MB').show(); 
          error += 1; 
      }
      
      if ( check == 1) {
        var ctime = /\d\d:\d\d/;
        if ( $('#start').val() == '' ) {
            $('#start-info').html('Start time is required').show(); 
            error += 1; 
        }else if( ctime.test($('#start').val()) == false ) { 
            $('#start-info').html('Start time invalid format').show(); 
            error += 1; 
        }
        if ( $('#duration').val() == '' ) {
            $('#dur-info').html('Duration time is required').show(); 
            error += 1; 
        }else if( ctime.test($('#duration').val()) == false ) { 
            $('#dur-info').html('Duration time invalid format').show(); 
            error += 1; 
        }else if(this.duration_format($('#duration').val()) < 1){ 
            $('#dur-info').html('Duration time minimal 1 seconds').show(); 
            error += 1; 
        }
      }
      if ( $('#category').val() == '0' ) { 
          $('#cat-info').html('Category is required').show(); 
          error += 1; 
      }else if( $('#sub_category').val() == '0' ) { 
          $('#cat-info').html('Sub category is required').show(); 
          error += 1; 
      }else { 
          $('#cat-info').hide();
      }
      
      // location
      if ( $('#add-location').val() == '' ) { 
          $('#add-location').focus(); 
          $('#loc-info').html('Location is required').show(); 
          error += 1; 
      } else {
	  	
	  	var loc_error_message = 'Invalid location (eg. city, state, country). Please choose your location from the drop-down list';
	  	var place = window.autocomplete.getPlace();
	  	
	  	
		if (place) {
                    if (!place.geometry) {
				$('#add-location').focus(); 
				$('#loc-info').html(loc_error_message).show(); 
				error += 1; 
		    } else {

		    	
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
						
					} 
                                        else {
						$('#add-location').focus(); 
						$('#loc-info').html(loc_error_message).show(); 
						error += 1; 							
					}
					
				} 
				else {
					$('#add-location').focus(); 
					$('#loc-info').html(loc_error_message).show(); 
					error += 1; 					
				}
						
		} 
	  }
                else {
				$('#add-location').focus(); 
				$('#loc-info').html(loc_error_message).show(); 
				error += 1; 			
		}
	  	


      
      
//      error=0;
      
    }
      if( error > 0 ) {
         return false;
      }
      return true;
    }

    function duration_format(src){
      var time = src.split(':');
      var sec1 = parseInt(time[0]);
      var sec2 = parseInt(time[1]);
      var seconds = 0;
      if( sec1 > 0 ) {
        var seconds = seconds+time[0]*60;
      }
      seconds = seconds + sec2;
      return seconds;
    }

    $( document ).ready(function() {
      $('#title').keyup(function(){
        if ( $(this).val().length > 4 ) {
        	change_page();
        }
      });

      $('#the-video-file-field').on("change", function(){
      	$('.video-delete').css('display','inline-block');
        if(this.files[0].size >= 100*1024*1024) {
          	$('#file-info').html('Your video can not be over 100 MB').show();
          	$('button[type=submit]').prop('disabled', true);
        } else if(this.files[0].size < 10*1024) {
        	$('#file-info').html('Your video must be greater than 10 KB').show();
          	$('button[type=submit]').prop('disabled', true);
        } else {
          	$('#file-info').html('').hide();
          	$('button[type=submit]').prop('disabled', false);
        }
        var file = $('#the-video-file-field')[0].files[0];
        if(file){
        	$('#the-video-file-field').hide();
        	$( '<span id="new_name_file">'+file.name+'</span>' ).insertAfter( "#the-video-file-field" );
        }
      });

    progress = false;
    $("#wb-upload-form").submit(function(e){
      if(!progress){
      var valid = valid_form(); 
      if(valid === false){
      	e.preventDefault();
      	e.stopPropagation();
        return false;
      }
      var formData = new FormData($(this)[0]);
      
      formData.append('action', 'upload_video_ajax');

      var upl = $.ajax({
           type: "POST",
           data: formData,
           async:true,
           url: ajax_object.ajaxurl,
           action: 'upload_video_ajax',
           timeout: 3600000,
           cache: false,
           contentType: false,
           processData: false,
       
           beforeSend: function(){
            progress = true;
            $('.wb-content').html('');
            $(".wb-content").append( "<div id='status-upload'></div>" );
            $(".wb-content").append( "<div class='status-upload'> Now your video is decoding. Please wait. After that you will be return to My Video page<div class='progress-upload'></div></div>" );
            $(".wb-content").append( "<div class='cancel-upload'><button id='cancel_upload' class='btn btn-danger'>CANCEL UPLOAD</button></div>" );
            $('html, body').animate({scrollTop: 150},500);
            //$('a').click(function(e) { e.preventDefault(); });
           },
           success: function( data ) {
    //           console.log(data);
                var obj = jQuery.parseJSON( data );
                if ( obj.status == 200 ) {
                     location.replace('/my-videos/');
                } else {
                     //$('.wb-content').html( obj.comment ).show('fast');
                     console.log(obj.comment);
                }
                progress = false;
           },
           xhr: function(){
               var xhr = $.ajaxSettings.xhr();
               xhr.upload.addEventListener("progress", function(evt){
                if (evt.lengthComputable) {
                  var percentComplete = parseInt((evt.loaded / evt.total) * 100);
                  $('#status-upload').html('Uploading video<br /><div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: '+percentComplete+'%;"><span class="sr-only">'+percentComplete+'% Upload Complete</span></div></div>');
                  if( percentComplete >= 97 ){
                       $('.status-upload').show();
                  }
                }
               }, false);
              return xhr;
           },
       
       }).fail(function ( data ) {
//       		$('.wb-content').html( "Error loading file! Please try again later." ).show('fast');
//                console.log(data);
//        	progress = false;
            location.replace('/my-videos/');
       });
       }
        e.preventDefault();

      $('#cancel_upload').on('click',function(e){
            e.preventDefault();
            progress = false;
            upl.abort();
            location.replace('/my-videos/');
        });

        return false;
       });
    
       });


    
    function drop_list() {
    var check = ( $("#list").is(':checked') ) ? 1 : 0;
    if (check == 1) {
      $("#preview_list").html(
      '<div class="form-group">'+
            '<label class="col-sm-3 control-label" for="title">Start time: *</label>'+
                '<span id="tit-info" class="error-info"></span>'+
                '<div class="col-sm-6">'+
                    '<input type="text" class="form-control" name="start" id="start" value="" maxlength="5" placeHolder="00:00" title="MM:SS" pattern="[0-9]{2}:[0-9]{2}" />'+
                '</div>'+
        '</div>'+
        '<div class="form-group">'+
            '<label class="col-sm-3 control-label" for="title">Duration: *</label>'+
                '<span id="tit-info" class="error-info"></span>'+
                '<div class="col-sm-6">'+
                    '<input type="text" class="form-control" name="duration" id="duration" value="" maxlength="5" placeHolder="00:00" title="MM:SS" pattern="[0-9]{2}:[0-9]{2}" />'+
                '</div>'+
        '</div>'
      );
    } else {
      $("#preview_list").empty();
    }
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
<?php get_footer(); ?>