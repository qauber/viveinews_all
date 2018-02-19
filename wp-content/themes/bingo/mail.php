<?php

//send email to admin and moderators if it switch on in theme options
function send_email_to_moderator($post_data = ''){
    
    global $bingo_option_data;
    
    $to = array();

    if ($bingo_option_data['bingo-send-email-to-administrator']){
    
        $args = array(
            'blog_id'       => $GLOBALS['blog_id'],
            'role'          => 'administrator',
            'fields'        => ['user_email'],
        );
        $admins = get_users( $args );

        foreach( $admins as $admin ){
            array_push($to, $admin->user_email);
        }
    }
    
    if ($bingo_option_data['bingo-send-email-to-editor']){
    
        $args = array(
            'blog_id'       => $GLOBALS['blog_id'],
            'role'          => 'editor',
            'fields'        => ['user_email'],
        );
        $editors = get_users( $args );

        foreach( $editors as $editor ){
            array_push($to, $editor->user_email);
        }
    }
    
//    print_r($editors);
    
    if (!empty($to)){
        $subject  = $bingo_option_data['bingo-new-video-email-subject'];
        $message = $bingo_option_data['bingo-new-video-email-message'];
        
        //modify message - replace shortcode to value
        
        //link to user page
        if (isset($post_data['id'])){
            
            $user = get_user_by('id', $post_data['id']);
            
            if($user){
                $link = '<a href=' . get_home_url(null,'?author='.$post_data['id']) .'>' . $user->display_name.'('.$user->user_login.')' . '</a>';
                $message = str_replace('[user]', $link, $message);
            }
        }
        
        //link to post page
        if (isset($post_data['post_url'])){
            $link = '<a href=' . $post_data['post_url'] .'>Click Here</a>';
            
            $message = str_replace('[link]',$link, $message);
        }
        
        //link to post edit page
        if (isset($post_data['post_id'])){
            $link = '<a href=' . get_home_url(null,'my-video-edit/?edit='.$post_data['post_id'])  .'>Click Here</a>';
            
            $message = str_replace('[link_edit]',$link, $message);
        }
        
//        print_r($message);
        
        remove_all_filters( 'wp_mail_from' );
        remove_all_filters( 'wp_mail_from_name' );

        $headers[] = 'From: Liveinews <publisher@liveinews.com>';
        $headers[] = 'content-type: text/html';

        foreach ($to as $to2) {
            wp_mail($to2, $subject, $message, $headers);
        }


        remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
    }
    return true;
}

//send email to admin and moderators if it switch on in theme options
function send_email_to_available_users($post_data = ''){
    
    global $bingo_option_data;
    
    $to = array();

    if ($bingo_option_data['bingo-send-email-to-available']){
    
        $args = array(
            'blog_id'       => $GLOBALS['blog_id'],
            'meta_key'     => 'available_now',
            'meta_value'   => '1',
            'meta_compare' => '=',
            'fields'        => ['user_email'],
        );
        $available_users = get_users( $args );
        
        print_r($available_users);

        foreach( $available_users as $user ){
            array_push($to, $user->user_email);
        }
    }
    
    if (!empty($to)){
        $subject  = $bingo_option_data['bingo-available-mail-subject'];
        $message = $bingo_option_data['bingo-available-mail-message'];
        
        //modify message - replace shortcode to value
        
        //link to user page
        if (isset($post_data['id'])){
            
            $user = get_user_by('id', $post_data['id']);
            
            if($user){
                $link = '<a href=' . get_home_url(null,'?author='.$post_data['id']) .'>' . $user->display_name.'('.$user->user_login.')' . '</a>';
                $message = str_replace('[user]', $link, $message);
            }
        }
        
        //link to post page
        if (isset($post_data['post_url'])){
            $link = '<a href=' . $post_data['post_url'] .'>Click Here</a>';
            
            $message = str_replace('[link]',$link, $message);
        }
        
        //link to post edit page
        if (isset($post_data['location'])){
            $location = $post_data['location'];
            
            $message = str_replace('[location]',$location, $message);
        }
        
//        Agreement for cj
        
        $agreement = get_home_url(null,'agreement-for-cj/');
        $message = str_replace('[agreement]', $agreement, $message);
        
//        print_r($message);
        
        remove_all_filters( 'wp_mail_from' );
        remove_all_filters( 'wp_mail_from_name' );

        $headers[] = 'From: Liveinews <publisher@liveinews.com>';
        $headers[] = 'content-type: text/html';

        foreach ($to as $to2) {
            wp_mail($to2, $subject, $message, $headers);
        }
    }
    return true;
}