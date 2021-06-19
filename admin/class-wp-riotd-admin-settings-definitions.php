<?php
/**
 *  CLASS-WP-RIOTD-ADMIN-SETTINGS-DEFINITIONS
 *  
 *  Contains all definitions for the settings
 * 
 * @link       https://github.com/tommasodargenio/wp-riotd/admin/class-wp-riotd-admin-settings-definitions.php
 * @since      1.0.1
 * 
 * @package    RIOTD
 * @subpackage RIOTD/admin
 * @author     Tommaso D'Argenio <dev@tommasodargenio.com>
 */
 // Prohibit direct script loading.
 defined( 'ABSPATH' ) || die( esc_html__('No direct script access allowed!', 'wp-riotd' ));

 class WP_RIOTD_ADMIN_SETTINGS_DEFINITIONS { 
     /**
     *  All the configuration settings for this plugin
     * 
     * @since   1.0.1
     * @access  protected
     * @var     array[]['uid'             => Unique identifier, 
     *                'label'           => description, 
     *                'section'         => parent section, 
     *                'type'            => type of setting (bool, text, password, number, textarea, select, multiselect),
     *                'options'         => if type is select or multiselect, this contains the option to display in a key=>value pair
     *                'placeholder'     => placeholder value for the field
     *                'helper'          => helper text displayed to the right of the field
     *                'supplemental'    => helper text displayed below the field
     *                'default'         => default value  ]            $settings_definitions               Array listing all settings based on WP field definition
     */
     protected $settings_definitions;
     /**
     *  All the cacheable data for this plugin
     * 
     * @since   1.0.1
     * @access  protected
     * @var     array[]['uid'       =>  Unique identifier
     *                'label'     =>  description
     *                'default'   =>  default value 
     *                'payload'   =>  cached data
     *               ]            $cache_definitions               Array listing all cacheable data
     */
    protected $cache_definitions;
     /**
     *  All the settings sections for this plugin
     * 
     * @since   1.0.1
     * @access  protected
     * @var     string[ 'uid'=> Unique identifier, 'label' => Description ]            $settings_sections               Array listing all sections
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
                'label' => 'Welcome'
            ),
            array(
                'uid'   => \WP_RIODT_SETTING_PREFIX.'_section_general',
                'label' => 'General Settings'
            ),
            array(
                'uid'   => \WP_RIODT_SETTING_PREFIX.'_section_layout',
                'label' => 'Theme Layout'
            ),
            array(
                'uid'   => \WP_RIODT_SETTING_PREFIX.'_section_reddit_channel',
                'label' => 'Configure Reddit Channel'
            ),
            array(
                'uid'   => \WP_RIODT_SETTING_PREFIX.'_section_image_preferences',
                'label' => 'Image Preferences'
            ),
        );

        $this->cache_definitions = array (
            array(
                'uid'       =>  \WP_RIODT_SETTING_PREFIX.'_cache',
                'label'     =>  'Image Cache',
                'default'   =>  '',
                'payload'   =>  '',
            ),
        );

        
        $this->settings_definitions = array (            
            array(
                'uid'           => \WP_RIODT_SETTING_PREFIX.'_aspect_ratio',
                'label'         => 'Image aspect',
                'section'       => \WP_RIODT_SETTING_PREFIX.'_section_image_preferences',
                'type'          => 'select',
                'allowed'       => array('string' => array('landscape','portrait')),
                'options'       => array( 'landscape' => 'Landscape', 'portrait'=> 'Portrait'),
                'placeholder'   => '',
                'helper'        => '',
                'supplemental'  => 'Select the preferred aspect ratio when selecting the image', 
                'default'       => 'landscape',
                'force_reload'  => true,
            ),
            array(
                'uid'           => \WP_RIODT_SETTING_PREFIX.'_image_max_width',
                'label'         => 'Max image width', 
                'section'       => \WP_RIODT_SETTING_PREFIX.'_section_image_preferences',
                'type'          => 'text',
                'allowed'       => array('integer'),
                'options'       => '',
                'placeholder'   => '',
                'helper'        => '',
                'supplemental'  => 'Indicate the max width of the image',
                'default'       => '1920',
                'force_reload'  => true,
            ),       
            array(
                'uid'           => \WP_RIODT_SETTING_PREFIX.'_image_max_height',
                'label'         => 'Max image height',
                'section'       => \WP_RIODT_SETTING_PREFIX.'_section_image_preferences',
                'type'          => 'text',
                'allowed'       => array('integer'),
                'options'       => '',
                'placeholder'   => '',
                'helper'        => '',
                'supplemental'  => 'Indicate the max height of the image', 
                'default'       => '1080',
                'force_reload'  => true,                
            ),                     

            array(
                'uid'           => \WP_RIODT_SETTING_PREFIX.'_channel',
                'label'         => 'Reddit Channel', 
                'section'       => \WP_RIODT_SETTING_PREFIX.'_section_reddit_channel',
                'type'          => 'text',
                'allowed'       => array('string'),
                'options'       => false,
                'placeholder'   => '',
                'helper'        => '',
                'supplemental'  => 'Set a valid subreddit channel you want to download images from',
                'default'       => 'images',
                'force_reload'  => true,                
            ),
            array(
                'uid'           => \WP_RIODT_SETTING_PREFIX.'_download_limit',
                'label'         => 'Download limits',
                'section'       => \WP_RIODT_SETTING_PREFIX.'_section_reddit_channel',
                'type'          => 'text',
                'allowed'       => array('integer'),
                'options'       => false,
                'placeholder'   => '50',
                'helper'        => '',
                'supplemental'  => 'Set a download limit, lower numbers results in less images but faster processing', 
                'default'       => '50',
                'force_reload'  => false,
            ),
            array(
                'uid'           => \WP_RIODT_SETTING_PREFIX.'_nsfw_switch',
                'label'         => 'Allow NSFW content',
                'section'       => \WP_RIODT_SETTING_PREFIX.'_section_general',
                'type'          => 'bool',
                'allowed'       => array('boolean'),
                'options'       => false,
                'placeholder'   => '',
                'helper'        => '',
                'supplemental'  => 'Allow to download and show images marked as Not Safe For Work (i.e.: adult content)', 
                'default'       => 0,
                'force_reload'  => true,                
            ),
            array(
                'uid'           => \WP_RIODT_SETTING_PREFIX.'_zoom_switch',
                'label'         => 'Allow Zoom on mouse over',
                'section'       => \WP_RIODT_SETTING_PREFIX.'_section_layout',
                'type'          => 'bool',
                'allowed'       => array('boolean'),                
                'options'       => false,
                'placeholder'   => '',
                'helper'        => '',
                'supplemental'  => 'If enabled, when the mouse is over the image it will overlay a window with the image in a bigger resolution.', 
                'default'       => 1,
                'force_reload'  => false,
            ),            
            array(
                'uid'           => \WP_RIODT_SETTING_PREFIX.'_author_switch',
                'label'         => 'Display author\'s name',
                'section'       => \WP_RIODT_SETTING_PREFIX.'_section_layout',
                'type'          => 'bool',
                'allowed'       => array('boolean'),
                'options'       => false,
                'placeholder'   => '',
                'helper'        => '',
                'supplemental'  => 'Display the author\'s name in the caption', 
                'default'       => 1,
                'force_reload'  => false,
            ),
            array(
                'uid'           => \WP_RIODT_SETTING_PREFIX.'_channel_switch',
                'label'         => 'Display channel\'s name', 
                'section'       => \WP_RIODT_SETTING_PREFIX.'_section_layout',
                'type'          => 'bool',
                'allowed'       => array('boolean'),
                'options'       => false,
                'placeholder'   => '',
                'helper'        => '',
                'supplemental'  => 'Display the subreddit channel\'s name in the header title?', 
                'default'       => 1,
                'force_reload'  => false,
            ),            
            array(
                'uid'           => \WP_RIODT_SETTING_PREFIX.'_title_switch',
                'label'         => 'Display image\'s title', 
                'section'       => \WP_RIODT_SETTING_PREFIX.'_section_layout',
                'type'          => 'bool',
                'allowed'       => array('boolean'),
                'options'       => false,
                'placeholder'   => '',
                'helper'        => '',
                'supplemental'  => 'Display the image\'s title', 
                'default'       => 1,
                'force_reload'  => false,
            ),
            array(
                'uid'           => \WP_RIODT_SETTING_PREFIX.'_link_switch',
                'label'         => 'Add link to reddit post?', 
                'section'       => \WP_RIODT_SETTING_PREFIX.'_section_layout',
                'type'          => 'bool',
                'allowed'       => array('boolean'),
                'options'       => false,
                'placeholder'   => '',
                'helper'        => '',
                'supplemental'  => 'If enabled, the image will have a link to the related reddit post, this will open in a new tab', 
                'default'       => 1,
                'force_reload'  => false,
            ),            
            array(
                'uid'           => \WP_RIODT_SETTING_PREFIX.'_image_scraping',
                'label'         => 'Image scraping mode',
                'section'       => \WP_RIODT_SETTING_PREFIX.'_section_general',
                'type'          => 'select',
                'allowed'       => array('string' => array('daily_update','random_update','last_update')),
                'options'       => array('daily_update'=>'Same daily', 'random_update' => 'Random', 'last_update' => 'Last posted'),
                'placeholder'   => '',
                'helper'        => '',
                'supplemental'  => 'Indicate if you want to change image every load (random), or use the same daily, or always use the last uploaded (this may change throughout the day)', 
                'default'       => 'daily_update',
                'force_reload'  => true,
            ),    
            array(
                'uid'           => \WP_RIODT_SETTING_PREFIX.'_cache_lifetime',
                'label'         => 'Cache duration', 
                'section'       => \WP_RIODT_SETTING_PREFIX.'_section_general',
                'type'          => 'seconds',
                'allowed'       => array('integer'),
                'options'       => false,
                'placeholder'   => '',
                'helper'        => '',
                'supplemental'  => '',
                'default'       => DAY_IN_SECONDS,
                'force_reload'  => false,

            ),            
            array(
                'uid'           => \WP_RIODT_SETTING_PREFIX.'_css_switch',
                'label'         => 'Use plugin\'s css?',
                'section'       => \WP_RIODT_SETTING_PREFIX.'_section_layout',
                'type'          => 'bool',
                'allowed'       => array('boolean'),
                'options'       => false,
                'placeholder'   => '',
                'helper'        => '',
                'supplemental'  => 'If enabled the plugin will use its own CSS styling, otherwise you can override the css classes with your own styling', 
                'default'       => 1,
                'force_reload'  => false,
            ),                
            array(
                'uid'           => \WP_RIODT_SETTING_PREFIX.'_layout',
                'label'         => 'Layout mode', 
                'section'       => \WP_RIODT_SETTING_PREFIX.'_section_layout',
                'type'          => 'select',
                'allowed'       => array('string' => array('minimal','full','reddit')),
                'options'       => array('minimal'=> 'Minimalistic', 'full' => 'Full', 'reddit'=>'Reddit' ),
                'placeholder'   => '',
                'helper'        => '',
                'supplemental'  => 'Select which layout you prefer. Minimalistic will only show the image, full will show all the available information using an internal styling, Reddit will use a layout compliant with Reddit branding policies', 
                'default'       => 'reddit',
                'force_reload'  => false,
            ),                      
            array(
                'uid'           => \WP_RIODT_SETTING_PREFIX.'_custom_css',
                'label'         => 'Custom CSS', 
                'section'       => \WP_RIODT_SETTING_PREFIX.'_section_layout',
                'type'          => 'textarea',
                'allowed'       => array('css'),
                'options'       => false,
                'placeholder'   => '',
                'helper'        => '',
                'supplemental'  => 'The CSS codes indicated in this box will override the plugin\'s own CSS styling', 
                'default'       => '',
                'force_reload'  => false,
            ),         
            array(
                'uid'           => \WP_RIODT_SETTING_PREFIX.'_activation_date',
                'label'         => 'Plugin Activation Date', 
                'section'       => \WP_RIODT_SETTING_PREFIX.'_section_private',
                'type'          => 'private',
                'allowed'       => array('date'),
                'options'       => false,
                'placeholder'   => '',
                'helper'        => '',
                'supplemental'  => '',
                'default'       => time(),
                'force_reload'  => false,
            ),       
            array(
                'uid'           => \WP_RIODT_SETTING_PREFIX.'_last_scraping_execution_time',
                'label'         => 'Last scraping execution time', 
                'section'       => \WP_RIODT_SETTING_PREFIX.'_section_private',
                'type'          => 'private',
                'allowed'       => array('integer'),
                'options'       => false,
                'placeholder'   => '',
                'helper'        => '',
                'supplemental'  => '',
                'default'       => 0,
                'force_reload'  => false,
            ),    
            array(
                'uid'           => \WP_RIODT_SETTING_PREFIX.'_last_image_scraped_on',
                'label'         => 'Last image was scraped on', 
                'section'       => \WP_RIODT_SETTING_PREFIX.'_section_private',
                'type'          => 'private',
                'allowed'       => array('date'),
                'options'       => false,
                'placeholder'   => '',
                'helper'        => '',
                'supplemental'  => '',
                'default'       => 0,
                'force_reload'  => false,
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
     * Return the requested element from the setting definitions array if it exists
     * @since   1.0.1
     * @param   string          $uid        Unique Idenfier of the setting definition to retrieve
     * @return  array           ['uid'             => Unique identifier, 
     *                'label'           => description, 
     *                'section'         => parent section, 
     *                'type'            => type of setting (bool, text, password, number, textarea, select, multiselect),
     *                'options'         => if type is select or multiselect, this contains the option to display in a key=>value pair
     *                'placeholder'     => placeholder value for the field
     *                'helper'          => helper text displayed to the right of the field
     *                'supplemental'    => helper text displayed below the field
     *                'default'         => default value  ]            $setting_definition               Array listing all parameters of the requested setting definition
     * @return  null            if no definition was found
     */
    public function get_setting_definition($uid) {
        if ( defined( 'WP_RIODT_SETTING_PREFIX' ) ) {
            // add SETTING_PREFIX to the key if not in it already
            if ( !stristr( $uid, \WP_RIODT_SETTING_PREFIX ) ) {
                $uid = \WP_RIODT_SETTING_PREFIX.'_'.$uid;
            }            
        }        
        foreach($this->settings_definitions as $field) { 
            if ( $uid != null && $uid != "" && $field['uid'] == $uid ) {
                return $field;
            } 
        }
        return null;
    }    
    /**
     * Return the settings sections array
     * @since   1.0.1
     * @return  string[]         $settings_sections              Array listing all sections  
     */
    public function get_settings_sections() {
        return $this->settings_sections;
    }
    /**
     * Return the cache definitions array
     * @since   1.0.1
     * @return  string[]['uid'       =>  Unique identifier
     *                'label'     =>  description
     *                'default'   =>  default value 
     *                'payload'   =>  cached data
     *                ]         $cache_definitions               Array containing all definitions for the cache elements
     */
    public function get_cache_definitions() {
        return $this->cache_definitions;
    }
    /**
     * Return the requested element from the cache definitions array if it exists
     * @since   1.0.1
     * @param   string          $uid        Unique Idenfier of the cache definition to retrieve
     * @return  string[]['uid'       =>  Unique identifier
     *                'label'     =>  description
     *                'default'   =>  default value 
     *                'payload'   =>  cached data
     *                ]         $cache_definition               Array detailing the cache definition
     * @return  null            if no definition was found
     */
    public function get_cache_definition($uid) {
        if ( defined( 'WP_RIODT_SETTING_PREFIX' ) ) {
            // add SETTING_PREFIX to the key if not in it already
            if ( !stristr( $uid, \WP_RIODT_SETTING_PREFIX ) ) {
                $uid = \WP_RIODT_SETTING_PREFIX.'_'.$uid;
            }            
        }
        foreach($this->cache_definitions as $field) { 
            if ( $uid != null && $uid != "" && $field['uid'] == $uid ) {
                return $field;
            } 
        }
        return null;
    }

 }