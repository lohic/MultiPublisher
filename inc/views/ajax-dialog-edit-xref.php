<?php

header('Content-Type: text/html; charset=utf-8');

global $wpdb; // this is how you get access to the database


$publication_parent_id = $_POST['parent_id'];

$xref_id  	= $_POST['xref_id'];
$xref_txt 	= stripslashes($_POST['xref_txt']);
$xref_href 	= $_POST['xref_href'];

echo "<div>\n";

echo "<p><label>xref id : </label><input id='name_partie' type='text' value='$xref_id'/></p>\n";
echo "<p><label>xref txt : </label><input id='name_partie' type='text' value='$xref_txt'/></p>\n";
echo "<p><label>xref href : </label><input id='name_partie' type='text' value='$xref_href'/></p>\n";
// echo "<h2>$publication_parent_id</h2>\n";
echo "</div>\n";

echo Multipublisher::mp_publication_xref_list( $publication_parent_id );

echo "<ul class='xref_result'></ul>";


wp_die(); // this is required to terminate immediately and return a proper response