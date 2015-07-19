<?php

/*
Plugin Name: HTTP/2 Server Push
Plugin URI:  https://github.com/daveross/http2-server-push
Description: EXPERIMENTAL implementation of HTTP/2 server push (tested with nghttpx)
Version:     0.1
Author:      David Michael Ross
Author URI:  http://davidmichaelross.com
*/

/**
 * Start an output buffer so this plugin can call header() later without errors
 *
 * @param string $template
 *
 * @return string
 */
function http2_link_template_redirect( $template ) {

	ob_start( null, 0, PHP_OUTPUT_HANDLER_CLEANABLE );

	return $template;

}

add_action( 'template_include', 'http2_link_template_redirect' );

/**
 * When rendering a <script> tag for an enqueued script, add a Link header signalling the HTTP/2 web server to
 * push this resource to the client
 *
 * @param string $src
 * @param string $handle
 *
 * @return string
 */
function http2_link_script_loader_src( $src, $handle ) {

	if ( strpos( $src, home_url() ) !== false ) {
		$relative_src = preg_replace( '/^http(s)?:\/\/[^\/]*/', '', $src );
		header( 'Link: <' . $relative_src . '>; rel=preload; as=script', false );
	}

	return $src;

}

add_filter( 'script_loader_src', 'http2_link_script_loader_src', 99, 2 );

/**
 * When rendering a <link> tag for an enqueued stylesheet, add a Link header signalling the HTTP/2 web server to
 * push this resource to the client
 *
 * @param string $src
 * @param string $handle
 *
 * @return string
 */
function http2_link_style_loader_src( $src, $handle ) {

	if ( strpos( $src, home_url() ) !== false ) {
		$relative_src = preg_replace( '/^http(s)?:\/\/[^\/]*/', '', $src );
		header( 'Link: <' . $relative_src . '>; rel=preload; as=stylesheet', false );
	}

	return $src;

}

add_filter( 'style_loader_src', 'http2_link_style_loader_src', 99, 2 );
