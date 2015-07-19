<?php

/*
Plugin Name: http/2 server push 
*/

$http2_link_buffer = array();

ob_start(null, 0, PHP_OUTPUT_HANDLER_CLEANABLE );
register_shutdown_function(function() {
  global $http2_link_buffer;
  echo implode('', $http2_link_buffer);
});
add_filter( 'script_loader_src', 'http2_link_script_loader_src', 99, 2);
function http2_link_script_loader_src($src, $handle) {
  global $http2_link_buffer;
  if (strpos($src, home_url()) !== false) {
  	$relative_src = preg_replace('/^http(s)?:\/\/[^\/]*/', '', $src);
    $http2_link_buffer[] = ob_get_clean();
    ob_start();
    header('Link: <' . $relative_src . '>; rel=preload; as=script', false);
  }
  return $src;
}
add_filter('style_loader_src', 'http2_link_style_loader_src', 99, 2);
function http2_link_style_loader_src($src, $handle) {
  global $http2_link_buffer;
  if (strpos($src, home_url()) !== false) {
  	$relative_src = preg_replace('/^http(s)?:\/\/[^\/]*/', '', $src);
    $http2_link_buffer[] = ob_get_clean(); 
    ob_start();
    header('Link: <' . $relative_src . '>; rel=preload; as=stylesheet', false);
  }
  return $src;
}
add_action('wp_head', 'http2_link_wp_head', 999);
function http2_link_wp_head() {
    global $http2_link_buffer;
    $http2_link_buffer[] = ob_get_clean();
    ob_start();
    $http2_link_buffer = array(implode('', $http2_link_buffer));
    $matches = array();
    preg_match('/\<link(.*)rel="stylesheet"(.*)href="(.*)"/', $http2_link_buffer[0], $matches);
    #header('Link: <' . $src . '>; rel=preload; as=stylesheet', false);
}
