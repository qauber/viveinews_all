<?php

function vendor_product_post_type(){
	register_post_type( 'vendor_product',
		array(
			'labels' => array(
				'name' => __('Vendors','woocommerce-vendor-setup'),
				'singular_name' => __( 'Vendor','woocommerce-vendor-setup' ),
        		'add_new_item' => __('Add New Vendor','woocommerce-vendor-setup'),
        		'edit_item' => __('Edit Vendor','woocommerce-vendor-setup')
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'vendor_products'),
			'supports' => array('title','editor','thumbnail')
		)
	);
	
}

/*function vendor_user_create_product_for_user(){
	//add_dashboard_page( 'Vendor Product', 'Vendor Product', 'normal', 'vendor_admin_meu', 'vendor_meta_box_content'); add_menu_page('Test Menu', 'Test Menu',
        // add_menu_page('Test Menu', 'Test Menu', null, 'test', 'test_user_admin_page');
		
		add_menu_page('Test Menu', 'Test Menu', 'exist', 'test', 'test_user_admin_page');
}*/

/*function vendor_user_create_product(){
	//add_meta_box('Meta Box',''.__('Vendor Admin','woocommerce-vendor-setup').'', 'vendor_meta_box_content', 'vendor_product', 'normal', 'high' );
	//add_dashboard_page( 'Vendor Product', 'Vendor Product', 'normal', 'vendor_admin_meu', 'vendor_meta_box_content'); add_menu_page('Test Menu', 'Test Menu',
        // add_menu_page('Test Menu', 'Test Menu', null, 'test', 'test_user_admin_page');
		
		add_menu_page('Test Menu', 'Test Menu', 'exist', 'test', 'test_user_admin_page');
}*/
function vendor_upload_product() {
	global $woocommerce, $post, $current_user, $wpdb;
	//echo "SELECT * FROM $wpdb->postmeta WHERE meta_key = '_vendor_user_id' and meta_value = '".get_current_user_id()."'";
	//$current_vendor_info = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."postmeta WHERE meta_key = '_vendor_user_id' and meta_value = '".get_current_user_id()."'" ), ARRAY_A );
	$current_vendor_info = $wpdb->get_row("SELECT * FROM $wpdb->postmeta WHERE meta_key = '_vendor_user_id' and meta_value = '".get_current_user_id()."'");
//echo $current_vendor_info->post_id; 
	$vendor_pro_publish_status=get_post_meta($current_vendor_info->post_id,'_vendor_publish_pro',true);
	//$vendor_publish_pro=get_post_meta($post->ID,'_vendor_publish_pro',true);
	//die($current_vendor_info->post_id);
	get_currentuserinfo();
	if($_POST){
		$post = array(
     'post_author' => get_current_user_id(),
     'post_content' => $_POST['van_pro_cont'],
     'post_status' => $vendor_pro_publish_status,
     'post_title' => $_POST['ven_pro_title'],
     'post_parent' => '',
     'post_type' => "product",

     );
      //Create post
     $post_id = wp_insert_post( $post );
     if($post_id){
     /*$attach_id = get_post_meta($product->parent_id, "_thumbnail_id", true);
     add_post_meta($post_id, '_thumbnail_id', $attach_id);*/
	 $image_path = wp_upload_dir();
	 //$image_path['path']
	 //$uploaddir = './uploads/image/large_image/'; 
	 //$file = $uploaddir . basename($_FILES['img_file']['name']); 
	 $file = $image_path['path'].'/'. basename($_FILES['img_file']['name']); 
	 $file_url = $image_path['url'].'/'. basename($_FILES['img_file']['name']);
	 $raw_file_name = $_FILES['img_file']['tmp_name'];
	 if (move_uploaded_file($_FILES['img_file']['tmp_name'], $file)) {
		//add_post_meta($post_id, '_thumbnail_id', $file_url); 
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		$thumb_url = $file_url;
		$tmp = download_url( $thumb_url );
		
		// Set variables for storage
		// fix file name for query strings
		preg_match('/[^\?]+\.(jpg|JPG|jpe|JPE|jpeg|JPEG|gif|GIF|png|PNG)/', $thumb_url, $matches);
		$file_array['name'] = basename($matches[0]);
		$file_array['tmp_name'] = $tmp;
		
		// If error storing temporarily, unlink
		/*if ( is_wp_error( $tmp ) ) {
		@unlink($file_array['tmp_name']);
		$file_array['tmp_name'] = '';
		$logtxt .= "Error: download_url error - $tmp\n";
		}else{
		$logtxt .= "download_url: $tmp\n";
		}*/
		
		//use media_handle_sideload to upload img:
		$thumbid = media_handle_sideload( $file_array, $post_id, 'gallery desc' );
		// If error storing permanently, unlink
		/*if ( is_wp_error($thumbid) ) {
		@unlink($file_array['tmp_name']);
		//return $thumbid;
		$logtxt .= "Error: media_handle_sideload error - $thumbid\n";
		}else{
		$logtxt .= "ThumbID: $thumbid\n";
		}*/
		
		set_post_thumbnail($post_id, $thumbid);
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		echo '<div style="width:100%; background-color:#09F; text-align:center; font-size:18px;">Product Uploaded Successfully</div>'; 
	 } else {
		echo '<div style="width:100%; background-color:#EF77AF; text-align:center; font-size:18px;">Product Upload Failed, Please Try Again </div>';
	 }
	 
	 
    }
    wp_set_object_terms( $post_id, '', 'product_cat' );// Computer
    wp_set_object_terms($post_id, $_POST['van_pro_type'], 'product_type');



     update_post_meta( $post_id, '_visibility', 'visible' );
     update_post_meta( $post_id, '_stock_status', $_POST['ven_pro_stock_status']);
     update_post_meta( $post_id, 'total_sales', '0');
	 if(isset($_POST['van_pro_downloadable'])){
     update_post_meta( $post_id, '_downloadable', 'yes');
	 }
	 if(isset($_POST['van_pro_virtual'])){
     update_post_meta( $post_id, '_virtual', 'yes');
	 }
     update_post_meta( $post_id, '_regular_price', $_POST['ven_pro_regular_price'] );
     update_post_meta( $post_id, '_sale_price', $_POST['ven_pro_sale_price'] );
     update_post_meta( $post_id, '_purchase_note', $_POST['ven_pro_purchase_note'] );
     update_post_meta( $post_id, '_featured', "no" );
     update_post_meta( $post_id, '_weight', $_POST['ven_pro_weight'] );
     update_post_meta( $post_id, '_length', $_POST['ven_pro_length'] );
     update_post_meta( $post_id, '_width', $_POST['ven_pro_width'] );
     update_post_meta( $post_id, '_height', $_POST['ven_pro_height'] );
     update_post_meta($post_id, '_sku', $_POST['ven_pro_sku']);
     update_post_meta( $post_id, '_product_attributes', array());
     update_post_meta( $post_id, '_sale_price_dates_from', "" );
     update_post_meta( $post_id, '_sale_price_dates_to', "" );
     update_post_meta( $post_id, '_price', $_POST['ven_pro_sale_price'] );
     update_post_meta( $post_id, '_sold_individually', "" );
     update_post_meta( $post_id, '_manage_stock', $_POST['ven_pro_manage_stock'] );
     update_post_meta( $post_id, '_backorders', $_POST['ven_pro_backorders'] );
     update_post_meta( $post_id, '_stock', $_POST['ven_pro_stock'] );
	 if(isset($_POST['ven_pro_vendor_select'])){
	  $vendor_select = $_POST['ven_pro_vendor_select'];
	  if( !empty( $vendor_select ) )
	  update_post_meta( $post_id, '_vendor_select', esc_attr( $vendor_select ) );
	}
	// Vendor Percentage
	if(isset($_POST['ven_pro_vendor_percentage'])){
	  $vendor_percentage = $_POST['ven_pro_vendor_percentage'];
	  if( !empty( $vendor_percentage ) )
	  update_post_meta( $post_id, '_vendor_percentage', esc_attr( $vendor_percentage ) );
	}
	// Vendor Note
	if(isset($_POST['ven_pro_vendor_note'])){
	  $vendor_note = $_POST['ven_pro_vendor_note'];
	  if( !empty( $vendor_note ) )
	  update_post_meta( $post_id, '_vendor_note', esc_html( $vendor_note ) );
	}
	 
	//-------------------------------------------------------------------------------------
	$to = get_option( 'admin_email' );//get_post_meta($item_arr[$i]['vendor_id'],'_vendor_email',true);
		//$subject = 'A order has been reseived, Order ID is '.$order_id;
		$subject = 'A new product has been inserted, which is pending for your approval';
		$message = '<!DOCTYPE HTML>'.
					'<head>'.
					'<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'.
					'<title>A new product hasbeen inserted by '.$current_user->user_login.' </title>'.
					'</head>'.
					
					'<body>'.
					  '<table style="width:100%;">'.
						'<tr>'.
							'<td align="center">'.
								'<table style="width:60%; border:solid 1px #69F;">'.
									'<tr style="width:100%;">'.
										'<td style="width:100%; background:#69F; color:#FFF;" height="50px;">&emsp;</td>'.
									'</tr>'.
									'<tr style="width:100%;">'.
										'<td style="width:100%; font-size:30px; color:#000; font-weight:bold;">A new product hasbeen inserted by '.$current_user->user_login.'</td>'.
									'</tr>'.
									'<tr>'.
										'<td>&nbsp;</td>'.
									'</tr>'.
									'<tr style="width:100%;">'.
										'<td style="width:100%;">Product name : '.$_POST['ven_pro_title'].'</td>
									</tr>'.
									'<tr>'.
										'<td>&nbsp;</td>'.
									'</tr>'.
									'<tr style="width:100%;">'.
										'<td style="width:100%;">ID : '.$post_id.'</td>
									</tr>'.
									'<tr>'.
										'<td>&nbsp;</td>'.
									'</tr>'.
									'<tr style="width:100%;">'.
										'<td style="width:100%;">Please approve this product for publish</td>'.
									'</tr>'.
									'<tr>'.
										'<td>&nbsp;</td>'.
									'</tr>'.
									'<tr style="width:100%;">'.
										'<td style="width:100%;">Thank you</td>'.
									'</tr>'.
									'<tr>'.
										'<td>&nbsp;</td>'.
									'</tr>'.
									'<tr style="width:100%;">'.
										'<td style="width:100%; background:#69F; color:#FFF;" height="50px;">&emsp;</td>'.
									'</tr>'.
								'</table>'.
							'</td>'.
						'</tr>'.
					  '</table>'.
					'</body>'.
					'</html>';
		
		//get_post_meta(get_current_user_id(),'_vendor_email',true);
		$headers = 'From: '.$current_user->user_login.' '.get_post_meta($current_user->ID,'_vendor_email',true);
		//die($to.'<br><br>'.$subject.'<br><br>'.$message);
		wp_mail( $to, $subject, $message, $headers);
	//------------------------------------------------------------------------------------- 

     // file paths will be stored in an array keyed off md5(file path)
    /*$downdloadArray =array('name'=>"Test", 'file' => $uploadDIR['baseurl']."/video/".$video);

    $file_path =md5($uploadDIR['baseurl']."/video/".$video);


    $_file_paths[  $file_path  ] = $downdloadArray;
    // grant permission to any newly added files on any existing orders for this product
    //do_action( 'woocommerce_process_product_file_download_paths', $post_id, 0, $downdloadArray );
    update_post_meta( $post_id, '_downloadable_files ', $_file_paths);
    update_post_meta( $post_id, '_download_limit', '');
    update_post_meta( $post_id, '_download_expiry', '');
    update_post_meta( $post_id, '_download_type', '');
    update_post_meta( $post_id, '_product_image_gallery', '');*/
	}
	else{
		//$image_path = wp_upload_dir();
		//die($image_path['path']);
	?>
    <form name="van_pro_upload_frm" id="van_pro_upload_frm" action="" method="post" enctype="multipart/form-data">
	<div class="wrap">
    	<table class="form-table">
        <tbody>
        <tr>
            <th scope="row"><label>Title</label></th>
            <td><input type="text" name="ven_pro_title" id="ven_pro_title" placeholder="Product Title Here" /></td>
        </tr>
        <tr>
            <th scope="row"><label>Product Content</label></th>
            <td><textarea name="van_pro_cont" id="van_pro_cont" placeholder="Product Content Here"></textarea></td>
        </tr>
        <tr>
            <th scope="row"><label>Product Data</label></th>
            <td>
            	<select name="van_pro_type" id="van_pro_type">
                  <option selected="selected" value="simple">Simple product</option>
                  <option value="grouped">Grouped product</option>
                  <option value="external">External/Affiliate product</option>
                  <option value="variable">Variable product</option>
                </select>
                &nbsp;<label>Virtual: <input type="checkbox" id="van_pro_virtual" name="van_pro_virtual" value="yes"></label>&nbsp;<label>Downloadable: <input type="checkbox" id="van_pro_downloadable" name="van_pro_downloadable" value="yes"></label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label>SKU</label></th>
            <td><input type="text" name="ven_pro_sku" id="ven_pro_sku" /></td>
        </tr>
        <tr>
            <th scope="row"><label>Regular Price (£)</label></th>
            <td><input type="text" id="ven_pro_regular_price" name="ven_pro_regular_price"></td>
        </tr>
        <tr>
            <th scope="row"><label>Sale Price (£)</label></th>
            <td><input type="text" id="ven_pro_sale_price" name="ven_pro_sale_price"></td>
        </tr>
        <tr>
            <th scope="row"><label>Manage stock?</label></th>
            <td><input type="checkbox" id="ven_pro_manage_stock" name="ven_pro_manage_stock" class="checkbox" value="yes"></td>
        </tr>
        <tr>
            <th scope="row"><label>Stock Qty</label></th>
            <td><input type="number" step="any" value="0" id="ven_pro_stock" name="ven_pro_stock" ></td>
        </tr>
        <tr>
            <th scope="row"><label>Allow Backorders?</label></th>
            <td>
            <select class="select short" name="ven_pro_backorders" id="ven_pro_backorders">
                <option value="no">Do not allow</option>
                <option value="notify">Allow, but notify customer</option>
                <option value="yes">Allow</option>
            </select>
          </td>
        </tr>
        <tr>
            <th scope="row"><label>Stock status</label></th>
            <td>
            <select class="select short" name="ven_pro_stock_status" id="ven_pro_stock_status">
                <option value="instock">In stock</option>
                <option value="outofstock">Out of stock</option>
            </select>
            </td>
        </tr>
        <tr>
            <th scope="row"><label>Weight (kg)</label></th>
            <td><input type="text" id="ven_pro_weight" name="ven_pro_weight"></td>
        </tr>
        <tr>
            <th scope="row"><label>Dimensions (cm)</label></th>
            <td>
            <span class="wrap">
                <input type="text" name="ven_pro_length" id="ven_pro_length" size="6" placeholder="Length">
                <input type="text" name="ven_pro_width" id="ven_pro_width" size="6" placeholder="Width">
                <input type="text" name="ven_pro_height" id="ven_pro_height" size="6" placeholder="Height">
            </span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label>Purchase Note</label></th>
            <td><textarea cols="20" rows="2" id="ven_pro_purchase_note" name="ven_pro_purchase_note"></textarea></td>
        </tr>
        <?php
        $selected_vendor = get_post_meta(get_the_ID(), '_vendor_select',true);
		$selected_vendor_percentage = get_post_meta(get_the_ID(), '_vendor_percentage',true);
		$selected_vendor_note = get_post_meta(get_the_ID(), '_vendor_note',true);
		wp_reset_query();
		$args = array(
				'post_type'   => 'vendor_product',
				'post_status' => 'publish',
				'posts_per_page'=> -1
				);
		$select_ven='';
		$posts = new WP_Query( $args );
		$posts = $posts->posts;
		if(!empty($posts)){
			$option_arr = array();
			foreach($posts as $pst){
				$vendor_list = get_post_meta($pst->ID, '_vendor_company',true);
				if($vendor_list!=''){
					$select_ven.='<option value="'.$pst->ID.'">'.$vendor_list.'</option>';
					//$option_arr[$pst->ID]=__( $vendor_list, 'woocommerce' );
				}
				else{
					$select_ven.='<option value="'.$pst->ID.'">'.$pst->post_title.'</option>';
					//$option_arr[$pst->ID]=__( $pst->post_title, 'woocommerce' );
				}
			}
		}
		?>
        <tr>
            <th scope="row"><label>Select Vendor</label></th>
            <td>
            <select name="ven_pro_vendor_select" id="ven_pro_vendor_select">
            	<?php echo $select_ven;?>
            </select>
            </td>
        </tr>        
       <!-- ---------
        <tr>
            <th scope="row"><label>Site Title</label></th>
            <td><input type="text" class="regular-text" value="Vendor" id="blogname" name="blogname"></td>
        </tr>
        ----------->
        <script type="text/javascript">
          //admin image upload
		  jQuery(document).ready(function() {
			var custom_uploader;
			jQuery('#ven_pro_upload').click(function() 
			{
			  custom_uploader = wp.media.frames.file_frame = wp.media({
				  title: 'Choose Image',
				  button: {
					  text: 'Add Image'
				  },
				  multiple: false
			  });
			  custom_uploader.on('select', function() {
				  attachment = custom_uploader.state().get('selection').first().toJSON();
				  if(attachment.url)
				  {
					jQuery('#ven_pro_vendor_image').val(attachment.url);
				  }
			  });
			  custom_uploader.open();
			});
		  });
        </script>
        <tr>
            <th scope="row"><label>Vendor Percentage</label></th>
            <td><input type="text" placeholder="Enter Percentage here" value="" id="ven_pro_vendor_percentage" name="ven_pro_vendor_percentage"></td>
        </tr>
        <tr>
            <th scope="row"><label>Vendor Note</label></th>
            <td><textarea cols="20" rows="2" id="ven_pro_vendor_note" name="ven_pro_vendor_note"></textarea></td>
        </tr>
        <!--<tr>
            <th scope="row"><label>Feature Product</label></th>
            <td><input type="text" id="ven_pro_vendor_image" name="ven_pro_vendor_image">&nbsp;<input type="button" name="ven_pro_upload" id="ven_pro_upload" value="Upload" /></td>
        </tr>-->
        <tr>
            <th scope="row"><label>Feature Product</label></th>
            <td><input type="file" name="img_file" id="img_file" /></td>
        </tr>
        <tr>
        	<td colspan="2" style="text-align:center"><input type="submit" name="ven_pro_submit" id="van_pro_submit" value="Insert" /></td>
        </tr>
        </tbody>
        </table>
    </div>
    </form>
	<?php
	}
	/*$selected_vendor = get_post_meta(get_the_ID(), '_vendor_select',true);
	$selected_vendor_percentage = get_post_meta(get_the_ID(), '_vendor_percentage',true);
	$selected_vendor_note = get_post_meta(get_the_ID(), '_vendor_note',true);
	wp_reset_query();
	$args = array(
			'post_type'   => 'vendor_product',
			'post_status' => 'publish',
			'posts_per_page'=> -1
			);
	$select_ven='';
	$posts = new WP_Query( $args );
	$posts = $posts->posts;
	if(!empty($posts)){
		$option_arr = array();
		foreach($posts as $pst){
			$vendor_list = get_post_meta($pst->ID, '_vendor_company',true);
			if($vendor_list!=''){
				$select_ven.='<option value="'.$pst->ID.'">'.$vendor_list.'</option>';
				//$option_arr[$pst->ID]=__( $vendor_list, 'woocommerce' );
			}
			else{
				$select_ven.='<option value="'.$pst->ID.'">'.$pst->post_title.'</option>';
				//$option_arr[$pst->ID]=__( $pst->post_title, 'woocommerce' );
			}
		}
	}*/
	//echo '<pre>';
	//print_r($option_arr);	
	/*echo '<div id="custom_tab_data" class="panel woocommerce_options_panel">';
	woocommerce_wp_select(
	array(
		'id' => '_vendor_select',
		'label' => __( 'Select Vendor','woocommerce-vendor-setup' ),
		'options' => $option_arr,
		'desc_tip' => 'true',
		'description' => __( 'Please Select vendor.','woocommerce-vendor-setup' )
		)
	);	
	
	woocommerce_wp_text_input(
	array(
		'id' => '_vendor_percentage',
		'label' => __( 'Vendor Percentage','woocommerce-vendor-setup' ),
		'placeholder' => __( 'Enter Percentage here','woocommerce-vendor-setup' ),
		'value' => '0',
		'desc_tip' => 'true',
		'description' => __( 'Enter Percentage Amount Here.','woocommerce-vendor-setup' )
		)
	);
	
	woocommerce_wp_textarea_input(
	array(
		'id' => '_vendor_note',
		'label' => __( 'Note','woocommerce-vendor-setup' ),
		'placeholder' => '',
		'value' => '',
		'desc_tip' => 'true',
		'description' => __( 'Enter Note Here If You Have.','woocommerce-vendor-setup' )
		)
	);
	echo '</div>';
    echo "<h2>Hello world .... hi sohel</h2>";*/
	//echo do_shortcode('[wpuf_addpost post_type="product"]');
	/*$post = array(
     'post_author' => get_current_user_id(),
     'post_content' => 'Gold Leaf Content',
     'post_status' => "publish",
     'post_title' => 'Gold Leaf',
     'post_parent' => '9',
     'post_type' => "product",

     );
      //Create post
     $post_id = wp_insert_post( $post, $wp_error );
     if($post_id){
     $attach_id = get_post_meta($product->parent_id, "_thumbnail_id", true);
     add_post_meta($post_id, '_thumbnail_id', $attach_id);
    }
    wp_set_object_terms( $post_id, 'Computer', 'product_cat' );
     wp_set_object_terms($post_id, 'simple', 'product_type');



     update_post_meta( $post_id, '_visibility', 'visible' );
     update_post_meta( $post_id, '_stock_status', 'instock');
     update_post_meta( $post_id, 'total_sales', '0');
     update_post_meta( $post_id, '_downloadable', 'yes');
     update_post_meta( $post_id, '_virtual', 'yes');
     update_post_meta( $post_id, '_regular_price', "180" );
     update_post_meta( $post_id, '_sale_price', "100" );
     update_post_meta( $post_id, '_purchase_note', "Its a limited Offer" );
     update_post_meta( $post_id, '_featured', "no" );
     update_post_meta( $post_id, '_weight', "" );
     update_post_meta( $post_id, '_length', "" );
     update_post_meta( $post_id, '_width', "" );
     update_post_meta( $post_id, '_height', "" );
     update_post_meta($post_id, '_sku', "gld_lf");
     update_post_meta( $post_id, '_product_attributes', array());
     update_post_meta( $post_id, '_sale_price_dates_from', "" );
     update_post_meta( $post_id, '_sale_price_dates_to', "" );
     update_post_meta( $post_id, '_price', "100" );
     update_post_meta( $post_id, '_sold_individually', "" );
     update_post_meta( $post_id, '_manage_stock', "yes" );
     update_post_meta( $post_id, '_backorders', "no" );
     update_post_meta( $post_id, '_stock', "50" );*/
	 
	 

     // file paths will be stored in an array keyed off md5(file path)
    /*$downdloadArray =array('name'=>"Test", 'file' => $uploadDIR['baseurl']."/video/".$video);

    $file_path =md5($uploadDIR['baseurl']."/video/".$video);


    $_file_paths[  $file_path  ] = $downdloadArray;
    // grant permission to any newly added files on any existing orders for this product
    //do_action( 'woocommerce_process_product_file_download_paths', $post_id, 0, $downdloadArray );
    update_post_meta( $post_id, '_downloadable_files ', $_file_paths);
    update_post_meta( $post_id, '_download_limit', '');
    update_post_meta( $post_id, '_download_expiry', '');
    update_post_meta( $post_id, '_download_type', '');
    update_post_meta( $post_id, '_product_image_gallery', '');*/
}
/*function vendor_user_create_product(){
	//add_meta_box('Meta Box',''.__('Vendor Admin','woocommerce-vendor-setup').'', 'vendor_meta_box_content', 'vendor_product', 'normal', 'high' );
	//add_dashboard_page( 'Vendor Product', 'Vendor Product', 'normal', 'vendor_admin_meu', 'vendor_meta_box_content'); add_menu_page('Test Menu', 'Test Menu',
        // add_menu_page('Test Menu', 'Test Menu', null, 'test', 'test_user_admin_page');
		
		add_menu_page('Test Menu', 'Test Menu', 'exist', 'test', 'test_user_admin_page');
}*/

