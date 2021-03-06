<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/tommasodargenio/wp-riotd/admin/class-wp-riotd-admin.php
 * @since      1.0.0
 * 
 * @package    RIOTD
 * @subpackage RIOTD/admin
 * @author     Tommaso D'Argenio <dev@tommasodargenio.com>
 *  
 */
// Prohibit direct script loading.
defined( 'ABSPATH' ) || die( esc_html__('No direct script access allowed!', 'wp-riotd' ));

class WP_RIOTD_Admin {
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The plugin shortname
	 * @since	1.0.0
	 * @access	private
	 * @var		string		$plugin_shortname  The plugin shortname 
	 */
    private $plugin_shortname;
    /**
     *  All the configuration user's settings for this plugin loaded from the database
     * 
     * @since   1.0.0
     * @access  protected
     * @var     string[]            $settings               Associative array listing all settings (setting->value)
     */
    protected $settings;

     /**
     *  All the configuration settings definitions for this plugin
     * 
     * @since   1.0.0
     * @access  protected
     * @var     WP_RIOTD_ADMIN_SETTINGS_DEFINITIONS     $settings_definitions               Associative array listing all settings (setting->value)
     */
	protected $settings_definitions;

	/**
	 * Define the default tab to show when opening the setting page
	 * @since	1.0.0
	 * @access	protected
	 * @var		string				$default_setting_tab				The default section associated with the tab to show, must be an existing section as defined in $settings_definitions
	 */
	protected $default_setting_tab;
	/**
	 * Define the menu slug to use in the admin page setup
	 * @since	1.0.0
	 * @access	protected
	 * @var		string				$menu_slug							The slug to identify the admin page
	 */
	protected $menu_slug;

	/**
	 * Base64 encoding of the plugin Icon SVG
	 * @since	1.0.0
	 * @access	protected
	 * @var		string				$plugin_icon						Base64 encoding of the plugin SVG ICON stored in images, the filename must be icon.svg
	 */
	protected $plugin_icon;
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $settings ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->settings = $settings;

		if ( defined( '\WP_RIOTD_SHORT_NAME' ) ) {
            $this->plugin_shortname = \WP_RIOTD_SHORT_NAME;
        } else {
            $this->plugin_shortname = 'RIOTD';
        }

		$this->menu_slug = strtolower($this->plugin_name);

		if ( class_exists('WP_RIOTD_ADMIN_SETTINGS_DEFINITIONS', false) ) {
			$this->settings_definitions = new WP_RIOTD_ADMIN_SETTINGS_DEFINITIONS();			
		}

		if ( file_exists( plugin_dir_path(__FILE__) . 'images/icon.svg' ) ) {
			$this->plugin_icon = 'data:image/svg+xml;base64,'.base64_encode(file_get_contents( plugin_dir_path(__FILE__) . 'images/icon.svg' ));
		} else {
			$this->plugin_icon = '';
		}

