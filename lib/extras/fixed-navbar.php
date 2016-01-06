<?php

/**
 * Plugin Name: Bootstrap Genesis Fixed Nav
 * Plugin URI:
 * Description: Modifies the Primary Navigation Menu so it is fixed to the top of the page
 * Version: 1.1.0
 * Author: Sal Ferrarello
 * Author URI: http://salferrarello.com/
 * Text Domain: bootstrap-genesis-fixed-nav
 * Domain Path: /languages
 * GitHub Plugin URI: https://github.com/salcode/bootstrap-genesis-fixed-nav
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
class Bootstrap_Genesis_Fixed_Nav {
	/**
	 * Setup filters and actions to make the primary nav fixed to the top
	 * of the screen
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_filter( 'bsg-classes-to-add', array( $this, 'modify_nav_class' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'load_css' ) );
		add_filter( 'genesis_markup_nav-primary_output',  array( $this, 'add_boot_strap_affix_markup' ) );
		add_filter( 'option_hash_link_scroll_offset', array( $this, 'option_hash_link_scroll_offset' ) );
		add_filter( 'body_class', array( $this, 'add_body_class' ) );
	}
	/**
	 * Add body class .bootstrap-genesis-fixed-nav
	 *
	 * This class allows us to target the CSS so it is only applied when
	 * this plugin is active. This is particularly helpful when moving
	 * the CSS into the Theme but wanting to insure things don't break if
	 * the plugin is disabled.
	 *
	 * @since 1.1.0
	 */
	public function add_body_class( $classes ) {
		$classes[] = 'bootstrap-genesis-fixed-nav';
		return $classes;
	}
	/**
	 * Modify primary nav CSS classes for .navbar-fixed-top
	 *
	 * @since 1.0.0
	 *
	 * @param key value array of context and classes to be applied
	 *
	 * @return key value array of context and classes to be applied with
	 *                   with modified values for nav-primary
	 */
	public function modify_nav_class( $classes_to_add ) {
		$classes_to_add['nav-primary'] = 'navbar navbar-default navbar-fixed-top';
		return $classes_to_add;
	}
	/**
	 * Enqueue CSS for fixed primary nav
	 *
	 * @since 1.0.0
	 */
	public function load_css() {
		if ( apply_filters( 'bootstrap_genesis_fixed_nav_load_css', true ) ) {
			wp_enqueue_style(
				'bsg-fixed-nav',
				plugins_url( 'assets/bsg-fixed-nav.css', __FILE__ ),
				'bsg_combined_css',
				'1.0.0'
			);
		}
	}
	/**
	 * Override offset value for lugin Hash Link Scroll Offset
	 * https://github.com/WebDevStudios/Hash-Link-Scroll-Offset
	 * offset varies based on whether or not the admin bar is displayed
	 *
	 * @since 1.0.0
	 *
	 * @param string offset value from plugin settings (this value is ignored)
	 *
	 * @return string modified offset value to be used when scrolling to
	 *                anchor. Two different values are returned, depending on
	 *                whether the admin bar is currently displayed or not
	 */
	public function option_hash_link_scroll_offset( $value ) {
		// height of navbar offset
		return '72';
	}
	/**
	 * Add Bootstrap Affix attributes to html tag
	 * See http://getbootstrap.com/javascript/#affix
	 *
	 * @since 1.0.0
	 *
	 * @param string $markup Rendered output for opening html tag
	 *
	 * @return string Modified version of the opening html tag
	 *                which now includes the data attributes to trigger
	 *                the affix behavior
	 */
	public function add_boot_strap_affix_markup( $markup ) {
		$markup = rtrim( $markup, ">" ) . 'data-spy="affix" data-offset-top="32">';
		return $markup;
	}
}
add_action( 'after_setup_theme', 'bootstrap_genesis_fixed_nav' );
function bootstrap_genesis_fixed_nav() {
	new Bootstrap_Genesis_Fixed_Nav();
}
