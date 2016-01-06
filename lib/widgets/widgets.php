<?php
/******************************************************************************************/
/*  Sidebar Filters - Remove Widget Panel in Header                                       */
/******************************************************************************************/
//*
function wordpress_widgets_booststrapped_widget_params( $params ) { 
  if ('header-right' === $params[0]['id']) {
    $params[0]['before_widget'] = ''; // before sidebar widget 
    $params[0]['after_widget']  = ''; // after sidebar widget 
  }
  return $params;
}
add_filter( 'dynamic_sidebar_params', 'wordpress_widgets_booststrapped_widget_params', 99 );
// */


/******************************************************************************************/
/*   Sidebar Defaults - Filter Genesis Sidebar Default Markup to add Panels               */
/******************************************************************************************/
//*
function gb3_register_sidebar_defaults( $defaults ) {
	$defaults['before_widget'] = '<section id="%1$s" class="panel panel-default widget %2$s"><div class="panel-body widget-wrap">';
	
	
	return $defaults;
}
add_filter( 'genesis_register_widget_area_defaults', 'gb3_register_sidebar_defaults', 99);
// */






/******************************************************************************************/
/*   Bootstrap 3 Widget Filters  -  Experimental Feature                                  */
/******************************************************************************************/
//*
if ( ! function_exists('bootstrap_genesis_widget_output_filters_dynamic_sidebar_params') ) {
	function bootstrap_genesis_widget_output_filters_dynamic_sidebar_params( $sidebar_params ) {
		if ( is_admin() ) {
			return $sidebar_params;
		}
		global $wp_registered_widgets;
		$widget_id = $sidebar_params[0]['widget_id'];
		$wp_registered_widgets[ $widget_id ]['original_callback'] = $wp_registered_widgets[ $widget_id ]['callback'];
		$wp_registered_widgets[ $widget_id ]['callback'] = 'bootstrap_genesis_widget_output_filters_display_widget';
		return $sidebar_params;
	}
	add_filter( 'dynamic_sidebar_params', 'bootstrap_genesis_widget_output_filters_dynamic_sidebar_params', 9 );
}

if ( ! function_exists('bootstrap_genesis_widget_output_filters_display_widget') ) {
	function bootstrap_genesis_widget_output_filters_display_widget() {
		global $wp_registered_widgets;
		$original_callback_params = func_get_args();
		$widget_id = $original_callback_params[0]['widget_id'];
		$original_callback = $wp_registered_widgets[ $widget_id ]['original_callback'];
		$wp_registered_widgets[ $widget_id ]['callback'] = $original_callback;
		$widget_id_base = $wp_registered_widgets[ $widget_id ]['callback'][0]->id_base;
		if ( is_callable( $original_callback ) ) {
			ob_start();
			call_user_func_array( $original_callback, $original_callback_params );
			$widget_output = ob_get_clean();
			echo apply_filters( 'widget_output', $widget_output, $widget_id_base, $widget_id );
		}
	}
}
// */







