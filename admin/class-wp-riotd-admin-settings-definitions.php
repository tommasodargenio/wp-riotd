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
                'uid'   => \WP_RIODT_SETTING_PREFIX.'_section_welcome',
                'label' => __('Welcome','wp_riotd')
            ),
            array(
                'uid'   => \WP_RIODT_SETTING_PREFIX.'_section_general',
                'label' => __('General Settings', 'wp_riotd' )
            ),
            array(
                'uid'   => \WP_RIODT_SETTING_PREFIX.'_section_layout',
                'label' => __('Theme Layout', 'wp_riotd')
            ),
            array(
                'uid'   => \WP_RIODT_SETTING_PREFIX.'_section_reddit_channel',
                'label' => __('Configure Reddit Channel', 'wp_riotd' )
            ),
            array(
                'uid'   => \WP_RIODT_SETTING_PREFIX.'_section_image_preferences',
                'label' => __('Image Preferences', 'wp_riotd') 
            ),
        );

        $this->settings_definitions = array (            
            array(
                'uid' => \WP_RIODT_SETTING_PREFIX.'_aspect_ratio',
                'label' => __( 'Image aspect', 'wp_riotd' ),
                'section' => \WP_RIODT_SETTING_PREFIX.'_section_image_preferences',
                'type' => 'select',
                'options' => array( 'landscape' => __('Landscape', 'wp_riotd'), 'portrait'=> __('Portrait', 'wp_riotd') ),
                'placeholder' => '',
                'helper' => '',
                'supplemental' => __('Select the preferred aspect ratio when selecting the image', 'wp_riotd'),
                'default' => array('landscape')
            ),
            array(
                'uid' => \WP_RIODT_SETTING_PREFIX.'_image_max_width',
                'label' => __( 'Max image width', 'wp_riotd' ),
                'section' => \WP_RIODT_SETTING_PREFIX.'_section_image_preferences',
                'type' => 'text',
                'options' => '',
                'placeholder' => '',
                'helper' => '',
                'supplemental' => __('Indicate the max width of the image', 'wp_riotd'),
                'default' => '640'
            ),       
            array(
                'uid' => \WP_RIODT_SETTING_PREFIX.'_image_max_height',
                'label' => __( 'Max image height', 'wp_riotd' ),
                'section' => \WP_RIODT_SETTING_PREFIX.'_section_image_preferences',
                'type' => 'text',
                'options' => '',
                'placeholder' => '',
                'helper' => '',
                'supplemental' => __('Indicate the max height of the image', 'wp_riotd'),
                'default' => '360'
            ),                     

            array(
                'uid' => \WP_RIODT_SETTING_PREFIX.'_channel',
                'label' => __( 'Reddit Channel', 'wp_riotd' ),
                'section' => \WP_RIODT_SETTING_PREFIX.'_section_reddit_channel',
                'type' => 'text',
                'options' => false,
                'placeholder' => '',
                'helper' => '',
                'supplemental' => __('Set a valid subreddit channel you want to download images from', 'wp_riotd'),
                'default' => 'images'
            ),
            array(
                'uid' => \WP_RIODT_SETTING_PREFIX.'_download_limit',
                'label' => __( 'Download limits', 'wp_riotd' ),
                'section' => \WP_RIODT_SETTING_PREFIX.'_section_reddit_channel',
                'type' => 'text',
                'options' => false,
                'placeholder' => '50',
                'helper' => '',
                'supplemental' => __('Set a download limit, lower numbers results in less images but faster processing', 'wp_riotd'),
                'default' => '50'
            ),
            array(
                'uid' => \WP_RIODT_SETTING_PREFIX'_nsfw_switch',
                'label' => __( 'Allow NSFW content', 'wp_riotd' ),
                'section' => \WP_RIODT_SETTING_PREFIX.'_section_general',
                'type' => 'bool',
                'options' => false,
                'placeholder' => '',
                'helper' => '',
                'supplemental' => __('Allow to download and show images marked as Not Safe For Work (i.e.: adult content)', 'wp_riotd'),
                'default' => 1
            ),
            array(
                'uid' => \WP_RIODT_SETTING_PREFIX.'_zoom_switch',
                'label' => __( 'Allow Zoom on mouse over', 'wp_riotd' ),
                'section' => \WP_RIODT_SETTING_PREFIX.'_section_layout',
                'type' => 'bool',
                'options' => false,
                'placeholder' => '',
                'helper' => '',
                'supplemental' => __('If enabled, when the mouse is over the image it will overlay a window with the image in a bigger resolution.', 'wp_riotd'),
                'default' => 1
            ),            
            array(
                'uid' => \WP_RIODT_SETTING_PREFIX.'_author_switch',
                'label' => __( 'Display author\'s name', 'wp_riotd' ),
                'section' => \WP_RIODT_SETTING_PREFIX.'_section_layout',
                'type' => 'bool',
                'options' => false,
                'placeholder' => '',
                'helper' => '',
                'supplemental' => __('Display the author\'s name in the caption', 'wp_riotd'),
                'default' => 1
            ),
            array(
                'uid' => \WP_RIODT_SETTING_PREFIX.'_channel_switch',
                'label' => __( 'Display channel\'s name', 'wp_riotd' ),
                'section' => \WP_RIODT_SETTING_PREFIX.'_section_layout',
                'type' => 'bool',
                'options' => false,
                'placeholder' => '',
                'helper' => '',
                'supplemental' => __('Display the subreddit channel\'s name in the header title?', 'wp_riotd'),
                'default' => 1
            ),            
            array(
                'uid' => \WP_RIODT_SETTING_PREFIX.'_title_switch',
                'label' => __( 'Display image\'s title', 'wp_riotd' ),
                'section' => \WP_RIODT_SETTING_PREFIX.'_section_layout',
                'type' => 'bool',
                'options' => false,
                'placeholder' => '',
                'helper' => '',
                'supplemental' => __('Display the image\'s title', 'wp_riotd'),
                'default' => 1
            ),
            array(
                'uid' => \WP_RIODT_SETTING_PREFIX.'_link_switch',
                'label' => __( 'Add link to reddit post?', 'wp_riotd' ),
                'section' => \WP_RIODT_SETTING_PREFIX.'_section_layout',
                'type' => 'bool',
                'options' => false,
                'placeholder' => '',
                'helper' => '',
                'supplemental' => __('If enabled, the image will have a link to the related reddit post, this will open in a new tab', 'wp_riotd'),
                'default' => 1
            ),            
            array(
                'uid' => \WP_RIODT_SETTING_PREFIX.'_image_scraping',
                'label' => __( 'Image scraping mode', 'wp_riotd' ),
                'section' => \WP_RIODT_SETTING_PREFIX.'_section_general',
                'type' => 'select',
                'options' => array('daily_update'=>__('Same daily', 'wp_riotd'), 'random_update' => __('Random','wp_riotd'), 'last_update' => __('Last posted','wp_riotd') ),
                'placeholder' => '',
                'helper' => '',
                'supplemental' => __('Indicate if you want to change image every load (random), or use the same daily, or always use the last uploaded (this may change throughout the day)', 'wp_riotd'),
                'default' => array('random_update')
            ),    
            array(
                'uid' => \WP_RIODT_SETTING_PREFIX.'_css_switch',
                'label' => __( 'Use plugin\'s css?', 'wp_riotd' ),
                'section' => \WP_RIODT_SETTING_PREFIX.'_section_layout',
                'type' => 'bool',
                'options' => false,
                'placeholder' => '',
                'helper' => '',
                'supplemental' => __('If enabled the plugin will use its own CSS styling, otherwise you can override the css classes with your own styling', 'wp_riotd'),
                'default' => 1
            ),                
            array(
                'uid' => \WP_RIODT_SETTING_PREFIX.'_layout',
                'label' => __( 'Layout mode', 'wp_riotd' ),
                'section' => \WP_RIODT_SETTING_PREFIX.'_section_layout',
                'type' => 'select',
                'options' => array('minimal'=>__('Minimalistic', 'wp_riotd'), 'full' => __('Full','wp_riotd') ),
                'placeholder' => '',
                'helper' => '',
                'supplemental' => __('Select which layout you prefer. Minimialistic will only show the image, full will show all the available information', 'wp_riotd'),
                'default' => array('full')
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