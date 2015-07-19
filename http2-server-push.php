<?php

/*
Plugin Name: http/2 server push
Plugin URI:  https://github.com/daveross/http2-server-push
Description: EXPERIMENTAL implementation of HTTP/2 server push (tested with nghttpx)
Version:     0.1
Author:      David Michael Ross
Author URI:  http://davidmichaelross.com
*/


add_filter( 'script_loader_src', 'http2_link_script_loader_src', 99, 2 );
function http2_link_script_loader_src( $src, $handle ) {
	global $http2_link_buffer;
	if ( strpos( $src, home_url() ) !== false ) {
		$relative_src = preg_replace( '/^http(s)?:\/\/[^\/]*/', '', $src );
		header( 'Link: <' . $relative_src . '>; rel=preload; as=script', false );
	}

	return $src;
}

add_filter( 'style_loader_src', 'http2_link_style_loader_src', 99, 2 );
function http2_link_style_loader_src( $src, $handle ) {
	if ( strpos( $src, home_url() ) !== false ) {
		$relative_src = preg_replace( '/^http(s)?:\/\/[^\/]*/', '', $src );
		header( 'Link: <' . $relative_src . '>; rel=preload; as=stylesheet', false );
	}

	return $src;
}

add_action( 'wp_head', 'http2_link_wp_head', 999 );
function http2_link_wp_head() {
	$matches = array();
	preg_match( '/\<link(.*)rel="stylesheet"(.*)href="(.*)"/', $http2_link_buffer[0], $matches );
	// header('Link: <' . $src . '>; rel=preload; as=stylesheet', false);
}

add_action( 'template_include', 'http2_link_template_redirect' );
function http2_link_template_redirect( $template ) {
	ob_start( null, 0, PHP_OUTPUT_HANDLER_CLEANABLE );

	return $template;
}
