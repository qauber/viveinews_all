<?php

function xxl_fixing($content){

    $block = join("|",array('list','item','tabs','tab','progress','download','accordion','aitem','timeline','titem','portfolio','portfolio_grid','button','profile','xxl_video','row','column','one_half','one_half_last','one_third','one_third_last','two_third','two_third_last','one_fourth','one_fourth_last','three_fourth','three_fourth_last','one_fourth_second','one_fourth_third','one_half_second','one_third_second','one_column') );

    $result = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);
    $result = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$result);

    $Old     = array( '<br />', '<br>' );
    $New     = array( '','' );
    $result = str_replace( $Old, $New, $result );


    return $result;

}

add_filter('the_content', 'xxl_fixing');
add_filter('the_content', 'do_shortcode', 7);




function xxl_column_shortcode( $atts , $content = null ) {


    extract( shortcode_atts( array(
      "lg"          => false,
      "md"          => false,
      "sm"          => false,
      "xs"          => false,
      "offset_lg"   => false,
      "offset_md"   => false,
      "offset_sm"   => false,
      "offset_xs"   => false,
      "pull_lg"     => false,
      "pull_md"     => false,
      "pull_sm"     => false,
      "pull_xs"     => false,
      "push_lg"     => false,
      "push_md"     => false,
      "push_sm"     => false,
      "push_xs"     => false,

    ), $atts ) );

    $class  = '';
    $class .= ( $lg )             ? ' col-lg-' . $lg : '';
    $class .= ( $md )             ? ' col-md-' . $md : '';
    $class .= ( $sm )             ? ' col-sm-' . $sm : '';
    $class .= ( $xs )             ? ' col-xs-' . $xs : '';
    $class .= ( $offset_lg )      ? ' col-lg-offset-' . $offset_lg : '';
    $class .= ( $offset_md )      ? ' col-md-offset-' . $offset_md : '';
    $class .= ( $offset_sm )      ? ' col-sm-offset-' . $offset_sm : '';
    $class .= ( $offset_xs )      ? ' col-xs-offset-' . $offset_xs : '';
    $class .= ( $pull_lg )        ? ' col-lg-pull-' . $pull_lg : '';
    $class .= ( $pull_md )        ? ' col-md-pull-' . $pull_md : '';
    $class .= ( $pull_sm )        ? ' col-sm-pull-' . $pull_sm : '';
    $class .= ( $pull_xs )        ? ' col-xs-pull-' . $pull_xs : '';
    $class .= ( $push_lg )        ? ' col-lg-push-' . $push_lg : '';
    $class .= ( $push_md )        ? ' col-md-push-' . $push_md : '';
    $class .= ( $push_sm )        ? ' col-sm-push-' . $push_sm : '';
    $class .= ( $push_xs )        ? ' col-xs-push-' . $push_xs : '';


    return '<div class="'.$class.'">' . do_shortcode($content) . '</div>';


}
//add_shortcode( 'column', 'xxl_column_shortcode' );





/**
*######################################################################
*#  list item
*######################################################################
*/


// Add Shortcode
function xxl_list_shortcode( $atts , $content = null ) {

	// Attributes
	$atts = extract( shortcode_atts(
		array(
			'type' => 'check',
		), $atts )
	);

	if( $type == 'check'){
		$class = "b-check-list";
	}
	else{
		$class = " ";
	}


	if ($type == "number"){
		return '<ol>'. do_shortcode($content) . '</ol>';
	}


	return '<ul class="'.$class.'">'. do_shortcode($content) . '</ul>';

}
add_shortcode( 'list', 'xxl_list_shortcode' );





function xxl_li_item_shortcode( $atts , $content = null ) {
	$atts = extract( shortcode_atts( array( 'default'=>'values' ),$atts ) );

	return '<li>'.do_shortcode($content).'</li>';
}
add_shortcode( 'item','xxl_li_item_shortcode' );



/**
*######################################################################
*#  Tabs
*######################################################################
*/


$tabs_divs = '';

function xxl_tabs_group_shortcode($atts, $content = null ) {
    global $tabs_divs;

    extract(shortcode_atts(array(
       'type' => 'top'
    ), $atts));

	$class= '';
	if($type == 'vertical'){
		$class= ' vertical';
	}

    $tabs_divs = '';

    $output = '<div class="responsive-tabs '.$class.'"><ul class="nav nav-tabs" ';
    $output.='>'.do_shortcode($content).'</ul>';
    $output.= '<div class="tab-content">'.$tabs_divs.'</div></div>';

    return $output;
}


function xxl_tab_shortcode($atts, $content = null) {
    global $tabs_divs;

    extract(shortcode_atts(array(
        'id' => '',
        'title' => '',
        'active' => false
    ), $atts));

    $class= '';
    if($active == 'true'){
    	$class = ' active';
    }


    if(empty($id))
        $id = 'dummy-tab-'.rand(100,999);

    $output = '
        <li class="'.$class.'">
            <a href="#'.$id.'">'.$title.'</a>
        </li>
    ';

    $tabs_divs.= '<li class="tab-pane '.$class.'" id="'.$id.'">'.$content.'</li>';

    return $output;
}

