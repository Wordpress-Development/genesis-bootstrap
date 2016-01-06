<?php

/**
 * Add Bootstrap Editor Styles
 * @since 1.0.0
 *
 * These functions adds Bootstrap styling support to the admin 
 * TinyMCE post editor
 */


/** Add Bootstrap styles */
add_filter( 'mce_css', 'twbsg_mce_css' );
function twbsg_mce_css( $mce_css ) {
	if (defined('TWBSG_CSS')) {
		$plugin_css = TWBSG_CSS;
	} else {
		$plugin_css = plugins_url('bootstrap/css/bootstrap.min.css', __DIR__);
	}
	 if ( ! empty( $mce_css ) ) {
		$mce_css .= ',';
		$mce_css .= $plugin_css;
		}
	 }
	return $mce_css;
}

/** Fix padding on editor body since Bootstrap container classes aren't used */
add_filter( 'tiny_mce_before_init', 'twbsg_tinymce_before_init_content_style' );
function twbsg_tinymce_before_init_content_style( $mce ) {
    // $mce['body_class'] = ' container-fluid'; 
    // $mce['content_css'] = plugins_url('bootstrap/css/bootstrap.min.css', __DIR__);
    $mce['content_style'] = "#tinymce {margin: 10px 15px!important;}";
    return $mce;
}