<?php
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
 
add_action( 'genesis_init', 'gs_constants', 15 );


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
