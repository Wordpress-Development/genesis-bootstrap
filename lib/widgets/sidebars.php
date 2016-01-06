<?php

/******************************************************************************************/
/*   Sidebar Defaults - Filter Genesis Sidebar Default Markup to add Panels               */
/******************************************************************************************/
//*
function gb3_register_sidebar_defaults( $defaults ) {
	$defaults['before_widget'] = '<section id="%1$s" class="panel panel-default widget %2$s"><div class="panel-body widget-wrap">';
        $defaults['after_widget'] = '</div></section>';
	return $defaults;
}
add_filter( 'genesis_register_widget_area_defaults', 'gb3_register_sidebar_defaults', 99);
// */

/******************************************************************************************/
/*  Sidebar Filters - Remove Widget Wrap in Header                                        */
/******************************************************************************************/
//*
function wordpress_widgets_booststrapped_widget_params( $params ) { 
  if(isset($params[0]['id']) && $params[0]['id'] == 'header-right'){
    $params[0]['before_widget'] = '<div '; // before sidebar widget 
    $params[0]['after_widget']  = ''; // after sidebar widget 
  }
  return $params;
}
add_filter( 'dynamic_sidebar_params', 'wordpress_widgets_booststrapped_widget_params', 99 );
// */
