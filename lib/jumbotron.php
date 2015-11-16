<?php

unregister_sidebar( 'header-right' );

add_action('widgets_init', 'register_additional_sidebars');
function register_additional_sidebars() {
    
    $jumbotron = array(
        'id'            => 'jumbotron-widget-area',
        'name'          => __( 'Jumbotron', 'gb3' ),
        'description'   => __( 'This is located inside the jumbotron header.',  'gb3'  ),
        'class'         => '',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h1>',
        'after_title'   => '</h1>',
        
    );
    
    register_sidebar( $jumbotron );

}



remove_action( 'genesis_site_title', 'genesis_seo_site_title' );
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );
add_action( 'genesis_header', 'jumbotron_widget_area_callback' );

function jumbotron_widget_area_callback() {
    if ( is_active_sidebar( 'jumbotron-widget-area' ) ) {
        echo '<div class="jumbotron">';
            genesis_structural_wrap( 'jumbotron-inner' );
                dynamic_sidebar( 'jumbotron-widget-area' );
            genesis_structural_wrap( 'jumbotron-inner', 'close' );
        echo '</div>';
   }
}

/*
    add_action( 'template_redirect', 'bsg_title_area_jumbotron_unit_on_front_page' );

function bsg_title_area_jumbotron_unit_on_front_page() {
    if ( is_front_page() ) {
        add_action( 'genesis_site_title', 'bsg_jumbotron_unit_open', 2 );
        add_action( 'genesis_site_description', 'bsg_jumbotron_unit_close', 30 );
    }
    else {
        remove_action( 'genesis_site_title', 'genesis_seo_site_title' );
        remove_action( 'genesis_site_description', 'genesis_seo_site_description' );
    }
}



function bsg_jumbotron_unit_open() {
echo '<div class="jumbotron">';
genesis_structural_wrap( 'jumbotron-inner' );
}

function bsg_jumbotron_unit_close() {
    genesis_structural_wrap( 'jumbotron-inner', 'close' );
    echo '</div>';
}

// */
