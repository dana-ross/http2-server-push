<?php

/*
Plugin Name: HTTP/2 Server Push
Plugin URI:  https://github.com/daveross/http2-server-push
Description: Enables HTTP/2 server push for local JavaScript and CSS resources enqueued in the page.
Version:     1.1
Author:      David Michael Ross
Author URI:  http://davidmichaelross.com
*/

// Global variables to keep track of resource URLs
$http2_script_srcs = array();
$http2_stylesheet_srcs = array();

/**
 * Start an output buffer so this plugin can call header() later without errors.
 * Need to use a function here instead of calling ob_start in the template_redirect
 * action as WordPress will pass an empty string as the first (only?) parameter
 * and PHP will try to use that as a function name.
 */
function http2_ob_start() {
    ob_start();
}
add_action( 'init', 'http2_ob_start' );

/**
 * @param string $src URL
 *
 * @return void
 */
function http2_link_preload_header( $src ) {

	if ( strpos( $src, home_url() ) !== false ) {

		$preload_src = apply_filters( 'http2_link_preload_src', $src );

		if( ! empty( $preload_src ) ) {

			header(
				sprintf(
					'Link: <%s>; rel=preload; as=%s',
					esc_url( http2_link_url_to_relative_path( $preload_src ) ),
					sanitize_html_class( http2_link_link_as( current_filter() ) )
				)
				, false
			);
			
			$GLOBALS['http2_' . http2_link_resource_hint_as( current_filter() ) . '_srcs'][] = http2_link_url_to_relative_path( $preload_src );
		
		}

	}

	return $src;
}

add_filter( 'script_loader_src', 'http2_link_preload_header', 99, 1 );
add_filter( 'style_loader_src', 'http2_link_preload_header', 99, 1 );

/**
 * Render "resource hints" in the <head> section of the page. These encourage preload/prefetch behavior
 * when HTTP/2 support is lacking.
 */
function http2_resource_hints() {
	$resource_types = array('script', 'style');
	array_walk( $resource_types, function( $resource_type ) {
		array_walk( $GLOBALS["http2_{$resource_type}_srcs"], function( $src ) use ( $resource_type ) {
			printf( '<link rel="preload"  href="%s" as="%s">', esc_url($src), esc_html( $resource_type ) );
		});	
	});

}
add_action( 'wp_head', 'http2_resource_hints', 99, 1);

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
 * Maps a WordPress hook to an "as" parameter in the Link header
 *
 * @param string $current_hook pass current_filter()
 *
 * @return string 'stylesheet' or 'script'
 */
function http2_link_link_as( $current_hook ) {
	return 'style_loader_src' === $current_hook ? 'stylesheet' : 'script';
}

/**
 * Maps a WordPress hook to an "as" parameter in a resource hint
 *
 * @param string $current_hook pass current_filter()
 *
 * @return string 'style' or 'script'
 */
function http2_link_resource_hint_as( $current_hook ) {
	return 'style_loader_src' === $current_hook ? 'style' : 'script';
}