function vendor_users_submenu() {
	add_users_page('Page Title', 'Upload Product', 'read', 'vendor_pro_upload', 'vendor_upload_product');
}


function vendor_product_category_init() {
	register_taxonomy(
	  'vendor_category',
	  'vendor_product',
	  array(
	   'label' => __( 'Category','woocommerce-vendor-setup' ),
	   'rewrite' => array( 'slug' => 'vendor_category' ),
	   'hierarchical' => true,
	  )
	 );
}


function vendor_meta_box() {
 
	add_meta_box('Meta Box',''.__('Vendor Options','woocommerce-vendor-setup').'', 'vendor_meta_box_content', 'vendor_product', 'normal', 'high' );

}

function vendor_meta_box_content( $post ) {

	$vendor_name=get_post_meta($post->ID,'_vendor_name',true);
	$vendor_company=get_post_meta($post->ID,'_vendor_company',true);
  	$vendor_email=get_post_meta($post->ID,'_vendor_email',true);
  	$vendor_phone=get_post_meta($post->ID,'_vendor_phone',true);
	$vendor_fax=get_post_meta($post->ID,'_vendor_fax',true);
	
	$vendor_address=get_post_meta($post->ID,'_vendor_address',true);
	$vendor_zip=get_post_meta($post->ID,'_vendor_zip',true);
  	$vendor_state=get_post_meta($post->ID,'_vendor_state',true);
  	$vendor_country=get_post_meta($post->ID,'_vendor_country',true);
	$vendor_paypal=get_post_meta($post->ID,'_vendor_paypal',true);
	$vendor_publish_pro=get_post_meta($post->ID,'_vendor_publish_pro',true);
	?>
    <script type="text/javascript">
    	function check_email(obj){
			if(email_validate(obj.value)){
			
			}
			else{
				jQuery('#vendor_email_fld').html('<font style="color:#F00;">&emsp;** Please enter valid emeil address</font>');
			}
		}
		function email_validate(address) {
            var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
            //var address = document.forms[form_id].elements[email].value;
            if (reg.test(address) == false) {
                //alert('Invalid Email Address');
                return false;
            }
            else {
                return true;
            }
        }
		function check_field(fld_name){
			//alert(fld_name);
			if(jQuery('#'+fld_name).val().length==0){
				jQuery('#'+fld_name+'_fld').html('<font style="color:#F00;">&emsp;** Please enter value</font>');
			}
		}
    </script>
  <table class="form-table">
    <tr>
      <th scope="row"><?php _e("Vendor Name","woocommerce-vendor-setup"); ?></th>
      <td><input type="text" name="_vendor_name" id="vendor_name" value="<?php if(isset($vendor_name)) printf(__("%s","woocommerce-vendor-setup"), $vendor_name);?>" onchange="check_field('vendor_name');" /><label id="vendor_name_fld"></label></td>
    </tr>
    <tr>
      <th scope="row"><?php _e("Company Name","woocommerce-vendor-setup"); ?></th>
      <td><input type="text" name="_vendor_company" id="vendor_company" value="<?php if(isset($vendor_company)) printf(__("%s","woocommerce-vendor-setup"), $vendor_company);?>" onchange="check_field('vendor_company');" /><label id="vendor_company_fld"></label></td>
    </tr>
    <tr>
      <th scope="row"><?php _e("Email","woocommerce-vendor-setup"); ?></th>
      <td><input type="text" name="_vendor_email" id="vendor_email" value="<?php if(isset($vendor_email)) printf(__("%s","woocommerce-vendor-setup"), $vendor_email);?>" onchange="check_email(this);" /><label id="vendor_email_fld"></label></td>
    </tr>
    <tr>
      <th scope="row"><?php _e("Phone","woocommerce-vendor-setup"); ?></th>
      <td><input type="text" name="_vendor_phone" id="vendor_phone" value="<?php if(isset($vendor_phone)) printf(__("%s","woocommerce-vendor-setup"), $vendor_phone);?>" onchange="check_field('vendor_phone');" /><label id="vendor_phone_fld"></label></td>
    </tr>
    <tr>
      <th scope="row"><?php _e("Fax","woocommerce-vendor-setup"); ?></th>
      <td><input type="text" name="_vendor_fax" id="vendor_fax" value="<?php if(isset($vendor_fax)) printf(__("%s","woocommerce-vendor-setup"), $vendor_fax);?>" /></td>
    </tr>
    <tr>
      <th scope="row"><?php _e("Address","woocommerce-vendor-setup"); ?></th>
      <td><input type="text" name="_vendor_address" id="vendor_address" value="<?php if(isset($vendor_address)) printf(__("%s","woocommerce-vendor-setup"), $vendor_address);?>" onchange="check_field('vendor_address');"  /><label id="vendor_address_fld"></label></td>
    </tr>
    <tr>
      <th scope="row"><?php _e("Zip Code","woocommerce-vendor-setup"); ?></th>
      <td><input type="text" name="_vendor_zip" id="vendor_zip" value="<?php if(isset($vendor_zip)) printf(__("%s","woocommerce-vendor-setup"), $vendor_zip);?>" onchange="check_field('vendor_zip');"  /><label id="vendor_zip_fld"></label></td>
    </tr>
    <tr>
      <th scope="row"><?php _e("State","woocommerce-vendor-setup"); ?></th>
      <td><input type="text" name="_vendor_state" id="vendor_state" value="<?php if(isset($vendor_state)) printf(__("%s","woocommerce-vendor-setup"), $vendor_state);?>" onchange="check_field('vendor_state');"  /><label id="vendor_state_fld"></label></td>
    </tr>
    <tr>
      <th scope="row"><?php _e("Country","woocommerce-vendor-setup"); ?></th>
      <td><input type="text" name="_vendor_country" id="vendor_country" value="<?php if(isset($vendor_country)) printf(__("%s","woocommerce-vendor-setup"), $vendor_country);?>" onchange="check_field('vendor_country');"  /><label id="vendor_country_fld"></label></td>
    </tr>
    <tr>
      <th scope="row"><?php _e("Paypal Address","woocommerce-vendor-setup"); ?></th>
      <td><input type="text" name="_vendor_paypal" id="vendor_paypal" value="<?php if(isset($vendor_paypal)) printf(__("%s","woocommerce-vendor-setup"), $vendor_paypal);?>" onchange="check_field('vendor_paypal');"  /><label id="vendor_paypal_fld"></label></td>
    </tr>
    <tr>
      <th scope="row">Can Publish Product</th>
      <td>
      <select name="_vendor_publish_pro" id="vendor_publish_pro">
      	<option value="pending" <?php if($vendor_publish_pro=='pending')echo 'selected="selected"';?>>Pending</option>
        <option value="publish" <?php if($vendor_publish_pro=='publish')echo 'selected="selected"';?>>Publish</option>
      </select>
      </td>
    </tr>
  </table>
 
  <div style="clear:both;"></div>
    
	<?php
}

