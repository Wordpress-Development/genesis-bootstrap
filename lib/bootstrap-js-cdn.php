<?php

function brw_load_bootstrap() {
  
$get_the_url = 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js';
$get_the_local = 'http://gb3.wpengine.com/wp-content/plugins/genesis-bootstrap-master/bootstrap/js/javascript.min.js';
  
$cdnIsUp = get_transient( 'use_bs_cdn' );
if ( $cdnIsUp ) {
    $load_source = $get_the_url;
} else {
    $cdn_response = wp_remote_get( $get_the_url );
    if( is_wp_error( $cdn_response ) || wp_remote_retrieve_response_code($cdn_response) != '200' ) {
        $load_source = $get_the_local;
    }
    else {
        $cdnIsUp = set_transient( 'use_bs_cdn', true, MINUTE_IN_SECONDS * 20 );
        $load_source = $get_the_url;
    }
 }
  
	return $load_source;
}


add_action('wp_enqueue_scripts', 'brw_enqueue_bootstrap');
function brw_enqueue_bootstrap() { 
    wp_register_script( 'bootstrap1', brw_load_bootstrap(), array('jquery'), 3.3, true); 
    wp_enqueue_script('bootstrap1'); 
}
