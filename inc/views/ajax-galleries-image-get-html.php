<?php

header('Content-Type: text/html; charset=utf-8');

global $wpdb; // this is how you get access to the database
//echo '<p>'.$_POST['id'].'</p>'."\n";


$id = $_POST['id'];
$info_img = wp_get_attachment_image_src ( $id );

echo '<img src ="'.$info_img[0].'"/>';
//echo "<img width=\"40\" height=\"40\"/>\n";


// ici si on veut on peut appeler des fonctions de MultiPublisher
// on alors des fonctions de wprdpress
// cf :
// https://developer.wordpress.org/reference/functions/wp_get_attachment_image_src/
// https://developer.wordpress.org/reference/functions/wp_get_attachment_image_url/
// il faut également récupérer la légende
// https://wordpress.org/support/topic/get-title-alt-or-caption-from-media-library-and-insert-into-theme





wp_die(); // this is required to terminate immediately and return a proper response
