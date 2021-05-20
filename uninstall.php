<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       http://emha.koeln
 * @since      0.1.0
 *
 * @package    Dovedevil
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}
global $wpdb;

// Delete Options
// delete_option('dovedevil');
$sql = "DELETE FROM " . $wpdb->prefix . "_options"; 
$sql .= " WHERE `option_name` like 'dovedevil_%'";

// old version
$sql = "DELETE FROM " . $wpdb->prefix . "_options";
$sql .= " WHERE `option_name` like 'homing_pigeon_%'";

// Drop db tables
// Drop clubs
$current_table = $wpdb->prefix . 'dovedevil_clubs';
$wpdb->query("DROP TABLE IF EXISTS $current_table");

// Drop fanciers
$current_table = $wpdb->prefix . 'dovedevil_fanciers';
$wpdb->query("DROP TABLE IF EXISTS $current_table");

// Drop pigeons
$current_table = $wpdb->prefix . 'dovedevil_pigeons';
$wpdb->query("DROP TABLE IF EXISTS $current_table");

