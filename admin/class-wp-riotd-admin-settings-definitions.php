<?php
/**
 *  CLASS-WP-RIOTD-ADMIN-SETTINGS-DEFINITIONS
 *  
 *  Contains all definitions for the settings
 * 
 * @link       https://github.com/tommasodargenio/wp-reddit-iodt/admin/class-wp-riotd-admin-settings-definitions.php
 * @since      1.0.1
 * 
 * @package    WP-Reddit-IOTD
 * @subpackage WP-Reddit-IOTD/admin
 * @author     Tommaso D'Argenio <dev@tommasodargenio.com>
 */

 class WP_RIOTD_ADMIN_SETTINGS_DEFINITIONS { 
     /**
     *  All the configuration settings for this plugin
     * 
     * @since   1.0.1
     * @access  protected
     * @var     string[]            $settings_definitions               Array listing all settings based on WP field definition
     */
     protected $settings_definitions;

     /**
     *  All the settings sections for this plugin
     * 
     * @since   1.0.1
     * @access  protected
     * @var     string[]            $settings_sections               Array listing all sections
     */

     protected $settings_sections;


     /**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.1
	 */
	public function __construct() {
        $this->settings_sections = array(
            array(
                'uid'   => 'wp_riotd_section_general',
                'label' => __('General Settings', 'wp_riotd' )
            ),
            array(
                'uid'   => 'wp_riotd_section_reddit_channel',
                'label' => __('Configure Reddit Channel', 'wp_riotd' )
            ),
        );

        $this->settings_definitions = array (
            array(
                'uid' => 'wp_riotd_channel',
                'label' => __( 'Reddit Channel', 'wp_riotd' ),
                'section' => 'wp_riotd_section_reddit_channel',
                'type' => 'text',
                'options' => false,
                'placeholder' => '',
                'helper' => '',
                'supplemental' => __('Set a valid subreddit channel you want to download images from', 'wp_riotd'),
                'default' => 'images'
            ),
            array(
                'uid' => 'wp_riotd_nsfw_switch',
                'label' => __( 'Allow NSFW content', 'wp_riotd' ),
                'section' => 'wp_riotd_section_general',
                'type' => 'bool',
                'options' => false,
                'placeholder' => '',
                'helper' => '',
                'supplemental' => __('Allow to download and show images marked as Not Safe For Work (i.e.: adult content)', 'wp_riotd'),
                'default' => 1
            ),
            array(
                'uid' => 'wp_riotd_image_selection',
                'label' => __( 'Image selection option', 'wp_riotd' ),
                'section' => 'wp_riotd_section_general',
                'type' => 'select',
                'options' => array('random_rotation' => 'Always random', 'daily_rotation' => 'Same daily' ),
                'placeholder' => '',
                'helper' => '',
                'supplemental' => __('Select if you want to pick a random image every time the page is loaded or keep the same image for the day', 'wp_riotd'),
                'default' => 'random_rotation'
            ),
            array(
                'uid' => 'wp_riotd_image_scraping',
                'label' => __( 'Image scraping mode', 'wp_riotd' ),
                'section' => 'wp_riotd_section_general',
                'type' => 'select',
                'options' => array('random_update' => 'Random', 'last_update' => 'Last posted' ),
                'placeholder' => '',
                'helper' => '',
                'supplemental' => __('Indicate if you want to pick a random image, or the last one uploaded', 'wp_riotd'),
                'default' => 'random_update'
            ),



            
        );
    }

    /**
     * Return the settings definitions array
     * @since   1.0.1
     * @return  string[]         $settings_definitions              Array listing all settings 
     */
    public function get_settings_definitions() {
        return $this->settings_definitions;
    }
    /**
     * Return the settings sections array
     * @since   1.0.1
     * @return  string[]         $settings_sections              Array listing all sections  
     */
    public function get_settings_sections() {
        return $this->settings_sections;
    }    
 }