<?php
/*
Plugin Name:        GB3 - Genesis Bootstrap
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
		deactivate_plugins( plugin_basename( __FILE__ ) ); 
    }
} 
add_action('after_switch_theme', 'deactivate_genesis_bootstrap_plugin_script_check');


add_action( 'genesis_init', 'gs_constants', 15 );


/**
 * This function defines the Genesis Child theme constants
 *
 * Data Constants: CHILD_SETTINGS_FIELD, CHILD_DOMAIN, CHILD_THEME_VERSION
 * CHILD_THEME_NAME, CHILD_THEME_URL, CHILD_DEVELOPER, CHILD_DEVELOPER_URL
 * Directories: CHILD_LIB_DIR, CHILD_IMAGES_DIR, CHILD_ADMIN_DIR, CHILD_JS_DIR, CHILD_CSS_DIR
 * URLs: CHILD_LIB, CHILD_IMAGES, CHILD_ADMIN, CHILD_JS, CHILD_CSS
 *
 * @since 1.1.0
 */
function gs_constants() {
  $theme = wp_get_theme();
    
    // Child theme (Change but do not remove)
        /** @type constant Child Theme Options/Settings. */
        define( 'CHILD_SETTINGS_FIELD', $theme->get('TextDomain') . '-settings' );
        
        /** @type constant Text Domain. */
        define( 'CHILD_DOMAIN', $theme->get('TextDomain') );
        
        /** @type constant Child Theme Version. */
        define( 'CHILD_THEME_VERSION', $theme->Version );
        
        /** @type constant Child Theme Name, used in footer. */
        define( 'CHILD_THEME_NAME', $theme->Name );
        
        /** @type constant Child Theme URL, used in footer. */
        define( 'CHILD_THEME_URL', $theme->get('ThemeURI') );
        
    // Developer Information, see lib/admin/admin-functions.php
        /** @type constant Child Theme Developer, used in footer. */
        define( 'CHILD_DEVELOPER', $theme->Author );
        
        /** @type constant Child Theme Developer URL, used in footer. */
        define( 'CHILD_DEVELOPER_URL', $theme->{'Author URI'}  );
        
    // Define Directory Location Constants
        /** @type constant Child Theme Library/Includes URL Location. */
        define( 'CHILD_LIB_DIR',    CHILD_DIR . '/lib' );
        
        /** @type constant Child Theme Images URL Location. */
        define( 'CHILD_IMAGES_DIR', CHILD_DIR . '/images' );
        
        /** @type constant Child Theme Admin URL Location. */
        define( 'CHILD_ADMIN_DIR',  CHILD_LIB_DIR . '/admin' );
        
        /** @type constant Child Theme JS URL Location. */
        define( 'CHILD_JS_DIR',     CHILD_DIR .'/js' );
        
        /** @type constant Child Theme JS URL Location. */
        define( 'CHILD_CSS_DIR',    CHILD_DIR . '/css' );
    
    // Define URL Location Constants
        /** @type constant Child Theme Library/Includes URL Location. */
        define( 'CHILD_LIB',        CHILD_URL . '/lib' );
        
        /** @type constant Child Theme Images URL Location. */
        define( 'CHILD_IMAGES',     CHILD_URL . '/images' );
        
        /** @type constant Child Theme Admin URL Location. */
        define( 'CHILD_ADMIN',      CHILD_LIB . '/admin' );
        
        /** @type constant Child Theme JS URL Location. */
        define( 'CHILD_JS',     CHILD_URL .'/js' );
        
        /** @type constant Child Theme JS URL Location. */
        define( 'CHILD_CSS',    CHILD_URL .'/css' );    
}





function gb3_custom_theme_support() {
$bsg_add_theme_support = array(
                        'bsg-add-head-markup',
                        'bsg-bootstrap-markup',
                        'bsg-bootstrap-walker',
                        'bsg-comment-form',
                        'bsg-custom-css-js',
                        'bsg-customizer',
                        'bsg-footer-creds',
                        'bsg-genesis-setup',
                        'bsg-image-display',
                        'bsg-load-assets',
                        'bsg-nav',
                        'bsg-pagination',
                        'bsg-post-content-nav',
                        'bsg-search-form',
                        'bsg-jumbotron',
    );
    
    foreach ( $bsg_add_theme_support as $bsg_support ) {
	           add_theme_support( $bsg_support );
    } 
    
}
add_action('after_setup_theme', 'gb3_custom_theme_support');



function bsg_load_lib_files() {
  global $_wp_theme_features;
  foreach (glob(__DIR__ . '/lib/*.php') as $file) {
    $feature = 'bsg-' . basename($file, '.php');
    if (isset($_wp_theme_features[$feature])) {
      require_once $file;
    }
  }
}
add_action('after_setup_theme', 'bsg_load_lib_files', 100);
