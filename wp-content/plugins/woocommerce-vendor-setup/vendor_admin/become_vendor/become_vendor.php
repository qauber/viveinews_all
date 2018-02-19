<?php

function approve_vendor_by_admin(){

	global $wpdb;
	global $current_user;
	$wpdb_all_prefix = $wpdb->prefix;
	if((!isset($_GET['approve_by']))){
		$_GET['approve_by']='Sorry No User For Approve';
	}
	$pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
	$limit =5;
	$offset = ( $pagenum - 1 ) * $limit;
	//-------------------------------------
	if((isset($_GET['approve_by']))&&($_GET['approve_by']=='admin')){
				$vendor_records = $wpdb->get_results("SELECT * FROM {$wpdb_all_prefix}usermeta where meta_key = 'become_a_vendor' and meta_value = 'vendor' ORDER BY umeta_id DESC" );
				if(!empty($vendor_records)){				
					foreach( $vendor_records as $ven_record ) {
					  $user_status = get_user_meta( $ven_record->user_id, 'become_a_vendor_status', true );
					  if($user_status=='Pending'){
				
						$user_name = get_user_meta( $ven_record->user_id, 'nickname', true );
						$user_id = $ven_record->umeta_id;
						$user_status = $user_status;
						$user_info = get_userdata($ven_record->user_id);
						$user_email = $user_info->user_email;
						$user_reg_date =  $user_info->user_registered;
						$page_check = get_page_by_title($user_name);
						$new_page = array(
								'post_type' => 'vendor_product',
								'post_title' => $user_name,
								'post_content' => '',
								'post_status' => 'publish',
								'comment_status' => 'closed',          
								'post_author' => $current_user->ID
						);
						if(!isset($page_check->ID)){
						  $new_page_id = wp_insert_post($new_page);
						  update_option( $user_name, $new_page_id );
						}
						
						update_post_meta($new_page_id,  '_vendor_name',  	$user_name );
						update_post_meta($new_page_id,  '_vendor_company',  '');
						update_post_meta($new_page_id,  '_vendor_email',   	$user_email);
						update_post_meta($new_page_id,  '_vendor_phone',   	'');
						update_post_meta($new_page_id,  '_vendor_fax',   	'');
						
						update_post_meta($new_page_id,  '_vendor_address',  '' );
						update_post_meta($new_page_id,  '_vendor_zip',   	'');
						update_post_meta($new_page_id,  '_vendor_state',   	'');
						update_post_meta($new_page_id,  '_vendor_country',  '');
						update_post_meta($new_page_id,  '_vendor_paypal',   '');
						update_post_meta($new_page_id,  '_vendor_user_id',  $user_id);
						update_user_meta($ven_record->user_id, 'become_a_vendor_status', 'Approved');
						update_user_meta($ven_record->user_id, 'become_a_vendor', 'vendor_approved');
					  }
				}
				wp_redirect( admin_url( '/edit.php?post_type=vendor_product&page=vendor_approve&approve_by=Approve%20Successfully') );
				}
				else{
					wp_redirect( admin_url( '/edit.php?post_type=vendor_product&page=vendor_approve&approve_by=Approve%20Failed') );
					echo 'Sorry No New User For Approval';
				}
			}
			else{
	//------------------------------------- 
	//echo "SELECT * FROM {$wpdb_all_prefix}usermeta where where meta_key = 'become_a_vendor' and meta_value = 'vendor' ORDER BY umeta_id DESC LIMIT $offset, $limit"; 
	//$vendor_records = $wpdb->get_results("SELECT * FROM {$wpdb_all_prefix}usermeta where meta_key = 'become_a_vendor' and meta_value = 'vendor' ORDER BY umeta_id DESC LIMIT $offset, $limit" );
	$vendor_records = $wpdb->get_results("SELECT * FROM {$wpdb_all_prefix}usermeta where meta_key = 'become_a_vendor' and meta_value = 'vendor' ORDER BY umeta_id DESC" );
	//echo '<pre>';
	//print_r($vendor_records);
	?>
	
	<div style="width:100%;">
		<script type="text/javascript">
			jQuery(document).ready(function(){ 
					jQuery("#myTable").tablesorter({widthFixed: false, widgets: ['zebra']}); 
					jQuery("#myTable").tablesorterPager({container: jQuery("#pager")});			
				} 
			);

		</script>
		<h2><?php _e("Approved Vendor","woocommerce-vendor-setup"); ?></font></h2>
        <?php  if(!empty($vendor_records)){?>
		<table style="width:100%;" id="myTable" class="tablesorter">
		  <thead style="background-color:#DBDBDB; cursor:pointer;"> 
			<tr>
			  <th><?php _e("User Name","woocommerce-vendor-setup"); ?></th>
              <th><?php _e("User ID","woocommerce-vendor-setup"); ?></th>
              <th><?php _e("Email","woocommerce-vendor-setup"); ?></th>
			  <th><?php _e("Status","woocommerce-vendor-setup"); ?></th>			  
			  <th><?php _e("Date","woocommerce-vendor-setup"); ?></th>
			</tr>
		  </thead>
		  <tbody>
		  <?php
			  $count = 0;
			  $class = '';
			  foreach( $vendor_records as $ven_record ) {
					  $user_status = get_user_meta( $ven_record->user_id, 'become_a_vendor_status', true );
					  $class = ( $count % 2 == 0 ) ? ' style="background-color:#4CC5E2"' : '';
					  if($user_status=='Pending'){
						  $user_name = get_user_meta( $ven_record->user_id, 'nickname', true );
						  $user_id = $ven_record->umeta_id;
						  $user_status = $user_status;
						  $user_info = get_userdata($ven_record->user_id);
						  $user_email = $user_info->user_email;
						  $user_reg_date =  $user_info->user_registered;
						  ?>
                          <tr<?php //echo $class; ?>>
                            <td><?php echo $user_name;?></td>
                            <td><?php echo $user_id;?></td>
                            <td><?php echo $user_email;?></td>
                            <td><?php echo $user_status;?></td>
                            <td><?php echo $user_reg_date;?></td>
                          </tr>
                          <?php
                            $count++;
					  }
					}
		  ?>
		  </tbody>
		</table>
        <div id="pager" class="pager">
            <form>
                <img src="<?php echo WP_CUSTOM_PRODUCT_URL;?>/vendor_resource/image/pager/first.png" class="first"/>
                <img src="<?php echo WP_CUSTOM_PRODUCT_URL;?>/vendor_resource/image/pager/prev.png" class="prev"/>
                <input type="text" class="pagedisplay"/>
                <img src="<?php echo WP_CUSTOM_PRODUCT_URL;?>/vendor_resource/image/pager/next.png" class="next"/>
                <img src="<?php echo WP_CUSTOM_PRODUCT_URL;?>/vendor_resource/image/pager/last.png" class="last"/>
                <select class="pagesize">
                	<option value="1">1</option>
                	<option value="5">5</option>
                    <option value="10">10</option>
                    <option selected="selected"  value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </form>
        </div>
		<?php
		}
		else{
			?>
			<div style="text-align:center; color:#F00;"><?php echo $_GET['approve_by'];?></div>
			<?php
		}
		if(!empty($vendor_records)){
			echo '<div style="text-align:left;"><a class="button button-primary button-large" href="edit.php?post_type=vendor_product&page=vendor_approve&approve_by=admin">Activate now</a></div>';
		}
	  ?>
      
      </div>
	
	<?php
	//echo '<pre>';
	//print_r($vendor_records);
	}
} 
function vendor_view_new_page_for_frontend(){
	
}

