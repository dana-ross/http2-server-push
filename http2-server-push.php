<?php 

/*
Plugin Name: HTTP/2 Server Push
Plugin URI:  https://github.com/daveross/http2-server-push
Description: Enables HTTP/2 server push for local JavaScript and CSS resources enqueued in the page.
Version:     1.4
Author:      David Michael Ross
Author URI:  http://davidmichaelross.com
*/

// Global variables to keep track of resource URLs
$http2_script_srcs = array();
$http2_stylesheet_srcs = array();

/**
 * Cloudflare gives an HTTP 520 error when more than 8k of headers are present. Limiting $this
 * plugin's output to 4k should keep those errors away.
 */
define('HTTP2_MAX_HEADER_SIZE', 1024 * 4);
$http2_header_size_accumulator = 0;

/**
 * Determine if the plugin should render its own resource hints, or defer to WordPress.
 * WordPress natively supports resource hints since 4.6. Can be overridden with
 * 'http2_render_resource_hints' filter.
 * @return boolean true if the plugin should render resource hints.
 */
function http2_should_render_prefetch_headers() {
	return apply_filters('http2_render_resource_hints', !function_exists( 'wp_resource_hints' ) );
}

/**
 * Start an output buffer so this plugin can call header() later without errors.
 * Need to use a function here instead of calling ob_start in the template_redirect
 * action as WordPress will pass an empty string as the first (only?) parameter
 * and PHP will try to use that as a function name.
 */
function http2_ob_start() {
    ob_start();
}
add_action('init', 'http2_ob_start');

/**
 * @param string $src URL
 *
 * @return void
 */
function http2_link_preload_header($src) {

	global $http2_header_size_accumulator;

    if (strpos($src, site_url()) !== false) {

        $preload_src = apply_filters('http2_link_preload_src', $src);

        if (!empty($preload_src)) {

			$header = sprintf(
				'Link: <%s>; rel=preload; as=%s',
				esc_url( http2_link_url_to_relative_path( $preload_src ) ),
				sanitize_html_class( http2_link_resource_hint_as( current_filter() ) )
			);

			// Make sure we haven't hit the header limit
			if(($http2_header_size_accumulator + strlen($header)) < HTTP2_MAX_HEADER_SIZE) {
				$http2_header_size_accumulator += strlen($header);
				header( $header, false );
			}
			
			
			$GLOBALS['http2_' . http2_link_resource_hint_as( current_filter() ) . '_srcs'][] = http2_link_url_to_relative_path( $preload_src );
		
		}

    }

    return $src;
}

if(!is_admin()) {
	add_filter('script_loader_src', 'http2_link_preload_header', 99, 1);
	add_filter('style_loader_src', 'http2_link_preload_header', 99, 1);
}

/**
 * Render "resource hints" in the <head> section of the page. These encourage preload/prefetch behavior
 * when HTTP/2 support is lacking.
 */
function http2_resource_hints() {
	$resource_types = array('script', 'style');
	array_walk( $resource_types, function( $resource_type ) {
		$resources = http2_get_resources($GLOBALS, $resource_type);
		array_walk( $resources, function( $src ) use ( $resource_type ) {
			printf( '<link rel="preload" href="%s" as="%s">', esc_url($src), esc_html( $resource_type ) );
		});	
	});

}

if(!is_admin() && http2_should_render_prefetch_headers()) {
	add_action( 'wp_head', 'http2_resource_hints', 99, 1);
}

/**
 * Get resources of a certain type that have been enqueued through the WordPress API.
 * Needed because some plugins mangle these global values
 * @param array $globals the $GLOBALS array
 * @param string $resource_type resource type (script, style)
 * @return array
 */
function http2_get_resources($globals = null, $resource_type) {

	$globals = (null === $globals) ? $GLOBALS : $globals;
	$resource_type_key = "http2_{$resource_type}_srcs";
	
	if(!(is_array($globals) && isset($globals[$resource_type_key]))) {
		return array();
	}
	else if(!is_array($globals[$resource_type_key])) {
		return array($globals[$resource_type_key]);
	}
	else {
		return $globals[$resource_type_key];
	}

}

/**
 * Convert an URL with authority to a relative path
 *
 * @param string $src URL
 *
 * @return string mixed relative path
 */
function http2_link_url_to_relative_path($src) {
    return '//' === substr($src, 0, 2) ? preg_replace('/^\/\/([^\/]*)\//', '/', $src) : preg_replace('/^http(s)?:\/\/[^\/]*/', '', $src);
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
