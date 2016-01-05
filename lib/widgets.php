<?php

function genesis_add_bs_widgets_form($t,$return,$instance) {
    $instance = wp_parse_args(
        (array)$instance,
        array(
          'genesis_bs_row_start'        => '',
          'genesis_bs_row_end'          => '',
          'genesis_bs_col_lg'           => '',
          'genesis_bs_col_lg_offset'    => '',
          'genesis_bs_col_md'           => '',
          'genesis_bs_col_md_offset'    => '',      
          'genesis_bs_col_sm'           => '',
          'genesis_bs_col_sm_offset'    => '',  
          'genesis_bs_col_xs'           => '',
          'genesis_bs_col_xs_offset'    => '',
          'genesis_bs_hide_lg'          => '',
          'genesis_bs_hide_md'          => '',
          'genesis_bs_hide_sm'          => '',
          'genesis_bs_hide_xs'          => '',
        )
    );
    $cols = array(0,1,2,3,4,5,6,7,8,9,10,11,12);
    ?>
    <div class="genesis-bs-widget-columns">
      <h3><a href="#" class="genesis-bs-widget-columns-handle"><?php _e('Bootstrap grid class', 'genesis-bscol'); ?> <span class="dashicons dashicons-arrow-down-alt"></span></a></h3>
      <div class="genesis-bs-widget-columns-inner">
        <hr>
    <!-- Rows -->
        <div class="form-group">
          <label for="<?php echo $t->get_field_id('genesis_bs_row_start'); ?>">
          <input
            class="genesis-bs-grid-input"
            id="<?php echo $t->get_field_id('genesis_bs_row_start'); ?>"
            name="<?php echo $t->get_field_name('genesis_bs_row_start'); ?>"
            type="checkbox"
            value="1"
            <?php echo $instance['genesis_bs_row_start'] == '1' ? ' checked="checked"' : ''; ?>>
            <?php _e('Open a .row', 'genesis-bscol'); ?></label>
        </div>
    
        <div class="form-group">
          <label for="<?php echo $t->get_field_id('genesis_bs_row_end'); ?>">
          <input
            class="genesis-bs-grid-input"
            id="<?php echo $t->get_field_id('genesis_bs_row_end'); ?>"
            type="checkbox"
            name="<?php echo $t->get_field_name('genesis_bs_row_end'); ?>"
            value="1"
            <?php echo $instance['genesis_bs_row_end'] == '1' ? ' checked="checked"' : ''; ?>>
            <?php _e('Close a .row', 'genesis-bscol'); ?></label>
        </div>
        <hr>
    
    
    <p>
    <!-- <i class="fa fa-desktop"></i> -->
    <span class="dashicons dashicons-desktop"></span> <?php _e('Desktops ', 'genesis-bscol'); ?>
    </p>
    <div class="form-inline">
        <div class="form-group">          
    <label for="<?php echo $t->get_field_id('genesis_bs_col_lg'); ?>"><?php _e('.col-lg- ', 'genesis'); ?></label>
          <select class="widefat" id="<?php echo $t->get_field_id('genesis_bs_col_lg'); ?>" name="<?php echo $t->get_field_name('genesis_bs_col_lg'); ?>">
            <?php foreach($cols as $col) : ?>
              <option value="<?php echo $col; ?>" <?php echo $instance['genesis_bs_col_lg'] == $col ? ' selected="selected"' : ''; ?>><?php echo $col; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">          
          <label for="<?php echo $t->get_field_id('genesis_bs_col_lg_offset'); ?>"><?php _e('.col-lg-offset- ', 'genesis'); ?></label>
          <select class="widefat" id="<?php echo $t->get_field_id('genesis_bs_col_lg_offset'); ?>" name="<?php echo $t->get_field_name('genesis_bs_col_lg_offset'); ?>">
            <?php foreach($cols as $col) : ?>
              <option value="<?php echo $col; ?>" <?php echo $instance['genesis_bs_col_lg_offset'] == $col ? ' selected="selected"' : ''; ?>><?php echo $col; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
    </div>  
    
    <hr>
        
    <p>
    <!-- <i class="fa fa-laptop"></i> -->
    <span class="dashicons dashicons-tablet"></span> <?php _e('Labtops ', 'genesis-bscol'); ?>
    </p>
        
    <div class="form-inline">
        
        <div class="form-group">          
          <label for="<?php echo $t->get_field_id('genesis_bs_col_md'); ?>"><?php _e('.col-md- ', 'genesis'); ?></label>
          <select class="widefat" id="<?php echo $t->get_field_id('genesis_bs_col_md'); ?>" name="<?php echo $t->get_field_name('genesis_bs_col_md'); ?>">
            <?php foreach($cols as $col) : ?>
              <option value="<?php echo $col; ?>" <?php echo $instance['genesis_bs_col_md'] == $col ? ' selected="selected"' : ''; ?>><?php echo $col; ?></option>
            <?php endforeach; ?>
          </select>
        </div>    
        
        <div class="form-group">          
          <label for="<?php echo $t->get_field_id('genesis_bs_col_md_offset'); ?>"><?php _e('.col-md-offset- ', 'genesis'); ?></label>
          <select class="widefat" id="<?php echo $t->get_field_id('genesis_bs_col_md_offset'); ?>" name="<?php echo $t->get_field_name('genesis_bs_col_md_offset'); ?>">
            <?php foreach($cols as $col) : ?>
              <option value="<?php echo $col; ?>" <?php echo $instance['genesis_bs_col_md_offset'] == $col ? ' selected="selected"' : ''; ?>><?php echo $col; ?></option>
            <?php endforeach; ?>
          </select>
        </div>        
    </div>  
        
    <hr>  
    
    <p>
    <!-- <i class="fa fa-tablet"></i> -->
    <span class="dashicons dashicons-smartphone"></span> <?php _e('Tablets ', 'genesis-bscol'); ?>
    </p>

    <div class="form-inline">
    <div class="form-group">          
          <label for="<?php echo $t->get_field_id('genesis_bs_col_sm'); ?>"><?php _e('.col-sm- ', 'genesis'); ?></label>
          <select class="widefat" id="<?php echo $t->get_field_id('genesis_bs_col_sm'); ?>" name="<?php echo $t->get_field_name('genesis_bs_col_sm'); ?>">
            <?php foreach($cols as $col) : ?>
              <option value="<?php echo $col; ?>" <?php echo $instance['genesis_bs_col_sm'] == $col ? ' selected="selected"' : ''; ?>><?php echo $col; ?></option>
            <?php endforeach; ?>
          </select>
        </div>  
        
        <div class="form-group">          
          <label for="<?php echo $t->get_field_id('genesis_bs_col_sm_offset'); ?>"><?php _e('.col-sm-offset- ', 'genesis'); ?></label>
          <select class="widefat" id="<?php echo $t->get_field_id('genesis_bs_col_sm_offset'); ?>" name="<?php echo $t->get_field_name('genesis_bs_col_sm_offset'); ?>">
            <?php foreach($cols as $col) : ?>
              <option value="<?php echo $col; ?>" <?php echo $instance['genesis_bs_col_sm_offset'] == $col ? ' selected="selected"' : ''; ?>><?php echo $col; ?></option>
            <?php endforeach; ?>
          </select>
        </div>        
        </div>
        
    <hr>

    <p>
    <!-- <i class="fa fa-mobile"></i> -->
    <span class="dashicons dashicons-phone"></span> <?php _e('Phones ', 'genesis-bscol'); ?> 
    </p>

    <div class="form-inline">
    <div class="form-group">          
          <label for="<?php echo $t->get_field_id('genesis_bs_col_xs'); ?>"><?php _e('.col-xs- ', 'genesis'); ?></label>
          <select class="widefat" id="<?php echo $t->get_field_id('genesis_bs_col_xs'); ?>" name="<?php echo $t->get_field_name('genesis_bs_col_xs'); ?>">
            <?php foreach($cols as $col) : ?>
              <option value="<?php echo $col; ?>" <?php echo $instance['genesis_bs_col_xs'] == $col ? ' selected="selected"' : ''; ?>><?php echo $col; ?></option>
            <?php endforeach; ?>
          </select>
        </div>        

        <div class="form-group">              
          <label for="<?php echo $t->get_field_id('genesis_bs_col_xs_offset'); ?>"><?php _e('.col-xs-offset- ', 'genesis'); ?></label>
          <select class="widefat" id="<?php echo $t->get_field_id('genesis_bs_col_xs_offset'); ?>" name="<?php echo $t->get_field_name('genesis_bs_col_xs_offset'); ?>">
            <?php foreach($cols as $col) : ?>
              <option value="<?php echo $col; ?>" <?php echo $instance['genesis_bs_col_xs_offset'] == $col ? ' selected="selected"' : ''; ?>><?php echo $col; ?></option>
            <?php endforeach; ?>
          </select>
        </div>        
        </div>
        
        
    <hr>
        <p>
          <label for="<?php echo $t->get_field_id('genesis_bs_hide_lg'); ?>">
          <input
            class="genesis-bs-grid-input"
            id="<?php echo $t->get_field_id('genesis_bs_hide_lg'); ?>"
            type="checkbox"
            name="<?php echo $t->get_field_name('genesis_bs_hide_lg'); ?>"
            value="1"
            <?php echo $instance['genesis_bs_hide_lg'] == '1' ? ' checked="checked"' : ''; ?>>
            <?php _e('Hide on .col-lg', 'genesis'); ?></label>
        </p>
        <p>
          <label for="<?php echo $t->get_field_id('genesis_bs_hide_md'); ?>">
          <input
            class="genesis-bs-grid-input"
            id="<?php echo $t->get_field_id('genesis_bs_hide_md'); ?>"
            type="checkbox"
            name="<?php echo $t->get_field_name('genesis_bs_hide_md'); ?>"
            value="1"
            <?php echo $instance['genesis_bs_hide_md'] == '1' ? ' checked="checked"' : ''; ?>>
            <?php _e('Hide on .col-md', 'genesis'); ?></label>
        </p>
        <p>
            <label for="<?php echo $t->get_field_id('genesis_bs_hide_sm'); ?>">
            <input
              class="genesis-bs-grid-input"
              id="<?php echo $t->get_field_id('genesis_bs_hide_sm'); ?>"
              type="checkbox"
              name="<?php echo $t->get_field_name('genesis_bs_hide_sm'); ?>"
              value="1"
              <?php echo $instance['genesis_bs_hide_sm'] == '1' ? ' checked="checked"' : ''; ?>>
              <?php _e('Hide on .col-sm', 'genesis'); ?></label>
        </p>
        <p>
          <label for="<?php echo $t->get_field_id('genesis_bs_hide_xs'); ?>">
          <input
            class="genesis-bs-grid-input"
            id="<?php echo $t->get_field_id('genesis_bs_hide_xs'); ?>"
            type="checkbox"
            name="<?php echo $t->get_field_name('genesis_bs_hide_xs'); ?>"
            value="1"
            <?php echo $instance['genesis_bs_hide_xs'] == '1' ? ' checked="checked"' : ''; ?>>
            <?php _e('Hide on .col-xs', 'genesis'); ?></label>
        </p>
        
      </div>
    </div>
    <?php
    $return = null;
    return array($t,$return,$instance);
}
add_action('in_widget_form', 'genesis_add_bs_widgets_form',5,3);
function genesis_add_bs_widgets_form_update($instance, $new_instance, $old_instance){
    $instance['genesis_bs_row_start'] = $new_instance['genesis_bs_row_start'];
    $instance['genesis_bs_row_end']   = $new_instance['genesis_bs_row_end'];
    $instance['genesis_bs_col_lg']    = $new_instance['genesis_bs_col_lg'];
  $instance['genesis_bs_col_lg_offset']    = $new_instance['genesis_bs_col_lg_offset'];
    $instance['genesis_bs_col_md']    = $new_instance['genesis_bs_col_md'];
    $instance['genesis_bs_col_md_offset']    = $new_instance['genesis_bs_col_md_offset'];
    $instance['genesis_bs_col_sm']    = $new_instance['genesis_bs_col_sm'];
    $instance['genesis_bs_col_sm_offset']    = $new_instance['genesis_bs_col_sm_offset'];
    $instance['genesis_bs_col_xs']    = $new_instance['genesis_bs_col_xs'];
    $instance['genesis_bs_col_xs_offset']    = $new_instance['genesis_bs_col_xs_offset'];
    $instance['genesis_bs_hide_lg']   = $new_instance['genesis_bs_hide_lg'];
    $instance['genesis_bs_hide_md']   = $new_instance['genesis_bs_hide_md'];
    $instance['genesis_bs_hide_sm']   = $new_instance['genesis_bs_hide_sm'];
    $instance['genesis_bs_hide_xs']   = $new_instance['genesis_bs_hide_xs'];
  
    return $instance;
}
add_filter('widget_update_callback', 'genesis_add_bs_widgets_form_update',5,3);
function genesis_add_bs_widgets_dynamic_sidebar_params($params){
    global $wp_registered_widgets;
    $widget_id = $params[0]['widget_id'];
    $widget_obj = $wp_registered_widgets[$widget_id];
    $widget_opt = get_option($widget_obj['callback'][0]->option_name);
    $widget_num = $widget_obj['params'][0]['number'];
    $classes = array();
    $cols = array(
      'genesis_bs_col_lg'         =>'col-lg-',
      'genesis_bs_col_lg_offset'  =>'col-lg-offset-',
      'genesis_bs_col_md'         =>'col-md-',
      'genesis_bs_col_md_offset'  =>'col-md-offset-',
      'genesis_bs_col_sm'         =>'col-sm-',
      'genesis_bs_col_sm_offset'  =>'col-sm-offset-',
      'genesis_bs_col_xs'         =>'col-xs-',
      'genesis_bs_col_xs_offset'  =>'col-xs-offset-',
      'genesis_bs_hide_lg'        =>'hidden-lg',
      'genesis_bs_hide_md'        =>'hidden-md',
      'genesis_bs_hide_sm'        =>'hidden-sm',
      'genesis_bs_hide_sm'        =>'hidden-xs',
    );
    foreach($cols as $col_opt => $col)
    {
      if(isset($widget_opt[$widget_num][$col_opt]) && $widget_opt[$widget_num][$col_opt] != '0')
        $classes[] = strpos($col_opt, 'hide') ? $col : $col.$widget_opt[$widget_num][$col_opt];
    }
        $params[0]['before_widget'] = str_replace(
        'class="',
        'class="' . join(' ', $classes ) . ' ',
        $params[0]['before_widget']
    );
    if(isset($widget_opt[$widget_num]['genesis_bs_row_start']) && $widget_opt[$widget_num]['genesis_bs_row_start'] == '1')
      $params[0]['before_widget'] = '<div class="row">'.$params[0]['before_widget'];
    if(isset($widget_opt[$widget_num]['genesis_bs_row_end']) && $widget_opt[$widget_num]['genesis_bs_row_end'] == '1')
      $params[0]['after_widget'] = $params[0]['after_widget'].'</div><!-- /.row -->';
    return $params;
}
add_filter('dynamic_sidebar_params', 'genesis_add_bs_widgets_dynamic_sidebar_params', 9);


function genesis_add_bs_widgets_head_style()
{
    echo '<style>.genesis-bs-widget-columns label{font-weight: bold;}.genesis-bs-widget-columns>h3 {background:#0074a2;color:#fff;border-top:3px solid #0074a2;text-align:center;border-radius:4px}.genesis-bs-widget-columns>h3>a{line-height:30px;color:#fff}.genesis-bs-widget-columns>h3>a span{line-height:30px;color:#fff}.genesis-bs-widget-columns-inner{display:none;}.genesis-bs-widget-columns-handle{text-decoration:none;}</style>';    
    echo '<script type="text/javascript">
            jQuery(document).ready(function($){
              $("body").on("click", ".genesis-bs-widget-columns-handle", function(){
                $(this).parent().siblings(".genesis-bs-widget-columns-inner").slideToggle();
                return false;
              });
            });
        </script>';
  }
add_action('admin_head-widgets.php', 'genesis_add_bs_widgets_head_style');
add_action('customize_controls_print_scripts', 'genesis_add_bs_widgets_head_style', 9999);










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