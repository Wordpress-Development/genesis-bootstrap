<?php

function plugin_mce_css( $mce_css ) {
	if ( ! empty( $mce_css ) )
		$mce_css .= ',';
	$mce_css .= plugins_url('bootstrap/css/bootstrap.min.css', __DIR__); 
	return $mce_css;
}
add_filter( 'mce_css', 'plugin_mce_css' );

/*
#tinymce {
    margin: 10px 15px;
}
*/
