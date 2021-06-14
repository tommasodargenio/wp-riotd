<?php
/**
 * CLASS-WP-RIOTD-SETTINGS
 * 
 * Get all the available settings from the database
 * 
 * 
 * @link       https://github.com/tommasodargenio/wp-riodt/includes/class-wp-riotd-settings.php
 * @since      1.0.1
 * 
 * @package    RIOTD
 * @subpackage RIOTD/includes
 * @author     Tommaso D'Argenio <dev@tommasodargenio.com>
 */
 // Prohibit direct script loading.
 defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );
 
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
      * Return all the settings from the database
      * @since  1.0.1
      * @return array[]     $result     Associative array containing the settings read from the database in format setting_name => setting_value      
      */
     public static function get_all() {
        $result = array();
        if ( class_exists('WP_RIOTD_ADMIN_SETTINGS_DEFINITIONS', false) ) {
			$settings_definitions = new WP_RIOTD_ADMIN_SETTINGS_DEFINITIONS();
            $settings = $settings_definitions->get_settings_definitions();            
            foreach($settings as $field) {                 
                    $result[$field['uid']] = get_option( $field['uid'], $field['default']);                
            }           
        }     
        return $result;
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
                // if the field['default'] element is null it will trigger an error
                // ref: https://core.trac.wordpress.org/ticket/52723
                if ($field['default'] === null ) {
                    $field['default'] = '';
                }
                // since this method is callable by the user, we don't want to reset the private settings 
                // which are internal to the plugin only - i.e. activation date, licenses, etc.
                if ($field['type'] != 'private') {
                    update_option( $field['uid'], $field['default']);
                }
            }
            return true;
        }
        return false;
     }
     /**
      * Go through all private settings and set the default values in the database
      * this must be only called once when the plugin is activated.
      * @since  1.0.1
      */
     public static function set_privates() {
        if ( class_exists('WP_RIOTD_ADMIN_SETTINGS_DEFINITIONS', false) ) {
			$settings_definitions = new WP_RIOTD_ADMIN_SETTINGS_DEFINITIONS();
            $settings = $settings_definitions->get_settings_definitions();            
            foreach($settings as $field) {
                // if the field['default'] element is null it will trigger an error
                // ref: https://core.trac.wordpress.org/ticket/52723
                if ($field['default'] === null ) {
                    $field['default'] = '';
                }
                // since this method is callable by the user, we don't want to reset the private settings 
                // which are internal to the plugin only - i.e. activation date, licenses, etc.
                if ($field['type'] == 'private') {
                    update_option( $field['uid'], $field['default']);
                }
            }            
        }        
     }

     /**
      * Compresses and encode all settings, this is useful for sending debug info for support
      * @since  1.0.1
      * @return string  Base64 encoding and GZCompressed of JSON export of settings 
      */
     public static function to_base64() {
        $json = json_encode(self::get_all());
        return base64_encode(gzcompress($json,9));   
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