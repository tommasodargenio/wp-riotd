<?php
/**
 * Fired during plugin activation
 *
 * @link       https://github.com/tommasodargenio/wp-reddit-iodt/includes/class-wp-riotd-activator.php
 * @since      1.0.1
 * 
 * @package    WP-Reddit-IOTD
 * @subpackage WP-Reddit-IOTD/includes
 * @author     Tommaso D'Argenio <dev@tommasodargenio.com>
 */

class WP_RIOTD_Activator {

	/**
	 * Run all the processes required to activate the plugin such as
	 * - create options in wp_options
	 * - set default options
	 * 
	 *	 
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		// create options in db and set the defaults
		WP_RIOTD_Settings::set_defaults();
	}

}