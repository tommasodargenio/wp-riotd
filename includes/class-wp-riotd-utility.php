<?php
/**
 * CLASS-WP-RIOTD-UTILITY
 * 
 * Collection of static utility methods of generic use throughout the plugin
 * 
 * 
 * @link       https://github.com/tommasodargenio/wp-reddit-iodt/includes/class-wp-riotd-utility.php
 * @since      1.0.1
 * 
 * @package    WP-Reddit-IOTD
 * @subpackage WP-Reddit-IOTD/includes
 * @author     Tommaso D'Argenio <dev@tommasodargenio.com>
 */

 class WP_RIOTD_Utility {
     /**
      * Convert seconds in human readable format
      * @author https://stackoverflow.com/a/19680778/3310134
      * @since  1.0.1
      * @param  int     $seconds        Seconds to convert
      * @return string  $human_str      Readable version of seconds in format: xx days, xx hours, xx minutes and xx seconds
      */
      public static function seconds_to_human($seconds) {
          // this will make sure the parameter is a number or reset to zero if not.
          $seconds = intval($seconds);
          $dtf = new \DateTime('@0');
          $dtT = new \DateTime("@$seconds");

          $d ='%a '.__('days','wp_riotd').', ';
          $h ='%h '.__('hours', 'wp_riotd').', ';
          $m ='%i '.__('minutes','wp_riotd');
          $s = ' '.__('and','wp_riotd').' %s '.__('seconds', 'wp_riotd');

          $diff = $dtf->diff($dtT);
          
          if ( $diff->d == 0 ) {
              $d = '';
          }
          if ( $diff->h == 0 ) {
              $h = '';
          }
          if ( $diff->i == 0 ) {
              $i = '';
          }
          if ( $diff->s == 0 ) {
              $s = '';
          }
          

          return $dtf->diff($dtT)->format($d.$h.$m.$s);
      }
 }