//* // SIDEBAR WIDGETS
function bootstrap_genesis_sidebar_widget_output_filters( $widget_output, $widget_type, $widget_id ) {
	
	switch( $widget_type ) {
		
		case 'categories' :
      			$widget_output = str_replace('<ul>', '<ul class="list-group">', $widget_output);
      			$widget_output = str_replace('<li class="cat-item cat-item-', '<li class="list-group-item cat-item cat-item-', $widget_output);
      			$widget_output = str_replace('(', '<span class="badge cat-item-count"> ', $widget_output);
      			$widget_output = str_replace(')', ' </span>', $widget_output);
      			break;
		case 'calendar' :
			$widget_output = str_replace('calendar_wrap', 'calendar_wrap table-responsive', $widget_output);
        		$widget_output = str_replace('<table id="wp-calendar', '<table class="table table-condensed" id="wp-calendar', $widget_output);
    			break;
		case 'tag_cloud' :    	
			$regex = "/(<a[^>]+?)( style='font-size:.+pt;'>)([^<]+?)(<\/a>)/"; //clean up
			$replace_with = "$1><span class='label label-primary'>$3</span>$4";
			$widget_output = preg_replace( $regex , $replace_with , $widget_output );
    			break;
		case 'archives' :	
      			$widget_output = str_replace('<ul>', '<ul class="list-group">', $widget_output);
      			$widget_output = str_replace('<li>', '<li class="list-group-item">', $widget_output);
			$widget_output = str_replace('(', '<span class="badge cat-item-count"> ', $widget_output);
   			$widget_output = str_replace(')', ' </span>', $widget_output);
    			break;
		case 'meta' :   	
        		$widget_output = str_replace('<ul>', '<ul class="list-group">', $widget_output);
        		$widget_output = str_replace('<li>', '<li class="list-group-item">', $widget_output);
    			break;
		case 'recent-posts' :   	
        		$widget_output = str_replace('<ul>', '<ul class="list-group">', $widget_output);
        		$widget_output = str_replace('<li>', '<li class="list-group-item">', $widget_output);
			$widget_output = str_replace('class="post-date"', 'class="post-date text-muted small"', $widget_output);
			//$widget_output = str_replace('class="post-date"', 'class="post-date label label-primary"', $widget_output);
    			break;
		case 'recent-comments' :   	
        		$widget_output = str_replace('<ul id="recentcomments">', '<ul id="recentcomments" class="list-group">', $widget_output);
        		$widget_output = str_replace('<li class="recentcomments">', '<li class="recentcomments list-group-item">', $widget_output);
     			break;
		case 'pages' :   	
	        	$widget_output = str_replace('<ul>', '<ul class="nav nav-stacked nav-pills">', $widget_output);
	     		break;
		case 'nav_menu' :   	
	        	$widget_output = str_replace(' class="menu"', 'class="menu nav nav-stacked nav-pills"', $widget_output);
	    		break;
    		default:
			$widget_output = $widget_output;
			
	}
      return $widget_output;
}
add_filter( 'widget_output', 'wop_bootstrap_widget_output_filters', 10, 3 );
// */




//* // FOOTER WIDGETS
function bootstrap_genesis_footer_widget_output_filters( $widget_output, $widget_type, $widget_id ) {
    	
    	switch( $widget_type ) {
		
		case 'categories' :
		        $widget_output = str_replace('<ul>', '<ul class="list-unstyled">', $widget_output);
			$widget_output = str_replace('(', '<span class="badge cat-item-count"> ', $widget_output);
   			$widget_output = str_replace(')', ' </span>', $widget_output);
		case 'calendar' :
			$widget_output = str_replace('calendar_wrap', 'calendar_wrap table-responsive', $widget_output);
		        $widget_output = str_replace('<table id="wp-calendar', '<table class="table table-condensed" id="wp-calendar', $widget_output);
		case 'tag_cloud' :    	
			$regex = "/(<a[^>]+?)( style='font-size:.+pt;'>)([^<]+?)(<\/a>)/";
			$replace_with = "$1><span class='label label-primary'>$3</span>$4";
			$widget_output = preg_replace( $regex , $replace_with , $widget_output );
		case 'archives' :	
        		$widget_output = str_replace('<ul>', '<ul class="list-unstyled">', $widget_output);
	    		$widget_output = str_replace('(', '<span class="badge cat-item-count"> ', $widget_output);
   			$widget_output = str_replace(')', ' </span>', $widget_output);
   			break;
		case 'meta' :   	
			$widget_output = str_replace('<ul>', '<ul class="list-unstyled">', $widget_output);
 	    		break;
		case 'recent-posts' :   	
 	    		$widget_output = str_replace('<ul>', '<ul class="list-unstyled">', $widget_output);
 	    		break;
		case 'recent-comments' :  
        		$widget_output = str_replace('<ul id="recentcomments">', '<ul id="recentcomments" class="list-unstyled">', $widget_output);
 	    		break;
		case 'pages' :   	
        		$widget_output = str_replace('<ul>', '<ul class="list-unstyled">', $widget_output);
 	    		break;
 		case 'nav_menu' :   	
        		$widget_output = str_replace(' class="menu"', 'class="menu list-unstyled"', $widget_output);
	    		break;
    		default:
			$widget_output = $widget_output;
	}
      return $widget_output;
}
// */




//* // Hooks for widget filtering
function gb3_do_widget_filters_on_sidebar() {
    add_filter( 'widget_output', 'my_widget_output_filter', 10, 3 );
}
add_action( 'genesis_before_sidebar_widget_area', 'gb3_do_widget_filters_on_sidebar' );
add_action( 'genesis_before_sidebar_alt_widget_area', 'gb3_do_widget_filters_on_sidebar' );

function gb3_do_widget_filters_on_footer() {
    remove_filter( 'widget_output', 'my_widget_output_filter');
    add_filter( 'widget_output', 'my_widget_output_filter_footer', 10, 3 );
}
add_action( 'genesis_before_footer', 'gb3_do_widget_filters_on_footer'  );
// */