function save_vendor_info_content($post_id) {
	
	if(isset($_POST["_vendor_email"])){
	$user_email = explode("@", $_POST["_vendor_email"]);
	$user_name = $user_email[0];
	$user_id = username_exists( $user_name );
	if ( !$user_id && email_exists($_POST["_vendor_email"]) == false ) {
		//echo 'aaaaaa';
		$random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );
		$user_id = wp_create_user( $user_name, $random_password, $_POST["_vendor_email"] );
		
		//print_r($user_id);
		//die();
		wp_new_user_notification( $user_id, $random_password );
		if($user_id!=''){
		  update_post_meta($post_id,  '_vendor_name',  	$_POST['_vendor_name'] );
		  update_post_meta($post_id,  '_vendor_company',  $_POST["_vendor_company"]);
		  update_post_meta($post_id,  '_vendor_email',   	$_POST["_vendor_email"]);
		  update_post_meta($post_id,  '_vendor_phone',   	$_POST["_vendor_phone"]);
		  update_post_meta($post_id,  '_vendor_fax',   	$_POST["_vendor_fax"]);
		  
		  update_post_meta($post_id,  '_vendor_address',  $_POST['_vendor_address'] );
		  update_post_meta($post_id,  '_vendor_zip',   	$_POST["_vendor_zip"]);
		  update_post_meta($post_id,  '_vendor_state',   	$_POST["_vendor_state"]);
		  update_post_meta($post_id,  '_vendor_country',  $_POST["_vendor_country"]);
		  update_post_meta($post_id,  '_vendor_paypal',   $_POST["_vendor_paypal"]);
		  update_post_meta($post_id,  '_vendor_publish_pro',   $_POST["_vendor_publish_pro"]);
		  update_post_meta($post_id,  '_vendor_user_id',  $user_id);
		  update_option( $user_name, $post_id );
		}
	}
	else{
		//die('bbbbbbb');
		//global $user_ID;
		$user_ID = get_current_user_id();
		$user_email = explode("@", $_POST["_vendor_email"]);
		$user_name = $user_email[0];
		update_post_meta($post_id,  '_vendor_name',  		$_POST['_vendor_name'] );
		update_post_meta($post_id,  '_vendor_company',  	$_POST["_vendor_company"]);
		update_post_meta($post_id,  '_vendor_email',   		$_POST["_vendor_email"]);
		update_post_meta($post_id,  '_vendor_phone',   		$_POST["_vendor_phone"]);
		update_post_meta($post_id,  '_vendor_fax',   		$_POST["_vendor_fax"]);
		
		update_post_meta($post_id,  '_vendor_address',  	$_POST['_vendor_address'] );
		update_post_meta($post_id,  '_vendor_zip',   		$_POST["_vendor_zip"]);
		update_post_meta($post_id,  '_vendor_state',   		$_POST["_vendor_state"]);
		update_post_meta($post_id,  '_vendor_country',  	$_POST["_vendor_country"]);
		update_post_meta($post_id,  '_vendor_paypal',   	$_POST["_vendor_paypal"]);
		update_post_meta($post_id,  '_vendor_publish_pro',  $_POST["_vendor_publish_pro"]);
		//update_post_meta($post_id,  '_vendor_user_id',  $user_ID);
		update_option( $user_name, $post_id );
		
	}
	}
}