add_shortcode('tabs', 'xxl_tabs_group_shortcode');
add_shortcode('tab', 'xxl_tab_shortcode');




/**
*######################################################################
*#  progress
*######################################################################
*/




function xxl_progress_shortcode( $atts ) {
	$atts = extract( shortcode_atts( array( 'score'=>'60', 'title'=>'', 'type'=>'' ,'text' => '' ),$atts ) );

	$class = '';
	$button = '';
	$innertext ='';
	$output = '';

	if($type == 'two'){
		$class = " toggle";
		$button = '<a href="#" class="progress-bar-toggle"></a>';
		$innertext = '<div class="progress-bar-content" style="display: none;">'.$text.'</div>';
	}elseif( $type == 'three'){
		$class = " style-2";
	}

	if ($type == 'four'){
		$output.='<div class="progress-circle" data-progress="'.$score.'">';
		$output.='<h3>'.$title.'</h3></div>';

	}elseif($type == 'five'){
    $class = " toggle style-2";
    $button = '<a href="#" class="progress-bar-toggle"></a>';
    $innertext = '<div class="progress-bar-content" style="display: none;">'.$text.'</div>';
  }else{


	$output.= '<div class="progress-bar'.$class.'" data-progress="'.$score.'">';
	$output.= $button;
	$output.= '<h6 class="progress-bar-title">'.$title.'</h6>';
	$output.= '<div class="progress-bar-inner"><span></span></div>';
	$output.= $innertext;
	$output.= '</div>';

	}


	return $output;

	// do shortcode actions here
}
add_shortcode( 'progress','xxl_progress_shortcode' );







/**
*######################################################################
*#  download
*######################################################################
*/





function download_shortcode( $atts ) {
	$atts = extract( shortcode_atts( array( 'title'=>'', 'description'=>'', 'extension'=>'', 'default'=>'values' ),$atts ) );

 	$output = '<a href="#" class="b-download">';
 	$output.='<span class="e-download-ico"><span><i class="fa fa-download"></i> <span>Download</span></span></span>';
 	$output.='<span class="e-download-title">'.$title.'</span>';
 	$output.='<span class="e-download-description">'.$description.'</span>';
 	$output.='<span class="e-download-extension"><span>'.$extension.'</span></span></a>';

 	return $output;
}
add_shortcode( 'download','download_shortcode' );




/**
*######################################################################
*#  accordion
*######################################################################
*/



function xxl_accordion($atts, $content = null){
  extract(shortcode_atts(array(
    'id'=>''
    ), $atts));

  $content = preg_replace('/<br class="nc".\/>/', '', $content);
  $result = '<div class="accordion"><ul>';
  $result .= do_shortcode($content );
  $result .= '</ul></div>';

  return force_balance_tags( $result );
}
add_shortcode('accordion', 'xxl_accordion');



function xxl_accordion_item($atts, $content = null){
  extract(shortcode_atts(array(

    'title'=>'',
    'subtitle'=>''

    ), $atts));

  $content = preg_replace('/<br class="nc".\/>/', '', $content);


  $result = '<li>';
  $result.='<a href="#">'.$title.'</a> ';
  $result.='<div style="display: none;">'.do_shortcode($content).'</div></li>';



  return force_balance_tags( $result );
}
add_shortcode('aitem', 'xxl_accordion_item');





/**
*######################################################################
*#  Timeline
*######################################################################
*/




function xxl_timeline( $atts , $content = null ) {
	$atts = extract( shortcode_atts( array('default'=>''),$atts ) );

	$output = '<ul class="b-timeline">'.do_shortcode( $content ).'</ul>';

	return $output;
}
add_shortcode( 'timeline','xxl_timeline' );


function xxl_timeline_item( $atts ) {
	$atts = extract( shortcode_atts( array(  'title'=>'','subtitle'=>'','position'=>'' ),$atts ) );
	$output = '';
	$output.='<li class="e-timeline-item">';
	$output.='<span class="e-timeline-item-label">'.$position.'.</span>';
	$output.='<h4 class="e-timeline-item-title">'.$title.'</h4>';
	$output.='<h5 class="e-timeline-item-subtitle">'.$subtitle.'</h5>';
	$output.='</li>';

	return $output;
}
add_shortcode( 'titem','xxl_timeline_item' );




/**
*######################################################################
*#  portfolio
*######################################################################
*/



