<?php
// Add your own footer and center it like bootstrap


//add_action( 'genesis_footer', 'gb3_footer_widget_area_callback' );
function gb3_footer_widget_area_callback() {
    if ( is_active_sidebar( 'footer-inside' ) ) {
                dynamic_sidebar( 'footer-inside' );
    }
}


add_filter( 'genesis_footer_output', 'bsg_footer_creds_filter', 10, 3 );
function bsg_footer_creds_filter( $creds ) {
	$creds = '<p class="text-center">[footer_copyright] &middot; <a href="'. esc_url( home_url( '/' ) ) .'">'. get_bloginfo( 'name' ) .'</a></p>';
        if ( is_active_sidebar( 'footer-inside' ) ) {
              dynamic_sidebar( 'footer-inside' );
        }
        return $creds;
}
