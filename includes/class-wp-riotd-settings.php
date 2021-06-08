<?php
/**
 * CLASS-WP-RIOTD-SETTINGS
 * 
 * Get all the available settings from the database
 * 
 * 
 * @link       https://github.com/tommasodargenio/wp-reddit-iodt/includes/class-wp-riotd-settings.php
 * @since      1.0.1
 * 
 * @package    WP-Reddit-IOTD
 * @subpackage WP-Reddit-IOTD/includes
 * @author     Tommaso D'Argenio <dev@tommasodargenio.com>
 */

 class WP_RIOTD_Settings {
     /**
      * Given a key, scans the setting definition array, if the key is found it will load the related value from the database
      * @since  1.0.1
      * @param  string  $key    the key to retrieve the setting for
      * @return string  setting the retrieved setting, the default setting if the column can't be found in the database or empty string if definitions could not be loaded     
      */
     public static function get($key) {
        if ( defined( 'WP_RIODT_SETTING_PREFIX' ) ) {
            // add SETTING_PREFIX to the key if not in it already
            if ( !stristr( $key, \WP_RIODT_SETTING_PREFIX ) ) {
                $key = \WP_RIODT_SETTING_PREFIX.'_'.$key;
            }            
        }
        if ( class_exists('WP_RIOTD_ADMIN_SETTINGS_DEFINITIONS', false) ) {
			$settings_definitions = new WP_RIOTD_ADMIN_SETTINGS_DEFINITIONS();
            $settings = $settings_definitions->get_settings_definitions();            
            foreach($settings_definitions->get_settings_definitions() as $field) { 
                if ( $key != null && $key != "" && $field['uid'] == $key ) {
                    return get_option( $field['uid'], $field['default']);
                }                    
            }
        }
        return "";
     }
 }