function portfolio_shortcode( $atts ) {
	$atts = extract( shortcode_atts( array( 'item'=>'2' ),$atts ) );

	$portfolio_args = array(
		'post_type' => 'portfolio',	'post_status' => 'publish','orderby' => 'date',	'order' => 'DESC', 'posts_per_page' => $item, 'cache_results' => false, 'no_found_rows' => true,
	);
	$portfolio_query = new WP_Query( $portfolio_args );



	$output='<div class="row">';
	while ( $portfolio_query->have_posts() ){

		$portfolio_query->the_post();
		$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'huge');
		//$categories = get_the_category();
     //   $categories = get_terms('skill');
        $categories = get_the_terms( get_the_ID(),'skill' );
		$tags = get_tags();

		$output.='<div class="col-md-3">';
		$output.='<div class="b-project"><div class="e-project-header">';
		$output.='<a class="e-project-thumb m-lightbox" href="'.$large_image_url[0].'" data-lightbox-group="dummy-projects">';
		$output.='<img alt="" src="'.$large_image_url[0].'"><span class="e-overlay"><span><span><i class="fa fa-search"></i> Zoom In</span></span></span></a>';
		$output.='<ul class="m-custom-list e-project-tags">';

		if($tags){ foreach($tags as $tag){
		 $output.= '<li>'.$tag->name.' </li>';
		} }

		$output.='</ul></div><div class="e-project-content">';
		$output.='<h4 class="e-project-title"><a href="#">'.get_the_title().'</a></h4>';
		$output.='<h5 class="e-project-category">';

 		if($categories){ foreach($categories as $category){
 		 	$output.= ' '.$category->name.' ';

 		} }
		$output.='</h5></div></div></div>';


	}

	wp_reset_query();

	$output.='</div>';

	return do_shortcode($output);
}
add_shortcode( 'portfolio','portfolio_shortcode' );







/**
*######################################################################
*#  Button
*######################################################################
*/



// <a class="b-button"><i class="fa fa-plus"></i> Icon Button</a>
// <a class="b-button m-color-2"><i class="fa fa-plus"></i> Icon Button</a>
// <a class="b-button m-color-3 m-type-2"><span>Verified Skill Tag</span> <i class="fa fa-check"></i></a>


//[button type="skill" icon="fa fa-check" color="three"]Hello[/button]

// [button color="two" icon="fa fa-check"] one button [/button]

function xxl_button( $atts ,$content = null ) {
	$atts = extract( shortcode_atts( array('target'=>'', 'url'=> '', 'color'=>'' ,'icon' => '' , 'type' => '' ),$atts ) );

	$add_icon ='';
	if(!empty($icon)){
		$add_icon='<i class="fa '.$icon.'"></i>';
	}

    if (!preg_match("~^(?:f|ht)tps?://~i", $url) ) {
        $url = "http://" . $url;
    }

	$newcolor = '';

	if($color == 'two'){
		$newcolor = 'm-color-2';
	}
	elseif($color == 'three'){
		$newcolor = 'm-color-3';
	}




	if($type == 'skill'){
        $newcolor = 'm-color-3';
		$output = '<a href="'.$url.'" target="'.$target.'" class="b-button m-type-2 '.$newcolor.'"><span>'.$content.'</span>'.$add_icon.'</a>';
	}else{
		$output = '<a  href="'.$url.'" target="'.$target.'" class="b-button '.$newcolor.'">'.$add_icon.$content.'</a>';
	}





	return $output;

}
add_shortcode( 'button','xxl_button' );








function profile_shortcode( $atts ,$content = null ) {
	$atts = extract( shortcode_atts( array( 'name'=>'','birth'=>'','location' =>'' ,'status'=>'','degree'=>'','permit'=>'','website'=>'' ),$atts ) );

	$output = '<div class="b-profile-details"><dl>';

	if(!empty($name)){
		$output.= '<dt>Name</dt>';
		$output.= '<dd>'.$name.'</dd>';
	}
	if(!empty($birth)){
		$output.= '<dt>Birth</dt>';
		$output.= '<dd>'.$birth.'</dd>';
	}

	if(!empty($location)){
		$output.= '<dt>Location</dt>';
		$output.= '<dd>'.$location.'</dd>';
	}



	if(!empty($status)){
		$output.= '<dt>Status</dt>';
		$output.= '<dd>'.$status.'</dd>';
	}

	if(!empty($degree)){
		$output.= '<dt>Degree</dt>';
		$output.= '<dd>'.$degree.'</dd>';
	}

	if(!empty($permit)){
		$output.= '<dt>Work Permit</dt>';
		$output.= '<dd>'.$permit.'</dd>';
	}


	if(!empty($website)){

        if (!preg_match("~^(?:f|ht)tps?://~i", $website) ) {
            $website = "http://" . $website;
        }


		$output.= '<dt>Website</dt>';
		$output.= '<dd><a href="'.$website.'"> '.$website.'</a></dd>';
	}


	$output.= '</dl></div>';

	return $output;
}
add_shortcode( 'profile','profile_shortcode' );









/**
*######################################################################
*#  video  [video type="vimeo" video_id=""]
*######################################################################
*/



