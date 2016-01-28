<?php

remove_action( 'genesis_meta', 'genesis_load_stylesheet' );
add_action( 'wp_enqueue_scripts', 'bsg_load_bootstrap_stylesheet' ); 

function bsg_load_bootstrap_stylesheet() {
    
    $bsg_theme_dir = trailingslashit(get_stylesheet_directory_uri());

    $pre = apply_filters( 'bsg_pre_load_css', false );
  
    if ( $pre !== false )
        $stylesheet = $pre;
    elseif ( file_exists( $bsg_theme_dir . 'bootstrap-theme.min.css' ) )
        $stylesheet = $bsg_theme_url . 'bootstrap-theme.min.css';
    elseif ( file_exists( $bsg_theme_dir . 'bootstrap-theme.css' ) )
        $stylesheet = $bsg_theme_url . 'bootstrap-theme.css';
    elseif ( file_exists( $bsg_theme_dir . 'css/bootstrap-theme.min.css' ) )
        $stylesheet = $bsg_theme_url . 'css/bootstrap-theme.min.css';
    elseif ( file_exists( $bsg_theme_dir . 'css/bootstrap-theme.css' ) )
        $stylesheet = $bsg_theme_url . 'css/bootstrap-theme.css';
    //elseif ( file_exists( home_url() . '/custom.css' ) )
        //$custom_css = home_url() . '/custom.css';
    else
        //$stylesheet = plugins_url('bootstrap/css/bootstrap.min.css', __DIR__); // plugin_dir_url( __FILE__ )
        $stylesheet = 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css';
    $stylesheet = apply_filters( 'bsg_css_url', $stylesheet );
    
    if ( $stylesheet ) {
        wp_enqueue_style( 'bsg-bootstrap-css', $stylesheet, array(), CHILD_THEME_VERSION );
        //wp_enqueue_script( 'bsg-bootstrap-js', plugins_url('bootstrap/js/javascript.min.js', __DIR__), array('jquery'), '3.3.5', true );

    //$css_file = file_get_contents($custom_css);
    //echo '<style type="text/css">' . $css_file . '</style>';
    //echo '<link rel="stylesheet" type="text/css" href="' . esc_url( $custom_css ) . '">' . "\n";

    }
    
    wp_enqueue_script( 'bsg-bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js', array('jquery'), '3.3.6', true );
    wp_enqueue_style( 'bsg-font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css', array(), CHILD_THEME_VERSION );
    
}
