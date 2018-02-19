<?php
// Display Fields
add_action( 'woocommerce_product_write_panels', 'woo_add_custom_general_fields' ); 
// Save Fields
add_action( 'save_post', 'woo_add_custom_general_fields_save' );

add_action( 'woocommerce_product_write_panel_tabs', 'woo_add_custom_admin_product_tab' );
 
function woo_add_custom_admin_product_tab() {
?>
<li class="custom_tab"><a href="#custom_tab_data"><?php _e('Vendor Setup', 'woocommerce'); ?></a></li>
<?php
}

function woo_add_custom_general_fields() {
	global $woocommerce, $post;
	$selected_vendor = get_post_meta(get_the_ID(), '_vendor_select',true);
	$selected_vendor_percentage = get_post_meta(get_the_ID(), '_vendor_percentage',true);
	$selected_vendor_note = get_post_meta(get_the_ID(), '_vendor_note',true);
	wp_reset_query();
	$args = array(
			'post_type'   => 'vendor_product',
			'post_status' => 'publish',
			'posts_per_page'=> -1
			);
	$posts = new WP_Query( $args );
	$posts = $posts->posts;
	if(!empty($posts)){
		$option_arr = array();
		foreach($posts as $pst){
			$vendor_list = get_post_meta($pst->ID, '_vendor_company',true);
			if($vendor_list!=''){
				$option_arr[$pst->ID]=__( $vendor_list, 'woocommerce' );
			}
			else{
				$option_arr[$pst->ID]=__( $pst->post_title, 'woocommerce' );
			}
		}
	}
	
	echo '<div id="custom_tab_data" class="panel woocommerce_options_panel">';
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
		'value' => $selected_vendor_percentage,
		'desc_tip' => 'true',
		'description' => __( 'Enter Percentage Amount Here.','woocommerce-vendor-setup' )
		)
	);
	
	woocommerce_wp_textarea_input(
	array(
		'id' => '_vendor_note',
		'label' => __( 'Note','woocommerce-vendor-setup' ),
		'placeholder' => '',
		'value' => $selected_vendor_note,
		'desc_tip' => 'true',
		'description' => __( 'Enter Note Here If You Have.','woocommerce-vendor-setup' )
		)
	);
	
	/*woocommerce_wp_checkbox(
	array(
		'id' => '_checkbox',
		'wrapper_class' => 'show_if_simple',
		'label' => __('My Checkbox Field', 'woocommerce' ),
		'description' => __( 'Check me!', 'woocommerce' )
		)
	);
	woocommerce_wp_hidden_input(
	array(
		'id' => '_hidden_field',
		'value' => 'hidden_value'
		)
	);*/
		
	echo '</div>';
}

function woo_add_custom_general_fields_save( $post_id ){
	// Select Vendor
	if(isset($_POST['_vendor_select'])){
	  $vendor_select = $_POST['_vendor_select'];
	  if( !empty( $vendor_select ) )
	  update_post_meta( $post_id, '_vendor_select', esc_attr( $vendor_select ) );
	}
	// Vendor Percentage
	if(isset($_POST['_vendor_percentage'])){
	  $vendor_percentage = $_POST['_vendor_percentage'];
	  if( !empty( $vendor_percentage ) )
	  update_post_meta( $post_id, '_vendor_percentage', esc_attr( $vendor_percentage ) );
	}
	// Vendor Note
	if(isset($_POST['_vendor_note'])){
	  $vendor_note = $_POST['_vendor_note'];
	  if( !empty( $vendor_note ) )
	  update_post_meta( $post_id, '_vendor_note', esc_html( $vendor_note ) );
	}
		
}



?>