function create_vendor_approve_page(){
	add_submenu_page('edit.php?post_type=vendor_product', 'Vendor Approve', 'Vendor Approve', 'edit_posts', 'vendor_approve', 'approve_vendor_by_admin');
	add_submenu_page('edit.php?post_type=vendor_product', 'Vendor Statistics', 'Statistics', 'edit_posts', 'vendor_statistics', 'vendor_statistics_view_by_admin');
	add_submenu_page('edit.php?post_type=vendor_product', 'Vendor Settings', 'Settings', 'edit_posts', 'vendor_settings', 'vendor_global_settings');
}

function vendor_statistics_view_by_admin(){
	global $woocommerce, $post, $wpdb;
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
	$custom_table_prefix = 'woocommerce_';
	$wpdb_all_prefix = $wpdb->prefix.$custom_table_prefix;
	$all_vendor_record = array();	
	$vendor_all_record = "['Store', 'Sales'],";
  if(!empty($option_arr)){
	foreach($option_arr as $key => $value){
		//echo $key.'--->'.$value;
		$vendor_total_sales = $wpdb->get_row("SELECT count(*) as vencnt FROM {$wpdb_all_prefix}vendor where vendor_vendor_id = ".$key." " );
		
		$vendor_all_record .="['".$value."', ".$vendor_total_sales->vencnt."],"; 
		
	}
	
	$vendor_all_record = rtrim($vendor_all_record,',');
	//print_r($asd);
	?>
	<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {

        /*var data = google.visualization.arrayToDataTable([
          ['Task', 'Sales'],
          ['Addidus',     11],
          ['Banson',      2],
          ['Bay Shoe',  2],
          ['Horse', 2],
          ['Girl T-shirt',    7],
		  ['Iphone4',    7]
        ]);*/
		var data = google.visualization.arrayToDataTable([<?php echo $vendor_all_record;?>]);

        var options = {
          title: 'All Store Sales Performance'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
	<div id="piechart" style="width: 900px; height: 500px;"></div>

	<?php
  }
  else{
    ?>
  <div style="width:100%; text-align: center; color: #F00; font-weight: bold; font-size: 16px; margin-top: 25%;"><?php _e("Sorry No Data Found","woocommerce-vendor-setup"); ?></div>  
    <?php
  }
}

function vendor_global_settings(){
		if(isset($_POST['vendor_paypal_setting'])&&($_POST['vendor_paypal_setting'])){
			update_option('masspay_user_name',$_POST['masspay_user_name']);
			update_option('masspay_api_pass',$_POST['masspay_api_pass']);
			update_option('masspay_api_signature',$_POST['masspay_api_signature']);
			update_option('masspay_api_mode',$_POST['masspay_api_mode']);
		}
		$vendor_paypal_username = get_option( 'masspay_user_name' );
		$vendor_paypal_password = get_option( 'masspay_api_pass' );
		$vendor_paypal_signature = get_option( 'masspay_api_signature' );
		$vendor_paypal_api_mode = get_option( 'masspay_api_mode' );
	?>
    	<form method="post" action="">
        <div class="wrap">
        <h2><?php _e("Mass Payment Settings","woocommerce-vendor-setup"); ?></h2>
		<table class="widefat">
        	<tr>
            	<td><label><?php _e("Masspay API User Name","woocommerce-vendor-setup"); ?></label></td>
                <td><input type="text" name="masspay_user_name" id="masspay_user_name" value="<?php echo $vendor_paypal_username;?>" class="input-text" /></td>
            </tr>
            <tr>
            	<td><label><?php _e("Masspay API Password","woocommerce-vendor-setup"); ?></label></td>
                <td><input type="text" name="masspay_api_pass" id="masspay_api_pass" value="<?php echo $vendor_paypal_password;?>" class="input-text" /></td>
            </tr>
            <tr>
              <td><label><?php _e("Masspay API Signature","woocommerce-vendor-setup"); ?></label></td>
              <td><input type="text" name="masspay_api_signature" id="masspay_api_signature" value="<?php echo $vendor_paypal_signature;?>" class="input-text" /></td>
            </tr>
            <tr>
              <td><label><?php _e("Masspay API Type","woocommerce-vendor-setup"); ?></label></td>
              <td>
                <select name="masspay_api_mode">
                  <option value="sandbox" <?php if($vendor_paypal_api_mode=='sandbox')echo 'selected="selected"';?> ><?php _e("Sandbox","woocommerce-vendor-setup"); ?></option>
                  <option value="live" <?php if($vendor_paypal_api_mode=='live')echo 'selected="selected"';?> ><?php _e("Live","woocommerce-vendor-setup"); ?></option>
                </select>
                <input type="hidden" name="vendor_paypal_setting" value="yes" />  
              </td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" name="Submit"  class="button-primary" value="<?php _e("Update Settings","woocommerce-vendor-setup"); ?>" /></td>
            </tr>
        </table>
        </div>
        </form>
	<?php
}


add_action('admin_menu', 'create_vendor_approve_page');
?>