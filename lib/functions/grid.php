<?php

/**
 * Adds Filters Automatically from Array Keys
 */
add_action('genesis_meta', 'bw_add_array_filters_genesis_attr');
function bw_add_array_filters_genesis_attr()
{
	$filters = bw_merge_genesis_attr_classes($classes);
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
function bw_merge_genesis_attr_classes($classes)
{
	$classes = array(
            'site-inner'                => 'container',
            'site-footer'               => 'container',
            'content-sidebar-wrap'      => 'row',
            'content'                   => 'hidden-xs col-sm-8 col-md-8 col-lg-9',
            'sidebar-primary'           => 'col-xs-12 col-sm-3 col-md-4 col-lg-3',
            'archive-pagination'        => 'clearfix',
            'entry-content'             => 'clearfix',
            'entry-pagination'          => 'clearfix bsg-pagination-numeric'
        );
	if (has_filter('bw_add_classes')) {
		$add_classes = apply_filters('bw_add_classes', $add_classes);
		$classes = wp_parse_args($classes, $add_classes);
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