add_filter( 'manage_edit-vendor_product_columns', 'edit_vendor_product_columns' ) ;

function edit_vendor_product_columns( $columns ) {
  $columns = array(
		'cb'            => '<input type="checkbox" />',
    	'title'         => __( 'Name','woocommerce-vendor-setup' ),
		'company'         => __( 'Company','woocommerce-vendor-setup' ),
		'email'           => __( 'Email','woocommerce-vendor-setup' ),
		'paypal'         => __( 'Paypal','woocommerce-vendor-setup' ),
		'date'          => __( 'Date','woocommerce-vendor-setup' )
	);
	return $columns;
}

add_action( 'manage_vendor_product_posts_custom_column', 'manage_vendor_product_columns', 10, 2 );

function manage_vendor_product_columns($column, $post_id){
  global $post;

	switch( $column ) {
		case 'company' :
      		$vendor_company = get_post_meta( $post_id, '_vendor_company', true );
			echo "<a href='admin.php?page=vendor_details&vendor_id=$post_id'>$vendor_company</a>";
			break;
			
    	case 'email' :
      		$vendor_email = get_post_meta( $post_id, '_vendor_email', true );
      		echo $vendor_email;
      		break;
			
    	case 'paypal' :
      		$vendor_paypal = get_post_meta( $post_id, '_vendor_paypal', true );
      		echo $vendor_paypal;
      		break;
		default :
			break;
	}
}

