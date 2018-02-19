<?php

if (is_user_logged_in()) {
    $user_ID = get_current_user_id();
    $user_type = get_user_meta($user_ID, "user_type", true);
    
    $page_id = get_the_ID();
    $page_uri = get_page_uri( $page_id );
    ?>
        <ul class="nav nav-tabs">
          <li <?php echo ($page_uri == 'my-account') ? 'class="active"' : ''; ?> ><a href="/my-account/">My info</a></li>
          
          <?php if ($user_type == "editor" || $user_type == "cj" || $user_type == "media") { ?>
            <li <?php  echo ($page_uri == 'my-videos') ? 'class="active"' : ''; ?> ><a href="/my-videos/" >My videos</a></li>
            <li <?php echo ($page_uri == 'default-record') ? 'class="active"' : ''; ?> ><a href="/default-record/" >Default Record Settings</a></li>
            <li <?php echo ($page_uri == 'upload-video') ? 'class="active"' : ''; ?> ><a href="/upload-video/" >Upload video</a></li>
          <?php } ?>
            
            <li <?php echo ($page_uri == 'default-view') ? 'class="active"' : ''; ?> ><a href="/default-view/">Default view settings</a></li>
            <?php if (current_user_can('administrator')){ ?>
                <li <?php echo ($page_uri == 'default-view-settings-for-other-users') ? 'class="active"' : ''; ?> ><a href="/default-view-settings-for-other-users/">Default view settings for unlogin users</a></li>
            <?php } ?>
          
        </ul>

    <?php 
    
}
?>