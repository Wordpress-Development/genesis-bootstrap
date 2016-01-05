<?php
/** 
 * Setup Genesis Defaults for Bootstrap Plugin and Themes
 * 
 */
 
add_action( 'genesis_setup', 'bsg_add_theme_support', 15 );
function bsg_add_theme_support() {

/** Remove Parent Theme Support */
remove_theme_support( 'genesis-accessibility' );

/** Hide Wordpress Specific Schema */
// remove_filter( 'genesis_attr_site-header', 'genesis_attributes_header' );
// remove_filter( 'genesis_attr_site-footer', 'genesis_attributes_site_footer' );

/** Remove Superfish */	
add_action( 'wp_enqueue_scripts', 'sp_disable_superfish' );
	
/** Add featured image sizes */
add_image_size( 'bsg-featured-image', 1170, 630, true );

/** Wrap Sidebar Widgets with Bootstrap Panel Classes */
add_filter( 'genesis_register_widget_area_defaults', 'gb3_register_sidebar_defaults');

/** Custom Post Info and Meta */
add_filter( 'genesis_post_info', 'sp_post_info_filter' );
add_filter( 'genesis_post_meta', 'sp_post_meta_filter' );

add_theme_support( 'html5', array( 
	'comment-list', 
	'comment-form', 
	'search-form', 
	'gallery', 
	'caption'  
	) );
add_theme_support( 'genesis-responsive-viewport' );

add_theme_support ( 'genesis-menus' , array ( 
	'primary' => __( 'Primary Navigation Menu', 'genesis' ),
	'secondary' => __( 'Secondary Navigation Menu', 'genesis' ),
	// Add New Footer Menu; Keep Primary and Secondary Menus
	'footer' => __( 'Footer Navigation Menu', 'genesis' )
	) );
}

add_theme_support( 'genesis-structural-wraps', array( 
	'menu-primary', 
	'menu-secondary', 
	'footer', 
	'jumbotron-inner', 
	'site-inner' 
) );



function gb3_register_sidebar_defaults( $defaults ) {
	$defaults['before_widget'] = '<section id="%1$s" class="panel panel-default widget %2$s"><div class="panel-body widget-wrap">';
	return $defaults;
}

function sp_post_info_filter($post_info) {
	$post_info = '[post_date format="j F, Y" before="<span class=\'post-date text-muted\'>" after="</span>" label="<i class=\'fa fa-clock-o\'></i> "] by [post_author_posts_link] [post_comments before="<span class=\'pull-right\'><span class=\'text-muted fa fa-comments\'></span>" after="</span>" zero=" Leave a Comment" one=" 1 Comment" more=" % Comments"]';
	return $post_info;
}

function sp_post_meta_filter($post_info) {
	$post_info = '';
	return $post_info;
}


function sp_disable_superfish() {
	wp_deregister_script( 'superfish' );
	wp_deregister_script( 'superfish-args' );
}

// Remove dynamic logo/text from admin customizer
add_action( 'customize_register', 'bsg_remove_genesis_customizer_controls', 20 );
function bsg_remove_genesis_customizer_controls( $wp_customize ) {
    $wp_customize->remove_control( 'blog_title' );
    return $wp_customize;
}

// Remove page templates
add_filter( 'theme_page_templates', 'bsg_be_remove_genesis_page_templates' );
function bsg_be_remove_genesis_page_templates( $page_templates ) {
	unset( $page_templates['page_archive.php'] );
	unset( $page_templates['page_blog.php'] );
	return $page_templates;
}

// Remove header settings from genesis admin screens
add_action( 'genesis_admin_before_metaboxes', 'bsg_remove_genesis_theme_metaboxes' );
function bsg_remove_genesis_theme_metaboxes( $hook ) {
    remove_meta_box( 'genesis-theme-settings-header',   $hook, 'main' );
}
