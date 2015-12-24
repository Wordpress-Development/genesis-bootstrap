<?php
/*----------------------------------------------------------------------------*
 * Bootstrap Header Support for IE and older browsers 
 *----------------------------------------------------------------------------*/
 
 
// Add no-js meta to html tag to <html> element
// http://www.paulirish.com/2009/avoiding-the-fouc-v3/
add_filter( 'language_attributes', 'bsg_js_detection_lang_atts' );
add_action( 'genesis_doctype', 'bsg_js_detection_script', 100 );

function bsg_js_detection_lang_atts($output) {
    return $output . ' class="no-js"';
}
function bsg_js_detection_script() {
    if ( has_filter( 'language_attributes', 'bsg_js_detection_lang_atts' ) ) {
        echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
    }
}



// Add IE compatability using wp functions : <meta http-equiv="X-UA-Compatible" content="IE=edge">
// This fixes validation errors and issues with ie
// https://codex.wordpress.org/Plugin_API/Action_Reference/send_headers
// http://stackoverflow.com/questions/6771258/whats-the-difference-if-meta-http-equiv-x-ua-compatible-content-ie-edge-e/8942455#8942455
// https://stackoverflow.com/questions/6771258/whats-the-difference-if-meta-http-equiv-x-ua-compatible-content-ie-edge-e
add_action( 'send_headers', 'bsg_add_header_xua_compatible' );
function bsg_add_header_xua_compatible() {
	header( 'X-UA-Compatible: IE=edge,chrome=1' );
}



// HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries 
// http://getbootstrap.com/getting-started/#support-ie8-ie9
// Should be added right before closing head tag
remove_action( 'wp_head', 'genesis_html5_ie_fix' ); // html5shiv.googlecode.com/svn/trunk/html5.js
add_action( 'wp_head', 'bsg_html5_shiv_respond_js_add_last', 999 );
function bsg_html5_shiv_respond_js_add_last() {	
?><!--[if lt IE 9]>
<script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<?php
}



// Remove 'viewport' tag from genesis_meta
remove_action( 'genesis_meta', 'genesis_responsive_viewport' );

// Allow theme to override with theme support method
// remove_theme_support('genesis-responsive-viewport');
function bootstrap_genesis_responsive_allow_child_theme_override() {
	if ( ! current_theme_supports( 'genesis-responsive-viewport' ) ) {
		add_theme_support('genesis-responsive-viewport');
	}
}
add_action('genesis_setup','bootstrap_genesis_responsive_allow_child_theme_override', 15);


// Add viewport earlier for better rendering
add_action( 'genesis_doctype', function() {
	return genesis_responsive_viewport();
});



// remove_action( 'wp_head', 'genesis_do_meta_pingback' );
