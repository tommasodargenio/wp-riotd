<?php
/**
 * Public facing functionality of the plugin.
 *
 * @link       https://github.com/tommasodargenio/wp-reddit-iodt/public/class-wp-riotd-public.php
 * @since      1.0.1
 * 
 * @package    WP-Reddit-IOTD
 * @subpackage WP-Reddit-IOTD/public
 * @author     Tommaso D'Argenio <dev@tommasodargenio.com>
 *  
 */

/**
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 */
class WP_RIOTD_Public {

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
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.1
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}	
    /**
	 * Register the stylesheets for the public area.
	 *
	 * @since    1.0.1
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-riotd-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public area.
	 *
	 * @since    1.0.1
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-riotd-public.js', array( 'jquery' ), $this->version, false );
	}

	/**
	 * Render the final view to be output on the public site
	 * 
	 * @since	1.0.1
	 * @return	string		$view		The html code that will be pasted in the public site where the plugin shortcut has been used
	 */
	public function render_view() {
		$view = '';

		$view_template = plugin_dir_path( __FILE__ )."partials/wp-riotd-public-single.php";
		
		$scraper = new WP_RIOTD_Scraper("mapporn");
		$scraped = 'nothing to see here!';
		if ( $scraper->scrape() ) {
			$scraped = $scraper->get_scraped_content();			
		}

		var_dump($scraped);

		if ( file_exists( $view_template ) ) {
			include_once $view_template;
		} else {
			return $view;
		}

		// return $view;
	}

}