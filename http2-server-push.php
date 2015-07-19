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
 */
function http2_link_template_redirect( $template ) {

	ob_start();

}

add_action( 'template_redirect', 'http2_link_template_redirect' );

/**
 * @param string $src URL
 *
 * @return void
 */
function http2_link_preload_header( $src, $handle ) {
	if ( strpos( $src, home_url() ) !== false ) {
		header( 'Link: <' . esc_url( http2_link_url_to_relative_path( $src ) ) . '>; rel=preload; as=' . sanitize_html_class( http2_link_link_as( current_filter() ) ), false );
	}

	return $src;
}

add_filter( 'script_loader_src', 'http2_link_preload_header', 99, 2 );
add_filter( 'style_loader_src', 'http2_link_preload_header', 99, 2 );

/**
 * Convert an URL with authority to a relative path
 *
 * @param string $src URL
 *
 * @return string mixed relative path
 */
function http2_link_url_to_relative_path( $src ) {
	return preg_replace( '/^http(s)?:\/\/[^\/]*/', '', $src );
}

/**
 * @param string $current_hook
 *
 * @return string
 */
function http2_link_link_as( $current_hook ) {
	return 'style_loader_src' === $current_hook ? 'stylesheet' : 'script';
}