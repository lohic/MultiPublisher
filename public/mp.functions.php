<?php
/**
 * 	
 * Public functions for Multipublisher
 * 
 * */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

if ( class_exists( 'MultiPublisher' ) ) {

	/**
	 * [get_mp_header description]
	 * @return [type] [description]
	 */
	function get_mp_header(){

		if(MultiPublisher::$publicationType == "epub" || MultiPublisher::$publicationType == "pdf" ){

			echo "<!DOCTYPE html>
			<html>
			<head>
				<meta charset=\"utf-8\">
			  	<title>".get_bloginfo( 'name', 'display' )."</title>
			  	<link rel=\"stylesheet\" type=\"text/css\" href=\"".get_mp_css_url()."\" >
			</head>

			<body>";

		}else{
			get_header();
		}
	}

	/**
	 * [get_mp_footer description]
	 * @return [type] [description]
	 */
	function get_mp_footer(){
		if(MultiPublisher::$publicationType == "epub" || MultiPublisher::$publicationType == "pdf"){

			echo "</body>
			</html>";

		}else{
			
			get_footer();

		}
	}


	function get_mp_css_url(){
		return Multipublisher::$pluginUrl.'themefiles/carnet-du-frac/style.css';
	}


	function get_mp_edition(){

	}



	/**
	 * Retourne l'URL du répertoire du plugin
	 * @return [type] [description]
	 */
	function mp_url(){
		return MultiPublisher::$pluginUrl;
	}




	function test_public(){

	    echo MultiPublisher::mp_public();

	}
}