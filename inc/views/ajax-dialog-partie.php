<?php

header('Content-Type: text/html; charset=utf-8');

global $wpdb; // this is how you get access to the database


echo "<input id='name_partie' type='text' value='Sans titre'/>\n";


wp_die(); // this is required to terminate immediately and return a proper response