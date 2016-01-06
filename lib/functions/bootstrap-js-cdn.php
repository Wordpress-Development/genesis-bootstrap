<?php

/* Bootstrap CDN - not fully supported (use at own risk) */


function twbsg_bootstrap_js_url() {
$bs_cdn_url = 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js';
$bs_plugin_url = plugins_url('bootstrap/js/javascript.min.js', __DIR__);
$cdnIsUp = get_transient( 'twbs_cdn_js' );
if ( $cdnIsUp ) {
	$load_source = $bs_cdn_url;
} else {
	$cdn_response = wp_remote_get( $bs_cdn_url );
	if( is_wp_error( $cdn_response ) || wp_remote_retrieve_response_code($cdn_response) != '200' ) {
		$load_source = $bs_plugin_url;
	}
	else {
		$cdnIsUp = set_transient( 'twbs_cdn_js', true, MINUTE_IN_SECONDS * 20 );
		$load_source = $bs_cdn_url;
	}
}
return $load_source;
}
add_action('wp_enqueue_scripts', function() {
	wp_register_script('bootstrap', twbsg_bootstrap_js_url(), array('jquery'), '3.3.6', true); 
    	wp_enqueue_script('bootstrap');
});



/*
function twbsg_bootstrap_js_cdn() {
    if ( false === ( $url = get_transient('twbs_cdn_js') ) ) {
        $url = ( is_ssl() ? 'https:' : 'http:' ) . '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js';
        $resp = wp_remote_head($url);
        if ( is_wp_error($resp) || 200 != $resp['response']['code'] ) {
            $url = plugins_url('bootstrap/js/javascript.min.js', __DIR__);
        }
        set_transient('twbs_cdn_js', $url, 60*5);
    }
    wp_deregister_script('bootstrap');
    wp_register_script('bootstrap', $url, array('jquery'), null, true);
    wp_enqueue_script('bootstrap');
}
add_action('wp_enqueue_scripts', 'twbsg_bootstrap_js_cdn');
// */




// Roots Way - http://wordpress.stackexchange.com/a/12450/43806
