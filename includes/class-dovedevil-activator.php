<?php

/**
 * Fired during plugin activation
 *
 * @link       http://emha.koeln
 * @since      0.1.0
 *
 * @package    Dovedevil
 * @subpackage Dovedevil/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      0.1.0
 * @package    Dovedevil
 * @subpackage Dovedevil/includes
 * @author     emha.koeln <mheep@emha.koeln>
 */
class Dovedevil_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    0.1.0
	 */
	public static function activate() {

	    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-dovedevil-static-db.php';
	    $db = new Dovedevil_Static_DB();
	    $db::create_db();
	    //$db::set_sample_data();
  
	}

	
}
