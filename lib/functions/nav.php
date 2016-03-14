<?php
/**
 * Bootstrap Multilevel Navbars
 *
 * You can enable/disable this feature in functions.php:
 * add_theme_support('bsg-nav');
 */

//* Disable Default Genesis Header
add_action('template_redirect', 'bsg_nav_remove_genesis_header');
function bsg_nav_remove_genesis_header() {
  unregister_sidebar( 'header-right' );
  remove_action( 'genesis_site_title', 'genesis_seo_site_title' );
  remove_action( 'genesis_site_description', 'genesis_seo_site_description' );
  remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
  remove_action( 'genesis_header', 'genesis_do_header' );
  remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
}

//* Register Customizer Logo
add_action('customize_register', 'bsg_nav_customize_register');

//* Load Bootstrap Navbar
add_action('get_header', 'bsg_nav_navbar');
function bsg_nav_navbar() {
  if ( !class_exists('wp_bootstrap_navwalker') ) {
    include_once( BSGEN_PLUGIN_PATH . 'lib/classes/class.wp_bootstrap_navwalker.php' );
  }
  add_filter('bsg_util_add_nav_classes', 'bsg_nav_navbar_classes');
  add_action('wp_enqueue_scripts', 'bsg_nav_navbar_enqueue_scripts');
  add_action('genesis_meta', 'bsg_nav_navbar_structural_wrap');
  add_filter('genesis_do_nav', 'bsg_nav_navbar_markup', 10, 3);
  add_filter('genesis_do_subnav', 'bsg_nav_navbar_markup', 10, 3);
  add_filter('bsg_navbar_brand_primary', 'bsg_nav_navbar_brand_markup');
}

//* Bootstrap Nav Classes
function bsg_nav_navbar_classes($classes) {
    $new_classes = array( 
            'nav-primary'   => 'navbar navbar-default navbar-static-top',
            'nav-secondary' => 'navbar navbar-inverse navbar-static-top hidden-xs'
    );
    return array_merge($new_classes, $classes);
}

//* Bootstrap Multilevel Dropdown Scripts/Styles
function bsg_nav_navbar_enqueue_scripts() {
  wp_enqueue_style( 'bsg-nav', BSG_PLUGIN_URL . '/css/bsg-nav.css', array( 'bootstrap' ), false, 'all' );
  wp_enqueue_script('bsg-nav', BSG_PLUGIN_URL . '/js/bsg-nav.js', array( 'jquery', ' bootstrap' ), false, true);
}

//* Bootstrap Container Fluid Structural Wrap
function bsg_nav_navbar_structural_wrap(){
  add_filter( 'genesis_structural_wrap-menu-primary', 'bsg_util_structural_wrap_container_fluid', 99, 2);
  add_filter( 'genesis_structural_wrap-menu-secondary', 'bsg_util_structural_wrap_container_fluid', 99, 2);
}

//* Bootstrap Nav Markup
function bsg_nav_navbar_markup($nav_output, $nav, $args) {
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
  $nav_markup.= apply_filters("bsg_nav_navbar_brand_{$sanitized_location}", $navbar_brand);
  $nav_markup.= '</div>'; // .navbar-header
  
  $nav_markup.= '<div class="collapse navbar-collapse" id="' . $data_target . '">';
  
  ob_start();
  do_action('bsg_nav_before_' . $sanitized_location);
  $before_nav = ob_get_clean();

  ob_start();
  do_action('bsg_nav_before_' . $sanitized_location);
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
function bsg_nav_customize_register( $wp_customize ) {
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
function bsg_nav_navbar_brand_markup($navbar_brand) {
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
function bsg_nav_do_navbar_right($nav_output, $nav) {
  $search = 'nav navbar-nav';
  $replace = 'nav navbar-nav navbar-right';
  $nav_output = str_replace($search, $replace, $nav_output);
  return $nav_output;
}
