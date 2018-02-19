<?php
/*
 * Plugin Name: wb-adsense
 * Plugin URI: http://webbook.com.ua/
 * Description: adding additional fields in the registration
 * Version: 0.1
 * Author: Web-Book
 */


class admin_page_option
{

    public function __construct(){
        add_action('admin_menu', array( $this, 'mt_add_pages'));
    }
    
    public function mt_add_pages() {
    add_options_page('WB banner block', 'WB banner block', 8, 'banner-block', array( $this, 'get_parametr_banner'));
    }

    public function get_parametr_banner() {
        $option_name = 'wb-banner-block';
      if (!empty($_POST['save-banner'])){ 
        $banner = array();
        $banner[] = esc_textarea($_POST['banner1']);
        $banner[] = esc_textarea($_POST['banner2']);
        $banner[] = esc_textarea($_POST['banner3']);
        $banner[] = esc_textarea($_POST['banner4']);
        $banner[] = esc_textarea($_POST['banner5']);
        $banner_data = serialize($banner);

         if ( get_option($option_name) ) {
            update_option($option_name, $banner_data);
         }else{
            add_option($option_name, $banner_data, 'Ссылки для баннеров.', 'yes');
         }
         echo 'Updated.'; 
      }
        $option = get_option($option_name);
        $option = unserialize($option);
        //var_dump($option);
         echo '
         <h2>Hello world</h2>
         <form action="" method="POST">
         Banner 200x250<br />
         <textarea name="banner1" cols="70" rows="3" style="resize: none;">'.wp_unslash($option[0]).'</textarea><br />
         Banner 200x250:<br />
         <textarea name="banner2" cols="70" rows="3" style="resize: none;">'.wp_unslash($option[1]).'</textarea><br />
         Banner 200x250:<br />
         <textarea name="banner3" cols="70" rows="3" style="resize: none;">'.wp_unslash($option[2]).'</textarea><br />
         Banner 200x250:<br />
         <textarea name="banner4" cols="70" rows="3" style="resize: none;">'.wp_unslash($option[3]).'</textarea><br />
         Banner 650x200:<br />
         <textarea name="banner5" cols="70" rows="3" style="resize: none;">'.wp_unslash($option[4]).'</textarea><br />
         <input type="submit" value="Save Changes" name="save-banner">
         </form>';
    }
}

$bn_cls = new admin_page_option();