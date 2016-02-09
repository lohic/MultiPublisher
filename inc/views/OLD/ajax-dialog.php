<?php

header('Content-Type: text/html; charset=utf-8');

global $wpdb; // this is how you get access to the database

$whatever = intval( $_POST['whatever'] );

$whatever += 10;

// $retour = new stdClass();

// $content  = "<h1>$whatever</h1>";
// $content .= "<p>ok àèéc</p>\n";

// $retour->content = $content;

// echo json_encode($retour);
// 
// 
echo "<h1>$whatever</h1>\n";
echo "<p>ok àèéc</p>\n";

wp_die(); // this is required to terminate immediately and return a proper response