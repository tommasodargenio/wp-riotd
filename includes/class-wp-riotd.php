<?php
/**
 *  CLASS-WP-RIOTD
 *  
 *  the core class
 * 
 * @link       https://github.com/tommasodargenio/wp-reddit-iodt/includes/class-wp-riotd.php
 * @since      1.0.1
 * 
 * @package    WP-Reddit-IOTD
 * @subpackage WP-Reddit-IOTD/includes
 * @author     Tommaso D'Argenio <dev@tommasodargenio.com>
 */

 class WP_RIOTD {
	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since   1.0.1
	 * @access  protected
	 * @var     WP_RIOTD_Loader     $loader         Maintains and registers all hooks for the plugin.
	 */
	protected $loader;
    /**
     * Unique identifier of this plugin
     * 
     * @since   1.0.1
     * @access  protected
     * @var     string              $plugin_name    The string used to uniquely identify this plugin
     */
    protected $plugin_name;
    /**
     * The current version of this plugin
     * 
     * @since   1.0.1
     * @access  protected
     * @var     string              $plugin_version        The current version of this plugin
     */
    protected $plugin_version;

    /**
     * The list of class dependencies to load
     * 
     * @since   1.0.1
     * @access  protected
     * @var     string[]            $dependendcies          Associative array listing class to load (class->filepath)
     */
    protected $dependencies;
    
    /**
     *  All the configuration settings for this plugin
     * 
     * @since   1.0.1
     * @access  protected
     * @var     string[]            $settings               Associative array listing all settings (setting->value)
     */
    protected $settings;

    /**
     * Class Constructor
     * 
     * set the plugin name and version, load dependencies, define local and set hooks
     * 
     * @since   1.0.1
     */
    public function __construct() {        
        if ( defined( 'WP_RIOTD_PLUGIN_NAME' ) ) {
            $this->plugin_name = WP_RIOTD_PLUGIN_NAME;
        } else {
            $this->plugin_name = 'WP-Reddit-IOTD';
        }

        if ( defined( 'WP_RIOTD_VERSION' ) ) {
            $this->plugin_version = WP_RIOTD_VERSION;
        } else {
            $this->plugin_version = '1.0.0';
        }

        // define the dependencies
        $this->dependencies = array(
                             // The class responsible to orchestrate the actions and filters of the core plugin
                             'WP_RIOTD_Loader' => 'includes/class-wp-riotd-loader.php',
                             // the class responsible for defining internationalisation functionality                     
                             'WP_RIOTD_i18n'   => 'includes/class-wp-riotd-i18n.php',
                             // the class responsible for defining all actions that occur in the admin area                      
                             'WP_RIOTD_Admin'  => 'admin/class-wp-riotd-admin.php',
                             // the class responsible for creating all settings definitions
                             'WP_RIOTD_ADMIN_SETTINGS_DEFINITIONS' => 'admin/class-wp-riotd-admin-settings-definitions.php',
                             // the class responsible for defining all actions that occur in the public side of the site
                             'WP_RIOTD_Public' => 'public/class-wp-riotd-public.php'
                            );

        // load settings from db
        $this->settings = get_option( 'wp_riotd_settings' );


        $this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
    }

    /**
     *  create an instance of the loader which will be used to register the hooks with WP.
     *  and load the required dependencies for this plugin:
     * 
     *  WP_RIOTD_Loader:    Orchestrates the hooks of the plugin
     *  WP_RIOTD_i18n:      Defines the internationalization functionality
     *  WP_RIOT_Admin:      Defines all hooks for the admin area
     *  WP_RIOT_Public:     Defines all hooks for the public side of the site
     * 
     * @since   1.0.1
     * @access  private
     */
    private function load_dependencies() {
        /*
        // The class responsible to orchestrate the actions and filters of the core plugin
        require_once plugin_dir_path( dirname( __FILE__ ) ).'includes/class-wp-riotd-loader.php';
        
        // the class responsible for defining internationalisation functionality
        require_once plugin_dir_path( dirname( __FILE__ ) ).'includes/class-wp-riotd-i18n.php';

        // the class responsible for defining all actions that occur in the admin area
        require_once plugin_dir_path( dirname( __FILE__ ) ).'admin/class-wp-riotd-admin.php';
        
        // the class responsible for defining all actions that occur in the public side of the site
        require_once plugin_dir_path( dirname( __FILE__) ).'public/class-wp-riotd-public.php';
        */

        if ( count($this->dependencies) > 0 ) {
            foreach ($this->dependencies as $class => $path) {
                $class_path = plugin_dir_path( dirname( __FILE__ ) ).$path;
                if ( file_exists($class_path) ) {
                    require_once $class_path;
                    if ( !class_exists($class, false) ) {
                        trigger_error(__("Unable to load required dependency", "wp-riotd").": $class", E_USER_ERROR);
                    }

                } else {
                    trigger_error(__("Unable to load required dependency", "wp-riotd").": $class", E_USER_ERROR);
                }
            }
        }

        $this->loader = new WP_RIOTD_Loader();
    }
    /**
     *  Define the local for this plugin for internationalisation
     *  @since  1.0.1
     *  @access private
     */
    private function set_locale() {
        $plugin_i18n = new WP_RIOTD_i18n();

        $this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
    }

    /**
     * Register all of the hooks related to the admin area
     * @since   1.0.1
     * @access private
     */
    private function define_admin_hooks() {
        if ( $this->validate_loader() ) {
            $plugin_admin = new WP_RIOTD_Admin( $this->get_plugin_name(), $this->get_version(), $this->settings);

            $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
            $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );    
            $this->loader->add_action( 'admin_menu', $plugin_admin, 'create_admin_menu' );
            $this->loader->add_action( 'admin_init', $plugin_admin, 'register_admin_settings' );
        }
    }

    /**
     * Register all of the hooks related to the public area
     * @since   1.0.1
     * @access private
     */
    private function define_public_hooks() {
        if ( $this->validate_loader() ) {
            $plugin_public = new WP_RIOTD_Public( $this->get_plugin_name(), $this->get_version() );

            $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
            $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );    
         
        }
    }

    /**
     * Validate if the loader exists and it's a valide instance of the WP_RIOTD_Loader class
     * @since   1.0.1
     * @return  bool    true if the loader is valid, false if it's not
     */
    public function validate_loader() {
        if ( $this->loader != null && $this->loader instanceof WP_RIOTD_Loader) {
            return true;
        } else {
            return false;
        }
    }

    /**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.1
	 */
	public function run() {
        if ( $this->validate_loader() ) {
            $this->loader->run();
        }	
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.1
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.1
	 * @return    WP_RIOTD_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.1
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->plugin_version;
	}
  }