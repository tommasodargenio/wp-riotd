<?php
/**
 *  CLASS-WP-RIOTD-ADMIN-SETTINGS-DEFINITIONS
 *  
 *  Contains all definitions for the settings
 * 
 * @link       https://github.com/tommasodargenio/wp-riodt/admin/class-wp-riotd-admin-settings-definitions.php
 * @since      1.0.1
 * 
 * @package    RIOTD
 * @subpackage RIOTD/admin
 * @author     Tommaso D'Argenio <dev@tommasodargenio.com>
 */
 // Prohibit direct script loading.
 defined( 'ABSPATH' ) || die( esc_html__('No direct script access allowed!' ));

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
                'label' => esc_html__('Welcome','wp-riotd')
            ),
            array(
                'uid'   => \WP_RIODT_SETTING_PREFIX.'_section_general',
                'label' => esc_html__('General Settings', 'wp-riotd' )
            ),
            array(
                'uid'   => \WP_RIODT_SETTING_PREFIX.'_section_layout',
                'label' => esc_html__('Theme Layout', 'wp-riotd')
            ),
            array(
                'uid'   => \WP_RIODT_SETTING_PREFIX.'_section_reddit_channel',
                'label' => esc_html__('Configure Reddit Channel', 'wp-riotd' )
            ),
            array(
                'uid'   => \WP_RIODT_SETTING_PREFIX.'_section_image_preferences',
                'label' => esc_html__('Image Preferences', 'wp-riotd') 
            ),
        );

        $this->cache_definitions = array (
            array(
                'uid'       =>  \WP_RIODT_SETTING_PREFIX.'_cache',
                'label'     =>  esc_html__( 'Image Cache', 'wp-riotd' ),
                'default'   =>  '',
                'payload'   =>  '',
            ),
        );

        
        $this->settings_definitions = array (            
            array(
                'uid'           => \WP_RIODT_SETTING_PREFIX.'_aspect_ratio',
                'label'         => esc_html__( 'Image aspect', 'wp-riotd' ),
                'section'       => \WP_RIODT_SETTING_PREFIX.'_section_image_preferences',
                'type'          => 'select',
                'allowed'       => array('string' => array('landscape','portrait')),
                'options'       => array( 'landscape' => esc_html__('Landscape', 'wp-riotd'), 'portrait'=> esc_html__('Portrait', 'wp-riotd') ),
                'placeholder'   => '',
                'helper'        => '',
                'supplemental'  => esc_html__('Select the preferred aspect ratio when selecting the image', 'wp-riotd'),
                'default'       => 'landscape',
                'force_reload'  => true,
            ),
            array(
                'uid'           => \WP_RIODT_SETTING_PREFIX.'_image_max_width',
                'label'         => esc_html__( 'Max image width', 'wp-riotd' ),
                'section'       => \WP_RIODT_SETTING_PREFIX.'_section_image_preferences',
                'type'          => 'text',
                'allowed'       => array('integer'),
                'options'       => '',
                'placeholder'   => '',
                'helper'        => '',
                'supplemental'  => esc_html__('Indicate the max width of the image', 'wp-riotd'),
                'default'       => '1920',
                'force_reload'  => true,
            ),       
            array(
                'uid'           => \WP_RIODT_SETTING_PREFIX.'_image_max_height',
                'label'         => esc_html__( 'Max image height', 'wp-riotd' ),
                'section'       => \WP_RIODT_SETTING_PREFIX.'_section_image_preferences',
                'type'          => 'text',
                'allowed'       => array('integer'),
                'options'       => '',
                'placeholder'   => '',
                'helper'        => '',
                'supplemental'  => esc_html__('Indicate the max height of the image', 'wp-riotd'),
                'default'       => '1080',
                'force_reload'  => true,                
            ),                     

            array(
                'uid'           => \WP_RIODT_SETTING_PREFIX.'_channel',
                'label'         => esc_html__( 'Reddit Channel', 'wp-riotd' ),
                'section'       => \WP_RIODT_SETTING_PREFIX.'_section_reddit_channel',
                'type'          => 'text',
                'allowed'       => array('string'),
                'options'       => false,
                'placeholder'   => '',
                'helper'        => '',
                'supplemental'  => esc_html__('Set a valid subreddit channel you want to download images from', 'wp-riotd'),
                'default'       => 'images',
                'force_reload'  => true,                
            ),
            array(
                'uid'           => \WP_RIODT_SETTING_PREFIX.'_download_limit',
                'label'         => esc_html__( 'Download limits', 'wp-riotd' ),
                'section'       => \WP_RIODT_SETTING_PREFIX.'_section_reddit_channel',
                'type'          => 'text',
                'allowed'       => array('integer'),
                'options'       => false,
                'placeholder'   => '50',
                'helper'        => '',
                'supplemental'  => esc_html__('Set a download limit, lower numbers results in less images but faster processing', 'wp-riotd'),
                'default'       => '50',
                'force_reload'  => false,
            ),
            array(
                'uid'           => \WP_RIODT_SETTING_PREFIX.'_nsfw_switch',
                'label'         => esc_html__( 'Allow NSFW content', 'wp-riotd' ),
                'section'       => \WP_RIODT_SETTING_PREFIX.'_section_general',
                'type'          => 'bool',
                'allowed'       => array('boolean'),
                'options'       => false,
                'placeholder'   => '',
                'helper'        => '',
                'supplemental'  => esc_html__('Allow to download and show images marked as Not Safe For Work (i.e.: adult content)', 'wp-riotd'),
                'default'       => 0,
                'force_reload'  => true,                
            ),
            array(
                'uid'           => \WP_RIODT_SETTING_PREFIX.'_zoom_switch',
                'label'         => esc_html__( 'Allow Zoom on mouse over', 'wp-riotd' ),
                'section'       => \WP_RIODT_SETTING_PREFIX.'_section_layout',
                'type'          => 'bool',
                'allowed'       => array('boolean'),                
                'options'       => false,
                'placeholder'   => '',
                'helper'        => '',
                'supplemental'  => esc_html__('If enabled, when the mouse is over the image it will overlay a window with the image in a bigger resolution.', 'wp-riotd'),
                'default'       => 1,
                'force_reload'  => false,
            ),            
            array(
                'uid'           => \WP_RIODT_SETTING_PREFIX.'_author_switch',
                'label'         => esc_html__( 'Display author\'s name', 'wp-riotd' ),
                'section'       => \WP_RIODT_SETTING_PREFIX.'_section_layout',
                'type'          => 'bool',
                'allowed'       => array('boolean'),
                'options'       => false,
                'placeholder'   => '',
                'helper'        => '',
                'supplemental'  => esc_html__('Display the author\'s name in the caption', 'wp-riotd'),
                'default'       => 1,
                'force_reload'  => false,
            ),
            array(
                'uid'           => \WP_RIODT_SETTING_PREFIX.'_channel_switch',
                'label'         => esc_html__( 'Display channel\'s name', 'wp-riotd' ),
                'section'       => \WP_RIODT_SETTING_PREFIX.'_section_layout',
                'type'          => 'bool',
                'allowed'       => array('boolean'),
                'options'       => false,
                'placeholder'   => '',
                'helper'        => '',
                'supplemental'  => esc_html__('Display the subreddit channel\'s name in the header title?', 'wp-riotd'),
                'default'       => 1,
                'force_reload'  => false,
            ),            
            array(
                'uid'           => \WP_RIODT_SETTING_PREFIX.'_title_switch',
                'label'         => esc_html__( 'Display image\'s title', 'wp-riotd' ),
                'section'       => \WP_RIODT_SETTING_PREFIX.'_section_layout',
                'type'          => 'bool',
                'allowed'       => array('boolean'),
                'options'       => false,
                'placeholder'   => '',
                'helper'        => '',
                'supplemental'  => esc_html__('Display the image\'s title', 'wp-riotd'),
                'default'       => 1,
                'force_reload'  => false,
            ),
            array(
                'uid'           => \WP_RIODT_SETTING_PREFIX.'_link_switch',
                'label'         => esc_html__( 'Add link to reddit post?', 'wp-riotd' ),
                'section'       => \WP_RIODT_SETTING_PREFIX.'_section_layout',
                'type'          => 'bool',
                'allowed'       => array('boolean'),
                'options'       => false,
                'placeholder'   => '',
                'helper'        => '',
                'supplemental'  => esc_html__('If enabled, the image will have a link to the related reddit post, this will open in a new tab', 'wp-riotd'),
                'default'       => 1,
                'force_reload'  => false,
            ),            
            array(
                'uid'           => \WP_RIODT_SETTING_PREFIX.'_image_scraping',
                'label'         => esc_html__( 'Image scraping mode', 'wp-riotd' ),
                'section'       => \WP_RIODT_SETTING_PREFIX.'_section_general',
                'type'          => 'select',
                'allowed'       => array('string' => array('daily_update','random_update','last_update')),
                'options'       => array('daily_update'=>esc_html__('Same daily', 'wp-riotd'), 'random_update' => esc_html__('Random','wp-riotd'), 'last_update' => esc_html__('Last posted','wp-riotd') ),
                'placeholder'   => '',
                'helper'        => '',
                'supplemental'  => esc_html__('Indicate if you want to change image every load (random), or use the same daily, or always use the last uploaded (this may change throughout the day)', 'wp-riotd'),
                'default'       => 'daily_update',
                'force_reload'  => true,
            ),    
            array(
                'uid'           => \WP_RIODT_SETTING_PREFIX.'_cache_lifetime',
                'label'         => esc_html__( 'Cache duration', 'wp-riotd' ),
                'section'       => \WP_RIODT_SETTING_PREFIX.'_section_general',
                'type'          => 'seconds',
                'allowed'       => array('integer'),
                'options'       => false,
                'placeholder'   => '',
                'helper'        => '',
                'supplemental'  => esc_html__( '', 'wp-riotd' ),
                'default'       => DAY_IN_SECONDS,
                'force_reload'  => false,

            ),            
            array(
                'uid'           => \WP_RIODT_SETTING_PREFIX.'_css_switch',
                'label'         => esc_html__( 'Use plugin\'s css?', 'wp-riotd' ),
                'section'       => \WP_RIODT_SETTING_PREFIX.'_section_layout',
                'type'          => 'bool',
                'allowed'       => array('boolean'),
                'options'       => false,
                'placeholder'   => '',
                'helper'        => '',
                'supplemental'  => esc_html__('If enabled the plugin will use its own CSS styling, otherwise you can override the css classes with your own styling', 'wp-riotd'),
                'default'       => 1,
                'force_reload'  => false,
            ),                
            array(
                'uid'           => \WP_RIODT_SETTING_PREFIX.'_layout',
                'label'         => esc_html__( 'Layout mode', 'wp-riotd' ),
                'section'       => \WP_RIODT_SETTING_PREFIX.'_section_layout',
                'type'          => 'select',
                'allowed'       => array('string' => array('minimal','full','reddit')),
                'options'       => array('minimal'=>esc_html__('Minimalistic', 'wp-riotd'), 'full' => esc_html__('Full','wp-riotd'), 'reddit'=>esc_html__('Reddit Branding','wp-riotd') ),
                'placeholder'   => '',
                'helper'        => '',
                'supplemental'  => esc_html__('Select which layout you prefer. Minimialistic will only show the image, full will show all the available information, Reddit Branding will use a layout compliant with Reddit branding policies', 'wp-riotd'),
                'default'       => 'reddit',
                'force_reload'  => false,
            ),                      
            array(
                'uid'           => \WP_RIODT_SETTING_PREFIX.'_custom_css',
                'label'         => esc_html__( 'Custom CSS', 'wp-riotd' ),
                'section'       => \WP_RIODT_SETTING_PREFIX.'_section_layout',
                'type'          => 'textarea',
                'allowed'       => array('css'),
                'options'       => false,
                'placeholder'   => '',
                'helper'        => '',
                'supplemental'  => esc_html__('The CSS codes indicated in this box will override the plugin\'s own CSS styling', 'wp-riotd'),
                'default'       => '',
                'force_reload'  => false,
            ),         
            array(
                'uid'           => \WP_RIODT_SETTING_PREFIX.'_activation_date',
                'label'         => esc_html__( 'Plugin Activation Date', 'wp-riotd' ),
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