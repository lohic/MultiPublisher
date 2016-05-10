<?php

header('Content-Type: text/html; charset=utf-8');

global $wpdb; // this is how you get access to the database ;

$gt 		= $_POST['gt'];
$id 		= $_POST['id'];
$abcd 		= $_POST['abcd'];
$size_id 	= $_POST['sizes'];

$arr_img = array();
for ( $i = 0; $i < count($id) ; $i ++ ){
	$info_img = wp_prepare_attachment_for_js( $id[$i] );
	$dir = dirname($info_img['url']);

	$sizes_img = wp_get_attachment_metadata($id[$i])["sizes"][$size_id[$i]];
	if ( $info_img['url'] !== null ){
		$classPos = $abcd[$i];
		if( $info_img['caption'] !== null ){
			$img = '<img data-abcd="'.$classPos.'" alt="'.$info_img['title'].'" src ="'.$dir."/".$sizes_img['file'].'"/><p class="wp-caption-dd">'.$info_img['caption'].'</p>';
			// $img = '<img style ="width:150px; height:auto;" data-abcd="'.$abcd[$i].'" alt="'.$info_img['title'].'" src ="'.$info_img['url'].'"/>';
		}else{
			$img = '<img data-abcd="'.$classPos.'" alt="'.$info_img['title'].'" src ="'.$dir."/".$sizes_img['file'].'"/>';
		};
	}else{
		$img = null;
	};
	array_push( $arr_img, $img );
};


echo json_encode($arr_img);

wp_die(); // this is required to terminate immediately and return a proper response
