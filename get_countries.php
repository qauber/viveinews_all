<?php

        $cyr  = array('а','б','в','г','д','e','ж','з','и','й','к','л','м','н','о','п','р','с','т','у', 
        'ф','х','ц','ч','ш','щ','ъ','ы','ь', 'ю','я','А','Б','В','Г','Д','Е','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь', 'Ю','Я' );
        $lat = array( 'a','b','v','g','d','e','zh','z','i','y','k','l','m','n','o','p','r','s','t','u',
        'f' ,'h' ,'ts' ,'ch','sh' ,'sht' ,'','y' ,'' ,'yu' ,'ya','A','B','V','G','D','E','Zh',
        'Z','I','Y','K','L','M','N','O','P','R','S','T','U',
        'F' ,'H' ,'Ts' ,'Ch','Sh' ,'Sht' ,'','Y' ,'' ,'Yu' ,'Ya' );

	$lang = 3; // russian
    $headerOptions = array(
        'http' => array(
            'method' => "GET",
            'header' => "Accept-language: en\r\n" .
            "Cookie: remixlang=$lang\r\n"
        )
    );

	if ($_GET['action'] == 'get_countries') {
	    $methodUrl = 'http://api.vk.com/method/database.getCountries?v=5.5&need_all=1&count=1000';
	    $streamContext = stream_context_create($headerOptions);
	    $json = file_get_contents($methodUrl, false, $streamContext);
	    echo $json;		
	} else if ($_GET['action'] == 'get_regions') {
		
		$country_id = $_GET['country_id'];	
		
	    $methodUrl = 'http://api.vk.com/method/database.getRegions?v=5.5&need_all=1&offset=0&count=1000&country_id=' . $country_id;
	    $streamContext = stream_context_create($headerOptions);
	    $json = file_get_contents($methodUrl, false, $streamContext);
	    
	    /* process */
	   	$res = json_decode($json,true);
	    foreach($res['response']['items'] as $num => &$item) {
			
				if (preg_match('/[А-Яа-яЁё]/u', $item['title']))
					$item['title'] = str_replace($cyr, $lat, $item['title']);				
		}
	    
	    $json = json_encode($res);
	    
	    echo $json;			
	} else if ($_GET['action'] == 'get_cities') {
		
		$country_id = $_GET['country_id'];	
		$region_id = $_GET['region_id'];	
		
	    $methodUrl = 'http://api.vk.com/method/database.getCities?v=5.5&need_all=1&offset=0&count=1000&country_id=' . $country_id . '&region_id='.$region_id . '&important=1';
	    
	    //echo $methodUrl;
	    
	    $streamContext = stream_context_create($headerOptions);
	    $json = file_get_contents($methodUrl, false, $streamContext);
	    
	    $res = json_decode($json,true);
	    
	    $all_items = $res['response']['items'];
	    
	    if ($res['response']['count'] > 1000) {
			$whole = ($res['response']['count'] / 1000);
			
			for ($i = 1; $i < $whole; $i++){
				
				$offset = $i * 1000;
				$methodUrl = 'http://api.vk.com/method/database.getCities?v=5.5&need_all=1&offset='.$offset.'&count=1000&country_id=' . $country_id . '&region_id='.$region_id . '&important=1';
				
	    		$streamContext = stream_context_create($headerOptions);
	    		$json = file_get_contents($methodUrl, false, $streamContext);		
	    		
	    		$res2 = json_decode($json,true);		
				
				$all_items = array_merge($all_items,$res2['response']['items']);
			}
		}
		$res['response']['items'] = $all_items;	    	
	    
	    foreach($res['response']['items'] as $num => &$item) {
	    	
	    	/*
	    	if ($item['area'])
				$item['title'] = $item['title'].', '.$item['area']; 
				
			if (preg_match('/[А-Яа-яЁё]/u', $item['title']))
				$item['title'] = str_replace($cyr, $lat, $item['title']);
			

			*/
			//if (!$item['area'] || (strpos($item['area'], $item['title'])!== false)) {
				if($item['area'])
					$item['title'] = $item['title'].', '.$item['area']; 
				if (preg_match('/[А-Яа-яЁё]/u', $item['title']))
					$item['title'] = str_replace($cyr, $lat, $item['title']);				
			//	unset($item['area']);				
			//} else {
			//	unset($res['response']['items'][$num]);
			//}
			

		}
	    
	    $json = json_encode($res);

	    
	   	echo $json;			
	}



    //$arr = json_decode($json, true);
    //echo 'Total countries count: ' . $arr['response']['count'] . ' loaded: ' . count($arr['response']['items']);
   // print_r($arr['response']['items']); 
    //print_r($arr); 
    
    
    
?>