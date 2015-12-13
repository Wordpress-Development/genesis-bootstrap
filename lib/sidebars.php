<?php

unregister_sidebar( 'header-right' );





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
