<?php

/******************************************************************************************/
/*   Sidebar Defaults - Filter Genesis Sidebar Default Markup to add Panels               */
/******************************************************************************************/

add_action( 'genesis_register_sidebar_defaults', 'twbsg_register_sidebar_defaults', 99 );
/**
 * Boostrap on Genesis sidebar defaults 
 *
 * @param  array $defaults Genesis defaults.
 * @return array           Modified Genesis defaults.
 */
function twbsg_register_sidebar_defaults( $defaults ) {
	return 	array(
		'before_widget' => '<section id="%1$s" class="panel panel-default widget %2$s"><div class="panel-body widget-wrap">',
		'after_widget'  => "</div></section>\n", 
		'before_title'  => '<h3 class="widgettitle">', 
		'after_title'   => "</h3>\n",
	);
}


/******************************************************************************************/
/*  Sidebar Filters - Remove Widget Wrap in Header                                        */
/******************************************************************************************/

add_filter( 'dynamic_sidebar_params', 'wordpress_widgets_booststrapped_widget_params', 99 );
/**
 * Wordpress Sidebar Filter 
 *
 * @param  array $defaults Genesis defaults.
 * @return array           Modified Genesis defaults.
 */
function wordpress_widgets_booststrapped_widget_params( $params ) { 
  if(isset($params[0]['id']) && $params[0]['id'] == 'header-right'){
    $params[0]['before_widget'] = printf( '<div %s>', genesis_attr( 'header-right-area' ) ); // before sidebar widget 
    $params[0]['after_widget']  = '</div>'; // after sidebar widget 
  }
  return $params;
}
