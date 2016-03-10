<?php

namespace Willis\BootGen\Layouts;

use Willis\BootGen\Utils;
	
remove_action( 'genesis_after_content_sidebar_wrap', 'genesis_get_sidebar_alt' );
add_action( 'genesis_after_content', 'genesis_get_sidebar_alt' );

// modify bootstrap classes based on genesis_site_layout
add_filter('bw_clean_classes_output', 'bw_modify_classes_based_on_template', 11, 3);
function bw_modify_classes_based_on_template( $classes, $context, $attr ) {
    $classes = bw_layout_options_modify_classes_to_add( $classes );
    return $classes;
}

function bw_layout_options_modify_classes_to_add( $classes_to_add ) {
    $layout = genesis_site_layout();
    // full-width-content   
    if ( 'full-width-content' === $layout ) {
        $classes_to_add['content'] = 'col-sm-12';
    }
    // sidebar-content
     if ( 'sidebar-content' === $layout ) {
        $classes_to_add['content'] = 'col-xs-12 col-sm-8 col-md-8 col-lg-7 col-sm-push-4 col-lg-push-4';
        $classes_to_add['sidebar-primary'] = 'hidden-xs col-sm-4 col-md-4 col-lg-3 col-sm-pull-8 col-lg-pull-6';
    } 
    // content-sidebar-sidebar  
    if ( 'content-sidebar-sidebar' === $layout ) {
        $classes_to_add['content'] = 'col-xs-12 col-sm-8 col-md-6';
        $classes_to_add['sidebar-primary'] = 'hidden-xs col-sm-4 col-md-3';
        $classes_to_add['sidebar-secondary'] = 'hidden-xs hidden-sm col-md-3';
    }
    // sidebar-sidebar-content 
    if ( 'sidebar-sidebar-content' === $layout ) {
        $classes_to_add['content'] = 'col-xs-12 col-sm-8 col-sm-push-4 col-md-6 col-md-push-6';
        $classes_to_add['sidebar-primary'] = 'hidden-xs col-sm-4 col-sm-pull-8 col-md-3 col-md-pull-3';
        $classes_to_add['sidebar-secondary'] = 'hidden-xs hidden-sm col-md-3 col-md-pull-9';
    }
    // sidebar-content-sidebar 
    if ( 'sidebar-content-sidebar' === $layout ) {
        $classes_to_add['content'] = 'col-xs-12 col-sm-8 col-md-6 col-md-push-3';
        $classes_to_add['sidebar-primary'] = 'hidden-xs col-sm-4 col-md-3 col-md-pull-6';
        $classes_to_add['sidebar-secondary'] = 'hidden-xs hidden-sm col-md-3';
    }
    return $classes_to_add;
}
