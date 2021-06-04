<?php
/**
 * WP Reddit IOTD
 * 
 * @link                https://github.com/tommasodargenio/wp-reddit-iotd/
 * @since               1.0.0
 * @package             WP-Reddit-IOTD
 * @author              Tommaso D'Argenio
 * @copyright           2021 Tommaso D'Argenio
 * @license             GPL-3.0-or-later
 * 
 * @wordpress-plugin
 * Plugin Name:         WordPress Reddit Image Of The Day
 * Plugin URI:          https://github.com/tommasodargenio/wp-reddit-iotd/
 * Description:         Download a random image from any subreddit and display it in your WordPress site
 * Version:             1.0.1
 * License:             GPLv3
 * License URI:         https://github.com/tommasodargenio/wp-reddit-iotd/LICENSE
 * Author:              Tommaso D'Argenio
 * Author URI:          https://tommasodargenio.com
 * Text Domain:         wp-riotd
 */

// check if this file is called within WP, if not abort
if ( !defined( 'WPINC' ) ) {
    die;
}

// Plugin version
define ('WP_RIOTD_VERSION', '1.0.1' );

// Plugin name
define ( 'WP_RIOTD_PLUGIN_NAME', 'WP-Reddit-IOTD' );

// Short code
define ( 'WP_RIOTD_SHORTCODE', 'reddit-iotd' );

// Reddit main url
define ('WP_RIOTD_REDDIT_MAIN', 'https://www.reddit.com');
 
// Reddit url to fecth data
define ('WP_RIOTD_REDDIT_URL', 'https://www.reddit.com/r/%reddit_channel%/new.json');



 /**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
/*
function activate_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-plugin-name-activator.php';
	Plugin_Name_Activator::activate();
}*/

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
/**function deactivate_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-plugin-name-deactivator.php';
	Plugin_Name_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_plugin_name' );
register_deactivation_hook( __FILE__, 'deactivate_plugin_name' );
*/

 // Core plugin classes
 require plugin_dir_path(__FILE__) . 'includes/class-wp-riotd.php';

 // Execution
 function run_wp_riotd() {
    $plugin = new WP_RIOTD();
    $plugin->run();    
 }

 run_wp_riotd();