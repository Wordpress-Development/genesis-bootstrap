<?php


add_action('genesis_meta', 'bw_genesis_add_bootstrap_entry_wrap');

function bw_genesis_add_bootstrap_entry_wrap() {
    add_action('genesis_entry_header', 'gb3_entry_archive_panel_wrapper_open', 4);
    add_action('genesis_entry_footer', 'gb3_entry_archive_panel_wrapper_close' , 55);
    add_filter('bw_add_classes', 'bw_custom_entry_wrap');
}

function gb3_entry_archive_panel_wrapper_open() {
    printf( '<div %s>', genesis_attr( 'entry-body' ) );
}

function gb3_entry_archive_panel_wrapper_close() {
    echo '</div>';
}

function bw_custom_entry_wrap($classes) {
    $classes = array( 
        'entry'          => 'panel panel-default',
	    'entry-body'     => 'panel-body'
    );
    return $classes;
}
