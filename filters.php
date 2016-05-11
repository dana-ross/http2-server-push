<?php

add_action( 'init', 'http2_ob_start' );
add_filter( 'script_loader_src', 'http2_link_preload_header', 99, 1 );
add_filter( 'style_loader_src', 'http2_link_preload_header', 99, 1 );
add_action( 'wp_head', 'http2_resource_hints', 99, 1);