		$this->default_setting_tab = 'wp_riotd_section_welcome';		
	}	
    /**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name.'_admin_css', plugin_dir_url( __FILE__ ) . 'css/wp-riotd-admin.css', array(), $this->version, 'all' );
		// also enqueue the frontend css as this is used in the preview
		wp_enqueue_style( $this->plugin_name.'_public_css', plugin_dir_url( __DIR__ ) . 'public/css/wp-riotd-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name.'_admin_js', plugin_dir_url( __FILE__ ) . 'js/wp-riotd-admin.js', array( 'wp-i18n', 'jquery' ), $this->version, false );
		// also enqueue the frontend script as this is used in the preview
		wp_enqueue_script( $this->plugin_name.'_public_js', plugin_dir_url( __DIR__ ) . 'public/js/wp-riotd-public.js', array( 'wp-i18n','jquery' ), $this->version, false );
		// create the nonce
		wp_localize_script($this->plugin_name.'_admin_js', 'wp_riotd_data', array(
				'nonce' => wp_create_nonce('nonce')
		));

		// hook the js with the translation system
		wp_set_script_translations($this->plugin_name.'_admin_js', 'wp-riotd', plugin_dir_path(dirname(__FILE__)).'languages/');


		// code mirror requirements
		$cm_settings['codeEditor'] = wp_enqueue_code_editor( array( 'type'=>'text/css' ) );
		wp_localize_script('jquery', 'cm_settings', $cm_settings);
		wp_enqueue_script('wp-theme-plugin-editor');
		wp_enqueue_style('wp-codemirror');
	}
	
	/**
	 * Add a link in the WP admin menu to open the settings page for the plugin
	 * 
	 * @since	1.0.0
	 */
	public function create_admin_menu() {
	
		add_menu_page(
			$this->plugin_shortname.' - '.esc_html__('Reddit Image of The Day', 'wp-riotd'),
			__('RIOTD', 'wp-riotd'),
			'manage_options',
			$this->menu_slug,
			array($this, 'load_admin_page'),
			$this->plugin_icon
		);
		add_submenu_page(
			$this->menu_slug,
			$this->plugin_shortname.' - '.esc_html__('Settings', 'wp-riotd'),
			__('Settings', 'wp-riotd'),
			'manage_options',
			$this->menu_slug,
			array($this, 'load_admin_page')
		);
		add_submenu_page(
			$this->menu_slug,
			$this->plugin_shortname.' - '.esc_html__('Usage instructions', 'wp-riotd'),
			__('How To Use', 'wp-riotd'),
			'manage_options',
			$this->menu_slug.'-usage',
			array($this, 'load_usage_page')
		);
		add_submenu_page(
			$this->menu_slug,
			$this->plugin_shortname.' - '.esc_html__('About Us', 'wp-riotd'),
			__('About Us', 'wp-riotd'),
			'manage_options',
			$this->menu_slug.'-aboutus',
			array($this, 'load_aboutus_page')
		);

	}
	/**
	 * Create a link to access a specific tab within the admin section, if the requested tab exists in the defined sections
	 * @since	1.0.0
	 * @param	string		$tab_include	the tab to search for (this can be the full tab name or a portion of it)
	 * @param	bool		$echo			if true it will echo the url otherwise not
	 * @return	string		$tab_url		the admin url 
	 */
	public function get_tab_url($tab_include, $echo = false) {
		$tab_name = "";
		$tab_url = "";		

		foreach($this->settings_definitions->get_settings_sections() as $section) {
			if ( stristr( $section['uid'],$tab_include ) ) {
				$tab_name = $section['uid'];
				break;
			}
		}	
		
		if ( $tab_name != "" ) {
			$tab_url = menu_page_url($this->menu_slug , false)."&tab=".$tab_name;
		}		

		if ($echo) {
			echo esc_url($tab_url);
		}

		return esc_url($tab_url);
	}

	/**
	 * Used by create_admin_menu as callback to laod the view template
	 * 
	 * @since	1.0.0
	 * @access	private
	 */
	public function load_admin_page() {		
		// check user capabilities
		if ( !current_user_can( 'manage_options' )) {
			return;
		}

		include_once plugin_dir_path( __FILE__ )."partials/wp-riotd-admin-menu.php";
	}

	/**
	 * Check if nonce is valid
	 * @since	1.0.0
	 * @return	int		HTTP response code 401 if nonce check fails
	 */
	public function check_nonce() {				
		$wp_riotd_nonce = filter_input(INPUT_POST, 'wp_riotd_nonce', FILTER_CALLBACK, ['options'=>'esc_attr']);
		if ( !$wp_riotd_nonce  || !wp_verify_nonce( $wp_riotd_nonce, 'nonce' ) ) {
			wp_send_json(['payload' => null], 401 );			
		}
	}
	/**
	 * Initialize all the configuration parameters and register them in the db
	 * @since	1.0.0 
	 */
	public function register_admin_settings() {

		// register a new section in the group
		foreach($this->settings_definitions->get_settings_sections() as $section) {
			add_settings_section( $section['uid'], esc_html__($section['label'],'wp-riotd'), array($this, 'section_renderer' ), $section['uid'] );			
		}
		
		// register fields
		foreach($this->settings_definitions->get_settings_definitions() as $field) {			
			if ($field['type'] != 'private') {
				//echo '<pre> setting field'.$field['uid']; print_r(__($field['label'],'wp-riotd')); echo '</pre>';
				add_settings_field($field['uid'], esc_html__($field['label'],'wp-riotd'), array($this, 'fields_renderer'), $field['section'], $field['section'], $field );
				// use a different callback if the field is of type seconds, as this would require some data post-processing
				if ( $field['type'] == 'seconds' ) {
					register_setting($field['section'], $field['uid'], array( 'sanitize_callback' => array($this, 'sanitize_time_field') ) );				
				} else {
					register_setting($field['section'], $field['uid'], array( 'sanitize_callback' => array($this, 'sanitize_me') ) );			
				}			
			}
		}
	}
	/**
	 *  Method to show the cache content stored in the database to the admin web page
	 * @since	1.0.0
	 * @return	string		$payload	The cache content if any and HTTP response code 200 or response code 400/401 if error
	 */
	public function riotd_view_cache() {
		$this->check_nonce();

		if ( class_exists( 'WP_RIOTD_Cache', false ) ) {

			$cache = WP_RIOTD_Cache::get_cache('cache');
				
			if ( false === $cache ) {			
				wp_send_json( ['cache'=>esc_html__( 'The cache is empty', 'wp-riotd' )], 204 );				
			} else {
				wp_send_json( ['cache' => $cache], 200 );				
			}
		}
		wp_die('', '400');
	}
	/**
	 * Method to return the cache expiration time if requested by admin page JS on WP heartbeat tick usually
	 * @since	1.0.0
	 * @return	array[]		['payload' => the timer, 'response_code' => 200 if data is found otherwise 400/401]	 
	 */
	public function riotd_get_cache_expiration() {
		$this->check_nonce();
		if( class_exists('WP_RIOTD_Cache', false) ) {
			$expires_in = WP_RIOTD_Cache::get_cache_expiration( 'cache' );			
			wp_send_json(['payload' => $expires_in], 200 );			
		}
		wp_die('','400');
	}
	/**
	 *  Method used in cron jobs to force a cache update, this method will re-download the image from reddit and save to cache
	 *  It is triggered if the a field with a force_reload attribute set to true is being saved
	 *  @since	1.0.0 	
	 */
	public function force_cache_update() {
		if( class_exists( 'WP_RIOTD_Public', false ) ) {
			if ( class_exists( 'WP_RIOTD_Cache', false ) ) {
				WP_RIOTD_Cache::purge_cache( 'cache' );
				$public = new WP_RIOTD_Public( $this->plugin_name, $this->version );				
			}// remove cache
		}		
	}
	/**
	 * Method to render the frontend in order to display the preview in the admin pages
	 * @since	1.0.0
	 * @return	array[]		['payload' => the rendered html page, 'response_code' => HTTP response code 200 or response code 400/401 if error, 'cache_time' => the refreshed cache timer]
	 */
	public function riotd_public_preview() {
		$this->check_nonce();

		if( class_exists( 'WP_RIOTD_Public', false ) ) {
			$public = new WP_RIOTD_Public( $this->plugin_name, $this->version );
			$css = $public->render_custom_css(true);
			if (is_wp_error($css)) {
				wp_send_json(['payload'=>'', 'error'=>$css->get_error_message()], 500);
			}			
			$payload = $css.$public->render_view(true);
			$expires_in = 0;
			// this will force the cache to be created if it's not there yet. We should send the new cache expiration timer
			if( class_exists('WP_RIOTD_Cache', false) ) {
				$expires_in = WP_RIOTD_Cache::get_cache_expiration( 'cache' );		
			}

			wp_send_json( ['payload'=> $payload, 'cache_time' => $expires_in], 200) ;
			
		}

		wp_die('', '400');
	}
	/**
	 * Method to purge the cache via the button on the admin page
	 * @since	1.0.0
	 * @return	int		$result		Follow HTTP REST code standards. 200 operation successfull, 401 unathorized - security check failed, 400 general failure* 
	 */
	public function riotd_purge_cache() {
		$this->check_nonce();
		if( class_exists('WP_RIOTD_Cache', false) ) {
			if (WP_RIOTD_Cache::purge_cache('cache')) {
				wp_send_json( ['expires_in' => WP_RIOTD_Cache::get_cache_expiration('cache')], 200 );				
			} else {
				wp_send_json( ['expires_in' => null], 400 );				
			}
		}

		wp_send_json( ['expires_in' => null], 400 );		
	}
	/**
	 * Method to reset all settings via the button on the admin page
	 * @since	1.0.0
	 * @return	int		$result		Follow HTTP REST code standards. 200 operation successfull, 401 unathorized - security check failed, 400 general failure
	 */
	public function riotd_reset_settings() {
		$this->check_nonce();
		if ( class_exists('WP_RIOTD_Settings', false) ) {
			if ( true === WP_RIOTD_Settings::set_defaults() ) {
				$all_settings = WP_RIOTD_Settings::get_all();
				if ( is_array( $all_settings ) || ( sizeof( $all_settings ) > 0 ) ) {
					wp_send_json(['payload' => $all_settings], 200 );
				} else {
					wp_send_json(['payload' => null], 200 );
				}		
			}
		}
		wp_send_json(['payload' => null], 400 );		
	}
	/**
	 * Sanitisation callback to validate and sanitize data before saving to DB
	 * @since	1.0.0	
	 * @param	string	$value		value being submitted from the form
	 * @return	string	$value		sanitized value	 
	 */
	public function sanitize_me( $value ) {
		// retrieve the setting definition based on the filter
		$def = null;
		if (stristr(current_filter(),'sanitize_option_')) {
			$uid = substr(current_filter(), strlen('sanitize_option_'));				
			$def = $this->settings_definitions->get_setting_definition($uid);		
		}

		// the definition has not been found, return the value sanitized anyway
		if ( null === $def ) {
			return sanitize_text_field( $value );
		}

		// check if admin has chosen to reset everything
		$post_reset = filter_input(INPUT_POST, 'reset', FILTER_CALLBACK, ['options'=>'esc_attr']);
		if ( $post_reset ) {
				$value = $def['default'];								 	
		}
		
		// data validation
		if ( is_array($def['allowed']) ) {
			$type = current($def['allowed']);
			$allowed_values = '';
			if ( is_array( current( $def['allowed'] ) ) ) {
				$type = array_key_first( $def['allowed'] );
				$allowed_values = current( $def['allowed'] );
			}
		
			
			switch($type) {
				case 'boolean':	
					// when using checkboxes input, if this is unchecked it won't be sent therefore it will be a null value
					if ( null === $value ) {
						$value = '0';						
					} else {				
						if ( true !== $value && false !== $value && 1 !== $value && 0 !== $value && '1' !== $value && '0' !== $value) {
							$value = WP_RIOTD_Settings::get( $def['uid'] );	
						}
					}
					break;
				case 'integer':
					if (! is_numeric($value) ) {
						$value = WP_RIOTD_Settings::get( $def['uid'] );
						break;
					}
					if ( is_array($allowed_values) && sizeof($allowed_values) == 2 ) {
							if ( $value <= $allowed_values[0] || $value >= $allowed_values[1] ) {
								$value = WP_RIOTD_Settings::get( $def['uid'] );
								/* translators: 1: minimum numeric value 2: maximum numeric value */
								$error_msg = $def['label'].' '.sprintf(esc_html__('must be between %1$s and %2$s', 'wp-riotd'),$allowed_values[0],$allowed_values[1]);

								add_settings_error( $uid, 'wp_riotd_error', $error_msg, 'error' );
							}
					}
					break;
				case 'string':
					if ( is_array($allowed_values) && sizeof($allowed_values) > 0 ) {
						if ( !in_array( $value, $allowed_values ) ) {
							$value = WP_RIOTD_Settings::get( $def['uid'] );
						}
					}
					break;
				case 'css':
					// special case to minify css
					$value = WP_RIOTD_Utility::minify_css($value);
				default:						
					$value = sanitize_text_field( $value );
			}

		}

		// check if the field being saved require to reload the image from reddit
		if ( true === $def['force_reload'] ) {
			// schedule the actvity via WP-Cron, the task will run on the next page load or heartbeat-tick, this is a one-off task
			if ( !wp_next_scheduled( \WP_RIODT_SETTING_PREFIX.'_force_cache_update' ) ) {
				wp_schedule_single_event(time(), \WP_RIODT_SETTING_PREFIX.'_force_cache_update');
			}
		}

		return $value;
	}

	/**
	 * Callback used to transform a time value from hours/minutes/days in seconds before being stored in the database
	 * @since	1.0.0
	 * @param	string		$value The value submitted through the option form
	 * @return	int			$value The value converted in seconds (integer)	if time_unit was sent otherwise return the same value unchanged.
	 */
	public function sanitize_time_field( $value ) {
		$time_unit = filter_input(INPUT_POST, 'time_unit', FILTER_CALLBACK, ['options'=>'esc_attr']);
		if ( $time_unit ) {
			switch( $time_unit ) {
				case 'minutes':
					$value *= MINUTE_IN_SECONDS;					
					break;
				case 'hours':
					$value *= HOUR_IN_SECONDS;
					break;
				case 'days':
					$value *= DAY_IN_SECONDS;
					break;
			}
		}

		return $value;
	}
	/**
	 * Callback used to display configuration section information
	 * @since	1.0.0
	 * @access	private
	 */
	public function section_renderer( $args ) {
		include_once plugin_dir_path( __FILE__ )."partials/settings/wp-riotd-admin-settings-section.php";	
	}

	/**
	 * Callback used to render the channel input field
	 * @since	1.0.0
	 * @access	private
	 */
	public function fields_renderer( $args ) {
		$value = get_option( $args['uid'] ); // Get the current value, if there is one
		 if( $value === null ) { // If no value exists
		 	$value = $args['default']; // Set to our default
		 }
		 if ($value === false && $args['type'] != 'bool') {
			 $value = $args['default'];
		 }
		 if ( $value === "" ) {
			 $value = $args['default'];
		 }
		 
		// Check which type of field we want
		switch( $args['type'] ){
			case 'seconds':
				$options_markup = '<option value="minutes" %minutes%>'.esc_html__('Minutes', 'wp-riotd' ).'</option>
								   <option value="hours" %hours%>'.esc_html__('Hours', 'wp-riotd' ).'</option>
								   <option value="days" %days%>'.esc_html__('Days', 'wp-riotd' ).'</option>';
				
				if ( $value >= DAY_IN_SECONDS ) {
					$value = floor( $value / DAY_IN_SECONDS );		
					$options_markup = str_replace("%minutes%","", $options_markup);			
					$options_markup = str_replace("%hours%","", $options_markup);			
					$options_markup = str_replace("%days%","selected", $options_markup);			
				} elseif ( $value >= HOUR_IN_SECONDS ) {
					$value = floor( $value / HOUR_IN_SECONDS );
					$options_markup = str_replace("%minutes%","", $options_markup);			
					$options_markup = str_replace("%hours%","selected", $options_markup);			
					$options_markup = str_replace("%days%","", $options_markup);			
				} elseif ( $value >= MINUTE_IN_SECONDS ) {					
					$value = floor( $value / MINUTE_IN_SECONDS );
					$options_markup = str_replace("%minutes%","selected", $options_markup);			
					$options_markup = str_replace("%hours%","", $options_markup);			
					$options_markup = str_replace("%days%","", $options_markup);			
				}				
				printf('<input name="%1$s" id="%1$s" placeholder="%2$s" value="%3$s" />', $args['uid'], $args['placeholder'], esc_attr($value));
				printf('<select name="time_unit" id="time_unit">%1$s</select>',$options_markup);
				break;
			case 'text': // If it is a text field
			case 'password':
			case 'number':
				printf( '<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />', $args['uid'], $args['type'], $args['placeholder'], esc_attr($value) );
				break;
			case 'textarea':
				printf( '<textarea name="%1$s" id="%1$s" placeholder="%2$s" rows="5" cols="50">%3$s</textarea>', $args['uid'], $args['placeholder'], esc_attr($value) );
			case 'select':
			case 'multiselect':
				if ( !empty( $args['options'] ) && is_array( $args['options']) ) {
					$attributes = '';
					$options_markup = '';							
					foreach( $args['options'] as $key => $label ) {
						$options_markup .= sprintf( '<option value="%1$s" %2$s>%3$s</option>', $key, selected( $value, $key, false ), esc_html__($label,'wp-riotd') );
					}
					if ( $args['type'] === 'multiselect' ) {
						$attributes = ' multiple="multiple" ';
					}
					printf('<select name="%1$s" id="%1$s" %2$s>%3$s</select>', $args['uid'], $attributes, $options_markup );
				}
				break;
			case 'bool': // single checkbox button				
				printf( '<label for="%1$s"><input id="%1$s" name="%1$s" type="checkbox" value="1" %3$s /></label>', $args['uid'], $value, checked( $value, "1", false ) );
				break;
		}
	
		// If there is help text
		if( $helper = $args['helper'] ){
			printf( '<span class="helper"> %s</span>', esc_html__($helper, 'wp-riotd') ); // Show it
		}
	
		// If there is supplemental text
		if( $supplemental = $args['supplemental'] ){
			printf( '<p class="description">%s</p>', esc_html__($supplemental, 'wp-riotd') ); // Show it
		}		
	}
	/**
	 * Render the cache information and clear cache button
	 * @since	1.0.0
	 */
	public function do_cache() {
		$cache = WP_RIOTD_Cache::get_cache( 'cache' );		
		$expires_in = WP_RIOTD_Cache::get_cache_expiration( 'cache' );		
		$expire_seconds = $expires_in;
		if ( $expires_in > 0 ) {
			$expires_in = WP_RIOTD_Utility::seconds_to_human($expires_in);
			$expired = false;
		} else {
			$expires_in = esc_html__('Expired', 'wp-riotd');
			$expired = true;
		}
		
		
		include plugin_dir_path( __FILE__ ).'partials/settings/wp-riotd-admin-settings-cache.php';
	}
	/**
	 * Render the various setting tabs
	 * @since	1.0.0 
	 */
	public function do_tabs($active_tab) {		
		foreach($this->settings_definitions->get_settings_sections() as $section) {
			include plugin_dir_path( __FILE__ ).'partials/settings/wp-riotd-admin-settings-section-tabs.php';		
		}
	}
	/**
	 * Render the welcome tab only
	 * @since	1.0.0
	 */
	public function welcome_tab() {
		include_once plugin_dir_path( __FILE__ ).'partials/settings/wp-riotd-admin-settings-welcome.php';
		include_once plugin_dir_path( __FILE__ ).'partials/wp-riotd-admin-social-sharing.php';
	}
	/**
	 * Render the usage page
	 * @since	1.0.0
	 */
	public function load_usage_page() {
		$shortcode = \WP_RIOTD_SHORTCODE;
		$shortcode_data = \WP_RIOTD_SHORTCODE_DATA;
		include_once plugin_dir_path( __FILE__ ).'partials/settings/wp-riotd-admin-settings-usage.php';		
	}
	/**
	 * Render the about us page
	 * @since	1.0.0
	 */
	public function load_aboutus_page() {
		include_once plugin_dir_path( __FILE__ ).'partials/wp-riotd-admin-aboutus.php';		
	}
	/**
	 * Return the Github repository link
	 * @since	1.0.0
	 * @param	bool	$echo				True will echo the link to the screen
	 * @return	string	WP_RIOTD_GITHUB		The value defined in the constant WP_RIOTD_GITHUB
	 */
	public function get_github_link($echo = false) {
		if ( defined('WP_RIOTD_GITHUB') ) {
			if ($echo) {
				echo esc_url(\WP_RIOTD_GITHUB);
			}

			return esc_url(\WP_RIOTD_GITHUB);
		}
	}
}