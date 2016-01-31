<?php
/** 
 * jQuery CDN with local fallback
 */
add_action('wp_enqueue_scripts', 'bsg_jquery_cdn', 100);
function bsg_jquery_cdn() {
  $suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
  $jquery_version = wp_scripts()->registered['jquery']->ver;
  wp_deregister_script('jquery');
  wp_register_script( 
	  'jquery', 
	  'https://ajax.googleapis.com/ajax/libs/jquery/' . $jquery_version . "/jquery{$suffix}.js", 
	  array(), 
	  null, 
	  true 
  );
  add_filter( 'script_loader_src', 'bsg_jquery_local_fallback', 10, 2 );
}
add_action( 'wp_head', 'bsg_jquery_local_fallback' );

function bsg_jquery_local_fallback( $src, $handle = null ) {
    static $add_jquery_fallback = false;
    if ($add_jquery_fallback) {
        echo '<script>window.jQuery || document.write(\'<script src="' . $add_jquery_fallback .'"><\/script>\')</script>' . "\n";
        $add_jquery_fallback = false;
    }
    if ($handle === 'jquery') {
        $add_jquery_fallback = apply_filters('script_loader_src', \includes_url('/js/jquery/jquery.js'), 'jquery-fallback');
    }
	return $src;
}