function xxl_video($atts){
  if(isset($atts['type'])){
    switch($atts['type']){
      case 'youtube':
        return youtube($atts);
        break;
      case 'vimeo':
        return vimeo($atts);
        break;
      case 'dailymotion':
        return dailymotion($atts);
        break;
    }
  }
  return '';
}
add_shortcode('xxl_video', 'xxl_video');


function vimeo($atts) {
  extract(shortcode_atts(array(
    'video_id'  => '',
    'width' => false,
    'height' => false,
    'title' => 'false',
  ), $atts));

  if ($height && !$width) $width = intval($height * 16 / 9);
  if (!$height && $width) $height = intval($width * 9 / 16);
  if (!$height && !$width){
    $height = '400';
    $width = '650';
  }
  if($title!='false'){
    $title = 1;
  }else{
    $title = 0;
  }

  if (!empty($video_id) && is_numeric($video_id)){
    return "<div class='video_frame'><iframe src='http://player.vimeo.com/video/$video_id?title={$title}&amp;byline=0&amp;portrait=0' width='$width' height='$height' frameborder='0'></iframe></div>";
  }
}

function youtube($atts, $content=null) {
  extract(shortcode_atts(array(
    'video_id'  => '',
    'width'   => false,
    'height'  => false,
  ), $atts));

  if ($height && !$width) $width = intval($height * 16 / 9);
  if (!$height && $width) $height = intval($width * 9 / 16) + 25;
  if (!$height && !$width){
    $height = '400';
    $width = '650';
  }

  if (!empty($video_id)){
    return "<div class='video_frame'><iframe src='http://www.youtube.com/embed/$video_id' width='$width' height='$height' frameborder='0'></iframe></div>";
  }
}

function dailymotion($atts, $content=null) {

  extract(shortcode_atts(array(
    'video_id'  => '',
    'width'   => false,
    'height'  => false,
  ), $atts));

  if ($height && !$width) $width = intval($height * 16 / 9);
  if (!$height && $width) $height = intval($width * 9 / 16);
  if (!$height && !$width){
    $height = '400';
    $width = '650';
  }

  if (!empty($video_id)){
    return "<div class='video_frame'><iframe src=http://www.dailymotion.com/embed/video/$video_id?width=$width&theme=none&foreground=%23F7FFFD&highlight=%23FFC300&background=%23171D1B&start=&animatedTitle=&iframe=1&additionalInfos=0&autoPlay=0&hideInfos=0' width='$width' height='$height' frameborder='0'></iframe></div>";
  }
}









/**
 *######################################################################
 *#  row
 *######################################################################
 */

function xxl_theme_row($params, $content = null) {
    extract(shortcode_atts(array(
        'class' => ''
    ), $params));
    $result = '<div class="row ' . $class . '">';
    //echo '<textarea>'.$content.'</textarea>';
    $content = str_replace("]<br />", ']', $content);
    $content = str_replace("<br />\n[", '[', $content);
    $result .= do_shortcode($content);
    $result .= '</div>';

    return $result;
}

add_shortcode('row', 'xxl_theme_row');


/**
 *######################################################################
 *#  column
 *######################################################################
 */

function xxl_theme_column($params, $content = null) {
    extract(shortcode_atts(array(
        'md' => '',
        'sm' => '',
        'xs' => '',
        'lg' => '',
        'mdoff' => '',
        'smoff' => '',
        'xsoff' => '',
        'lgoff' => '',
        'mdhide' => '',
        'smhide' => '',
        'xshide' => '',
        'lghide' => '',
        'mdclear' => '',
        'smclear' => '',
        'xsclear' => '',
        'lgclear' => '',
        'off'=>''
    ), $params));


    $arr = array('md', 'xs', 'sm');
    $classes = array();
    foreach ($arr as $k => $aa) {
        if (${$aa} == 12 || ${$aa} == '') {
            $classes[] = 'col-' . $aa . '-12';
        } else {
            $classes[] = 'col-' . $aa . '-' . ${$aa};
        }
    }
    $arr2 = array('mdoff', 'smoff', 'xsoff', 'lgoff');
    foreach ($arr2 as $k => $aa) {
        $nn = str_replace('off', '', $aa);
        if (${$aa} == 0 || ${$aa} == '') {
            //$classes[] = '';
        } else {
            $classes[] = 'col-' . $nn . '-offset-' . ${$aa};
        }
    }
    $arr2 = array('mdhide', 'smhide', 'xshide', 'lghide');
    foreach ($arr2 as $k => $aa) {
        $nn = str_replace('hide', '', $aa);
        if (${$aa} == 'yes') {
            $classes[] = 'hidden-' . $nn;
        }
    }
    $arr2 = array('mdclear', 'smclear', 'xsclear', 'lgclear');
    foreach ($arr2 as $k => $aa) {
        $nn = str_replace('clear', '', $aa);
        if (${$aa} == 'yes') {
            $classes[] = 'clear-' . $nn;
        }
    }
    if ($off != '') {
        $classes[] = 'col-lg-offset-'.$off;
    }

    if ($off != '') {
        $classes[] = 'col-lg-offset-'.$off;
    }
    $result = '<div class="col-lg-' . $lg . ' ' . implode(' ', $classes) . '">';
    $result .= do_shortcode($content);
    $result .= '</div>';

    return $result;
}

