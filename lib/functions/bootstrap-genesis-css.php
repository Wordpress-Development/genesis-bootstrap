<?php

add_action( 'wp_enqueue_scripts', 'bsg_theme_default_style_fixes', 999 ); 
function bsg_theme_default_style_fixes() {
    $stylesheet = plugins_url('lib/assets/css/bootstrap-genesis.css', __DIR__); // plugin_dir_url( __FILE__ )
    wp_enqueue_style( 'bsg-theme-css', $stylesheet, array(), false );
}
