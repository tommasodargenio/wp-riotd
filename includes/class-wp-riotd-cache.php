<?php
/**
 * CLASS-WP-RIOTD-CACHE
 * 
 * Manage the cacheable data, leveraging the WordPress Transient API
 * 
 * 
 * @link       https://github.com/tommasodargenio/wp-reddit-iodt/includes/class-wp-riotd-cache.php
 * @since      1.0.1
 * 
 * @package    WP-Reddit-IOTD
 * @subpackage WP-Reddit-IOTD/includes
 * @author     Tommaso D'Argenio <dev@tommasodargenio.com>
 */

 class WP_RIOTD_Cache {
    /**
     *  Set the given entity in the WP Cache
     *  @since  1.0.1
     *  @param  array['uid' => Unique Identifier, 'payload' => the data to store]   $entity     Object / Array to store in cache
     */
    public static function set_cache($entity) {
        // check if the entity contains the required element
        if ( !array_key_exists( 'uid', $entity ) || !array_key_exists( 'payload', $entity ) ) {            
            return;
        }

        // check if the uid is not null or empty, and if the payload is not empty. No point in setting an empty cache element
        if ( $entity['uid'] === null || $entity['uid'] === '' || $entity['payload'] === null || $entity['payload'] === '') {            
            return;
        }

        // check if the entity is a valid cacheable object
        if ( class_exists( 'WP_RIOTD_ADMIN_SETTINGS_DEFINITIONS', false ) ) {
			$settings_definitions = new WP_RIOTD_ADMIN_SETTINGS_DEFINITIONS();
            $cache = $settings_definitions->get_cache_definition( $entity['uid'] );

            // if cache is null or empty then the definition doesn't exist, so we don't cache
            if ( $cache === null || sizeof($cache) <= 0 ) {                
                return;
            }

            // get the default expiration setting
            $expiration = WP_RIOTD_Settings::get('cache_lifetime');
                
            
            // set the cache
            set_transient( $cache['uid'], $entity['payload'], $expiration );
        }
        return;
    }
    /**
     *  Retrieve a cached entity from the WP Cache
     *  @since  1.0.1
     *  @param  string  $uid        Unique identified of the entity to retrieve
     *  @return string  $payload    Cached data
     */
    public static function get_cache($uid) {
        // can't retrieve a cache if we don't know the identifier
        if ( $uid === null || $uid === '' ) {
            return;
        }

        // check if the uid is has a valid cache definition
        if ( class_exists( 'WP_RIOTD_ADMIN_SETTINGS_DEFINITIONS', false ) ) {
			$settings_definitions = new WP_RIOTD_ADMIN_SETTINGS_DEFINITIONS();
            $cache = $settings_definitions->get_cache_definition( $uid );

            // if cache is null or empty then the definition doesn't exist, so we don't cache
            if ( $cache === null || sizeof($cache) <= 0 ) {
                return;
            }

            $payload = get_transient( $cache['uid'] );

            return $payload;
        }
        return;
    }

    /**
     *  Delete a cached entity from the WP Cache
     *  @since  1.0.1
     *  @param  string  $uid        Unique identified of the entity to retrieve     
     *  @return boolean             false if failed, true if cache deleted
     */

    public static function purge_cache($uid) {
        // can't delete a cache if we don't know the identifier
        if ( $uid === null || $uid === '' ) {
            return false;
        }

        // check if the uid is has a valid cache definition
        if ( class_exists( 'WP_RIOTD_ADMIN_SETTINGS_DEFINITIONS', false ) ) {
			$settings_definitions = new WP_RIOTD_ADMIN_SETTINGS_DEFINITIONS();
            $cache = $settings_definitions->get_cache_definition( $uid );

            // if cache is null or empty then the definition doesn't exist, so we don't cache
            if ( $cache === null || sizeof($cache) <= 0 ) {
                return false;
            }
            
            return delete_transient( $cache['uid'] );
        }
        return false;
    }

    /**
     *  Get the time left in seconds before expiration of the requested cache
     *  @since  1.0.1
     *  @param  string  $uid        Unique idenfitier of the chace to check the expiration time for
     *  @return int     $time_left  The time left in seconds before the cache expires
     */
     public static function get_cache_expiration($uid) {
        if ( class_exists( 'WP_RIOTD_ADMIN_SETTINGS_DEFINITIONS', false ) ) {
			$settings_definitions = new WP_RIOTD_ADMIN_SETTINGS_DEFINITIONS();
            $cache = $settings_definitions->get_cache_definition( $uid );

            // if cache is null or empty then the definition doesn't exist, so we assume cache expired and never re-created
            if ( $cache === null || sizeof($cache) <= 0 ) {
                return 0;
            }

            $expires = (int) get_option( '_transient_timeout_'.$cache['uid'], 0 );
            
            
            if ( $expires === 0  ) {
                // can't find the expiration setting or cache expired already
                return 0;
            }
            
            $time_left = $expires - time();
            return $time_left;
        }
        

     }

 }