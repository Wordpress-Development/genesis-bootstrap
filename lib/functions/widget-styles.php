<?php
/**
 * Wordpress Widgets Bootstrapped for Genesis
 *
 * @package   Wordpress Widgets Bootstrapped
 * @author    Bryan Willis
 * @link      http://wordpress.stackexchange.com/a/211634/43806
 */
 
/**
 * This plugin does the following on activation:
 * - Filters the html markup to support Bootstrap 3 styling for Genesis
 * - Supports - categories, calendar, tag cloud, archives, meta, recent-posts, recent-comments, pages, nav-menu, search
 */



class Widget_Output_Filters {

	/**
	 * Initializes the functionality by registering actions and filters.
	 */
	public function __construct() {

		// Priority of 9 to run before the Widget Logic plugin.
		add_filter( 'dynamic_sidebar_params', array( $this, 'filter_dynamic_sidebar_params' ), 9 );
	}

	/**
	 * Replaces the widget's display callback with the Dynamic Sidebar Params display callback, storing the original callback for use later.
	 *
	 * The $sidebar_params variable is not modified; it is only used to get the current widget's ID.
	 *
	 * @param array $sidebar_params The sidebar parameters.
	 *
	 * @return array The sidebar parameters
	 */
	public function filter_dynamic_sidebar_params( $sidebar_params ) {

		if ( is_admin() ) {
			return $sidebar_params;
		}

		global $wp_registered_widgets;
		$current_widget_id = $sidebar_params[0]['widget_id'];

		$wp_registered_widgets[ $current_widget_id ]['original_callback'] = $wp_registered_widgets[ $current_widget_id ]['callback'];
		$wp_registered_widgets[ $current_widget_id ]['callback'] = array( $this, 'display_widget' );

		return $sidebar_params;
	}

	/**
	 * Execute the widget's original callback function, filtering its output.
	 */
	public function display_widget() {

		global $wp_registered_widgets;
		$original_callback_params = func_get_args();

		$widget_id         = $original_callback_params[0]['widget_id'];
		$original_callback = $wp_registered_widgets[ $widget_id ]['original_callback'];

		$widget_id_base = $original_callback[0]->id_base;
		$sidebar_id     = $original_callback_params[0]['id'];

		if ( is_callable( $original_callback ) ) {

			ob_start();
			call_user_func_array( $original_callback, $original_callback_params );
			$widget_output = ob_get_clean();

			/**
			 * Filter the widget's output.
			 *
			 * @param string $widget_output  The widget's output.
			 * @param string $widget_id_base The widget's base ID.
			 * @param string $widget_id      The widget's full ID.
			 * @param string $sidebar_id     The current sidebar ID.
			 */
			echo apply_filters( 'widget_output', $widget_output, $widget_id_base, $widget_id, $sidebar_id );
		}
	}
}

new Widget_Output_Filters();




/******************************************************************************************/
/*   Bootstrap 3 Widget Filters                                                           */
/******************************************************************************************/


add_filter( 'widget_output', 'wop_bootstrap_widget_output_filters', 10, 4 );
function wop_bootstrap_widget_output_filters( $widget_output, $widget_type, $widget_id, $sidebar_id ) {
   
	if ( $widget_type === 'calendar' ) {
		$widget_output = str_replace('calendar_wrap', 'calendar_wrap table-responsive', $widget_output);
		$widget_output = str_replace('<table id="wp-calendar', '<table class="table table-condensed" id="wp-calendar', $widget_output);     
   	}
  
	if ( $widget_type === 'tag_cloud' ) {
		$regex = "/(<a[^>]+?)( style='font-size:.+pt;'>)([^<]+?)(<\/a>)/";
		$replace_with = "$1><span class='label label-primary'>$3</span>$4";
		$widget_output = preg_replace( $regex , $replace_with , $widget_output );      
	}
   
	if ( 'sidebar' === $sidebar_id || 'sidebar-alt' === $sidebar_id ) {
		if ( $widget_type === 'categories' ) {
      		$widget_output = str_replace('<ul>', '<ul class="list-group">', $widget_output);
      		$widget_output = str_replace('<li class="cat-item cat-item-', '<li class="list-group-item cat-item cat-item-', $widget_output);
      	    $widget_output = str_replace('postform', 'postform form-control', $widget_output);
		}
		elseif ( $widget_type === 'archives' ) {
      		$widget_output = str_replace('<ul>', '<ul class="list-group">', $widget_output);
      		$widget_output = str_replace('<li>', '<li class="list-group-item">', $widget_output);
      		$widget_output = str_replace('<select id="archives-dropdown', '<select class="form-control" id="archives-dropdown', $widget_output);
			$widget_output = str_replace('(', '<span class="badge cat-item-count">', $widget_output);
   			$widget_output = str_replace(')', ' </span>', $widget_output);
		}
		elseif ( $widget_type === 'meta' ) {
        	$widget_output = str_replace('<ul>', '<ul class="list-group">', $widget_output);
        	$widget_output = str_replace('<li>', '<li class="list-group-item">', $widget_output);
		}
		elseif ( $widget_type === 'recent-posts' ) {
        	$widget_output = str_replace('<ul>', '<ul class="list-group">', $widget_output);
        	$widget_output = str_replace('<li>', '<li class="list-group-item">', $widget_output);
        	$widget_output = str_replace('class="post-date"', 'class="post-date text-muted small"', $widget_output);
		}
		elseif ( $widget_type === 'recent-comments' ) {
        	$widget_output = str_replace('<ul id="recentcomments">', '<ul id="recentcomments" class="list-group">', $widget_output);
        	$widget_output = str_replace('<li class="recentcomments">', '<li class="recentcomments list-group-item">', $widget_output);
		}
		elseif ( $widget_type === 'pages' ) {
		    $widget_output = str_replace('<ul>', '<ul class="nav nav-stacked nav-pills">', $widget_output);
       	}
       	elseif ( $widget_type === 'nav-menu' ) {
	       	$widget_output = str_replace(' class="menu"', 'class="menu nav nav-stacked nav-pills"', $widget_output);	
       	}
	} 
    	return $widget_output;
}


// Using widget_output to do this breaks throws dev console erros due to dynamic javascript being added for nested categories
// A quick fix is to just use the wp_list_categories filter otherwise more advanced regex like tag cloud example needs to be written
add_filter('wp_list_categories','categories_postcount_filter', 99);
function categories_postcount_filter ($variable) {
	$variable = str_replace('(', '<span class="badge">', $variable );
	$variable = str_replace( ')', ' </span>', $variable );
	return $variable;
}
