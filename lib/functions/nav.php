<?php


 /**
  * Remove Header Defaults
  */


	unregister_sidebar( 'header-right' );
	//remove_action( 'genesis_site_title', 'genesis_seo_site_title' );
	remove_action( 'genesis_site_description', 'genesis_seo_site_description' );
	remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
	remove_action( 'genesis_header', 'genesis_do_header' );
	remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

/* # NAVBAR HEADER
add_filter( 'genesis_seo_title', 'bhww_filter_genesis_seo_site_title', 10, 2 );
function bhww_filter_genesis_seo_site_title( $title, $inside ){
		$child_inside = sprintf( '<a href="%s" title="%s"><img src="'. get_theme_mod('brand_logo') .'" title="%s" alt="%s"/></a>', trailingslashit( home_url() ), esc_attr( get_bloginfo( 'name' ) ), esc_attr( get_bloginfo( 'name' ) ), esc_attr( get_bloginfo( 'name' ) ) );
		$title = str_replace( $inside, $child_inside, $title );
		return $title;
}
// */



add_filter('bw_add_classes', 'bsg_custom_nav_classes');
function bsg_custom_nav_classes($classes) 
{
    $new_classes = array( 
            'nav-primary'               => 'navbar navbar-default navbar-static-top',
            'nav-secondary'             => 'navbar navbar-inverse navbar-static-top hidden-xs'
    );
    return array_merge($new_classes, $classes);
}



add_action( 'genesis_meta', 'bsgen_structural_wrap_fluid_menu' );
function bsgen_structural_wrap_fluid_menu(){
  add_filter( 'genesis_structural_wrap-menu-primary', 'bsg_wrap_container_fluid', 99, 2);
  add_filter( 'genesis_structural_wrap-menu-secondary', 'bsg_wrap_container_fluid', 99, 2);
}






/**
  * Bootstrap Nav Walker
  */
/*
if ( !class_exists('wp_bootstrap_navwalker') ) {
	require_once( plugins_url('/classes/class.wp_bootstrap_navwalker.php', __DIR__ ) );
}
// */


/**
 * Class Name: wp_bootstrap_navwalker
 * GitHub URI: https://github.com/twittem/wp-bootstrap-navwalker
 */
//*
class wp_bootstrap_navwalker extends Walker_Nav_Menu {
  public function start_lvl( &$output, $depth = 0, $args = array() ) {
    $indent = str_repeat( "\t", $depth );
    $output .= "\n$indent<ul role=\"menu\" class=\" dropdown-menu\">\n";
  }
  public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
    $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
    if ( strcasecmp( $item->attr_title, 'divider' ) == 0 && $depth === 1 ) {
      $output .= $indent . '<li role="presentation" class="divider">';
    } else if ( strcasecmp( $item->title, 'divider') == 0 && $depth === 1 ) {
      $output .= $indent . '<li role="presentation" class="divider">';
    } else if ( strcasecmp( $item->attr_title, 'dropdown-header') == 0 && $depth === 1 ) {
      $output .= $indent . '<li role="presentation" class="dropdown-header">' . esc_attr( $item->title );
    } else if ( strcasecmp($item->attr_title, 'disabled' ) == 0 ) {
      $output .= $indent . '<li role="presentation" class="disabled"><a href="#">' . esc_attr( $item->title ) . '</a>';
    } else {
      $class_names = $value = '';
      $classes = empty( $item->classes ) ? array() : (array) $item->classes;
      $classes[] = 'menu-item-' . $item->ID;
      $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
      if ( $args->has_children )
        $class_names .= ' dropdown';
      if ( in_array( 'current-menu-item', $classes ) )
        $class_names .= ' active';
      $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
      $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
      $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
      $output .= $indent . '<li' . $id . $value . $class_names .'>';
      $atts = array();
      $atts['title']  = ! empty( $item->title ) ? $item->title  : '';
      $atts['target'] = ! empty( $item->target )  ? $item->target : '';
      $atts['rel']    = ! empty( $item->xfn )   ? $item->xfn  : '';

      if ( $args->has_children && $depth === 0 ) {
        $atts['href']       = '#';
        $atts['data-toggle']  = 'dropdown';
        $atts['class']      = 'dropdown-toggle';
        $atts['aria-haspopup']  = 'true';
      } else {
        $atts['href'] = ! empty( $item->url ) ? $item->url : '';
      }
      // do_action( 'wp_nav_menu_item_custom_fields', $item_id, $item, $depth, $args );
      $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );
      $attributes = '';
      foreach ( $atts as $attr => $value ) {
        if ( ! empty( $value ) ) {
          $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
          $attributes .= ' ' . $attr . '="' . $value . '"';
        }
      }
      $item_output = $args->before;
      if ( ! empty( $item->attr_title ) ){
        $item_output .= '<a'. $attributes .'><span class="glyphicon ' . esc_attr( $item->attr_title ) . '"></span>&nbsp;';
      }else{
        $item_output .= '<a'. $attributes .'>';
      }
      $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
      $item_output .= ($args->has_children) ? ' <span class="caret"></span></a>' : '</a>';
      $item_output .= '</a>';
      $item_output .= $args->after;
      $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
      
      
    }
  }
  public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
        if ( ! $element )
            return;
        $id_field = $this->db_fields['id'];
        if ( is_object( $args[0] ) )
           $args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
        parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }
  public static function fallback( $args ) {
    if ( current_user_can( 'manage_options' ) ) {
      extract( $args );
      $fb_output = null;
      if ( $container ) {
        $fb_output = '<' . $container;
        if ( $container_id )
          $fb_output .= ' id="' . $container_id . '"';
        if ( $container_class )
          $fb_output .= ' class="' . $container_class . '"';
        $fb_output .= '>';
      }
      $fb_output .= '<ul';
      if ( $menu_id )
        $fb_output .= ' id="' . $menu_id . '"';
      if ( $menu_class )
        $fb_output .= ' class="' . $menu_class . '"';
      $fb_output .= '>';
      $fb_output .= '<li><a href="' . admin_url( 'nav-menus.php' ) . '">Add a menu</a></li>';
      $fb_output .= '</ul>';
      if ( $container )
        $fb_output .= '</' . $container . '>';
      echo $fb_output;
    }
  }
}
// */



