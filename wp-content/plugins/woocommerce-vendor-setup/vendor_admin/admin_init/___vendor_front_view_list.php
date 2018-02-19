<?php

	
add_shortcode('vendor_order_list_view', 'view_vendor_order_list_for_front_page');

function vendor_add_front_sub_menu_function(){
	$user_id = get_current_user_id();
	$become_a_vendor = get_user_meta( $user_id, 'become_a_vendor', true ); 
	$vendor_status = get_user_meta( $user_id, 'become_a_vendor_status', true ); 
	if($become_a_vendor=='vendor'){
		create_post_page('Vendor','[vendor_order_list_view]');
	}
}



function create_post_page($title,$content){
	
	global $user_ID;
	$new_page_title = $title;
	$new_page_content = $content;
	$new_page_template = '';
	$page_check = get_page_by_title($new_page_title);
	$new_page = array(
			'post_type' => 'page',
			'post_title' => $new_page_title,
			'post_content' => $new_page_content,
			'post_status' => 'publish',
			'comment_status' => 'closed',          
			'post_author' => $user_ID
	);
	if(!isset($page_check->ID)){
	  $new_page_id = wp_insert_post($new_page);
	  update_option( $title, $new_page_id );
	}
}

function view_vendor_order_list_for_front_page(){
	if (!is_user_logged_in()) {
    	wp_redirect( get_permalink( get_option('woocommerce_myaccount_page_id') ) );
    	exit;
	}
	//*********************************************************************************
	if(isset($_GET['action_type'])&&($_GET['action_type']=='order_details')){
		$order_id = $_GET['order_id'];
		//die($order_id);
		global $woocommerce;
		global $wpdb;
		global $user_ID;
		global $current_user;
		echo woocommerce_order_details_table($order_id);
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	}
	else if(isset($_GET['delivery_type'])&&($_GET['delivery_type']=='delivered')){
		global $wpdb;
		global $user_ID;
		global $current_user;
		global $woocommerce;
		
		$custom_table_prefix = 'woocommerce_';
	  	$wpdb_all_prefix = $wpdb->prefix.$custom_table_prefix;
		$vendor_page = get_page_by_title('Vendor');
		$vendor_page_id =  $vendor_page->ID;
		
		
		$current_user = wp_get_current_user();
		//echo 'fdgdfgdfg';
		
		$user_ID = get_option( $current_user->user_nicename );
		//echo $user_ID.'---->';
		$order_id = $_GET['order_id'];
		//echo "SELECT * FROM {$wpdb_all_prefix}vendor where vendor_vendor_id = ".$user_ID." and vendor_order_id = ".$order_id." ORDER BY vendor_id DESC";
		$vendor_records_popup = $wpdb->get_results("SELECT * FROM {$wpdb_all_prefix}vendor where vendor_vendor_id = ".$user_ID." and vendor_order_id = ".$order_id." ORDER BY vendor_id DESC " );
		$vendor_id = $wpdb->get_row("SELECT vendor_vendor_id FROM wp_woocommerce_vendor where vendor_order_id = ".$order_id." limit 1" );
		//print_r($vendor_records_popup);
		if( $vendor_records_popup ) { 
			foreach( $vendor_records_popup as $ven_record ) {
				$vendor_product = $wpdb->get_row("SELECT * FROM wp_postmeta where post_id = ".$ven_record->vendor_product_id." and meta_value = ".$vendor_id->vendor_vendor_id."" );
				//echo '<pre>';
				//print_r($vendor_product);
				
				if(!empty($vendor_product)){
					/*echo "
					  UPDATE {$wpdb_all_prefix}vendor 
					  SET vendor_product_delivared = '".$_GET['action_type']."'
					  WHERE vendor_order_id = ".$ven_record->vendor_order_id." 
						  AND vendor_product_id = ".$ven_record->vendor_product_id."
					  ";*/
				  $wpdb->query(
					  "
					  UPDATE {$wpdb_all_prefix}vendor 
					  SET vendor_product_delivared = '".$_GET['action_type']."'
					  WHERE vendor_order_id = ".$ven_record->vendor_order_id." 
						  AND vendor_product_id = ".$ven_record->vendor_product_id."
					  "
				  );
				}
			}
		}
		wp_redirect( site_url( '/?page_id='.$vendor_page_id.'') );
    	exit;
		
		
	}
	else{
	?>
  <script type="text/javascript">
  /*jQuery(document).ready(function(){
	jQuery( '.vendor_view_tab').tabs();
  });*/
  	function get_hostname(url) {
		var m = url.match(/^http:\/\/[^/]+/);
		return m ? m[0] : null;
	}
	function ShowMyDiv(Obj){
  var elements = document.getElementsByTagName('div');
	for (var i = 0; i < elements.length; i++) 
		if(elements[i].className=='tabcontent')
			elements[i].style.display= 'none';

	document.getElementById(Obj.rel).style.display= 'block';
	//------------------------------------

  var ul_el = document.getElementById('tab_ul');
  var li_el = ul_el.getElementsByTagName('li');
	for (var i = 0; i < li_el.length; i++) 
		li_el[i].className="";

	Obj.parentNode.className="selected";}
	function set_delivery_status(vendor_page, vendor_order){
		//alert(vendor_page+'----'+vendor_order);
		var action_type = jQuery("#ven_order_"+vendor_order).val();
		//alert(vendor_page+'----'+vendor_order+'----'+action_type);
		
		if((vendor_page!='')&&(vendor_order!='')){
			//alert("<?php echo get_option('siteurl');?>/?page_id="+vendor_page+"&order_id="+vendor_order+"&action_type="+action_type+"&delivery_type=delivered");
			window.location.href="<?php echo get_option('siteurl');?>/?page_id="+vendor_page+"&order_id="+vendor_order+"&action_type="+action_type+"&delivery_type=delivered";
			/*setTimeout(function() {
				  window.location.href = "<?php echo get_option('siteurl');?>/?page_id="+vendor_page+"&order_id="+vendor_order+"&action_type="+action_type+"&delivery_type=delivered";
			}, 5000);*/
			<?php
				//wp_redirect( site_url( '/?page_id='.$vendor_page_id.'&order_id='.$order_id.'&action_type='.$order_id.'') );
    			//exit;
			?>
		}
		//alert(jQuery("#ven_order_"+vendor_order).val());
		//alert(get_hostname("http://example.com/path"));
		//alert("<?php //echo get_option('siteurl');?>/?page_id="+vendor_page+"&order_id="+vendor_order+"&action_type="+action_type+"");
	}
  
  </script>

  <?php
	global $wpdb;
	global $user_ID;
	global $current_user;
	global $woocommerce;
    $current_user = wp_get_current_user();
	$vendor_page = get_page_by_title('Vendor');
	$vendor_page_id =  $vendor_page->ID;
	//echo $current_user->user_nicename.'--->';
	//echo '<pre>';
	//print_r($current_user);
	$user_ID = get_option( $current_user->user_nicename );
	//echo '---->'.$user_ID;
	//die('56566464464--->'.$vendor_id);
	  //-------------------  Vendor Info ----------------------
	$vendor_name=get_post_meta($user_ID,'_vendor_name',true);
	$vendor_company=get_post_meta($user_ID,'_vendor_company',true);
  	$vendor_email=get_post_meta($user_ID,'_vendor_email',true);
  	$vendor_phone=get_post_meta($user_ID,'_vendor_phone',true);
	$vendor_fax=get_post_meta($user_ID,'_vendor_fax',true);
	
	$vendor_address=get_post_meta($user_ID,'_vendor_address',true);
	$vendor_zip=get_post_meta($user_ID,'_vendor_zip',true);
  	$vendor_state=get_post_meta($user_ID,'_vendor_state',true);
  	$vendor_country=get_post_meta($user_ID,'_vendor_country',true);
	$vendor_paypal=get_post_meta($user_ID,'_vendor_paypal',true);
	  //-------------------------------------------------------	  
	  $custom_table_prefix = 'woocommerce_';
	  $pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
	  $limit =5;
	  $offset = ( $pagenum - 1 ) * $limit;
	  $wpdb_all_prefix = $wpdb->prefix.$custom_table_prefix;
	  //echo "SELECT * FROM {$wpdb_all_prefix}vendor where vendor_vendor_id = ".$user_ID."  ORDER BY vendor_id";
	  //$vendor_records = $wpdb->get_results("SELECT * FROM {$wpdb_all_prefix}vendor where vendor_vendor_id = ".$user_ID."  ORDER BY vendor_id DESC LIMIT $offset, $limit" );
	  $vendor_records_details = $wpdb->get_results("SELECT * FROM {$wpdb_all_prefix}vendor where vendor_vendor_id = ".$user_ID."  ORDER BY vendor_id DESC " );
	  $vendor_records = $wpdb->get_results("SELECT vendor_order_id, count(*) as total_product, count(vendor_product_qty) as pro_qty,sum(vendor_product_amount) as total_price, vendor_order_date FROM wp_woocommerce_vendor where vendor_vendor_id = ".$user_ID." GROUP BY `vendor_order_id`" );
	  
	  
	  $vendor_records_stat = $wpdb->get_results("SELECT count(*) as cnt_record, `vendor_order_date` FROM {$wpdb_all_prefix}vendor WHERE `vendor_vendor_id` = ".$user_ID." GROUP BY `vendor_order_date` ORDER BY vendor_id" );
	  $vendor_all_record = "['Date', 'Sales'],";
	  foreach($vendor_records_stat as $ven_stat){
		
		$vendor_all_record .="['".$ven_stat->vendor_order_date."', ".$ven_stat->cnt_record."],"; 
		
	}
	  //echo '<pre>';
	  //print_r($vendor_records);
	  //die();
	   if( $vendor_records ) { 
            $count = 1;
            $class = '';
            foreach( $vendor_records as $ven_record ) {
            ?>
          <div id="vendor_ordered_item_<?php echo $ven_record->vendor_order_id;?>" style="display:none">
            <h2>My items Order No&nbsp;:&nbsp;<?php echo $ven_record->vendor_order_id;?></h2> 
            <!--<div style="float:left;padding:10px; width:90%;">-->
            <div class="woocommerce" style="float:left;padding:10px; width:95%;">
          <table class="shop_table my_account_orders">
                <thead>
                  <tr>
                    <th>Product</th>
                    <th>&nbsp;</th>
                    <th>Qty</th>
                	<th>Amount</th>
                	<th>Percent</th>
                    <th>Percent Amount</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
				$vendor_records_popup = $wpdb->get_results("SELECT * FROM {$wpdb_all_prefix}vendor where vendor_vendor_id = ".$user_ID." and vendor_order_id = ".$ven_record->vendor_order_id." ORDER BY vendor_id DESC " );
				//echo "SELECT vendor_vendor_id FROM wp_woocommerce_vendor where vendor_order_id = ".$ven_record->vendor_order_id." limit 1";
				$vendor_id = $wpdb->get_row("SELECT vendor_vendor_id FROM wp_woocommerce_vendor where vendor_order_id = ".$ven_record->vendor_order_id." limit 1" );
				
				//echo $vendor_id->vendor_vendor_id;
				//print_r($vendor_id);
				if( $vendor_records_popup ) { 
                $count = 1;
				$delivary_status = '';				
                $class = '';
                foreach( $vendor_records_popup as $ven_record ) {
					$vendor_product = $wpdb->get_row("SELECT * FROM wp_postmeta where post_id = ".$ven_record->vendor_product_id." and meta_value = ".$vendor_id->vendor_vendor_id."" );
					if(!empty($vendor_product)){
						if($ven_record->vendor_product_delivared=='Pending'){
							$delivary_status = 'Pending';
						}
						else{
							$delivary_status = 'Delivered';
						}
                  $class = ( $count % 2 == 0 ) ? ' style="background-color:#4CC5E2"' : '';
                ?>
                  <tr>
                    <td><?php echo $ven_record->vendor_product_name;?></td>
                    <td>
                    	<?php
							$img_url = wp_get_attachment_image_src(get_post_thumbnail_id($ven_record->vendor_product_id),'thumbnail');
						?>
                        <img src="<?php echo $img_url[0];?>" width="45" height="45" />
                    </td>
                    <td><?php echo $ven_record->vendor_product_qty;?></td>
                    <td><?php echo $ven_record->vendor_product_amount;?></td>                
                	<td><?php echo $ven_record->vendor_percent;?>&nbsp;%</td>
                    <td><?php echo $ven_record->vendor_amount;?></td>
                    <td><?php echo $ven_record->vendor_product_delivared;?></td>
                  </tr>
                  <?php
                    $count++;
					}
                  }
                  ?>
                  <?php } else { ?>
                  <tr>
                    <td colspan="4" style="text-align:center; color:#F00; font-weight:bold;">You have no order for pending.</td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
              <div style="width:100%;">
              	<?php
                	
					$billing_first_name =  get_post_meta($ven_record->vendor_order_id,'_billing_first_name',true);
					$billing_last_name = get_post_meta($ven_record->vendor_order_id,'_billing_last_name',true);
					$billing_company = get_post_meta($ven_record->vendor_order_id,'_billing_company',true);
					$billing_address = get_post_meta($ven_record->vendor_order_id,'_billing_address_1',true);
					$billing_address2 = get_post_meta($ven_record->vendor_order_id,'_billing_address_2',true);
					$billing_city = get_post_meta($ven_record->vendor_order_id,'_billing_city',true);
					$billing_postcode = get_post_meta($ven_record->vendor_order_id,'_billing_postcode',true);
					$billing_country = get_post_meta($ven_record->vendor_order_id,'_billing_country',true);
					$billing_state = get_post_meta($ven_record->vendor_order_id,'_billing_state',true);
					$billing_email = get_post_meta($ven_record->vendor_order_id,'_billing_email',true);
					$billing_phone = get_post_meta($ven_record->vendor_order_id,'_billing_phone',true);
					$billing_paymethod = get_post_meta($ven_record->vendor_order_id,'_payment_method',true);
					
					 
					
					$shipping_first_name =  get_post_meta($ven_record->vendor_order_id,'_shipping_first_name',true);
					$shipping_last_name = get_post_meta($ven_record->vendor_order_id,'_shipping_last_name',true);
					$shipping_company = get_post_meta($ven_record->vendor_order_id,'_shipping_company',true);
					$shipping_address = get_post_meta($ven_record->vendor_order_id,'_shipping_address_1',true);
					$shipping_address2 = get_post_meta($ven_record->vendor_order_id,'_shipping_address_2',true);
					$shipping_city = get_post_meta($ven_record->vendor_order_id,'_shipping_city',true);
					$shipping_postcode = get_post_meta($ven_record->vendor_order_id,'_shipping_postcode',true);
					$shipping_country = get_post_meta($ven_record->vendor_order_id,'_shipping_country',true);
					$shipping_state = get_post_meta($ven_record->vendor_order_id,'_shipping_state',true);
					$shipping_email = get_post_meta($ven_record->vendor_order_id,'_shipping_email',true);
					$shipping_phone = get_post_meta($ven_record->vendor_order_id,'_shipping_phone',true);
					//$billing_paymethod = get_post_meta($ven_record->vendor_order_id,'_payment_method',true);
					
					 
				?>
                <div style="width:49%; min-height:220px; float:left; border:solid 1px #CCCCCC;">
                	<div style="width:100%; min-height:20px; background:#CCC;">
                    	<h3>&emsp;Billing Address</h3>
                    </div>
                	<div style="width:80%; margin:auto;">                                    	
                	<?php
                    	echo $billing_first_name.' '.$billing_last_name.'<br>';
						echo $billing_company.'<br>'; 
						echo $billing_address.'<br>'; 
						echo $billing_city.'<br>'; 
						echo $billing_postcode.'<br>';
						echo $billing_state.', '.$billing_country.'<br>'; 
						echo $billing_email.'<br>'; 
						echo $billing_phone.'<br>'; 
						//echo $billing_paymethod.'<br>';
					?>
                    </div>
                </div>
                <div style="width:49%; min-height:220px; float:right;  border:solid 1px #CCCCCC;">
                	<div style="width:100%; min-height:20px; background:#CCC;">
                    	<h3>&emsp;Shipping Address</h3>
                    </div>
                	<div style="width:80%; margin:auto;">                    
                	<?php
                    	echo $shipping_first_name.' '.$shipping_last_name.'<br>';
						echo $shipping_company.'<br>'; 
						echo $shipping_address.'<br>'; 
						echo $shipping_city.'<br>'; 
						echo $shipping_postcode.'<br>';
						echo $shipping_state.', '.$shipping_country.'<br>'; 
						echo $shipping_email.'<br>'; 
						echo $shipping_phone.'<br>';
					?>
                    </div>
                </div>
              </div>
              <div style="clear:both;"></div>
              <div style="width:98%; text-align:right; margin-top:5px;">
              	<?php
                	//if($delivary_status!='Delivered'){
				?>
                <select id="ven_order_<?php echo $ven_record->vendor_order_id;?>">
                	<option value="Pending" <?php if($delivary_status=='Pending')echo 'selected="selected"';?>>Pending</option>
                    <option value="Delivered" <?php if($delivary_status=='Delivered')echo 'selected="selected"';?>>Delivered</option>
                </select>
                <a class="button view" onclick="set_delivery_status('<?php echo $vendor_page_id;?>','<?php echo $ven_record->vendor_order_id;?>');">Submit</a>
              	<!--<a class="button view" href="?page_id=<?php //echo $vendor_page_id;?>&order_id=<?php //echo $ven_record->vendor_order_id;?>&action_type=delivered">Delivered It</a>-->
                <?php
					//}
				?>
              </div>
            </div>           
            <!--<strong>Just click outside the pop-up to close it.</strong>-->
          </div>
          <?php
			}
		  }
		  ?>
          
          
          
        <div class="wrap stat_display">
          <ul id="tab_ul" class="tabs">
            <li class="selected"><a rel="tab_div1" href="#" onClick="javascript:ShowMyDiv(this);">Order List</a></li>
            <?php
            //if (!is_admin()) {
			if(!current_user_can('edit_theme_options')){
			?>
            <li><a rel="tab_div2" href="#" onClick="javascript:ShowMyDiv(this);">Statistics</a></li>
            <li><a rel="tab_div3" href="#" onClick="javascript:ShowMyDiv(this);">Payment Status</a></li>
            <?php
			}
			?>
          </ul>
          <div class="tabcontents">
          <div class="tabcontent" id="tab_div1" style="display: block;">
          <h2>Order Record of <font style="color:#090; font-weight:bold;"><?php echo $vendor_name;?></font></h2>
          <div class="woocommerce">
          <table class="shop_table my_account_orders">
            <thead>
              <tr>
              	<th>Order ID</th>
                <th>Total Item</th>
                <th>Qty</th>
                <th>Amount</th>			  
                <th>Purchase Date</th>
                <th>&nbsp;</th>
              </tr>
            </thead>
            <tbody>
            <?php if( $vendor_records ) { 
            $count = 1;
            $class = '';
            foreach( $vendor_records as $ven_record ) {
              $class = ( $count % 2 == 0 ) ? ' style="background-color:#4CC5E2"' : '';
            ?>
              <tr>
              	<td style="color:#1898FC;"><a style="cursor:pointer;" href="?page_id=<?php echo $vendor_page_id;?>&order_id=<?php echo $ven_record->vendor_order_id;?>&action_type=order_details" >#<?php echo $ven_record->vendor_order_id;?></a></td>
                <td><?php echo $ven_record->total_product;?>&nbsp;Item</td>
                <td><?php echo $ven_record->pro_qty;?></td>
                <td><?php echo $ven_record->total_price;?></td>                
                <td><?php echo $ven_record->vendor_order_date;?></td>
                <td class="order-actions">
					<a class="button view thickbox" href="#TB_inline?width=600&height=550&inlineId=vendor_ordered_item_<?php echo $ven_record->vendor_order_id;?>">Order Details</a>
                    					
                </td>
              </tr>
              <?php
                $count++;
              }
              ?>
              <?php } else { ?>
              <tr>
                <td colspan="6" style="text-align:center; color:#F00; font-weight:bold;">You have no order for pending.</td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
          </div>
          <?php
          $total = $wpdb->get_var( "SELECT count(*) FROM {$wpdb_all_prefix}vendor where vendor_vendor_id = ".$user_ID."  ORDER BY vendor_id DESC");
          $num_of_pages = ceil( $total / $limit );
          $page_links = paginate_links( array(
              'base' => add_query_arg( 'pagenum', '%#%' ),
              'format' => '',
              'prev_text' => __( '&laquo;', 'aag' ),
              'next_text' => __( '&raquo;', 'aag' ),
              'total' => $num_of_pages,
              'current' => $pagenum
            ));
          if ( $page_links ) {
            echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . $page_links . '</div></div>';
          }
          
        ?>
        </div>
        	<?php
        	 //if (!is_admin()) { 
				if(!current_user_can('edit_theme_options')){ 
			?>
			<div class="tabcontent" id="tab_div2" style="display: none;">
				<script type="text/javascript">
				  google.load("visualization", "1", {packages:["corechart"]});
				  google.setOnLoadCallback(drawChart);
				  function drawChart(){
					  
			  /*var data = google.visualization.arrayToDataTable([
					  ['Year', 'Sales', 'Expenses'],
					  ['2013',  1000,      400],
					  ['2014',  1170,      460],
					  ['2015',  660,       1120],
					  ['2016',  1030,      540]
					]);*/
					 /*var data = google.visualization.arrayToDataTable([
					  ['Year', 'Sales'],
					  ['2013',  1000],
					  ['2014',  1170],
					  ['2015',  660],
					  ['2016',  1030]
					]);*/
					var data = google.visualization.arrayToDataTable([<?php echo $vendor_all_record;?>]);
			
					var options = {
					  title: 'Sales Performance',
					  hAxis: {title: 'Date',  titleTextStyle: {color: '#333'}},
					  vAxis: {minValue: 0},
					  colors: ['#1C9B24']
					};
			
					var chart = new google.visualization.AreaChart(document.getElementById('liner_div'));
					chart.draw(data, options);
				  }
				</script>
				<!--<div id="liner_div" style="width: 900px; height: 500px;"></div>-->
				<div id="liner_div" style="width: 100%; height: 100%;"></div>
			</div>
           <!-- ********************************** Payment Status ************************************************** -->
            <div class="tabcontent" id="tab_div3" style="display: none;">
              <h2>Order Record of <font style="color:#090; font-weight:bold;"><?php echo $vendor_name;?></font></h2>
              <div class="woocommerce">
              <table class="shop_table my_account_orders">
                <thead>
                  <tr>
                    <th>Product</th>
                    <th>Qty</th>
                	<th>Amount</th>
                	<th>Percent</th>
                	<th>Percent Amount</th>			  
                	<th>Purchase Date</th>
                    <th>Status</th>
                    <th>Pay Date</th>
                  </tr>
                </thead>
                <tbody>
                <?php if( $vendor_records_details ) { 
                $count = 1;
                $class = '';
                foreach( $vendor_records_details as $ven_record ) {
                  $class = ( $count % 2 == 0 ) ? ' style="background-color:#4CC5E2"' : '';
                ?>
                  <tr>
                    <td><?php echo $ven_record->vendor_product_name;?></td>
                    <td><?php echo $ven_record->vendor_product_qty;?></td>
                    <td><?php echo $ven_record->vendor_product_amount;?></td>                
                	<td><?php echo $ven_record->vendor_percent;?>&nbsp;%</td>
                	<td><?php echo $ven_record->vendor_amount;?></td>
                	<td><?php echo $ven_record->vendor_order_date;?></td>
                    <td><?php echo $ven_record->vendor_send_money_status;?></td>
                    <td><?php echo $ven_record->vendor_send_money_date;?></td>
                  </tr>
                  <?php
                    $count++;
                  }
                  ?>
                  <?php } else { ?>
                  <tr>
                    <td colspan="6" style="text-align:center; color:#F00; font-weight:bold;">You have no order for pending.</td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
              </div>
              <?php
              $total = $wpdb->get_var( "SELECT count(*) FROM {$wpdb_all_prefix}vendor where vendor_vendor_id = ".$user_ID."  ORDER BY vendor_id DESC");
              $num_of_pages = ceil( $total / $limit );
              $page_links = paginate_links( array(
                  'base' => add_query_arg( 'pagenum', '%#%' ),
                  'format' => '',
                  'prev_text' => __( '&laquo;', 'aag' ),
                  'next_text' => __( '&raquo;', 'aag' ),
                  'total' => $num_of_pages,
                  'current' => $pagenum
                ));
              if ( $page_links ) {
                echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . $page_links . '</div></div>';
              }
              
            ?>
            </div>
			<?php
				 }
				  //echo woocommerce_order_details_table('173');
				  //$uu = get_page_by_title('Vendor');
				  //echo $uu->ID;
				  //print_r($uu);
			?>
         </div>
       </div>
	  <?php
	

	//*********************************************************************************
}
			}
/*add_action( 'woocommerce_order_items_table', 'xcsn_woocommerce_order_items_table');
function xcsn_woocommerce_order_items_table ( $order ) {
	echo $order->id;
}*/






?>
