<?php

function email_list_form_show($atts){
    $atts = shortcode_atts( array(
        'title' => 'Enter your email',
        'button_text' => 'Subscribe'
    ), $atts );

    include('template/front_form.php');

}
add_shortcode('email_list_form', 'email_list_form_show');