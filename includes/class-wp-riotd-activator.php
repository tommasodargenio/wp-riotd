<?php
/**
 * Fired during plugin activation
 *
 * @link       https://github.com/tommasodargenio/wp-riotd/includes/class-wp-riotd-activator.php
 * @since      1.0.0
 * 
 * @package    RIOTD
 * @subpackage RIOTD/includes
 * @author     Tommaso D'Argenio <dev@tommasodargenio.com>
 */
// Prohibit direct script loading.
defined( 'ABSPATH' ) || die( esc_html__('No direct script access allowed!' ,'wp-riotd'));

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
		// set internal / private settings
		WP_RIOTD_Settings::set_privates();
	}

}