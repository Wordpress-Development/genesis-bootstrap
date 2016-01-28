<?php
/**
 * Template Loader for Plugins
 *
 * @package   Template_Loader_For_Plugins
 * @author    Gary Jones
 * @link      http://gamajo.com/template-loader
 * @copyright 2013 Gary Jones
 * @license   GPL-2.0+
 */
/**
 * Template loader.
 *
 * Originally based on functions in Easy Digital Downloads.
 *
 * When using in a plugin, create a new class that extends this one and just overrides the properties.
 *
 * @package Meal_Planner
 * @author  Gary Jones
 */
class Gamajo_Template_Loader {
	/**
	 * Prefix for filter names.
	 *
	 * @since 1.0.0
	 * @type string
	 */
	protected $filter_prefix = 'your_plugin';
	/**
	 * Directory name where custom templates for this plugin should be found in the theme.
	 *
	 * @since 1.0.0
	 * @type string
	 */
	protected $theme_template_directory = 'your-plugin'; // or 'your-plugin-templates' etc.
	/**
	 * Reference to the root directory path of this plugin.
	 *
	 * @since 1.0.0
	 * @type string
	 */
	protected $plugin_directory = YOUR_PLUGIN_DIR; // or plugin_dir_path( dirname( __FILE__ ) ); etc.
	/**
	 * Retrieve a template part.
	 *
	 * @since 1.0.0
	 *
	 * @uses Meal_Planner_Template_Loader::locate_template()
	 *
	 * @param string  $slug
	 * @param string  $name Optional. Default null.
	 * @param bool    $load Optional. Default true.
	 *
	 * @return string
	 */
	public function get_template_part( $slug, $name = null, $load = true ) {
		// Execute code for this part
		do_action( 'get_template_part_' . $slug, $slug, $name );
		$templates = $this->get_template_possible_parts( $slug, $name );
		// Return the part that is found
		return $this->locate_template( $templates, $load, false );
	}
	/**
	 * Given a slug and optional name, create the file names of templates.
	 *
	 * @since 1.0.0
	 *
	 * @param string  $slug
	 * @param string  $name
	 *
	 * @return array
	 */
	protected function get_template_possible_parts( $slug, $name ) {
		if ( isset( $name ) ) {
			$templates[] = $slug . '-' . $name . '.php';
		}
		$templates[] = $slug . '.php';
		// Allow template parts to be filtered, removes empty entries
		return apply_filters( $this->filter_prefix . '_get_template_part', $templates, $slug, $name );
	}
	/**
	 * Retrieve the name of the highest priority template file that exists.
	 *
	 * Searches in the STYLESHEETPATH before TEMPLATEPATH so that themes which
	 * inherit from a parent theme can just overload one file. If the template is
	 * not found in either of those, it looks in the theme-compat folder last.
	 *
	 * @since 1.0.0
	 *
	 * @param string|array $template_names Template file(s) to search for, in order.
	 * @param bool    $load           If true the template file will be loaded if it is found.
	 * @param bool    $require_once   Whether to require_once or require. Default true.
	 *   Has no effect if $load is false.
	 * @return string The template filename if one is located.
	 */
	protected function locate_template( $template_names, $load = false, $require_once = true ) {
		// No file found yet
		$located = false;
		// Remove empty entries
		$template_names = array_filter( (array) $template_names );
		// Try to find a template file
		foreach ( $template_names as $template_name ) {
			// Trim off any slashes from the template name
			$template_name = ltrim( $template_name, '/' );
			// Try locating this template file by looping through the template paths
			foreach ( $this->get_theme_template_paths() as $template_path ) {
				if ( file_exists( $template_path . $template_name ) ) {
					$located = $template_path . $template_name;
					break;
				}
			}
		}
		if ( $load && $located ) {
			load_template( $located, $require_once );
		}
		return $located;
	}
	/**
	 * Return a list of paths to check for template locations
	 *
	 * @since 1.0.0
	 *
	 * @return mixed|void
	 */
	protected function get_theme_template_paths() {
		$theme_directory = trailingslashit( $this->theme_template_directory );
		$file_paths = array(
			1   => trailingslashit( get_stylesheet_directory() ) . $theme_directory,
			10  => trailingslashit( get_template_directory() ) . $theme_directory,
			100 => $this->get_templates_dir()
		);
		$file_paths = apply_filters( $this->filter_prefix . '_template_paths', $file_paths );
		// sort the file paths based on priority
		ksort( $file_paths, SORT_NUMERIC );
		return array_map( 'trailingslashit', $file_paths );
	}
	/**
	 * Return the path to the templates directory in this plugin.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	protected function get_templates_dir() {
		return $this->plugin_directory . 'templates';
	}
}