add_action( 'woocommerce_thankyou', 'woo_vendor_order_data' );

function woo_vendor_order_data( $order_id ) {
	global $wpdb;
	//require_once WP_CUSTOM_PRODUCT_PATH.'PHPMailer-master/class.phpmailer.php';
	$item_arr = array();
	$i=0;
	$vendor_table_prefix = 'woocommerce_';
	$order = new WC_Order( $order_id );
	$items = $order->get_items();
	foreach ( $items as $item ) {
		$item_arr[$i]['name'] = $item['name'];
		$item_arr[$i]['product_id'] = $item['product_id'];
		
		$item_arr[$i]['vendor_id'] = get_post_meta($item['product_id'], '_vendor_select',true);
		$item_arr[$i]['vendor_percentage'] = get_post_meta($item['product_id'], '_vendor_percentage',true);
		$item_arr[$i]['product_qty'] = $item['qty'];
		$item_arr[$i]['product_subtotal'] = $item['line_subtotal'];
		$wpdb->insert($wpdb->prefix.$vendor_table_prefix.'vendor',
          array(
              'vendor_id'					=> '',
			  'vendor_vendor_id'			=> $item_arr[$i]['vendor_id'],
              'vendor_product_id'      		=> $item_arr[$i]['product_id'],
              'vendor_product_name'     	=> $item_arr[$i]['name'],
              'vendor_product_qty'  		=> $item_arr[$i]['product_qty'],
              'vendor_product_unit_price'  	=> ($item_arr[$i]['product_subtotal']/$item_arr[$i]['product_qty']),
              'vendor_product_amount'      	=> $item_arr[$i]['product_subtotal'],
              'vendor_percent'     			=> $item_arr[$i]['vendor_percentage'],
              'vendor_amount'       		=> (($item_arr[$i]['vendor_percentage']*$item_arr[$i]['product_subtotal'])/100),
              'vendor_order_id'   			=> $order->id,
              'vendor_order_date'     		=> date("Y-m-d"),
              'vendor_send_money_status'    => 'Pending',
              'vendor_send_money_date'    	=> '',
			  'vendor_product_delivared'    => 'Pending'
          )
        );
		$to = get_post_meta($item_arr[$i]['vendor_id'],'_vendor_email',true);
		//echo $to;
		//die();
		//$to = 'arif@gmail.com';
		//$subject = 'A order has been reseived, Order ID is '.$order_id;
		$subject = ''.__('A order has been reseived, Order ID is ','woocommerce-vendor-setup').''.$order_id;
		//$message = 'A order has been received.<br><b>Order Details:</b></br><br><b>Product Name:</b>'.$item_arr[$i]['name'].'</br><br><b>Product Quantity:</b>'.$item_arr[$i]['product_qty'].'</br><br><b>Product Price:</b>'.$item_arr[$i]['product_subtotal'].'</br><br><b>Your Percentage:</b>'.$item_arr[$i]['vendor_percentage'].'</br><br><b>Your Ammount:</b>'.(($item_arr[$i]['vendor_percentage']*$item_arr[$i]['product_subtotal'])/100).'</br><br><br>Please contact with stote owner for your payment.</br><br><br>Thankyou';
		
		$message = '<!DOCTYPE HTML>'.
					'<head>'.
					'<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'.
					'<title>'.__('Email notification ','woocommerce-vendor-setup').'</title>'.
					'</head>'.
					
					'<body>'.
					  '<table style="width:100%;">'.
						'<tr>'.
							'<td align="center">'.
								'<table style="width:60%; border:solid 1px #69F;">'.
									'<tr style="width:100%;">'.
										'<td style="width:100%; background:#69F; font-size:46px; color:#FFF; font-weight:bold;" height="100px;">&nbsp;'.__('New customer order','woocommerce-vendor-setup').'</td>'.
									'</tr>'.
									'<tr style="width:100%;">'.
										'<td style="width:100%;">'.__('You have received an order. Their order is as follows:','woocommerce-vendor-setup').'</td>'.
									'</tr>'.
									'<tr>'.
										'<td>&nbsp;</td>'.
									'</tr>'.
									'<tr style="width:100%;">'.
										'<td style="width:100%; font-size:30px; color:#000; font-weight:bold;">'.__('Order','woocommerce-vendor-setup').': #'.$order_id.' ('.date("F j, Y, g:i a").')</td>
									</tr>'.
									'<tr>'.
										'<td>&nbsp;</td>'.
									'</tr>'.
									'<tr style="width:100%;">'.
										'<td style="width:100%;">'.
											'<table style="width:100%;">'.
												'<tr>'.
													'<td style="font-weight:bold; color:#000;">'.__('Product Name','woocommerce-vendor-setup').'</td>'.
													'<td>:</td>'.
													'<td>'.$item_arr[$i]['name'].'</td>'.
												'</tr>'.
												'<tr>'.
													'<td style="font-weight:bold; color:#000;">'.__('Product Quantity','woocommerce-vendor-setup').'</td>'.
													'<td>:</td>'.
													'<td>'.$item_arr[$i]['product_qty'].'</td>'.
												'</tr>'.
												'<tr>'.
													'<td style="font-weight:bold; color:#000;">'.__('Product Price','woocommerce-vendor-setup').'</td>'.
													'<td>:</td>'.
													'<td>'.$item_arr[$i]['product_subtotal'].'</td>'.
												'</tr>'.
												'<tr>'.
													'<td style="font-weight:bold; color:#000;">'.__('Your Percentage','woocommerce-vendor-setup').'</td>'.
													'<td>:</td>'.
													'<td>'.$item_arr[$i]['vendor_percentage'].'%</td>'.
												'</tr>'.
												'<tr>'.
													'<td style="font-weight:bold; color:#000;">'.__('Your Ammount','woocommerce-vendor-setup').'</td>'.
													'<td>:</td>'.
													'<td>'.(($item_arr[$i]['vendor_percentage']*$item_arr[$i]['product_subtotal'])/100).'</td>'.
												'</tr>'.
											'</table>'.
										'</td>'.
									'</tr>'.
									'<tr>'.
										'<td>&nbsp;</td>'.
									'</tr>'.
									'<tr style="width:100%;">'.
										'<td style="width:100%;">'.__('Please contact with stote owner for your payment.','woocommerce-vendor-setup').'<br /><br />'.__('Thank you','woocommerce-vendor-setup').'</td>'.
									'</tr>'.
									'<tr>'.
										'<td>&nbsp;</td>'.
									'</tr>'.
									'<tr style="width:100%;">'.
										'<td style="width:100%; background:#69F; color:#FFF;" height="50px;">&emsp;</td>'.
									'</tr>'.
								'</table>'.
							'</td>'.
						'</tr>'.
					  '</table>'.
					'</body>'.
					'</html>';
		
		
		$headers = 'From: Your Name <your@email.com>' . "\r\n";
		//die($to.'<br><br>'.$subject.'<br><br>'.$message);
		wp_mail( $to, $subject, $message, $headers);
		//sleep(10);
		//send_mail('admin@admin.com', $to, $message, $subject);
		
		$i++;
		
	}
	//wp_mail( 'sagarseth9@example.com',' Woocommmerce Order ID is '.$order_id , 'Woocommerce order' );

}
function send_mail($from_mail, $to_mail, $message, $subject){
      $mail             = new PHPMailer();
      $body             = eregi_replace("[\]",'',$message);
      $mail->AddReplyTo($from_mail);
      $mail->SetFrom($from_mail);
      $mail->AddReplyTo($from_mail);
      $mail->AddAddress($to_mail);
      $mail->Subject    = $subject;
      $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
      $mail->MsgHTML($body);

      if(!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
      } else {
        echo "Message sent!";
      }
}

/*function set_html_content_type() {
return 'text/html';
}*/

//add_filter( 'wp_mail_content_type', 'set_html_content_type' );
add_action( 'init', 'vendor_product_post_type' );
add_action( 'init', 'vendor_product_category_init' );
add_action('admin_menu', 'vendor_users_submenu');
//add_action('user_admin_menu', 'vendor_user_create_product_for_user');//admin_menu
//add_action('admin_metabox', 'vendor_user_create_product');
//add_action('user_admin_metabox', 'vendor_user_create_product');

add_action( 'add_meta_boxes', 'vendor_meta_box' );
add_action( 'save_post','save_vendor_info_content', 10, 2 );