add_shortcode('column', 'xxl_theme_column');


function xxl_theme_one_half($params, $content = null) {
    extract(shortcode_atts(array(
        'md' => '',
        'sm' => '',
        'xs' => '',
        'off' => ''
    ), $params));
    if ($md == 12) {
        $mds = '';
    } else {
        $mds = 'col-md-' . $md;
    }
    if ($sm == 12) {
        $sms = '';
    } else {
        $sms = 'col-sm-' . $sm;
    }
    if ($xs == 12) {
        $xss = '';
    } else {
        $xss = 'col-xs-' . $xs;
    }
    $result = '<div class="col-lg-6 ' . $mds . ' ' . $sms . ' ' . $xss . ' col-lg-offset-' . $off . '  one-half">';
    $result .= do_shortcode($content);
    $result .= '</div>';

    return $result;
}

add_shortcode('one_half', 'xxl_theme_one_half');

function xxl_theme_one_half_last($params, $content = null) {
    extract(shortcode_atts(array(
        'md' => '',
        'sm' => '',
        'xs' => '',
        'off' => ''
    ), $params));
    if ($md == 12) {
        $mds = '';
    } else {
        $mds = 'col-md-' . $md;
    }
    if ($sm == 12) {
        $sms = '';
    } else {
        $sms = 'col-sm-' . $sm;
    }
    if ($xs == 12) {
        $xss = '';
    } else {
        $xss = 'col-xs-' . $xs;
    }
    $result = '<div class="col-lg-6 ' . $mds . ' ' . $sms . ' ' . $xss . ' col-lg-offset-' . $off . ' one-half-last">';
    $result .= do_shortcode($content);
    $result .= '</div>';

    return $result;
}

add_shortcode('one_half_last', 'xxl_theme_one_half_last');

/* * *********************************************************
 * THIRD
 * ********************************************************* */

function xxl_theme_one_third($params, $content = null) {
    extract(shortcode_atts(array(
        'md' => '',
        'sm' => '',
        'xs' => '',
        'off' => ''
    ), $params));
    if ($md == 12) {
        $mds = '';
    } else {
        $mds = 'col-md-' . $md;
    }
    if ($sm == 12) {
        $sms = '';
    } else {
        $sms = 'col-sm-' . $sm;
    }
    if ($xs == 12) {
        $xss = '';
    } else {
        $xss = 'col-xs-' . $xs;
    }
    $result = '<div class="sc-column col-lg-4 ' . $mds . ' ' . $sms . ' ' . $xss . ' col-lg-offset-' . $off . ' ">'; //one-third
    $result .= do_shortcode($content);
    $result .= '</div>';

    return $result;
}

add_shortcode('one_third', 'xxl_theme_one_third');

function xxl_theme_one_third_last($params, $content = null) {
    extract(shortcode_atts(array(
        'md' => '',
        'sm' => '',
        'xs' => '',
        'off' => ''
    ), $params));
    if ($md == 12) {
        $mds = '';
    } else {
        $mds = 'col-md-' . $md;
    }
    if ($sm == 12) {
        $sms = '';
    } else {
        $sms = 'col-sm-' . $sm;
    }
    if ($xs == 12) {
        $xss = '';
    } else {
        $xss = 'col-xs-' . $xs;
    }
    $result = '<div class="col-lg-4 ' . $mds . ' ' . $sms . ' ' . $xss . ' col-lg-offset-' . $off . '  column-last">'; // one-third-last
    $result .= do_shortcode($content);
    $result .= '</div>';

    return $result;
}

add_shortcode('one_third_last', 'xxl_theme_one_third_last');

function xxl_theme_two_third($params, $content = null) {
    extract(shortcode_atts(array(
        'md' => '',
        'sm' => '',
        'xs' => '',
        'off' => ''
    ), $params));
    if ($md == 12) {
        $mds = '';
    } else {
        $mds = 'col-md-' . $md;
    }
    if ($sm == 12) {
        $sms = '';
    } else {
        $sms = 'col-sm-' . $sm;
    }
    if ($xs == 12) {
        $xss = '';
    } else {
        $xss = 'col-xs-' . $xs;
    }
    $result = '<div class=" col-lg-8 ' . $mds . ' ' . $sms . ' ' . $xss . ' col-lg-offset-' . $off . ' ">'; //two-third
    $result .= do_shortcode($content);
    $result .= '</div>';

    return $result;
}

