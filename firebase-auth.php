<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/bhoot-biswas
 * @since             1.0.0
 * @package           Firebase_Auth
 *
 * @wordpress-plugin
 * Plugin Name:       Firebase Auth
 * Plugin URI:        https://dev.dhakadesk.com/plugins/firebase-auth/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Mithun Biswas
 * Author URI:        https://github.com/bhoot-biswas
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       firebase-auth
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
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-firebase-auth-activator.php
 */
function activate_firebase_auth() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-firebase-auth-activator.php';
	Firebase_Auth_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-firebase-auth-deactivator.php
 */
function deactivate_firebase_auth() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-firebase-auth-deactivator.php';
	Firebase_Auth_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_firebase_auth' );
register_deactivation_hook( __FILE__, 'deactivate_firebase_auth' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-firebase-auth.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_firebase_auth() {

	$plugin = new Firebase_Auth();
	$plugin->run();

}
run_firebase_auth();
