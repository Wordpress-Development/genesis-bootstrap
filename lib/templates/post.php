<?php

// Should we run this only in the loop since it messes with genesis widgets
add_action('genesis_meta', 'gb3_add_entry_wrap_markup');
function gb3_add_entry_wrap_markup() {
	add_action('genesis_entry_header', 'gb3_entry_wrap_open', -1);
	add_action('genesis_entry_footer', 'gb3_entry_wrap_close' , 55);
    	add_filter('bw_add_classes', 'gb3_entry_wrap_classes');
}


/* Content Body */
function gb3_entry_wrap_open() {
    printf( '<div %s>', genesis_attr( 'entry-outer-wrap' ) );
    printf( '<div %s>', genesis_attr( 'entry-inner-wrap' ) );
}

function gb3_entry_wrap_close() {
    echo '</div></div>';
}


// COMMENT CLASS FILTERS - you can modify this in your theme
add_filter('bw_add_classes', 'gb3_entry_wrap_classes');
function gb3_entry_wrap_classes($classes) {
    $new_classes = array( 
            'entry-outer-wrap'        => 'thumbnail',
            'entry-inner-wrap'        => 'caption'
    );
    return wp_parse_args($new_classes, $classes);
}
