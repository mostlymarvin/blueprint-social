<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in
 * the plugin admin area. This file also includes all of the dependencies
 * used by the plugin, registers the activation and deactivation functions,
 * and defines a function that starts the plugin.
 *
 * @link              https://memphismckay.com
 * @since             1.0.0
 * @package           Blueprint_Social
 *
 * @wordpress-plugin
 * Plugin Name:       Blueprint Social
 * Plugin URI:        https://blueprint-social.memphismckay.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Memphis McKay
 * Author URI:        https://memphismckay.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       blueprint-social
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'BLUEPRINT_SOCIAL_VERSION', '1.0.0' );
define( 'BLUEPRINT_SOCIAL_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'BLUEPRINT_SOCIAL_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'BLUEPRINT_SOCIAL_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-blueprint-social-activator.php
 */
function activate_blueprint_social() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-blueprint-social-activator.php';
	Blueprint_Social_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-blueprint-social-deactivator.php
 */
function deactivate_blueprint_social() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-blueprint-social-deactivator.php';
	Blueprint_Social_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_blueprint_social' );
register_deactivation_hook( __FILE__, 'deactivate_blueprint_social' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-blueprint-social.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_blueprint_social() {

	$plugin = new Blueprint_Social();
	$plugin->run();

}
run_blueprint_social();
