<?php 
// Utility Helper Functions

/**
* Replace theme supported container wraps with container fluid wraps using genesis_structural_wrap.
* Related File: https://github.com/Wordpress-Development/genesis-bootstrap/blob/master/lib/genesis-setup.php#L30
* Docs: https://github.com/Wordpress-Development/genesis-bootstrap/wiki/Bootstrap-Fluid-Containers
* 
* @param string $output The markup to be returned
* @param string $original_output Set to either 'open' or 'close'
*/
function tbg3_wrap_container_fluid( $output, $original_output ) {
  if( 'open' == $original_output ) {
	   $output = sprintf( '<div %s>', genesis_attr( 'container-fluid' ) );
  }
  return $output;
}

/*
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
add_filter( 'genesis_structural_wrap-site-inner', 'brw_filter_footer_widgets_structural_wrap', 999, 2);
// */
