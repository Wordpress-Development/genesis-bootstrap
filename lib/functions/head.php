<?php
/**
 * Bootstrap Genesis Plugin.
 *
 * WARNING: This file is part of the core Bootstrap Genesis Plugin. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package TWBSG\Head
 * @author  BryanWillis
 * @license GPL-2.0+
 * @link    https://github.com/Wordpress-Development/genesis-bootstrap/
 */
 
 
/**
 * Add `X-UA-compatible` Header
 */
is_admin() || add_action( 'send_headers', function() {
	header( 'X-UA-Compatible: IE=edge,chrome=1' );
}, 1 );



/**
 * Responsive Viewport
 */
add_theme_support( 'genesis-responsive-viewport' );



/**
 * Add `no-js` class to `<html>` and include javascript check script early
 */
add_filter( 'language_attributes', 'bsg_js_detection_lang_atts' );
 
function bsg_js_detection_lang_atts($output) {
	return $output . ' class="no-js"';
}

add_action( 'genesis_doctype', function() {
	if ( has_filter( 'language_attributes', 'bsg_js_detection_lang_atts' ) ) {
		echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
	}
}, 100 );



/**
 * Enqueued CSS Stylesheets
 */
remove_action( 'genesis_meta', 'genesis_load_stylesheet' );
add_action( 'wp_enqueue_scripts', 'twbsg_load_bootstrap' ); 
add_action( 'wp_enqueue_scripts', 'twbsg_load_stylesheet_theme_tweaks', 99 );

function twbsg_load_bootstrap() {
	$stylesheet = 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css';
	$stylesheet = apply_filters( 'bsg_css_url', $stylesheet );
	wp_enqueue_style( 'bootstrap', $stylesheet, array(), false );  
    
	wp_enqueue_script( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js', array('jquery'), false, false );
	wp_enqueue_style( 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css', array(), false );
}

function twbsg_load_stylesheet_tweaks() {
	$stylesheet = plugins_url('/assets/css/bootstrap-genesis.css', __DIR__); // plugin_dir_url( __FILE__ )
	wp_enqueue_style( 'theme-tweaks', $stylesheet, array(), false );
}



/**
 * IE8 Support
 */
if ( has_action( 'wp_head', 'genesis_html5_ie_fix' ) ) {
	remove_action( 'wp_head', 'genesis_html5_ie_fix' );
	add_action('wp_enqueue_scripts', 'twbsg_ie_fix');	
}

function twbsg_ie_fix()  {
	wp_enqueue_script( 'html5shiv',
		'https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js',
		array(),
		false,
		false
	);
	wp_enqueue_script( 'respond',
		'https://oss.maxcdn.com/respond/1.4.2/respond.min.js',
		array(),
		false,
		false
	);
  	wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );
  	wp_script_add_data( 'respond', 'conditional', 'lt IE 9' );
}