add_shortcode('two_third', 'xxl_theme_two_third');

function xxl_theme_two_third_last($params, $content = null) {
    extract(shortcode_atts(array(
        'md' => '',
        'sm' => '',
        'xs' => '',
        'off' => ''
    ), $params));
    if ($md == 12) {
        $mds = '';
    } else {
        $mds = 'col-md-' . $md;
    }
    if ($sm == 12) {
        $sms = '';
    } else {
        $sms = 'col-sm-' . $sm;
    }
    if ($xs == 12) {
        $xss = '';
    } else {
        $xss = 'col-xs-' . $xs;
    }
    $result = '<div class="col-lg-8 ' . $mds . ' ' . $sms . ' ' . $xss . ' col-lg-offset-' . $off . '  column-last ">'; //two-third-last
    $result .= do_shortcode($content);
    $result .= '</div>';

    return $result;
}

add_shortcode('two_third_last', 'xxl_theme_two_third_last');

/* * *********************************************************
 * FOURTH
 * ********************************************************* */

function xxl_theme_one_fourth($params, $content = null) {
    extract(shortcode_atts(array(
        'md' => '',
        'sm' => '',
        'xs' => '',
        'off' => ''
    ), $params));
    if ($md == 12) {
        $mds = '';
    } else {
        $mds = 'col-md-' . $md;
    }
    if ($sm == 12) {
        $sms = '';
    } else {
        $sms = 'col-sm-' . $sm;
    }
    if ($xs == 12) {
        $xss = '';
    } else {
        $xss = 'col-xs-' . $xs;
    }
    $result = '<div class="col-lg-3 ' . $mds . ' ' . $sms . ' ' . $xss . ' col-lg-offset-' . $off . ' one-fourth">';
    $result .= do_shortcode($content);
    $result .= '</div>';

    return $result;
}

add_shortcode('one_fourth', 'xxl_theme_one_fourth');

function xxl_theme_one_fourth_last($params, $content = null) {
    extract(shortcode_atts(array(
        'md' => '',
        'sm' => '',
        'xs' => '',
        'off' => ''
    ), $params));
    if ($md == 12) {
        $mds = '';
    } else {
        $mds = 'col-md-' . $md;
    }
    if ($sm == 12) {
        $sms = '';
    } else {
        $sms = 'col-sm-' . $sm;
    }
    if ($xs == 12) {
        $xss = '';
    } else {
        $xss = 'col-xs-' . $xs;
    }
    $result = '<div class="col-lg-3 ' . $mds . ' ' . $sms . ' ' . $xss . ' col-lg-offset-' . $off . ' column-last one-fourth-last">';
    $result .= do_shortcode($content);
    $result .= '</div>';

    return $result;
}

add_shortcode('one_fourth_last', 'xxl_theme_one_fourth_last');

function xxl_theme_three_fourth($params, $content = null) {
    extract(shortcode_atts(array(
        'md' => '',
        'sm' => '',
        'xs' => '',
        'off' => ''
    ), $params));
    if ($md == 12) {
        $mds = '';
    } else {
        $mds = 'col-md-' . $md;
    }
    if ($sm == 12) {
        $sms = '';
    } else {
        $sms = 'col-sm-' . $sm;
    }
    if ($xs == 12) {
        $xss = '';
    } else {
        $xss = 'col-xs-' . $xs;
    }
    $result = '<div class="col-lg-3 ' . $mds . ' ' . $sms . ' ' . $xss . ' col-lg-offset-' . $off . '  three-fourth">';
    $result .= do_shortcode($content);
    $result .= '</div>';

    return $result;
}

add_shortcode('three_fourth', 'xxl_theme_three_fourth');

function xxl_theme_three_fourth_last($params, $content = null) {
    extract(shortcode_atts(array(
        'md' => '',
        'sm' => '',
        'xs' => '',
        'off' => ''
    ), $params));
    if ($md == 12) {
        $mds = '';
    } else {
        $mds = 'col-md-' . $md;
    }
    if ($sm == 12) {
        $sms = '';
    } else {
        $sms = 'col-sm-' . $sm;
    }
    if ($xs == 12) {
        $xss = '';
    } else {
        $xss = 'col-xs-' . $xs;
    }
    $result = '<div class="col-lg-6  ' . $mds . ' ' . $sms . ' ' . $xss . ' col-lg-offset-' . $off . ' column-last three-fourth-last">';
    $result .= do_shortcode($content);
    $result .= '</div>';

    return $result;
}

add_shortcode('three_fourth_last', 'xxl_theme_three_fourth_last');

