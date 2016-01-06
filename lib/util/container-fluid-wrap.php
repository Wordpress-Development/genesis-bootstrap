<?php 
// Container Fluid
/**
* Replace theme supported container wraps with container fluid wraps using genesis_structural_wrap.
* Related File: https://github.com/Wordpress-Development/genesis-bootstrap/blob/master/lib/genesis-setup.php#L30
* Docs: https://github.com/Wordpress-Development/genesis-bootstrap/wiki/Bootstrap-Fluid-Containers
* 
* @param string $output The markup to be returned
* @param string $original_output Set to either 'open' or 'close'
*/
function bsg_wrap_container_fluid( $output, $original_output ) {
	switch ( $original_output ) {
		case 'open':
	   		$output = sprintf( '<div %s>', genesis_attr( 'container-fluid' ) );
  		break;
	}
  return $output;
}






function __bsg_wrap_container_fluid_all() {
    $genesis_atts = array(
	'menu-primary', 
	'menu-secondary', 
	'footer', 
	'jumbotron-inner', 
	'site-inner' 
    );
    foreach ( $genesis_atts as $context ) {
	$context = "genesis_attr_$context";
	$output = add_filter( $context, 'bsg_wrap_container_fluid', 11, 2 );
    }
    return $output;
}




<?php 
// Container Fluid
/**
* Replace theme supported container wraps with container fluid wraps using genesis_structural_wrap.
* Related File: https://github.com/Wordpress-Development/genesis-bootstrap/blob/master/lib/genesis-setup.php#L30
* Docs: https://github.com/Wordpress-Development/genesis-bootstrap/wiki/Bootstrap-Fluid-Containers
* 
* @param string $output The markup to be returned
* @param string $original_output Set to either 'open' or 'close'
*/



add_action('after_setup_theme', 'boot_gen_supports_structural_wraps')
/**
 * Support for Genesis Structural Wraps
 */
function boot_gen_supports_structural_wraps() {
	add_theme_support( 'genesis-structural-wraps', array( 
		'menu-primary', 
		'menu-secondary', 
		'footer', 
		'jumbotron-inner', 
		'site-inner' 
	) );
}


add_filter( 'genesis_attr_structural-wrap', 'boot_gen_structural_wrap_class_container_fluid' );
/**
 * Replaces all genesis .wrap class with .container-fluid by default 
 */
function boot_gen_structural_wrap_class_container_fluid( $attributes ) {
    $attributes['class'] = 'container-fluid';
    return $attributes;
}


/**
 * Add structural-wrap replacement utility function to use 
 * Bootstrap responsive .container class
 *
 * Useage: add_filter( 'genesis_structural_wrap-{$context}', 'bsg_wrap_container_fluid');
 */
function bsg_wrap_container_fluid( $output, $original_output ) {
	if ( $original_output == 'open' ) {
	   	$output = sprintf( '<div %s>', genesis_attr( 'container' ) );
	}
	return $output;
}


function __boot_gen_wrap_container() {
	$function = bsg_wrap_container_fluid();
	add_filter('', ) 
	
}



function do_container_fluid_structural_wrap( $context ) {
    $output = apply_filters( 'wrap_class-'$context, 'do_container_wrap' );
    $output = add_filter( 'genesis_structural_wrap-'$context, 'bsg_wrap_container_fluid', 16, 2);
    return $output;
}


add_filter('wrap_class-site-inner', 'do_container_wrap');




function gb3_structural_wrap_container () {
	return 'container-fluid'
}
function gb3_structural_wrap_container () {
	return ''
}





function __bsg_wrap_container_fluid_all() {
    $context = apply_filters ('genesis_structural_wrap_group', 
    array(
	'menu-primary', 
	'menu-secondary', 
	'footer', 
	'jumbotron-inner', 
	'site-inner' 
    );
    foreach ( $context as $tag_context ) {
    	$tag_context = apply_filters( genesis_structural_wrap_container_$tag_context, 'bsg_structural_wrap_container_fluid');
	$tag  = 'genesis_structural_wrap-'{$tag_context};
	$output  = add_filter( $tag, 'bsg_wrap_container_fluid', 11, 2 );
    }
    return $output;
}




/* Useage
-----------

On single page templates add this anywhere before genesis(); function :

__bsg_wrap_all_container_fluid();

Or use in functions.php :

function mytheme_return_full_wrap_pages(){
	if ( is_page('foo') ||  is_page('bar') {
		__bsg_wrap_all_container_fluid();
	}
}
add_action('genesis_before', 'mytheme_return_full_wrap_pages');

*/



/* # Other notes / experiments below - not tested in anyway

function brw_filter_footer_widgets_structural_wrap( $output, $original_output ) {
  	switch ( $original_output ) {
		case 'open':
			$output = sprintf( '<div %s>', genesis_attr( 'container-fluid' ) );
			break;
		case 'close':
			$output = '</div>';
			break;
	}
  	return $output;
}
add_filter( 'genesis_structural_wrap-site-inner', 'brw_filter_footer_widgets_structural_wrap', 99, 2);
// */

/*
function foo($wrap_context) {
    add_filter( 'genesis_structural_wrap-'{$wrap_context}, 'brw_filter_footer_widgets_structural_wrap', 99, 2);
}
foo('site-inner');
// */


/* Useage
-----------

On single page templates add this anywhere before genesis(); function :

__bsg_wrap_all_container_fluid();

Or use in functions.php :

function mytheme_return_full_wrap_pages(){
	if ( is_page('foo') ||  is_page('bar') {
		__bsg_wrap_all_container_fluid();
	}
}
add_action('genesis_before', 'mytheme_return_full_wrap_pages');

*/



/* # Other notes / experiments below - not tested in anyway

function brw_filter_footer_widgets_structural_wrap( $output, $original_output ) {
  	switch ( $original_output ) {
		case 'open':
			$output = sprintf( '<div %s>', genesis_attr( 'container-fluid' ) );
			break;
		case 'close':
			$output = '</div>';
			break;
	}
  	return $output;
}
add_filter( 'genesis_structural_wrap-site-inner', 'brw_filter_footer_widgets_structural_wrap', 99, 2);
// */

/*
function foo($wrap_context) {
    add_filter( 'genesis_structural_wrap-'{$wrap_context}, 'brw_filter_footer_widgets_structural_wrap', 99, 2);
}
foo('site-inner');
// */
