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
	 * Image scraped from reddit
	 * @since	1.0.1	
	 * @access	protected
	 * @var    array[thumbnail_url: string, full_res_url: string, width:int, height: int, title: string, post_url: string, author: string, nsfw: bool ]    $scraped_content    array containing the images scraped 
	 */
	protected $scraped;

	/**
	 * Reddit channel being scraped
	 * @since 	1.0.1
	 * @access	proteced
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
		$scraper->scrape();
		$this->scraped = $scraper->get_image();
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
	public function render_view() {
		$view = 'Template not available :(';
		$scraped = 'No images availabe :(';
		$reddit_channel = "";
		$reddit_channel_url = "";
		$author = "";
		$title = "";
		$post_url = "";
		$full_res_url = "";
		$overlay = WP_RIOTD_Settings::get('wp_riotd_zoom_switch');
			
		


		if ( sizeof($this->scraped) <= 0 ) {			
			$view_template = plugin_dir_path( __FILE__ )."partials/wp-riotd-public-empty.php";
		} else {			
			$layout = WP_RIOTD_Settings::get("wp_riotd_layout")[0];			
			
			if ($layout == "full") {
				$view_template = plugin_dir_path( __FILE__ )."partials/wp-riotd-public-single.php";
			} else {
				$view_template = plugin_dir_path( __FILE__ )."partials/wp-riotd-public-minimal.php";
			}
			
			
			if ( WP_RIOTD_Settings::get("wp_riotd_channel_switch") ) {
				$reddit_channel = $this->reddit_channel;
				$reddit_channel_url = \WP_RIOTD_REDDIT_MAIN.'/r/'.$reddit_channel;	
			} 
		
			if ( WP_RIOTD_Settings::get("wp_riotd_author_switch") ) {
				$author = $this->scraped["author"];
			} 

			if ( WP_RIOTD_Settings::get("wp_riotd_title_switch") ) {
				$title = $this->scraped["title"];
			}

			if ( WP_RIOTD_Settings::get("wp_riotd_link_switch") ) {
				$post_url = $this->scraped["post_url"];
			}

			$full_res_url = $this->scraped["full_res_url"];
		}

		if ( file_exists( $view_template ) ) {
			include_once $view_template;
		} else {
			return $view;
		}

		// return $view;
	}

	/**
	 *  Return any key from the scraped image if any
	 * 	@since	1.0.1
	 *  @var	string	$attr	contains the key requested
	 * 	@return	string	$value 	the value from the scraped image dataset corresponding to the requested key if it exists, otherwise an empty string
	 */
	public function get_image_info($attr) {
		if (array_key_exists('key', $attr)) {
			$key = $attr["key"];
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