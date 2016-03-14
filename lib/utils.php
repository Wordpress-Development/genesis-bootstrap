<?php
/**
 * Bootstrap Genesis Utilities/Helpers
 *
 * This file is required for the plugin to work
 */
 
 
//* Auto Add Filters from Array Keys
add_action('genesis_meta', 'bsg_utils_genesis_attr_add_filters');
function bsg_utils_genesis_attr_add_filters() {
    $filters = bsg_utils_merge_genesis_attr_classes();
    foreach(array_keys($filters) as $context) {
        $context = "genesis_attr_$context";
        add_filter($context, 'bsg_utils_sanitize_classes', 10, 2);
    }
}

//* Clean classes output
function bsg_utils_sanitize_classes($attr, $context) {
    $classes = array();
    if (has_filter('bsg_utils_clean_classes_output')) {
        $classes = apply_filters('bsg_utils_clean_classes_output', $classes, $context, $attr);
    }
    $value = isset($classes[$context]) ? $classes[$context] : array();
    if (is_array($value)) {
        $classes_array = $value;
    }
    else {
        $classes_array = explode(' ', (string)$value);
    }
    $classes_array = array_map('sanitize_html_class', $classes_array);
    $attr['class'].= ' ' . implode(' ', $classes_array);
    return $attr;
}

//* Default array of classes to add
if (!function_exists( 'bsg_utils_merge_genesis_attr_classes')) {
  function bsg_utils_merge_genesis_attr_classes() {
    $classes = array(
            'content-sidebar-wrap'      => 'row',
            'content'                   => 'col-xs-12 col-sm-8 col-lg-7 col-lg-offset-1',
            'sidebar-primary'           => 'hidden-xs col-sm-4 col-lg-3',
            'archive-pagination'        => 'clearfix',
            'entry-content'             => 'clearfix',
            'entry-pagination'          => 'clearfix',
            'sidebar-secondary'         => '',
    );
    if (has_filter('bsg_utils_add_nav_classes')) {
        $classes = apply_filters('bsg_utils_add_nav_classes', $classes);
    }
    return $classes;
  }
}

//* Adds classes array to bsg_add_markup_class() for cleaning
add_filter('bsg_utils_clean_classes_output', 'bsg_utils_do_default_classes', 10, 3);
function bsg_utils_do_default_classes($classes, $context, $attr) {
    $classes = bsg_utils_merge_genesis_attr_classes($classes);
    return $classes;
}

//* Add theme support for structural wraps
if (!current_theme_supports('genesis-structural-wraps')) {
  add_theme_support(
    'genesis-structural-wraps', 
    array( 
	'menu-primary', 
	'menu-secondary',
	'footer',
	'site-inner',
    	'header'
    ) 
  );
}

//* Filter genesis_attr_structural-wrap to use BS .container-fluid classes
add_filter( 'genesis_attr_structural-wrap', 'bsg_utils_attr_structural_wrap_container' );
function bsg_utils_attr_structural_wrap_container( $attributes ) {
    $attributes['class'] = 'container';
    return $attributes;
}

/**
 * Add structural-wrap replacement utility function to use 
 * Bootstrap responsive .container class
 *
 * Useage: add_filter( 'genesis_structural_wrap-{$context}', 'bsg_util_structural_wrap_container_fluid');
 */
function bsg_util_structural_wrap_container_fluid( $output, $original_output ) {
	if ( $original_output == 'open' ) {
	   	$output = sprintf( '<div %s>', genesis_attr( 'container-fluid' ) );
	}
	return $output;
}

/**
 * Helper function to apply to all areas
 *
 * Useage: add_filter( 'genesis_structural_wrap-{$context}', 'bsg_utils_structural_wrap_container_fluid_all');
 */
function bsg_utils_structural_wrap_container_fluid_all() {
 $genesis_atts =  array(
     'menu-primary',
     'menu-secondary',
     'footer',
     'jumbotron-inner',
     'site-inner'
 );
 foreach ( $genesis_atts as $context ) {
     $context = "genesis_structural_wrap-$context";
     add_filter( $context, 'bsg_utils_structural_wrap_container_fluid', 16, 2 );
 }
}
