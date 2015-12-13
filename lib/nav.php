<?php

if (
    class_exists('UberMenu')
    || class_exists('UberMenuStandard')
) {
    return;
}


remove_action( 'genesis_site_title', 'genesis_seo_site_title' );
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );

// remove primary & secondary nav from default position
remove_action( 'genesis_after_header', 'genesis_do_nav' );
remove_action( 'genesis_after_header', 'genesis_do_subnav' );

// add primary & secondary nav to top of the page
add_action( 'genesis_header', 'genesis_do_nav', 15 );
add_action( 'genesis_header', 'genesis_do_subnav', 15 );


add_filter( 'wp_nav_menu_args', 'bsg_nav_menu_args_filter' );
function bsg_nav_menu_args_filter( $args ) {
    if (
        'primary' === $args['theme_location'] ||
        'secondary' === $args['theme_location']
    ) {
        $args['depth'] = 2;
        $args['menu_class'] = 'nav navbar-nav';
        $args['fallback_cb'] = 'wp_bootstrap_navwalker::fallback';
        $args['walker'] = new wp_bootstrap_navwalker();
    }
    return $args;
}

add_filter( 'wp_nav_menu', 'bsg_nav_menu_markup_filter', 10, 2 );
function bsg_nav_menu_markup_filter( $html, $args ) {
    if (
        'primary'   !== $args->theme_location &&
        'secondary' !== $args->theme_location
    ) {
        return $html;
    }
    $data_target = "nav-collapse" . sanitize_html_class( '-' . $args->theme_location );
    $output = <<<EOT
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#{$data_target}">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
EOT;

        if ( 'primary' === $args->theme_location ) {
            $output .= apply_filters( 'bsg_navbar_brand', bsg_navbar_brand_markup() );
        }
        $output .= '</div>'; // .navbar-header
        $output .= "<div class=\"collapse navbar-collapse\" id=\"{$data_target}\">";
            $output .= $html;
        $output .= '</div>'; // .collapse .navbar-collapse
    return $output;
}


  // add customizer controls
add_action( 'customize_register', 'bsg_navbar_brand_logo_customize_register' );
function bsg_navbar_brand_logo_customize_register( $wp_customize ) {
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

function bsg_navbar_brand_markup() {
        $brand_logo = get_theme_mod( 'brand_logo' );
        if ( ! $brand_logo ) {
            return $output;
        }
        $output = '<a class="navbar-brand" id="logo" title="' .
            esc_attr( get_bloginfo( 'description' ) ) .
            '" href="' .
            esc_url( home_url( '/' ) ) .
            '">';
        $output .= '<img src="' .
            $brand_logo .
            '" alt="' .
            esc_attr( get_bloginfo( 'name' ) ) .
            '">';
        $output .= '</a>';
        return $output;
}



function gb3_navbar_nav_navbar_right( $nav_output, $nav ) {
	$search = 'nav navbar-nav';
	$replace = 'nav navbar-nav navbar-right';
	$nav_output = str_replace( $search, $replace, $nav_output );
	return $nav_output;
}
