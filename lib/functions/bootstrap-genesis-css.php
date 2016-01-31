<?php
/**
 * Enqueued CSS Stylesheets
 */
remove_action( 'genesis_meta', 'genesis_load_stylesheet' );
add_action( 'wp_enqueue_scripts', 'twbsg_load_stylesheet_bootstrap' ); 
add_action( 'wp_enqueue_scripts', 'twbsg_load_stylesheet_theme_tweaks', 99 );

function twbsg_load_stylesheet_bootstrap() {
    $stylesheet = 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css';
    $stylesheet = apply_filters( 'bsg_css_url', $stylesheet );
    wp_enqueue_style( 'bootstrap', $stylesheet, array(), false );
}

function twbsg_load_stylesheet_tweaks() {
    $stylesheet = plugins_url('/assets/css/bootstrap-genesis.css', __DIR__); // plugin_dir_url( __FILE__ )
    wp_enqueue_style( 'theme-tweaks', $stylesheet, array(), false );
}
