<?php

header('Content-Type: text/html; charset=utf-8');

global $wpdb; // this is how you get access to the database



//echo "parent_id : ".$_POST['parent_id']."\n";
//echo "post_id   : ".$_POST['post_id']."\n";
//echo MultiPublisher::$pluginUrl."\n";


// $my_wp_query  = new WP_Query();
// $all_wp_pages = $my_wp_query->query(array('post_type' => 'publication'));
// $children 	  = get_page_children( $_POST['post_id'], $all_wp_pages );
// 
// echo json_encode($children);


$parent_tree = MultiPublisher::page_ancestor( $_POST['post_id'], $_POST['parent_id'] );

$result = new stdClass();

if($parent_tree[0] != $_POST['post_id']){
	//echo "Main parent : ".$parent_tree[0]."\n";

	$result->main_parent_id = $parent_tree[0];

}else{
	//echo "aucun parent\n";

	$result->main_parent_id = '';
}

echo json_encode( $result );


wp_die(); // this is required to terminate immediately and return a proper response