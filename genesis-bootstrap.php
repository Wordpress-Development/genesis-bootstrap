<?php
/*
Plugin Name:        GB3
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



add_action( 'genesis_init', 'bsg_add_theme_support', 15 );
function bsg_add_theme_support() {
// Add theme support for new menu
// Add New Footer Menu; Keep Primary and Secondary Menus
add_theme_support ( 'genesis-menus' , array ( 
	'primary' => __( 'Primary Navigation Menu', 'genesis' ),
	'secondary' => __( 'Secondary Navigation Menu', 'genesis' ),
	'footer' => __( 'Footer Navigation Menu', 'genesis' )
	) );
}


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
        define( 'CHILD_CSS',    CHILD_URL .'/css/' );    
}


function gb3_register_sidebar_defaults( $defaults ) {
	$defaults['before_widget'] = '<section id="%1$s" class="panel panel-default widget %2$s"><div class="panel-body widget-wrap">';
	return $defaults;
}
function genesis_edit_widget_areas() {
    add_filter( 'genesis_register_widget_area_defaults', 'gb3_register_sidebar_defaults');
}
add_action( 'genesis_setup', 'genesis_edit_widget_areas', 15 );


add_filter( 'genesis_post_info', 'sp_post_info_filter' );
function sp_post_info_filter($post_info) {
	$post_info = '[post_date format="j F, Y" before="<span class=\'post-date text-muted\'>" after="</span>" label="<i class=\'fa fa-clock-o\'></i> "] by [post_author_posts_link] [post_comments before="<span class=\'pull-right\'><span class=\'text-muted fa fa-comments\'></span>" after="</span>" zero=" Leave a Comment" one=" 1 Comment" more=" % Comments"]';
	return $post_info;
}


add_filter( 'genesis_post_meta', 'sp_post_meta_filter' );
function sp_post_meta_filter($post_info) {
	$post_info = '';
	return $post_info;
}




function gb3_custom_theme_support() {
           $bsg = array(
                        'bsg-head',
                        'bsg-bootstrap-markup',
                        'bsg-comments',
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
                        'bsg-footer',
                        'bsg-responsive-videos-widget',
                        'bsg-mce-css',
                        'bsg-bootstrap-widgets',
                        'bsg-bootstrap-genesis-css'
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
  foreach (glob(__DIR__ . '/lib/*.php') as $file) {
    $feature = 'bsg-' . basename($file, '.php');
    if (isset($_wp_theme_features[$feature])) {
      require_once $file;
    }
  }
}
add_action('after_setup_theme', 'bsg_load_lib_files', 100);
