<?php

function boot_gen_move_js_to_footer() {
    $scripts = wp_scripts();
    foreach( $scripts->registered as $script ) {
	    if ( 'html5shiv' == $script->handle || 'respond' == $script->handle )  {
            wp_script_add_data( $script->handle, 'group', 0 );
        } else {
            wp_script_add_data( $script->handle, 'group', 1 );
        }
    }
}
add_action( 'wp_enqueue_scripts', 'boot_gen_move_js_to_footer', 99 );
