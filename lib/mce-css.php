<?php

function plugin_mce_css( $mce_css ) {
	if ( ! empty( $mce_css ) )
		$mce_css .= ',';
	$mce_css .= plugins_url('bootstrap/css/bootstrap.min.css', __DIR__); 
	return $mce_css;
}
add_filter( 'mce_css', 'plugin_mce_css' );



/*
function wpse15850_body_class( $wp_classes, $extra_classes )
{
    // List of the only WP generated classes allowed
    $whitelist = array( '' );
    // List of the only WP generated classes that are not allowed
    $blacklist = array( '' );

    // Filter the body classes
    // Whitelist result: (comment if you want to blacklist classes)
    # $wp_classes = array_intersect( $wp_classes, $whitelist );
    // Blacklist result: (uncomment if you want to blacklist classes)
     $wp_classes = array_diff( $wp_classes, $blacklist );

    // Add the extra classes back untouched
    return array_merge( $wp_classes, (array) $extra_classes );
}
add_filter( 'body_class', 'wpse15850_body_class', 10, 2 );
*/

/*
function wpse_128380_tinymce_body_class( $mce ) {
    $mce['body_class'] = ' panel-body';
    return $mce;
}
add_filter( 'tiny_mce_before_init', 'wpse_128380_tinymce_body_class' );
// */

/*
Need to figure out a way to add padding to body without needing custom bootstrap... or maybe not
#tinymce {
    margin: 10px 15px;
}
*/
