<?php 

// Utility Helper Functions

// Replace container with container fluid

function tbg3_wrap_container_fluid( $output, $original_output ) {
  if( 'open' == $original_output ) {
	   $output = sprintf( '<div %s>', genesis_attr( 'container-fluid' ) );
  }
  return $output;
}