function xxl_theme_one_fourth_second($params, $content = null) {
    extract(shortcode_atts(array(
        'md' => '',
        'sm' => '',
        'xs' => '',
        'off' => ''
    ), $params));
    if ($md == 12) {
        $mds = '';
    } else {
        $mds = 'col-md-' . $md;
    }
    if ($sm == 12) {
        $sms = '';
    } else {
        $sms = 'col-sm-' . $sm;
    }
    if ($xs == 12) {
        $xss = '';
    } else {
        $xss = 'col-xs-' . $xs;
    }
    $result = '<div class="col-lg-3  ' . $mds . ' ' . $sms . ' ' . $xss . ' col-lg-offset-' . $off . ' one-fourth-second">';
    $result .= do_shortcode($content);
    $result .= '</div>';

    return $result;
}

add_shortcode('one_fourth_second', 'xxl_theme_one_fourth_second');

function xxl_theme_one_fourth_third($params, $content = null) {
    extract(shortcode_atts(array(
        'md' => '',
        'sm' => '',
        'xs' => '',
        'off' => ''
    ), $params));
    if ($md == 12) {
        $mds = '';
    } else {
        $mds = 'col-md-' . $md;
    }
    if ($sm == 12) {
        $sms = '';
    } else {
        $sms = 'col-sm-' . $sm;
    }
    if ($xs == 12) {
        $xss = '';
    } else {
        $xss = 'col-xs-' . $xs;
    }

    $result = '<div class="col-lg-3  ' . $mds . ' ' . $sms . ' ' . $xss . ' col-lg-offset-' . $off . ' one-fourth-third">';
    $result .= do_shortcode($content);
    $result .= '</div>';

    return $result;
}

add_shortcode('one_fourth_third', 'xxl_theme_one_fourth_third');

function xxl_theme_one_half_second($params, $content = null) {
    extract(shortcode_atts(array(
        'md' => '',
        'sm' => '',
        'xs' => '',
        'off' => ''
    ), $params));
    if ($md == 12) {
        $mds = '';
    } else {
        $mds = 'col-md-' . $md;
    }
    if ($sm == 12) {
        $sms = '';
    } else {
        $sms = 'col-sm-' . $sm;
    }
    if ($xs == 12) {
        $xss = '';
    } else {
        $xss = 'col-xs-' . $xs;
    }
    $result = '<div class="col-lg-6  ' . $mds . ' ' . $sms . ' ' . $xss . ' col-lg-offset-' . $off . ' one-half-second">';
    $result .= do_shortcode($content);
    $result .= '</div>';

    return $result;
}

add_shortcode('one_half_second', 'xxl_theme_one_half_second');

function xxl_theme_one_third_second($params, $content = null) {
    extract(shortcode_atts(array(
        'md' => '',
        'sm' => '',
        'xs' => '',
        'off' => ''
    ), $params));
    if ($md == 12) {
        $mds = '';
    } else {
        $mds = 'col-md-' . $md;
    }
    if ($sm == 12) {
        $sms = '';
    } else {
        $sms = 'col-sm-' . $sm;
    }
    if ($xs == 12) {
        $xss = '';
    } else {
        $xss = 'col-xs-' . $xs;
    }
    $result = '<div class="col-lg-4  ' . $mds . ' ' . $sms . ' ' . $xss . ' col-lg-offset-' . $off . ' one-third-second">';
    $result .= do_shortcode($content);
    $result .= '</div>';

    return $result;
}

add_shortcode('one_third_second', 'xxl_theme_one_third_second');

function xxl_theme_one_column($params, $content = null) {
    extract(shortcode_atts(array(
        'md' => '',
        'sm' => '',
        'xs' => '',
        'off' => ''
    ), $params));
    if ($md == 12) {
        $mds = '';
    } else {
        $mds = 'col-md-' . $md;
    }
    if ($sm == 12) {
        $sms = '';
    } else {
        $sms = 'col-sm-' . $sm;
    }
    if ($xs == 12) {
        $xss = '';
    } else {
        $xss = 'col-xs-' . $xs;
    }
    $result = '<div class="col-lg-12  ' . $mds . ' ' . $sms . ' ' . $xss . ' col-lg-offset-' . $off . ' one-column">';
    $result .= do_shortcode($content);
    $result .= '</div>';

    return $result;
}

add_shortcode('one_column', 'xxl_theme_one_column');











/* * *********************************************************
 * By PROBAL
 * ********************************************************* */


/* * *********************************************************
 * buy theme block
 * ********************************************************* */


function bingo_buy_theme( $atts, $content ){
  $atts = shortcode_atts(
    array(
      'image'   =>  '',
      'puchase_text'  => 'Purchase Bingo',
      'content' =>  !empty($content) ? $content : 'lorem ipsum'
    ), $atts
  );

  extract($atts);

  if($image == ''){
    $image = IMAGES . '/content/call-to-action-icon.png';
  }

  $output  =  '<div class="call-to-action-section">';
  $output.=   '<div class="icon">';
  $output.=    '<img src=" ' . $image . ' " alt="">';
  $output.=      '</div>';
  $output.=      '<div class="text css-table">';
  $output.=          '<div class="css-table-cell">';
  $output.=            '<p>' . $content . '</p>';
  $output.=          '</div>';
  $output.=          '<div class="css-table-cell">';
  $output.=            '<a href="#" class="btn btn-default"><i class="fa fa-shopping-cart"></i>' . $puchase_text . '</a>';
  $output.=        '</div>';
  $output.=      '</div>';
  $output.=    '</div>';

  return $output;

}
add_shortcode( 'buy_theme', 'bingo_buy_theme' );


