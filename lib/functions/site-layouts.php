<?php
/**
 * Page/Post Layouts
 *
 * You can enable/disable this feature in functions.php:
 * add_theme_support('bsg-layouts');
 */

//* Make the main content use .container-fluid by default
add_action( 'genesis_meta', 'bsg_layouts_container_fluid_site_inner' );
function bsg_layouts_container_fluid_site_inner(){
  add_filter( 'genesis_structural_wrap-site-inner', 'bsg_util_structural_wrap_container_fluid', 99, 2);
}

//* Modify Bootstrap classes based on genesis_site_layout()
add_filter('bsg_utils_clean_classes_output', 'bsg_layouts_modify_classes_based_on_template', 11, 3);
function bsg_layouts_modify_classes_based_on_template( $classes, $context, $attr ) {
    $classes = bsg_layouts_modify_classes( $classes );
    return $classes;
}

//* Default Layouts - Copy and paste this funciton in theme to override
if (!function_exists('bsg_layouts_modify_classes')) {
  function bsg_layouts_modify_classes( $classes_to_add ) {
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
}

//* Move sidebar secondary
remove_action( 'genesis_after_content_sidebar_wrap', 'genesis_get_sidebar_alt' );
add_action( 'genesis_after_content', 'genesis_get_sidebar_alt' );
