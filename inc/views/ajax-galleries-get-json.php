<?php

header('Content-Type: text/html; charset=utf-8');

global $wpdb; // this is how you get access to the database



echo json_encode( MultiPublisher::get_gallery_json() );

//echo '{"ok":"ok"}';


wp_die(); // this is required to terminate immediately and return a proper response