<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/tommasodargenio/wp-reddit-iodt/admin/class-wp-riotd-admin.php
 * @since      1.0.1
 * 
 * @package    WP-Reddit-IOTD
 * @subpackage WP-Reddit-IOTD/admin
 * @author     Tommaso D'Argenio <dev@tommasodargenio.com>
 *  
 */

/**
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 */
class WP_RIOTD_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.1
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.1
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

    
    /**
     *  All the configuration user's settings for this plugin loaded from the database
     * 
     * @since   1.0.1
     * @access  protected
     * @var     string[]            $settings               Associative array listing all settings (setting->value)
     */
    protected $settings;

     /**
     *  All the configuration settings definitions for this plugin
     * 
     * @since   1.0.1
     * @access  protected
     * @var     string[]            $settings_definitions               Associative array listing all settings (setting->value)
     */
	protected $settings_definitions;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.1
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $settings ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->settings = $settings;

		if ( class_exists('WP_RIOTD_ADMIN_SETTINGS_DEFINITIONS', false) ) {
			$this->settings_definitions = new WP_RIOTD_ADMIN_SETTINGS_DEFINITIONS();			
		}

	}	
    /**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.1
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-riotd-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.1
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-riotd-admin.js', array( 'jquery' ), $this->version, false );
	}
	
	/**
	 * Add a link in the WP admin menu to open the settings page for the plugin
	 * 
	 * @since	1.0.1
	 */
	public function create_admin_menu() {
		add_menu_page(
			'Reddit Image Of The Day - Settings',
			'Reddit-IOTD',
			'manage_options',
			'wp-reddit-iotd',
			array($this, 'load_admin_page')
		);
	}
	
	/**
	 * Used by create_admin_menu as callback to laod the view template
	 * 
	 * @since	1.0.1
	 * @access	private
	 */
	public function load_admin_page() {
		include_once plugin_dir_path( __FILE__ )."partials/wp-riotd-admin-menu.php";
	}

	/**
	 * Initialize all the configuration parameters and register them in the db
	 * @since	1.0.1 
	 */
	public function register_admin_settings() {

		// register a new section in the group
		foreach($this->settings_definitions->get_settings_sections() as $section) {
			add_settings_section( $section['uid'], $section['label'], array($this, 'section_renderer' ), 'wp_riotd' );			
		}
		
		// register fields
		foreach($this->settings_definitions->get_settings_definitions() as $field) {
			add_settings_field($field['uid'], $field['label'], array($this, 'fields_renderer'), 'wp_riotd', $field['section'], $field );
			register_setting('wp_riotd', $field['uid']);
		}
	}

	/**
	 * Callback used to display configuration section information
	 * @since	1.0.1
	 * @access	private
	 */
	public function section_renderer( $args ) {
		include_once plugin_dir_path( __FILE__ )."partials/settings/wp-riotd-admin-settings-section.php";	
	}

	/**
	 * Callback used to render the channel input field
	 * @since	1.0.1
	 * @access	private
	 */
	public function fields_renderer( $args ) {
		$value = get_option( $args['uid'] ); // Get the current value, if there is one

		 if( $value === null ) { // If no value exists
		 	$value = $args['default']; // Set to our default
		 }
		 
		// Check which type of field we want
		switch( $args['type'] ){
			case 'text': // If it is a text field
			case 'password':
			case 'number':
				printf( '<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />', $args['uid'], $args['type'], $args['placeholder'], $value );
				break;
			case 'textarea':
				printf( '<textarea name="%1$s" id="%1$s" placeholder="%2$s" rows="5" cols="50">%3$s</textarea>', $args['uid'], $args['placeholder'], $value );
			case 'select':
			case 'multiselect':
				if ( !empty( $args['options'] ) && is_array( $args['options']) ) {
					$attributes = '';
					$options_markup = '';
					foreach( $args['options'] as $key => $label ) {
						$options_markup .= sprintf( '<option value="%1$s" %2$s>%3$s</option>', $key, selected( $value[array_search($key, $value, false)], $key, false ), $label );
					}
					if ( $args['type'] === 'multiselect' ) {
						$attributes = ' multiple="multiple" ';
					}
					printf('<select name="%1$s[]" id="%1$s" %2$s>%3$s</select>', $args['uid'], $attributes, $options_markup );
				}
				break;
			case 'bool': // single checkbox button				
				printf( '<label for="%1$s"><input id="%1$s" name="%1$s" type="checkbox" value="1" %3$s /></label>', $args['uid'], $value, checked( "1", $value, false) );
				break;
		}
	
		// If there is help text
		if( $helper = $args['helper'] ){
			printf( '<span class="helper"> %s</span>', $helper ); // Show it
		}
	
		// If there is supplemental text
		if( $supplimental = $args['supplemental'] ){
			printf( '<p class="description">%s</p>', $supplimental ); // Show it
		}		
	}

}