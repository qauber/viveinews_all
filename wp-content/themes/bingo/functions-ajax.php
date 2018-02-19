<?php

//function get default-view form data and save to user account

function liveinews_default_view_save(){
    $current_user = wp_get_current_user();
    $uid = $current_user->ID;

    $formData = array();
    parse_str($_POST['data_form'], $formData);
//    print_r($formData);

    $response = array();

    if (!isset($formData['main-category']) && $formData['main-category'] == 0){
        $response['status'] = 'Fail';
        $response['error'] = true;
        $response['message'] = 'Main Category field is required';
    }

    if (!isset($formData['category']) && $formData['category'] == 0){
        $response['status'] = 'Fail';
        $response['error'] = true;
        $response['message'] = 'Category field is required';
    }

    if (!isset($formData['location']) && $formData['location'] == 0){
        $response['status'] = 'Fail';
        $response['error'] = true;
        $response['message'] = 'Location field is required';
    }

//    if ($response['error'] === false){
        update_user_meta($uid, 'default_view', $_POST['data_form']);

        $response['status'] = 'Success';
        $response['message'] = 'Your default view settings save successfuly';

//    }

    print json_encode($response);

    wp_die();

}
add_action('wp_ajax_liveinews_default_view', 'liveinews_default_view_save');
add_action('wp_ajax_nopriv_liveinews_default_view', 'liveinews_default_view_save');

function liveinews_view_settings()
{
    $current_user = wp_get_current_user();
    $uid = $current_user->ID;

    $response = array();

    $result = update_user_meta($uid, 'view_settings', $_POST['data_form']);

    if ($result) {
        $response['status'] = 'Success';
        $response['message'] = 'Your default view settings save successfuly';
    }else{
        $response['status'] = 'Fail';
        $response['message'] = 'Nothing update';
    }

    print json_encode($response);

    wp_die();

}
add_action('wp_ajax_liveinews_view_settings', 'liveinews_view_settings');
add_action('wp_ajax_nopriv_liveinews_view_settings', 'liveinews_view_settings');

function liveinews_view_settings_other_users()
{
    $current_user = wp_get_current_user();
    $uid = $current_user->ID;

    $response = array();


    $result = update_option( 'view_settings_other_users', $_POST['data_form'], '', '' );

    if ($result) {
        $response['status'] = 'Success';
        $response['message'] = 'Your default view settings save successfuly';
    }else{
        $response['status'] = 'Fail';
        $response['message'] = 'Nothing update';
    }

    print json_encode($response);

    wp_die();

}
add_action('wp_ajax_liveinews_view_settings_other_users', 'liveinews_view_settings_other_users');
add_action('wp_ajax_nopriv_liveinews_view_settings_other_users', 'liveinews_view_settings_other_users');


function liveinews_get_default_view(){
    $current_user = wp_get_current_user();
    $uid = $current_user->ID;
    
    $default_view_ser = get_user_meta($uid, 'default_view',true);
  
    $default_view = array();
    
    if($default_view_ser){
        
        parse_str($default_view_ser, $default_view);
        $default_view['status'] = 'success';
        $default_view['message'] = 'Your default view apply';
        $default_view['user_id'] = $uid;
        $default_view['datetime'] = current_time( 'Ymd-His' );
    }else{
        $default_view['status'] = 'error';
        $default_view['message'] = 'Sorry, maybe your default view is empty, you can set it in the next tab';
    }
    
    print json_encode($default_view);
    
    wp_die();
}
add_action('wp_ajax_liveinews_get_default_view', 'liveinews_get_default_view');
add_action('wp_ajax_nopriv_liveinews_get_default_view', 'liveinews_get_default_view');

//set status Availabel Now for current user
function liveinews_set_available_status(){
    $current_user = wp_get_current_user();
    $uid = $current_user->ID;
    
    
    if (isset($_POST['available_status']) && !empty($_POST['available_status'])){
        if ($_POST['available_status'] == 'available'){
            $status = 1;
        }else{
            $status = 0;
        }
        
        update_user_meta($uid, 'available_now', $status);
    }
    
    $available_status = get_user_meta($uid, 'available_now',true);
    
    if ($available_status == $status){
        $answer['status'] = 'success';
    }
    
    print json_encode($answer);
    
    wp_die();
}
add_action('wp_ajax_liveinews_set_available_status', 'liveinews_set_available_status');
add_action('wp_ajax_nopriv_liveinews_set_available_status', 'liveinews_set_available_status');

function remove_advanced_filter(){

    $user_id = get_current_user_id();

    $user_filters = get_user_meta($user_id, 'advanced_filters',true);

    $user_filters = unserialize($user_filters);

    unset($user_filters[$_POST['filter_name']]);

    $user_filters = serialize($user_filters);

    $available_status = update_user_meta($user_id,'advanced_filters', $user_filters);

    if ($available_status == true){
        $answer['status'] = 'success';
    }

    print json_encode($answer);

    wp_die();
}
add_action('wp_ajax_remove_advanced_filter', 'remove_advanced_filter');
add_action('wp_ajax_nopriv_remove_advanced_filter', 'remove_advanced_filter');