<?php
/**
 * Public facing functionality of the plugin.
 *
 * @link       https://github.com/tommasodargenio/wp-riodt/public/class-wp-riotd-public.php
 * @since      1.0.1
 * 
 * @package    RIOTD
 * @subpackage RIOTD/public
 * @author     Tommaso D'Argenio <dev@tommasodargenio.com>
 *  
 */

 // Prohibit direct script loading.
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

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
	 * Image scraped from reddit
	 * @since	1.0.1	
	 * @access	protected
	 * @var    array[][thumbnail_url: string, full_res_url: string, width:int, height: int, title: string, post_url: string, author: string, nsfw: bool ]    $scraped_content    array containing the images scraped 
	 */
	protected $scraped;

	/**
	 * Reddit channel being scraped
	 * @since 	1.0.1
	 * @access	protected
	 * @var		string	$reddit_channel		the reddit channel being scraped
	 */
	protected $reddit_channel;

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
		
		if ( !class_exists( 'WP_RIOTD_Scraper', false ) ) {
			trigger_error(__("Can't find the scraper class", "wp-riotd"), E_USER_ERROR);    
		}

		$scraper = new WP_RIOTD_Scraper();
		// check if cache exists, if not create and store scraped image in cache. If it exists take image from there
		if( (class_exists( 'WP_RIOTD_Cache', false )) ) {
			$cache = WP_RIOTD_Cache::get_cache('cache');
			
			if ( false === $cache ) {
			// cache doesn't exist, download image and then store in cache				
				$scraper->scrape();
				$this->scraped = $scraper->get_image();
	
				WP_RIOTD_Cache::set_cache( array( 'uid' => 'cache', 'payload' => $this->scraped ) );
			} else {
					$this->scraped = $cache;
			}
		}
		// $scraper->scrape();
		// $this->scraped = $scraper->get_image();
		$this->reddit_channel = $scraper->get_reddit_channel();
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
	public function render_view($admin_view = false) {
		$view = 'Template not available :(';
		$scraped = 'No images availabe :(';
		$reddit_channel = "";
		$reddit_channel_url = "";
		$author = "";
		$title = "";
		$post_url = "";
		$full_res_url = "";
		$overlay = WP_RIOTD_Settings::get('wp_riotd_zoom_switch');
		$custom_css = "";
		
		// add custom CSS if defined		
		if ( "0" === WP_RIOTD_Settings::get( "css_switch" ) || 0 === WP_RIOTD_Settings::get( "css_switch" ) || false === WP_RIOTD_Settings::get( "css_switch" ) ) {
			$custom_css = WP_RIOTD_Settings::get("custom_css");			
			if ( ! empty( $custom_css ) ) {
				$custom_css = "<style type=\"text/css\">\n$custom_css\n</style>\n";
			}
		}

		// If no images were found, load the empty template
		if ( sizeof($this->scraped) <= 0 ) {			
			$view_template = plugin_dir_path( __FILE__ )."partials/wp-riotd-public-empty.php";
		} else {			

			// check which layout the user prefer, if not set we will use the full one
			$layout = WP_RIOTD_Settings::get("wp_riotd_layout");			
			
			if ($layout == "full") {
				$view_template = plugin_dir_path( __FILE__ )."partials/wp-riotd-public-single.php";
			} else {
				$view_template = plugin_dir_path( __FILE__ )."partials/wp-riotd-public-minimal.php";
			}
			
			// check if the user wants the reddit channel displayed
			if ( WP_RIOTD_Settings::get("wp_riotd_channel_switch") ) {
				$reddit_channel = $this->reddit_channel;
				$reddit_channel_url = \WP_RIOTD_REDDIT_MAIN.'/r/'.$reddit_channel;	
			} 
			// check if the user wants the post's author displayed
			if ( WP_RIOTD_Settings::get("wp_riotd_author_switch") ) {
				$author = $this->scraped["author"];
			} 
			// check if the user wants the post's title displayed
			if ( WP_RIOTD_Settings::get("wp_riotd_title_switch") ) {
				$title = $this->scraped["title"];
			}
			// check if the user wants a link to the post on the image
			if ( WP_RIOTD_Settings::get("wp_riotd_link_switch") ) {
				$post_url = $this->scraped["post_url"];
			}
			// setting the full resolution image URL
			$full_res_url = $this->scraped["full_res_url"];
		}

		// output the template
		if ( file_exists( $view_template ) ) {
			if (false === $admin_view) {
				include_once $view_template;
			} else {
				ob_start();
				include_once $view_template;
				return ob_get_clean();
			}
		} else {
			return $view;
		}
	}

	/**
	 *  Return any key from the scraped image if any, this is used with the shortcode reddit-iotd-data
	 * 	@since	1.0.1
	 *  @var	string	$attr	contains the key requested
	 * 	@return	string	$value 	the value from the scraped image dataset corresponding to the requested key if it exists, otherwise an empty string
	 */
	public function get_image_info($attr) {
		// set defaults
		$attributes = shortcode_atts( array(
			'key'=>'title',
		), $attr);

		if (array_key_exists('key', $attributes)) {
			$key = $attributes["key"];
			if ( sizeof($this->scraped) > 0 && array_key_exists($key, $this->scraped) ) {		
				return $this->scraped[$key];
			} else {
				return "";
			}	
		} else {
			return "";
		}
	}

}