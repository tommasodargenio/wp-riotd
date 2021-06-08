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
            foreach($settings as $field) { 
                if ( $key != null && $key != "" && $field['uid'] == $key ) {
                    return get_option( $field['uid'], $field['default']);
                }                    
            }           
        }
        return "";
     }
     /**
      * Go throuh all the setting definitions and set the default in the database
      * this should be called in the plugin activation phase or if the user wants to reset all settings to default
      * BEWARE: If the setting already exists in the database it will be overwritten with the default value from the definitions
      * @since  1.0.1      
      */
     public static function set_defaults() {
        if ( class_exists('WP_RIOTD_ADMIN_SETTINGS_DEFINITIONS', false) ) {
			$settings_definitions = new WP_RIOTD_ADMIN_SETTINGS_DEFINITIONS();
            $settings = $settings_definitions->get_settings_definitions();            
            foreach($settings as $field) { 
                update_option( $field['uid'], $field['default']);
            }
        }
     }

     /**
      * Go through all the setting definitions and remove the related option from the database
      * this method should only be called in the plugin de-activation phase
      * @since  1.0.1
      */
     public static function purge() {
        if ( class_exists('WP_RIOTD_ADMIN_SETTINGS_DEFINITIONS', false) ) {
			$settings_definitions = new WP_RIOTD_ADMIN_SETTINGS_DEFINITIONS();
            $settings = $settings_definitions->get_settings_definitions();            
            foreach($settings as $field) { 
                delete_option( $field['uid'] );
            }
        }
     }
 }