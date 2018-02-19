<?php
date_default_timezone_set ( 'America/New_York' );
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

date_default_timezone_set('US/Arizona');

ignore_user_abort(true);
if ( !empty($_POST) || defined('DOING_AJAX') || defined('DOING_CRON') )
	die();

if ( !defined('ABSPATH') ) {
	/** Set up WordPress environment */
	require_once( dirname( __FILE__ ) . '/wp-load.php' );
}


$time_week = date("Y-m-d H:i:s", time()-(7*24*3600)); // - 7 days
$time_one = date("Y-m-d H:i:s", time()-3600); // -1 hours category
$term_id = array("202");
$new_cat_id = "203"; # id cat terms
$arhive_id = "209";

function get_category_children_id( $id ) {
	global $wpdb;
	$arr = array();
    $row = $wpdb->get_results("SELECT term_id FROM $wpdb->term_taxonomy WHERE taxonomy='product_cat' AND parent='{$id}'");
    foreach ($row as $value) {
    	$arr[] = $value->term_id;
    }
    return $arr;
}

function get_post_by_time( $id ) {
	global $wpdb;
    $row = $wpdb->get_results("SELECT id, post_date as hour FROM $wpdb->posts WHERE post_status='publish' AND post_type='product' AND id IN ( SELECT object_id FROM $wpdb->term_relationships WHERE term_taxonomy_id in ( SELECT term_taxonomy_id FROM $wpdb->term_taxonomy WHERE term_id='{$id}') )");
    return $row;
}

function get_post_all() {
	global $wpdb;
    $row = $wpdb->get_results("SELECT id, post_date as hour FROM $wpdb->posts WHERE post_status='publish' AND post_type='product' AND id IN ( SELECT object_id FROM $wpdb->term_relationships WHERE term_taxonomy_id in ( SELECT term_taxonomy_id FROM $wpdb->term_taxonomy) )");
    return $row;
}

function get_term_by_post_id( $id ){
	global $wpdb;
	$row = $wpdb->get_row("SELECT term_id FROM  $wpdb->term_taxonomy WHERE taxonomy='product_cat' AND term_taxonomy_id IN (SELECT term_taxonomy_id FROM $wpdb->term_relationships WHERE object_id='{$id}') LIMIT 1");
	return $row->term_id;
}

function delete_category_post_by_id( $id, $term_id ) {
	global $wpdb;
    $wpdb->query("DELETE FROM $wpdb->term_relationships WHERE object_id='{$id}' AND term_taxonomy_id IN ( SELECT term_taxonomy_id FROM $wpdb->term_taxonomy WHERE term_id='{$term_id}' AND taxonomy='product_cat')");
    # update count in category
    update_count_post($term_id, 0);
}

function change_cat_id( $id, $from, $to) {
	global $wpdb;
    $wpdb->query("DELETE FROM $wpdb->term_relationships WHERE object_id='{$id}' AND term_taxonomy_id IN ( SELECT term_taxonomy_id FROM $wpdb->term_taxonomy WHERE term_id='{$from}' AND taxonomy='product_cat')");
    # update count in category
    update_count_post( $from, 0 );
    $wpdb->query("INSERT INTO $wpdb->term_relationships (object_id,term_taxonomy_id) VALUES ('{$id}','{$to}')");
    # update count in category
    update_count_post( $to, 1 );
}

function get_tax_id($id){
	global $wpdb;
	$row = $wpdb->get_row("SELECT term_taxonomy_id FROM $wpdb->term_taxonomy WHERE term_id='{$id}' LIMIT 1");
	return $row->term_taxonomy_id;
}

function update_count_post( $term_id, $val ) {
	global $wpdb;
    if($val == 0) {
        $wpdb->query("UPDATE $wpdb->term_taxonomy SET count=count-'1' WHERE term_id='{$term_id}'");
        $wpdb->query("UPDATE $wpdb->woocommerce_termmeta SET meta_value=meta_value-'1' WHERE woocommerce_term_id='{$term_id}' AND meta_key='product_count_product_cat'");
    } else {
        $wpdb->query("UPDATE $wpdb->term_taxonomy SET count=count+'1' WHERE term_id='{$term_id}'");
        $wpdb->query("UPDATE $wpdb->woocommerce_termmeta SET meta_value=meta_value+'1' WHERE woocommerce_term_id='{$term_id}' AND meta_key='product_count_product_cat'");
    }
    $opt = $wpdb->get_row("SELECT option_value FROM $wpdb->options WHERE option_name='_transient_wc_term_counts' LIMIT 1");
    
    if($opt->option_value != '') {
        $opt_value = unserialize( $opt->option_value );
        
        foreach ($opt_value as $key => $value) {
            if ($key == $term_id) {
                if($val == 0) {
                    $value = $value - 1;
                } else {
                    $value = $value + 1;
                }
            }
             $opt_arr[$key] = $value;
        }
        $opt_value = serialize( $opt_arr );
        $wpdb->query("UPDATE $wpdb->options SET option_value='{$opt_value}' WHERE option_name='_transient_wc_term_counts' LIMIT 1");
    }
}

function delete_atach_post_not_parent() {
	global $wpdb;
    $wpdb->query("DELETE FROM $wpdb->posts WHERE post_status='inherit' AND post_type='attachment' AND post_parent NOT IN ( SELECT id FROM $wpdb->posts )");
}

function delete_postmeta_not_post() {
	global $wpdb;
    $wpdb->query("DELETE FROM $wpdb->postmeta WHERE post_id NOT IN ( SELECT id FROM $wpdb->posts )");
}

delete_atach_post_not_parent();
delete_postmeta_not_post();

# breaking news and children category
$term_id = array_merge($term_id, get_category_children_id( $term_id[0] ));

$arr_child = array();
foreach (get_category_children_id( $term_id[0] ) as $id) {
   if(is_array(get_category_children_id( $id ))){
      foreach(get_category_children_id( $id ) as $nid){
        $arr_child[] = $nid;
      }
   }else{
        $arr_child[] = get_category_children_id( $id );
   }
}

if(is_array($arr_child)){
    if(count($arr_child) > 0){
        $term_id = array_merge($term_id, $arr_child);
    }
}


# delete one hours
foreach ($term_id as $value) {
    foreach( get_post_by_time($value) as $value1 ){
    	
    	if($value1->id == $arhive_id) continue;

        if($time_one > $value1->hour){
        	if($value == $new_cat_id) continue;
        	//change_cat_id( $value1->id, $value, get_tax_id($new_cat_id) );
        	delete_category_post_by_id($value1->id, $value);
        }

        /*if($time_week > $value1->hour){
            change_cat_id( $value1->id, $value, get_tax_id($arhive_id) );
        }*/
    }
}

# delete one week
foreach( get_post_all() as $value1 ){
    if($time_week > $value1->hour){
            change_cat_id( $value1->id, get_term_by_post_id($value1->id), get_tax_id($arhive_id) );
    }
}



