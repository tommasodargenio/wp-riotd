<?php
/**
 * Fired during plugin deactivation
 *
 * @link       https://github.com/tommasodargenio/wp-riodt/includes/class-wp-riotd-deactivator.php
 * @since      1.0.1
 * 
 * @package    RIOTD
 * @subpackage RIOTD/includes
 * @author     Tommaso D'Argenio <dev@tommasodargenio.com>
 */
// Prohibit direct script loading.
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );
class WP_RIOTD_Deactivator {

	/**
	 * Run all the processes required to deactivate the plugin such as
	 * - remove all settings from wp_options table
	 * - purge and remove any residual cache
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		// remove all settings from option table
		WP_RIOTD_Settings::purge();
		// remove cache
		WP_RIOTD_Cache::purge_cache( 'cache' );
	}

}