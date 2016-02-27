<?php

header('Content-Type: text/html; charset=utf-8');

global $wpdb; // this is how you get access to the database ;
// il faudra renvoyer une array avec chaque id liée à une lettre;

$gt = $_POST['gt'];
$id = $_POST['id'];
$class = $_POST['class'];

$json_gall = MultiPublisher::get_gallery_json();
$arr_img = array();

for ( $i = 0; $i < count($id) ; $i ++ ){
  $info_img = wp_prepare_attachment_for_js( $id[$i] );
  //print_r($info_img);
  if $info_img[url] !== null ){
    if( $info_img[caption] !== null ){
      $img = '<img class="'.$class[$i].'" alt="'.$info_img[title].'" src ="'.$info_img[url].'"/><p class="caption">'.$info_img[caption].'</p>';
    }else{
      $img = '<img class="'.$class[$i].'" alt="'.$info_img[title].'" src ="'.$info_img[url].'"/>';
    };
  }else{
    $img = '';
  };
  array_push( $arr_img, $img );
};

echo $json_gall[$gt];
$obj_gal = json_encode(array(
   "table" => $json_gall[$gt],
   "arr_img" => $arr_img
));
print_r( json_decode( $obj_gal ) );

wp_die(); // this is required to terminate immediately and return a proper response
