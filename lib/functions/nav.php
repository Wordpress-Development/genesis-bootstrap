<?php


 /**
  * Remove Header Defaults
  */
add_action('genesis_setup', 'bsg_remove_header_defaults', 15);
function bsg_remove_header_defaults() {
	unregister_sidebar( 'header-right' );
	remove_action( 'genesis_site_title', 'genesis_seo_site_title' );
	remove_action( 'genesis_site_description', 'genesis_seo_site_description' );
	remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
	remove_action( 'genesis_header', 'genesis_do_header' );
	remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
}



/**
  * Bootstrap Nav Classes
  */
add_filter('bw_add_classes', 'bsg_custom_nav_classes');
function bsg_custom_nav_classes($classes) 
{
    $new_classes = array( 
            'nav-primary'               => 'navbar navbar-default navbar-static-top',
            'nav-secondary'             => 'navbar navbar-inverse navbar-static-top',
            'site-header'               => 'container'
    );
    return wp_parse_args($new_classes, $classes);
}



/**
  * Bootstrap Nav Walker
  */
if ( !class_exists('wp_bootstrap_navwalker') ) {
	require_once( plugins_url('/lib/classes/class.wp_bootstrap_navwalker.php', __DIR__) );
}



/**
  * Bootstrap Nav Markup
  */ 
add_filter( 'genesis_do_nav', 'genesis_child_nav', 10, 3 );
add_filter( 'genesis_do_subnav', 'genesis_child_nav', 10, 3 );
function genesis_child_nav($nav_output, $nav, $args)
{
    $args['depth'] = 3;
    $args['menu_class'] = 'nav navbar-nav';
    $args['fallback_cb'] = 'wp_bootstrap_navwalker::fallback';
    $args['walker'] = new wp_bootstrap_navwalker();
    
    $nav = wp_nav_menu( $args );
    $sanitized_location = sanitize_key( $args['theme_location'] );
    $data_target = 'nav-collapse-' . $sanitized_location;

    $nav_markup = <<<EOT
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#{$data_target}">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
EOT;
    if ( 'primary' === $sanitized_location ) {
        $nav_markup .= apply_filters( 'bsg_navbar_brand', bsg_navbar_brand_markup() );
    }
    $nav_markup .= '</div>'; // .navbar-header
    $nav_markup .= '<div class="collapse navbar-collapse" id="'.$data_target.'">';
	$nav_markup .= $nav;
    $nav_markup .= '</div>'; // .collapse .navbar-collapse
    
    $nav_markup_open  = sprintf( '<nav %s>', genesis_attr( 'nav-' . $sanitized_location ) );
    $nav_markup_open .= genesis_structural_wrap( 'menu-' . $sanitized_location, 'open', 0 );
    
	$nav_markup_close  = genesis_structural_wrap( 'menu-' . $sanitized_location, 'close', 0 ) . '</nav>';
  	
	$nav_output = $nav_markup_open . $nav_markup . $nav_markup_close;
    	
	return $nav_output;
}



/**
 * Navbar Brand Image Customizer Controls
 */ 
add_action( 'customize_register', 'bsg_navbar_brand_logo_customize_register' );
function bsg_navbar_brand_logo_customize_register( $wp_customize ) 
{
	    $wp_customize->add_setting( 'brand_logo',
             array(
                'default' => '',
                'type' => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport' => 'refresh',
             )
        );
        $wp_customize->add_control( new WP_Customize_Image_Control(
             $wp_customize,
             'bsg_brand_logo',
             array(
                'label' => __( 'Navbar Logo', 'bsg' ),
                'section' => 'title_tagline',
                'settings' => 'brand_logo',
                'priority' => 10,
             )
        ) );
}



/**
 * Navbar Brand Image Output
 */ 
function bsg_navbar_brand_markup() 
{
    $name = esc_attr( get_bloginfo( 'name' ) );

    if ( get_theme_mod( 'brand_logo' ) ) {
    	$brand = '<img src="'.get_theme_mod('brand_logo').'" alt="'.$name.'">';
    } else {
    	$brand = $name;
    }
	
	return '<a class="navbar-brand" id="logo" title="'.esc_attr( get_bloginfo( 'description' ) ).'" href="'.esc_url( home_url( '/' ) ).'">'.$brand.'</a>';

}







add_action('wp_head', 'multilevel_dropdown_menu_css', 99);
function multilevel_dropdown_menu_css() {
    ?>
<style type="text/css">
/**
 *----------------------------------------- 
 * Bootstrap Multilevel Menu 
 * Change default caret(down) to right caret (for desktop screens only)
 *-----------------------------------------
 */
ul.dropdown-menu .caret {
	display: inline-block;
	width: 0;
	height: 0;
	margin-left: 2px;
	vertical-align: middle;
	border-left: 4px solid;
	border-right: 4px solid transparent;
	border-top: 4px solid transparent;
	border-bottom: 4px solid transparent;
}

@media (max-width: 767px) {
ul.dropdown-menu .caret {	
	display: inline-block;
	width: 0;
	height: 0;
	margin-left: 2px;
	vertical-align: middle;
	border-top: 4px solid;
	border-right: 4px solid transparent;
	border-left: 4px solid transparent;
	}
	
}
ul.dropdown-menu ul.dropdown-menu{
	top:0;
	left:100%;
}
</style>
<?php
}




add_action('wp_footer', 'multilevel_dropdown_menu', 999);
function multilevel_dropdown_menu(){
?>
<script type="text/javascript">
(function($) {
    "use strict";
    $(function() {
        $('ul.dropdown-menu .dropdown>a').on('click', function(event) {
            event.preventDefault();
            event.stopPropagation();
            var cur_nav_element = $(this).parent();
            cur_nav_element.parent().find('li.dropdown').not($(this).parent()).removeClass('open');
            cur_nav_element.toggleClass('open');
        });
        $('ul.navbar-nav a.dropdown-toggle').on('click', function(event) {
            var cur_nav_element = $(this).parent();
            cur_nav_element.parent().find('li.dropdown').not($(this).parent()).removeClass('open');
        });
    });
}(jQuery));
</script>
<?php
}





function gb3_navbar_nav_navbar_right($nav_output, $nav)
{
	$search = 'nav navbar-nav';
	$replace = 'nav navbar-nav navbar-right';
	$nav_output = str_replace($search, $replace, $nav_output);
	return $nav_output;
}
