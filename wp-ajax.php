<?php

function upload_video_ajax(){

if (!session_id())
    session_start();
set_time_limit(0);

$url = "http://liveinews.net/bootstrap.php?page=upload_p";

if (count($_POST) > 0) {
    $id = (isset($_SESSION["id_user"]) && preg_match("|^[\d]{1,11}$|", trim($_SESSION["id_user"]))) ? intval(trim($_SESSION["id_user"])) : false;
    $check = (!empty($_POST["preview"]) && preg_match("|^[\d]{1}$|", intval(trim($_POST["preview"])))) ? 1 : 0;

    if ($check == 1) {
        $start_time = explode(':', $_POST["start"]);
        $dur_time = explode(':', $_POST["duration"]);

        function get_time($src = array()) {
            if ($src[0] != 00) {
                $minut = intval($src[0] * 60);
            } else
                $minut = 0;
            if ($src[1] != 00) {
                $second = intval($src[1] * 1);
            } else
                $second = 0;
            return intval($minut + $second);
        }

        $start = get_time($start_time);
        $duration = get_time($dur_time);

        if ($start < 0)
            die(json_encode(array("comment" => "Start time minimal 0 seconds", "status" => 500)));

        if ($duration < 1)
            die(json_encode(array("comment" => "Duration time minimal 1 seconds", "status" => 500)));
    }
    if ($id === false OR $check === false) {
        die(json_encode(array("comment" => "Error data", "status" => 500)));
    }
    if ($_FILES["userfile"]["error"] > 0){
        die(json_encode(array("comment" => $_FILES["userfile"]["error"], "status" => 500)));
    }

    $file = $_FILES["userfile"]["tmp_name"];
    $file_size = @filesize($file);
    $type_array = array('mp4', 'avi', 'flv', '3gp', '3gpp', 'mkv', 'mov');
    $file_type = strtolower(substr(strrchr($_FILES["userfile"]['name'], '.'), 1));
    $min_size = 10 * 1024;
    $max_size = 100 * 1024 * 1024;
    if (!in_array($file_type, $type_array))
        die(json_encode(array("comment" => "Video type not supported", "status" => 500)));
    if ($file_size < $min_size)
        die(json_encode(array("comment" => "Your video must be greater than 10 KB", "status" => 500)));
    if ($file_size >= $max_size)
        die(json_encode(array("comment" => "Your video can not be over 100 MB", "status" => 500)));

    $fp = fopen($file, 'r');
    if ($ch = curl_init()) {
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_INFILE, $fp);
        curl_setopt($ch, CURLOPT_INFILESIZE, $file_size);
        curl_setopt($ch, CURLOPT_PUT, true);
        curl_setopt($ch, CURLOPT_UPLOAD, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5000);
        $result = curl_exec($ch);
        curl_close($ch);
        $filename = json_decode($result);
    }
    if ($filename->status != 200) {
        die(json_encode(array("comment" => $result, "status" => 500)));
    } else {
        
//        $curl = curl_init("http://liveinews.net/bootstrap.php?page=uploads");
        
        $config[CURLOPT_URL] = 'http://liveinews.net/bootstrap.php?page=uploads';
        $config[CURLOPT_POST] = 1;

        $datas = array(
            "id" => $id,
            "video" => $filename->new_file_name,
            "title" => $_POST["title"],
            "description" => $_POST["description"],
            "category" => array($_POST["category"]),
            "location" => $_POST["location"],
            "check" => $check,
            "start" => $start,
            "duration" => $duration
        );
        $data = json_encode($datas);
        
        $config[CURLOPT_POSTFIELDS] = $data;
        $config[CURLOPT_CONNECTTIMEOUT] = 0;
        $config[CURLOPT_TIMEOUT] = 900000;
        $config[CURLOPT_FRESH_CONNECT] = 1;
        $config[CURLOPT_RETURNTRANSFER] = 1;

        $curl = curl_init();
        
        curl_setopt_array($curl, $config);
        
        $result = curl_exec($curl);
        curl_close($curl);
        
        print_r($result);
        
        $result_decode = json_decode($result);
        
        send_email_to_moderator($result_decode['post_url']);
        die();
    }
} else
    die(json_encode(array("comment" => "Error", "status" => 500)));

}

add_action('wp_ajax_upload_video_ajax', 'upload_video_ajax');
add_action('wp_ajax_nopriv_upload_video_ajax', 'upload_video_ajax');
?>