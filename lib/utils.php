<?php

/**
 * Adds Filters Automatically from Array Keys
 */
add_action('genesis_meta', 'bw_add_array_filters_genesis_attr');
function bw_add_array_filters_genesis_attr()
{
    $filters = bw_merge_genesis_attr_classes();
    foreach(array_keys($filters) as $context) {
        $context = "genesis_attr_$context";
        add_filter($context, 'bw_add_markup_sanitize_classes', 10, 2);
    }
}

/**
 * Clean classes output
 */
function bw_add_markup_sanitize_classes($attr, $context)
{
    $classes = array();
    if (has_filter('bw_clean_classes_output')) {
        $classes = apply_filters('bw_clean_classes_output', $classes, $context, $attr);
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

/**
 * Default array of classes to add
 */
function bw_merge_genesis_attr_classes()
{
    $classes = array(
            'content-sidebar-wrap'      => 'row',
            'content'                   => 'col-xs-12 col-sm-8 col-lg-7 col-lg-offset-1',
            'sidebar-primary'           => 'hidden-xs col-sm-4 col-lg-3',
            'archive-pagination'        => 'clearfix',
            'entry-content'             => 'clearfix',
            'entry-pagination'          => 'clearfix',
            'sidebar-secondary'         => '',
    );
    if (has_filter('bw_add_classes')) {
        $classes = apply_filters('bw_add_classes', $classes);
    }
    return $classes;
}



/**
 * Adds classes array to bsg_add_markup_class() for cleaning
 */
add_filter('bw_clean_classes_output', 'bw_modify_classes_based_on_extras', 10, 3);
function bw_modify_classes_based_on_extras($classes, $context, $attr)
{
    $classes = bw_merge_genesis_attr_classes($classes);
    return $classes;
}






/**
 * Add theme support for structural wraps
 */
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




add_action( 'genesis_meta', 'bsgen_structural_wrap_fluid_site_inner' );
function bsgen_structural_wrap_fluid_site_inner(){
  add_filter( 'genesis_structural_wrap-site-inner', 'bsg_wrap_container_fluid', 99, 2);
}
