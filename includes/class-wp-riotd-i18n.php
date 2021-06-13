<?php
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 * 
 * @link       https://github.com/tommasodargenio/wp-riodt/includes/class-wp-riotd-i18n.php
 * @since      1.0.1
 * 
 * @package    RIOTD
 * @subpackage RIOTD/includes
 * @author     Tommaso D'Argenio <dev@tommasodargenio.com>
 */
// Prohibit direct script loading.
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

class WP_RIOTD_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.1
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wp-riotd',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}