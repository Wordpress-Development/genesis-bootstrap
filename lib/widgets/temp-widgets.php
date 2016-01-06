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
 

/******************************************************************************************/
/*   Bootstrap 3 Widget Filters                                                           */
/******************************************************************************************/

if ( !class_exists('Widget_Output_Filters') ) {
class Widget_Output_Filters {
	public function __construct() {
		add_filter( 'dynamic_sidebar_params', array( $this, 'filter_dynamic_sidebar_params' ), 9 );
	}
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
	public function display_widget() {
		global $wp_registered_widgets;
		$original_callback_params = func_get_args();
		$widget_id = $original_callback_params[0]['widget_id'];
		$original_callback = $wp_registered_widgets[ $widget_id ]['original_callback'];
		$widget_id_base = $original_callback[0]->id_base;
		$sidebar_id = $original_callback_params[0]['id'];
		if ( is_callable( $original_callback ) ) {
			ob_start();
			call_user_func_array( $original_callback, $original_callback_params );
			$widget_output = ob_get_clean();
			echo apply_filters( 'widget_output', $widget_output, $widget_id_base, $widget_id, $sidebar_id );
		}
	}
}
new Widget_Output_Filters();
}

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
add_filter('wp_list_categories','categories_postcount_filter');
function categories_postcount_filter ($variable) {
	$variable = str_replace('( ', '<span class="badge"> ', $variable );
	$variable = str_replace( ')', ' </span>', $variable );
	return $variable;
}







/******************************************************************************************/
/*   Sidebar Styling - Uses bsg-classes-to-add filter                                     */
/******************************************************************************************/

/*  #http://bit.do/bootstrap-markup-php-L55 
add_filter('bsg-classes-to-add', 'bsg_modify_classes_based_on_template', 10, 3);   
function bsg_layout_options_modify_classes_to_add( $classes_to_add ) {
        $classes_to_add['widget'] = 'panel panel-default';
}
// */
    



/******************************************************************************************/
/*   Search Form - Using native in wordpress filter                                       */
/******************************************************************************************/

//*
add_filter( 'get_search_form', 'wop_bootstrap_search_form', 100);
function wop_bootstrap_search_form() {
	$value_or_placeholder = ( get_search_query() == '' ) ? 'placeholder' : 'value';
	$label = 'Search';
	$search_text = 'Search this website...';
	$button_text = 'Search';

$form = '<form method="get" class="search-form form-inline" action="'.home_url( '/' ).'" role="search">
    <div class="form-group">
        <label class="sr-only sr-only-focusable" for="bsg-search-form">'.esc_html( $label ).'</label>
        <div class="input-group">
            <input type="search" class="search-field form-control" id="search" name="s" '.$value_or_placeholder.'="'.esc_attr( $search_text ).'">
            <span class="input-group-btn">
                <button type="submit" class="search-submit btn btn-default">
                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                    <span class="sr-only">'.esc_attr( $button_text ).'</span>
                </button>
            </span>
        </div>
    </div>
</form>';

return $form;
}
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
/*  Sidebar Filters - Remove Widget Panel in Header                                       */
/******************************************************************************************/

//*
add_filter( 'dynamic_sidebar_params', 'wordpress_widgets_booststrapped_widget_params', 99 );
function wordpress_widgets_booststrapped_widget_params( $params ) { 
if ( ! is_admin() ) {
	  if(isset($params[0]['id']) && $params[0]['id'] == 'header-right'){
		$params[0]['before_widget'] = '';
    		$params[0]['after_widget'] = '';	  }
  		return $params;
	}
}
// */