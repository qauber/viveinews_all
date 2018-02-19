<?php



	define('UOU', get_template_directory_uri().'/framwork/');
	define('UOU_LIB', get_template_directory_uri().'/framwork/lib/');
	define('UOU_EX', get_template_directory_uri().'/framwork/vendor/');
	define('UOU_JS', get_template_directory_uri().'/js/' );
	define('UOU_CSS', get_template_directory_uri().'/css/' );









	#vendor loading

	// REDUX


	if ( !class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/vendor/ReduxFramework/ReduxCore/framework.php' ) ) {
	    require_once( dirname( __FILE__ ) . '/vendor/ReduxFramework/ReduxCore/framework.php' );
	}
	if ( !isset( $redux_demo ) && file_exists( dirname( __FILE__ ) . '/vendor/ReduxFramework/config/config.php' ) ) {
	    require_once( dirname( __FILE__ ) . '/vendor/ReduxFramework/config/config.php' );
	}



	// load plugins

	require_once('vendor/plugins/class-tgm-plugin-activation.php');

	require_once('vendor/plugins/load-plugin.php');






	#lib loading



	// stylesheet & scripts

	require_once('lib/style.php');
	require_once('lib/script.php');


	// for custom post and post meta

	// require_once('vendor/cuztom/cuztom.php');


	// for theme function

	require_once('lib/uou-functions.php');



	// for ajaxing

	// require_once('lib/UOU-ajax-posting.php');




