<?php 

// Utility Helper Functions

// Replace container with container fluid

function tbg3_wrap_container_fluid( $output, $original_output ) {
  if( 'open' == $original_output ) {
	   $output = sprintf( '<div %s>', genesis_attr( 'container-fluid' ) );
  }
  return $output;
}


/*
function jmw_filter_footer_widgets_structural_wrap( $output, $original_output ) {
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
add_filter( "genesis_structural_wrap-site-inner", 'jmw_filter_footer_widgets_structural_wrap', 999, 2);
// */
