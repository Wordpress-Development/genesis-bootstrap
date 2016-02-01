<?php
/*
Plugin Name:        GB3 - Genesis Bootstrap 3
Plugin URI:         https://github.com/bryanwillis/bootstrap-genesis-addons/
Description:        Add Bootstrap to Genesis Theme via plugin
Version:            1.0.0
Author:             bryanwillis
Author URI:         https://github.com/bryanwillis/
License:            MIT License
License URI:        http://opensource.org/licenses/MIT
*/


defined( 'WPINC' ) or die;
register_activation_hook( __FILE__, 'activate_genesis_bootstrap_plugin_script_check' );
function activate_genesis_bootstrap_plugin_script_check() {
	// require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
	// genesis_detect_plugin( array $plugins )
	if ( ! function_exists('genesis_pre') ) {
		deactivate_plugins( plugin_basename( __FILE__ ) );
		wp_die( sprintf( __( 'Sorry, you can\'t activate %1$sGenesis Bootstrap unless you have installed the %3$sGenesis Framework%4$s. Go back to the %5$sPlugins Page%4$s.' ), '<em>', '</em>', '<a href="http://www.studiopress.com/themes/genesis" target="_blank">', '</a>', '<a href="javascript:history.back()">' ) );
	}
}

function deactivate_genesis_bootstrap_plugin_script_check() {
    if ( ! function_exists('genesis_pre') ) {
    		add_action( 'admin_notices', 'admin_notice_genesis_bootstrap_plugin_deactivate' );
		deactivate_plugins( plugin_basename( __FILE__ ) );
    }
} 
add_action('after_switch_theme', 'deactivate_genesis_bootstrap_plugin_script_check');



function admin_notice_genesis_bootstrap_plugin_deactivate() {
  ?>
  <div class="update-nag notice">
      <p><?php _e( 'Genesis Bootstrap plugin has been deactivated. You must have a Genesis theme active before you can reactivate.', 'genesis' ); ?></p>
  </div>
  <?php
}



// require_once dirname( __FILE__ ) . '/lib/genesis_setup';






/******************************************************************************************/
/*   Sidebar Defaults - Filter Genesis Sidebar Default Markup to add Panels               */
/******************************************************************************************/


add_action( 'genesis_register_widget_area_defaults', 'twbsg_register_sidebar_defaults', 99 );
/**
 * Boostrap on Genesis sidebar defaults 
 *
 * @param  array $defaults Genesis defaults.
 * @return array Modified Genesis defaults.
 */
function twbsg_register_sidebar_defaults( $defaults ) {
    $defaults = array(
    'before_widget' => '<section id="%1$s" class="panel panel-default widget %2$s"><div class="panel-body widget-wrap">',
    'after_widget'  => "</div></section>\n",
    'before_title'  => '<h4 class="widget-title widgettitle">',
    'after_title'   => "</h4>\n",
  );
    return $defaults;
}


/******************************************************************************************/
/*  Sidebar Filters - Remove Widget Wrap in Header                                        */
/******************************************************************************************/


// add_filter( 'dynamic_sidebar_params', 'wordpress_widgets_booststrapped_widget_params', 99 );
/**
 * Wordpress Sidebar Filter 
 *
 * @param  array $defaults Genesis defaults.
 * @return array           Modified Genesis defaults.
 */
 /*
function wordpress_widgets_booststrapped_widget_params( $params ) {
  if(isset($params[0]['id']) && $params[0]['id'] == 'header-right'){
    $params[0]['before_widget'] =  '';
    $params[0]['after_widget']  = '';
  }
  return $params;
}
// */







function gb3_custom_theme_support() {
           $theme_support = array(
                        'bsg-bootstrap-genesis-css',
                        'bsg-comments',
                        'bsg-footer',
                        'bsg-genesis-setup',
                        'bsg-grid',
                        'bsg-head',
                        'bsg-images',
                        'bsg-layouts',
                        'bsg-load-assets',
                        'bsg-mce-css',
                        'bsg-nav',
                        'bsg-pagination',
                        'bsg-post-content-nav',
                        'bsg-post',
                        'bsg-responsive-embed-widget',
                        'bsg-search-form',
                        'bsg-sidebar-styles',
                        'bsg-structural-wraps',
                        'bsg-widget-columns',
                        'bsg-widget-styles'
            );
    if(has_filter('bsg_modify_theme')) {
	     $theme_support = apply_filters('bsg_modify_theme', $theme_support);
    }
    foreach ( $theme_support as $file ) {
	   add_theme_support( $file );
    } 
}
add_action('plugins_loaded', 'gb3_custom_theme_support');



function bsg_load_lib_files() {
  global $_wp_theme_features;
  foreach (glob(__DIR__ . '/lib/functions/*.php') as $file) {
    $feature = 'bsg-' . basename($file, '.php');
    if (isset($_wp_theme_features[$feature])) {
      require_once $file;
    }
  }
}
add_action('after_setup_theme', 'bsg_load_lib_files', 100);




add_action( 'genesis_setup', 'news_secondheader', 15 );
function news_secondheader() {
  genesis_register_widget_area( array(
    'id'          => 'after-nav-primary',
    'name'        => __( 'Credits Left', 'jan' ),
    'description' => __( 'This is the footer Credits Left area.', 'jan' ),
  ));
}
