<?php
/**
 * Templates
 *
 * @package   Template_Loader
 * @author    Gary Jones
 * @link      http://gamajo.com/meal-planner
 * @copyright 2013 Gary Jones
 * @license   GPL-2.0+
 */
require plugin_dir_path( __FILE__ ) . 'class-gamajo-template-loader.php';
/**
 * Template loader for Meal Planner plugin.
 *
 * Only need to specify class properties here.
 *
 * @package Meal_Planner
 * @author  Gary Jones
 */
class Meal_Planner_Template_Loader extends Gamajo_Template_Loader {
	/**
	 * Prefix for filter names.
	 *
	 * @since 1.0.0
	 * @type string
	 */
	protected $filter_prefix = 'bootstrap_genesis_teplates';
	/**
	 * Directory name where custom templates for this plugin should be found in the theme.
	 *
	 * @since 1.0.0
	 * @type string
	 */
	protected $theme_template_directory = 'bootstrap-genesis-teplates';
	/**
	 * Reference to the root directory path of this plugin.
	 *
	 * @since 1.0.0
	 * @type string
	 */
	protected $plugin_directory = BSG_PLUGIN_DIR;
}
