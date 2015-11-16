<?php


<?php

// Parent Theme Fix
remove_theme_support( 'genesis-accessibility' );
add_action( 'wp_enqueue_scripts', 'sp_disable_superfish' );
function sp_disable_superfish() {
	wp_deregister_script( 'superfish' );
	wp_deregister_script( 'superfish-args' );
}

// Child Theme Support
add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption'  ) );
add_theme_support( 'genesis-responsive-viewport' );
add_theme_support( 'genesis-structural-wraps', array( 'menu-primary', 'menu-secondary', 'footer', 'jumbotron-inner', 'site-inner', ) );



// remove Site Title/Logo: Dynamic Text or Image Logo option from Customizer
function bsg_remove_genesis_customizer_controls( $wp_customize ) {
    $wp_customize->remove_control( 'blog_title' );
    return $wp_customize;
}

// Remove page templates
function bsg_be_remove_genesis_page_templates( $page_templates ) {
	unset( $page_templates['page_archive.php'] );
	unset( $page_templates['page_blog.php'] );
	return $page_templates;
}
add_filter( 'theme_page_templates', 'bsg_be_remove_genesis_page_templates' );


// Add featured image sizes
add_image_size( 'bsg-featured-image', 1170, 630, true );

// Add container->wrap classes
add_filter( 'genesis_attr_structural-wrap', 'bsg_attributes_structural_wrap' );
function bsg_attributes_structural_wrap( $attributes ) {
    $attributes['class'] = 'container';
    return $attributes;
}

// Remove header settings from genesis admin screens
add_action( 'genesis_admin_before_metaboxes', 'bsg_remove_genesis_theme_metaboxes' );
function bsg_remove_genesis_theme_metaboxes( $hook ) {
    remove_meta_box( 'genesis-theme-settings-header',   $hook, 'main' );
}

// Remove item(s) from genesis customizer
add_action( 'customize_register', 'bsg_remove_genesis_customizer_controls', 20 );














//
//apply_filters( 'genesis_superfish_enabled', false );
//add_filter( 'genesis_superfish_enabled', '__return_false' );









    


/*
add_theme_support( 'genesis-structural-wraps', array(
	'header',
        'nav',
        'subnav',
        'jumbotron-inner',
        'site-inner',
        'footer'
	'footer-widgets',
) );

add_theme_support( 'genesis-accessibility', array(
	'404-page',
	'drop-down-menu',
	'headings',
	'rems',
	'search-form',
	'skip-links',
) );
// */









// We should try to add support for this either with css or filtering php
//if ( ! is_child_theme() ) {
//    remove_theme_support( 'genesis-accessibility' );

//}





// Parent Theme Fix
remove_theme_support( 'genesis-accessibility' );
add_action( 'wp_enqueue_scripts', 'sp_disable_superfish' );
function sp_disable_superfish() {
	wp_deregister_script( 'superfish' );
	wp_deregister_script( 'superfish-args' );
}


// Child Theme Support
add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption'  ) );
add_theme_support( 'genesis-responsive-viewport' );
add_theme_support( 'genesis-structural-wraps', array( 'menu-primary', 'menu-secondary', 'footer', 'jumbotron-inner', 'site-inner', ) );


// Remove dynamic logo/text from genesis customizer
add_action( 'customize_register', 'bsg_remove_genesis_customizer_controls', 20 );
function bsg_remove_genesis_customizer_controls( $wp_customize ) {
    $wp_customize->remove_control( 'blog_title' );
    return $wp_customize;
}


// Remove page templates
function bsg_be_remove_genesis_page_templates( $page_templates ) {
	unset( $page_templates['page_archive.php'] );
	unset( $page_templates['page_blog.php'] );
	return $page_templates;
}
add_filter( 'theme_page_templates', 'bsg_be_remove_genesis_page_templates' );


// Add featured image sizes
add_image_size( 'bsg-featured-image', 1170, 630, true );


// Add container->wrap classes
add_filter( 'genesis_attr_structural-wrap', 'bsg_attributes_structural_wrap' );
function bsg_attributes_structural_wrap( $attributes ) {
    $attributes['class'] = 'container';
    return $attributes;
}


// Remove header settings from genesis admin screens
add_action( 'genesis_admin_before_metaboxes', 'bsg_remove_genesis_theme_metaboxes' );
function bsg_remove_genesis_theme_metaboxes( $hook ) {
    remove_meta_box( 'genesis-theme-settings-header',   $hook, 'main' );
}