/* # Widget Area
add_action( 'after_nav_primary', 'sk_do_nav_widget' );
function sk_do_nav_widget(){
  return genesis_widget_area( 'after-nav-primary', array(
    'before' => '<div class="after-nav-primary">',
    'after'  => '</div>',
  ) );
}
// */



/**
 * Bootstrap Nav Markup
 */
add_filter('genesis_do_nav', 'genesis_child_nav', 10, 3);
add_filter('genesis_do_subnav', 'genesis_child_nav', 10, 3);

function genesis_child_nav($nav_output, $nav, $args)
{
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
	$nav_markup.= apply_filters("bsg_navbar_brand_{$sanitized_location}", $navbar_brand);
	$nav_markup.= '</div>'; // .navbar-header
	
	$nav_markup.= '<div class="collapse navbar-collapse" id="' . $data_target . '">';
	
	ob_start();
	do_action('before_nav_' . $sanitized_location);
	$before_nav = ob_get_contents();
	ob_end_clean();
	$nav_markup.= $before_nav;
	
	$nav_markup.= $nav;
	
	ob_start();
	do_action('after_nav_' . $sanitized_location);
	$after_nav = ob_get_contents();
	ob_end_clean();
	$nav_markup.= $after_nav;
	
	$nav_markup.= '</div>'; // .collapse .navbar-collapse
	
	$nav_markup_open = sprintf('<nav %s>', genesis_attr('nav-' . $sanitized_location));
	$nav_markup_open.= genesis_structural_wrap('menu-' . $sanitized_location, 'open', 0);
	$nav_markup_close = genesis_structural_wrap('menu-' . $sanitized_location, 'close', 0) . '</nav>';
	
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
                'label' => __( 'Navbar Brand', 'bsg' ),
                'section' => 'title_tagline',
                'settings' => 'brand_logo',
                'priority' => 10,
             )
        ) );
}

//add_filter('bsg_navbar_brand_secondary', 'bsg_navbar_brand_markup');
//add_filter('bsg_navbar_brand_secondary', 'bsg_navbar_brand_markup');
//add_filter('bsg_navbar_brand_primary', 'bsg_navbar_brand_markup');
function bsg_navbar_brand_markup($navbar_brand) {
    $brand_name = esc_attr( get_bloginfo( 'name' ) );
    if ( get_theme_mod( 'brand_logo' ) ) {
    	$brand = '<img src="'.get_theme_mod('brand_logo').'" alt="'.$brand_name.'">';
    } else {
    	$brand = $name;
    }
	$navbar_brand =  '<a class="navbar-brand" id="logo" title="'.esc_attr( get_bloginfo( 'description' ) ).'" href="'.esc_url( home_url( '/' ) ).'">'.$brand.'</a>';
    return $navbar_brand;
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
