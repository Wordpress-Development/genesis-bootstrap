<?php

/**
 * Add theme support for structural wraps
 */
function gb3_add_theme_support_structural_wraps() {
	add_theme_support( 'genesis-structural-wraps', 
		array( 
			'menu-primary', 
			'menu-secondary',
			'footer',
			'jumbotron-inner',
			'site-inner',
    			'header'
		) 
	);
}


/**
 * Filter genesis_attr_structural-wrap to use BS .container-fluid classes
 */
add_filter( 'genesis_attr_structural-wrap', 'bsg_attributes_structural_wrap' );
function bsg_attributes_structural_wrap( $attributes ) {
    $attributes['class'] = 'container';
    return $attributes;
}


/**
 * Add structural-wrap replacement utility function to use 
 * Bootstrap responsive .container class
 *
 * Useage: add_filter( 'genesis_structural_wrap-{$context}', 'bsg_wrap_container_fluid');
 */
function bsg_wrap_container_fluid( $output, $original_output ) {
	if ( $original_output == 'open' ) {
	   	$output = sprintf( '<div %s>', genesis_attr( 'container-fluid' ) );
	}
	return $output;
}


/**
 * Helper function to apply to all areas
 *
 * Useage: add_filter( 'genesis_structural_wrap-{$context}', 'bsg_wrap_container_fluid');
 */
function bsg_wrap_all_container_fluid() {
 $genesis_atts = array(
     'menu-primary',
     'menu-secondary',
     'footer',
     'jumbotron-inner',
     'site-inner'
     );
 foreach ( $genesis_atts as $context ) {
     $context = "genesis_structural_wrap-$context";
     add_filter( $context, 'bsg_wrap_container_fluid', 16, 2 );
 }
}


/**
 * Helper function to apply to all areas
 */
function do_genesis_wrap() {
   if (is_home() ) {
       bsg_wrap_all_container_fluid();
   }
}
add_action('genesis_before', 'do_genesis_wrap');
