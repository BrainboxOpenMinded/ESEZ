<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://brainbox.com.pl/
 * @since             2.0.0
 * @package           Ewidencja_Zmarlych
 *
 * @wordpress-plugin
 * Plugin Name:       Ewidencja zmarłych
 * Plugin URI:        https://brainbox.com.pl
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           2.0.0
 * Author:            Brainbox
 * Author URI:        https://brainbox.com.pl/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ewidencja-zmarlych
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
define( 'EWIDENCJA_ZMARLYCH_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ewidencja-zmarlych-activator.php
 */
function activate_ewidencja_zmarlych() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ewidencja-zmarlych-activator.php';
	Ewidencja_Zmarlych_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ewidencja-zmarlych-deactivator.php
 */
function deactivate_ewidencja_zmarlych() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ewidencja-zmarlych-deactivator.php';
	Ewidencja_Zmarlych_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ewidencja_zmarlych' );
register_deactivation_hook( __FILE__, 'deactivate_ewidencja_zmarlych' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ewidencja-zmarlych.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ewidencja_zmarlych() {

	$plugin = new Ewidencja_Zmarlych();
	$plugin->run();

}
run_ewidencja_zmarlych();
