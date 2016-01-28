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





require_once dirname( __FILE__ ) . '/lib/genesis_setup';



function gb3_custom_theme_support() {
           $bsg = array(
                        'bsg-bootstrap-genesis-css'
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
	     $bsg = apply_filters('bsg_modify_theme', $bsg);
    }
    
    foreach ( $bsg as $file ) {
	  add_theme_support( $file );
    } 
    
}
add_action('after_setup_theme', 'gb3_custom_theme_support');



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
