<?php
/**
 * RIOTD Reddit Image of The Day
 * 
 * @link                https://github.com/tommasodargenio/wp-riotd/
 * @since               1.0.0
 * @package             WP-RIOTD
 * @author              Tommaso D'Argenio
 * @copyright           2021 Tommaso D'Argenio
 * @license             GPL-3.0-or-later
 * 
 * @wordpress-plugin
 * Plugin Name:         RIOTD Reddit Image Of The Day
 * Plugin URI:          https://github.com/tommasodargenio/wp-riotd/
 * Description:         Download a random image from any subreddit and display it in your WordPress site
 * Version:             1.0.0
 * License:             GPLv3
 * License URI:         https://github.com/tommasodargenio/wp-riotd/gpl-3.0.txt
 * Author:              Tommaso D'Argenio
 * Author URI:          https://tommasodargenio.com
 * Text Domain:         wp-riotd
 */
// Prohibit direct script loading.
defined( 'ABSPATH' ) || die( esc_html__('No direct script access allowed!', 'wp-riotd'));

// Plugin version
define ( 'WP_RIOTD_VERSION', '1.0.0' );

// Plugin name
define ( 'WP_RIOTD_PLUGIN_NAME', 'RIOTD-Reddit-Image-Of-The-Day' );

// Plugin shortname
define ( 'WP_RIOTD_SHORT_NAME', 'RIOTD');

// Short code for full UI
define ( 'WP_RIOTD_SHORTCODE', 'riotd' );

// Short code for data only
define ( 'WP_RIOTD_SHORTCODE_DATA', 'riotd-data' );

// Reddit main url
define ('WP_RIOTD_REDDIT_MAIN', 'https://www.reddit.com' );
 
// Reddit url to fecth data
define ( 'WP_RIOTD_REDDIT_URL', 'https://www.reddit.com/r/%reddit_channel%/new.json' );


// Reddit url to fecth channel information
define ( 'WP_RIOTD_REDDIT_CHANNEL_INFO', 'https://www.reddit.com/r/%reddit_channel%/about.json');

// Github Repository link
define ( 'WP_RIOTD_GITHUB', 'https://github.com/tommasodargenio/wp-riotd' );

// Prefix for settings
define ( 'WP_RIODT_SETTING_PREFIX', 'wp_riotd' );

 /**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-riotd-activator.php
 */
function activate_wp_riotd() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-riotd-activator.php';
	WP_RIOTD_Activator::activate();
}

register_activation_hook( __FILE__, 'activate_wp_riotd' );

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-riotd-deactivator.php
 */
function deactivate_wp_riotd() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-riotd-deactivator.php';
	WP_RIOTD_Deactivator::deactivate();
}

register_deactivation_hook( __FILE__, 'deactivate_wp_riotd' );


 // Core plugin classes
 require plugin_dir_path(__FILE__) . 'includes/class-wp-riotd.php';

 // Execution
 function run_wp_riotd() {
    $plugin = new WP_RIOTD();
    $plugin->run();    
 }

 run_wp_riotd();