<?php

add_action( 'genesis_init', 'bsg_add_theme_support', 15 );
function bsg_add_theme_support() {
// Add theme support for new menu
// Add New Footer Menu; Keep Primary and Secondary Menus
add_theme_support ( 'genesis-menus' , array ( 
	'primary' => __( 'Primary Navigation Menu', 'genesis' ),
	'secondary' => __( 'Secondary Navigation Menu', 'genesis' ),
	'footer' => __( 'Footer Navigation Menu', 'genesis' )
	) );
}


function gb3_register_sidebar_defaults( $defaults ) {
	$defaults['before_widget'] = '<section id="%1$s" class="panel panel-default widget %2$s"><div class="panel-body widget-wrap">';
	return $defaults;
}
function genesis_edit_widget_areas() {
    add_filter( 'genesis_register_widget_area_defaults', 'gb3_register_sidebar_defaults');
}
add_action( 'genesis_setup', 'genesis_edit_widget_areas', 15 );




add_filter( 'genesis_post_info', 'sp_post_info_filter' );
function sp_post_info_filter($post_info) {
	$post_info = '[post_date format="j F, Y" before="<span class=\'post-date text-muted\'>" after="</span>" label="<i class=\'fa fa-clock-o\'></i> "] by [post_author_posts_link] [post_comments before="<span class=\'pull-right\'><span class=\'text-muted fa fa-comments\'></span>" after="</span>" zero=" Leave a Comment" one=" 1 Comment" more=" % Comments"]';
	return $post_info;
}


add_filter( 'genesis_post_meta', 'sp_post_meta_filter' );
function sp_post_meta_filter($post_info) {
	$post_info = '';
	return $post_info;
}
