<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://emha.koeln
 * @since             0.1.0
 * @package           Dovedevil
 *
 * @wordpress-plugin
 * Plugin Name:       Dovedevil
 * Plugin URI:        http//wp-plugins.emha.koeln/dovedevil
 * Description:       Manage your Pigeons as Fancier or as Club
 * Version:           0.1.1
 * Author:            emha.koeln
 * Author URI:        http://emha.koeln
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       dovedevil
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 0.1.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'DOVEDEVIL_VERSION', '0.1.1' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-dovedevil-activator.php
 */
function activate_dovedevil() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dovedevil-activator.php';
	Dovedevil_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-dovedevil-deactivator.php
 */
function deactivate_dovedevil() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dovedevil-deactivator.php';
	Dovedevil_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_dovedevil' );
register_deactivation_hook( __FILE__, 'deactivate_dovedevil' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-dovedevil.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.1.0
 */
function run_dovedevil() {

    $plugin = new Dovedevil( plugin_dir_path(__FILE__), plugin_dir_url(__FILE__) );
	$plugin->run();

}
run_dovedevil();