/* * *********************************************************
 * Project block
 * ********************************************************* */
function bingo_project_block( $atts, $content ){
  $atts = shortcode_atts(
    array(
      'type'   =>  '',
      'title'   =>  '',
      'content' =>  !empty($content) ? $content : 'lorem ipsum'
    ), $atts
  );

  extract($atts);

  if($type == 'one'){
    $class = " crowdfunding";
    $icons = '<div class="progress-bar" data-progress="60"><div class="progress-bar-inner"><span></span></div></div>';
  }elseif($type == 'two'){
    $class = " rating";
    $icons = '<ul class="stars"><li><i class="fa fa-star"></i></li><li><i class="fa fa-star"></i></li><li><i class="fa fa-star"></i></li><li><i class="fa fa-star-half-o"></i></li><li><i class="fa fa-star-o"></i></li></ul>';
  }elseif($type == 'three'){
    $class = " selling";
    $icons = '<i class="fa fa-lightbulb-o"></i>+<i class="fa fa-smile-o"></i>=<i class="fa fa-money"></i>';
  }else{
    $class = " auction";
    $icons = '<i class="fa fa-usd"></i><i class="fa fa-usd"></i><i class="fa fa-usd middle"></i><i class="fa fa-usd"></i><i class="fa fa-usd"></i>';
  }

  $output =  '<div class="call-to-action-box'. $class .'">';
  $output.=    '<div class="head"><h4>'. $title .'</h4></div>';
  $output.=    '<div class="icons">'. $icons .'</div>';
  $output.=     '<div class="content">';
  $output.=        '<p>' . $content . '</p>';
  $output.=        '<div class="btn btn-default"><i class="fa fa-angle-right"></i> Get Started</div>';
  $output.=     '</div>';
  $output.=   '</div>';


  return $output;

}
add_shortcode( 'project_block', 'bingo_project_block' );


/* * *********************************************************
 * Testimonial block
 * ********************************************************* */

function bingo_testimonial( $atts, $content ){
  $atts = shortcode_atts(
    array(
      'image'   =>  '',
      'title'   =>  '',
      'content' =>  !empty($content) ? $content : 'lorem ipsum'
    ), $atts
  );

  extract($atts);

  if($image == ''){
    $image = IMAGES . '/content/testimonials-avatar.png';
  }


  $output =  '<div class="testimonials-section">';
  $output.=    '<div class="testimonial">';
  $output.=       '<img src="'. $image .'" alt="">';
  $output.=         '<div>';
  $output.=           '<blockquote>';
  $output.=              '<h2>"'.$content.'"</h2>';
  $output.=              '<cite>'.$title.'</cite>';
  $output.=           '</blockquote>';
  $output.=         '</div>';
  $output.=     '</div>';
  $output.=   '</div>';


  return $output;

}
add_shortcode( 'testimonial_block', 'bingo_testimonial' );




/* * *********************************************************
 * Blockquotes
 * ********************************************************* */
function blockquotes($atts, $content = null) {
    extract(shortcode_atts(array(
        'cite' => ''
    ), $atts));
    $blockquotes = '<blockquote';
    $blockquotes .= '><p>' . $content . '</p>';
    if ($cite) {
        $blockquotes .= '<cite>' . $cite . '</cite>';
    }
    $blockquotes .= '</blockquote>';
    return $blockquotes;
}

add_shortcode('blockquote', 'blockquotes');

/*-----------------------------------------------------------------------------------*/
/*  Alerts
/*-----------------------------------------------------------------------------------*/

function bingo_alert_shortcode( $atts, $content = null )
{
  extract( shortcode_atts( array(
      'title' => '',
      'type' => '',
      ), $atts ) );

  if($type == 'info'){
    $class = " alert-info";
  }elseif($type == 'success'){
    $class = " alert-success";
  }elseif($type == 'warning'){
    $class = " alert-warning";
  }elseif($type == 'error'){
    $class = " alert-error";
  }else{
    $class = "";
  }


  $output = '<div class="alert'. $class .'">';
  if($title){
    $output.=    '<h6>'. $title .'</h6>';
  }
  $output.=    '<p>'. $content .'</p>';
  $output.=    '<a href="#" class="close fa fa-times"></a>';
  $output.= '</div>';


  return $output;

}
add_shortcode('alert', 'bingo_alert_shortcode');




/*-----------------------------------------------------------------------------------*/
/*  Button
/*-----------------------------------------------------------------------------------*/

