<?php
/*----------------------------------------------------------------------------*
 * Bootstrap Header Support for IE and older browsers 
 *----------------------------------------------------------------------------*/
 
 
// Add no-js meta to html tag to <html> element
add_filter( 'language_attributes', 'bsg_doctype_language_atts_no_js' );
function bsg_doctype_language_atts_no_js($output) {
    return $output . ' class="no-js"';
}


// Remove 'viewport' tag 
remove_action( 'genesis_meta', 'genesis_responsive_viewport' );
add_theme_support('genesis-responsive-viewport');

// Add early for better rendering
add_action( 'genesis_doctype', 'bsg_browser_support', 99 );
function bsg_browser_support() {
?>
<?php genesis_responsive_viewport(); ?>
<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>
<?php
}


// Add IE compatability using wp functions : <meta http-equiv="X-UA-Compatible" content="IE=edge">
// This fixes validation errors and issues with ie
// For more approaches : http://stackoverflow.com/questions/6771258/whats-the-difference-if-meta-http-equiv-x-ua-compatible-content-ie-edge-e/8942455#8942455
add_action( 'send_headers', 'add_header_xua_compatible' );
function add_header_xua_compatible() {
	header( 'X-UA-Compatible: IE=edge,chrome=1' );
}



// HTML5shiv and Respond JS for older browsers and IE
// Should be added right before closing head tag
remove_action( 'wp_head', 'genesis_html5_ie_fix' ); // html5shiv.googlecode.com/svn/trunk/html5.js
add_action( 'wp_head', 'html5_shiv_respond_js_add_last', 999 );
function html5_shiv_respond_js_add_last() {	
?><!--[if lt IE 9]>
<script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<?php
}
