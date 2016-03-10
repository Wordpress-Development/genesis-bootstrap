<?php

namespace Willis\BootGen\Navbar;

use Willis\BootGen\Utils;

/**
 * Bootstrap Multilevel Navbars
 *
 * You can enable/disable this feature in functions.php:
 * add_theme_support('bootgen-nav');
 */

//* Disable Default Header
add_action('template_redirect', __NAMESPACE__ . '\\remove_genesis_header');
function remove_genesis_header() {
  unregister_sidebar( 'header-right' );
  remove_action( 'genesis_site_title', 'genesis_seo_site_title' );
  remove_action( 'genesis_site_description', 'genesis_seo_site_description' );
  remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
  remove_action( 'genesis_header', 'genesis_do_header' );
  remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
}

//* Register Customizer Logo
add_action('customize_register', __NAMESPACE__ . '\\customize_register');

//* Bootstrap Load Navbar
add_action('get_header', __NAMESPACE__ . '\\add_navbar');
function add_navbar() {
  if ( !class_exists('wp_bootstrap_navwalker') ) {
    include_once( BSGEN_PLUGIN_PATH . 'lib/classes/class.wp_bootstrap_navwalker.php' );
  }
  add_filter('add_nav_classes', __NAMESPACE__ . '\\classes');
  add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\scripts');
  add_action('genesis_meta', __NAMESPACE__ . '\\structural_wrap');
  add_filter('genesis_do_nav', __NAMESPACE__ . '\\nav_markup', 10, 3);
  add_filter('genesis_do_subnav', __NAMESPACE__ . '\\structural_wrap', 10, 3);
  add_filter('bsg_navbar_brand_primary', __NAMESPACE__ . '\\navbar_brand_markup');
}

//* Bootstrap Nav Classes
function classes($classes) {
    $new_classes = array( 
            'nav-primary'   => 'navbar navbar-default navbar-static-top',
            'nav-secondary' => 'navbar navbar-inverse navbar-static-top hidden-xs'
    );
    return array_merge($new_classes, $classes);
}

//* Bootstrap Multilevel Dropdown Scripts
function scripts() {
  wp_enqueue_style('bootstrap-multilevel', );
  wp_enqueue_script('bootstrap-multilevel', );
}

//* Bootstrap Container Fluid Structural Wrap
function structural_wrap(){
  add_filter( 'genesis_structural_wrap-menu-primary', 'bsg_wrap_container_fluid', 99, 2);
  add_filter( 'genesis_structural_wrap-menu-secondary', 'bsg_wrap_container_fluid', 99, 2);
}

//* Bootstrap Nav Markup
function nav_markup($nav_output, $nav, $args) {
  $args['depth'] = 3;
  $args['menu_class'] = 'nav navbar-nav';
  $args['fallback_cb'] = 'wp_bootstrap_navwalker::fallback';
  $args['walker'] = new wp_bootstrap_navwalker();
  
  $nav = wp_nav_menu($args);
  $sanitized_location = sanitize_key($args['theme_location']);
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
  $nav_markup.= apply_filters("navbar_brand_{$sanitized_location}", $navbar_brand);
  $nav_markup.= '</div>'; // .navbar-header
  
  $nav_markup.= '<div class="collapse navbar-collapse" id="' . $data_target . '">';
  
  ob_start();
  do_action('before_nav_' . $sanitized_location);
  $before_nav = ob_get_clean();

  ob_start();
  do_action('after_nav_' . $sanitized_location);
  $after_nav = ob_get_clean();

  $nav_markup.= $before_nav . $nav . $after_nav;
  
  $nav_markup.= '</div>'; // .collapse .navbar-collapse
  
  $nav_markup_open = sprintf('<nav %s>', genesis_attr('nav-' . $sanitized_location));
  $nav_markup_open.= genesis_structural_wrap('menu-' . $sanitized_location, 'open', 0);
  $nav_markup_close = genesis_structural_wrap('menu-' . $sanitized_location, 'close', 0) . '</nav>';
  
  $nav_output = $nav_markup_open . $nav_markup . $nav_markup_close;
  return $nav_output;
}

//* Customizer controls for Bootstrap navbar-brand
function customize_register( $wp_customize ) {
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
      'label' => __( 'Navbar Brand', 'genesis' ),
      'section' => 'title_tagline',
      'settings' => 'brand_logo',
      'priority' => 10,
    )
  ));
}

//* Brand Output
function navbar_brand_markup($navbar_brand) {
  $brand_name = esc_attr( get_bloginfo( 'name' ) );
  if ( get_theme_mod( 'brand_logo' ) ) {
    $brand = '<img src="'.get_theme_mod('brand_logo').'" alt="'.$brand_name.'">';
  } else {
    $brand = $name;
  }
  $navbar_brand =  '<a class="navbar-brand" id="logo" title="'.esc_attr( get_bloginfo( 'description' ) ).'" href="'.esc_url( home_url( '/' ) ).'">'.$brand.'</a>';
  return $navbar_brand;
}

//* Navbar Right Helper
function navbar_right($nav_output, $nav) {
  $search = 'nav navbar-nav';
  $replace = 'nav navbar-nav navbar-right';
  $nav_output = str_replace($search, $replace, $nav_output);
  return $nav_output;
}
