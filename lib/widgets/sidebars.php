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
    $params[0]['before_widget'] = printf( '<div %s>', genesis_attr( 'header-right-area' ) ); // before sidebar widget 
    $params[0]['after_widget']  = '</div>'; // after sidebar widget 
  }
  return $params;
}
add_filter( 'dynamic_sidebar_params', 'wordpress_widgets_booststrapped_widget_params', 99 );
// */



/******************************************************************************************/
/*   Sidebar Styling - Uses bsg-classes-to-add filter                                     */
/******************************************************************************************/

/*  #http://bit.do/bootstrap-markup-php-L55 
add_filter('bsg-classes-to-add', 'bsg_modify_classes_based_on_template', 10, 3);   
function bsg_layout_options_modify_classes_to_add( $classes_to_add ) {
        $classes_to_add['widget'] = 'panel panel-default';
}
// */
