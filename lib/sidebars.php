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
    $footer = array(
        'id'            => 'footer-inside',
        'name'          => __( 'Footer', 'gb3' ),
        'description'   => __( 'This is located inside the footer container.',  'gb3'  ),
        'class'         => '',
        'before_widget' => '<span id="%1$s" class="%2$s">',
        'after_widget'  => '</span>',
        'before_title'  => '<h3 class="widgettitle">',
        'after_title'   => '</h3>',
        
    );
    register_sidebar( $jumbotron );
    register_sidebar( $footer );
}




// Add widget area to single post
add_theme_support( 'genesis-after-entry-widget-area' );
remove_action( 'genesis_after_entry', 'genesis_after_entry_widget_area' );
add_action( 'genesis_after_entry', 'amethyst_after_entry', 9 );
function amethyst_after_entry() {
   if ( ! is_singular( array( 'post' )) )
        return;
        genesis_widget_area( 'after-entry', array(
            'before' => '<div class="after-entry widget-area">',
            'after'  => '</div>',
        ) );
}
