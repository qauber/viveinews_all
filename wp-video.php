<?php
session_start();

function is_md5($md5 ='') {
   return preg_match('/^[a-f0-9]{32}$/', $md5);
}

function redirect($url) {
 try {
  if (!headers_sent()) {
   @header('Location: ' . $url);
   exit;
} else
  throw new Exception();
 } catch (Exception $ex) {
  echo '<script type="text/javascript">';
  echo 'window.location.href="' . $url . '";';
  echo '</script>';
  echo '<noscript>';
  echo '<meta http-equiv="refresh" content="0;url=' . $url . '" />';
  echo '</noscript>';
  exit;
 }
}

function get_http_response_code($url) {
    $headers = get_headers($url);
    return substr($headers[0], 9, 3);
}

$wb_video = ((isset($_SESSION['wb_video']) && $_SESSION['wb_video'] !== NULL) ? $_SESSION['wb_video'] : '');
$id 	  = (is_md5($_GET['src']) == 1) ? $_GET['src'] : false;
$video 	  = $wb_video[$id];

//unset( $_SESSION['wb_video'][$id] );
header('Content-Type: video/mp4');
if(get_http_response_code($video) != "200"){
    echo "error";
}else{
	if( strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE OR strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== FALSE ) {
		echo @file_get_contents($video);
	} else {
		redirect( $video );
	}
}
die();

/*
MSIE - Internet explore
Trident - Internet explore
Firefox - 
Chrome - 
Opera Mini - 
Opera - 
Safari - 
*/
?>