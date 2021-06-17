<?php
/**
 * CLASS-WP-RIOTD-UTILITY
 * 
 * Collection of static utility methods of generic use throughout the plugin
 * 
 * 
 * @link       https://github.com/tommasodargenio/wp-riodt/includes/class-wp-riotd-utility.php
 * @since      1.0.1
 * 
 * @package    RIOTD
 * @subpackage RIOTD/includes
 * @author     Tommaso D'Argenio <dev@tommasodargenio.com>
 */
 // Prohibit direct script loading.
 defined( 'ABSPATH' ) || die( esc_html__('No direct script access allowed!' ));

 class WP_RIOTD_Utility {
     /**
      *  Convert a number in a human readable format if over or equal to 1000, adapted to php from a js source
      *  @since     1.0.1
      *  @author    https://stackoverflow.com/a/28608086/3310134
      *  @param     int     $number     Number to convert
      *  @param     int     $digits     Number of digits to appear after the decimal point   
      *  @return    string  $human_str  Readable version of number
      *  @example   // number_to_human(12453, 1) -> returns '12.5k'
      */
      public static function number_to_human($number, $digits) {
        $units = ['k', 'M', 'G', 'T', 'P', 'E', 'Z', 'Y'];        

        for($i=sizeof($units)-1; $i>=0; $i--) {
            $decimal = pow(1000, $i+1);

            if($number <= -$decimal || $number >= $decimal) {
                return number_format( ($number / $decimal), $digits ). $units[$i];
            }
        }

        return strval($number);
      }
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

          $d ='%a '.esc_html__('days','wp-riotd').', ';
          $h ='%h '.esc_html__('hours', 'wp-riotd').', ';
          $m ='%i '.esc_html__('minutes','wp-riotd');
          /* translators: %s is the number of seconds in numerical format no translation needed */
          $s = ' '.esc_html__('and %s seconds','wp-riotd');

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

      /**
       * Dirty CSS minifier - may not cover all cases and could break css. Since this will be used to minify user's custom CSS should contain complicated CSS in theory
       * @since     1.0.1
       * @author    Gary Jones (https://twitter.com/GaryJ)
       * @link      https://github.com/GaryJones/Simple-PHP-CSS-Minification/blob/master/minify.php
       * @param     string  $css    CSS to minify
       * @return    string  minified CSS    
       */
      public static function minify_css($css) {
        // Normalize whitespace
        $css = preg_replace( '/\s+/', ' ', $css );
        
        // Remove spaces before and after comment
        $css = preg_replace( '/(\s+)(\/\*(.*?)\*\/)(\s+)/', '$2', $css );

        // Remove comment blocks, everything between /* and */, unless
        // preserved with /*! ... */ or /** ... */
        $css = preg_replace( '~/\*(?![\!|\*])(.*?)\*/~', '', $css );

        // Remove ; before }
        $css = preg_replace( '/;(?=\s*})/', '', $css );

        // Remove space after , : ; { } */ >
        $css = preg_replace( '/(,|:|;|\{|}|\*\/|>) /', '$1', $css );

        // Remove space before , ; { } ( ) >
        $css = preg_replace( '/ (,|;|\{|}|\(|\)|>)/', '$1', $css );

        // Strips leading 0 on decimal values (converts 0.5px into .5px)
        $css = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );

        // Strips units if value is 0 (converts 0px to 0)
        $css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );

        // Converts all zeros value into short-hand
        $css = preg_replace( '/0 0 0 0/', '0', $css );

        // Shortern 6-character hex color codes to 3-character where possible
        $css = preg_replace( '/#([a-f0-9])\\1([a-f0-9])\\2([a-f0-9])\\3/i', '#\1\2\3', $css );

        return trim( $css );          
      }
 }
