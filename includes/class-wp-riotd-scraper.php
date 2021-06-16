<?php
/**
 * CLASS-WP-RIOTD-SCRAPER
 * 
 * Download images from a reddit channel if they exist via reddit JSON export of the channel
 * 
 * 
 * @link       https://github.com/tommasodargenio/wp-riodt/includes/class-wp-riotd-scraper.php
 * @since      1.0.1
 * 
 * @package    RIOTD
 * @subpackage RIOTD/includes
 * @author     Tommaso D'Argenio <dev@tommasodargenio.com>
 */

// Prohibit direct script loading.
defined( 'ABSPATH' ) || die( esc_html__('No direct script access allowed!' ));
class WP_RIOTD_Scraper {
    /**
     * Contains all the plugin settings
     * 
     * @since   1.0.1
     * @access  protected
     * @var     string      $settings     load all plugin settings
     */
    protected $settings;

    /**
     *  Store the url to be used to download the channel json export
     *  @since  1.0.1
     *  @access protected
     *  @var    string      $reddit_json_url    the reddit json export url 
     */
    protected $reddit_json_url;

    /**
     *  Contains the images scraped
     *  @since  1.0.1  
     *  @access protected
     *  @var    array[][thumbnail_url: string, full_res_url: string, width:int, height: int, title: string, post_url: string, author: string, nsfw: bool ]    $scraped_content    array containing the images scraped 
     */
    protected $scraped_content;
    
    /**
     *  Collect statistical information on downloaded posts
     *  @since  1.0.1
     *  @access protected
     *  @var    array[][tot_posts: int, tot_images: int, tot_videos: int, tot_galleries: int, tot_nsfw: int, tot_viable_images: int]      $statistics     array containing statistical information on collected data
     */
    protected $statistics;
    /**
     *  Status of scraper operation
     *  @since  1.0.1
     *  @access protected
     *  @var    bool        $scraper_status     True if scraper operation run successfully otherwise false if not or never ran
     */
    protected $scraper_status;
    /**
     * Constructor to initialize the instanced object
     * 
     * @since   1.0.1
     * 
     */
    public function __construct($channel = null) {    
        // get the plugin options
        if ( class_exists('WP_RIOTD_ADMIN_SETTINGS_DEFINITIONS', false) ) {
			$settings_definitions = new WP_RIOTD_ADMIN_SETTINGS_DEFINITIONS();
            foreach($settings_definitions->get_settings_definitions() as $field) { 
                $this->settings[$field['uid']] = get_option( $field['uid'], $field['default']);
            }
		}

        if ( isset($this->settings['wp_riotd_channel']) && $this->settings['wp_riotd_channel'] != '' ) {
            if ( defined( '\WP_RIOTD_REDDIT_URL' ) ) {
                $this->reddit_json_url = str_replace( '%reddit_channel%', $this->settings['wp_riotd_channel'], \WP_RIOTD_REDDIT_URL );
            } else {
                trigger_error(esc_html__("Reddit URL not defined", "wp-riotd"), E_USER_ERROR);    
            }
        }            
        else {
            trigger_error(esc_html__("Reddit channel not specified", "wp-riotd"), E_USER_ERROR);
        }

        $this->statistics = array('tot_posts' => 0, 'tot_images' => 0, 'tot_videos' => 0, 'tot_galleries' => 0, 'tot_nsfw' => 0, 'tot_viable_images'=>0 );
    }

    /**
     * Main method to fetch the json export of the channel and extract the image
     * all extracted images / titles / etc. are stored as properties
     * 
     * @since   1.0.1
     * @return  bool      $status               true if image was found, false otherwise
     */
    public function scrape() {
        // download the json file from the reddit url if available
        if ( $this->reddit_json_url != null && $this->reddit_json_url != "" ) {
            // set the number of posts to download if defined
            if ( isset($this->settings['wp_riotd_download_limit']) && intval($this->settings['wp_riotd_download_limit']) > 0 ) {
                $this->reddit_json_url .= '?limit='.$this->settings['wp_riotd_download_limit'];
            }
            $response   = wp_remote_get( $this->reddit_json_url );            
            $http_code  = wp_remote_retrieve_response_code( $response );
            // check if the download was successfull if not exit
            if ( $http_code != 200 ) {
                $this->scraper_status = false;
                return false;
            } else {
                $tot_results = 0;
                $data = null;
                // retrieve the response body
                $body   = wp_remote_retrieve_body( $response );
                $content_type = wp_remote_retrieve_header( $response, 'content-type' );

                // make sure the response is in json format
                if ( stristr( $content_type, 'application/json' ) ) {
                    // decode the json
                    $scrapes = json_decode($body);

                    // if null something went wrong
                    if ( $scrapes == null ) {
                        trigger_error(esc_html__("Reddit returned an unexpected result, check your settings", "wp-riotd"), E_USER_ERROR);   
                    }

                    // if there is no data property in the object, then the channel is empty or something went wrong
                    if ( !property_exists( $scrapes, 'data' ) ) {
                        trigger_error(esc_html__("The reddit channel selected is empty or something went wrong during the download", "wp-riotd"), E_USER_ERROR);                           
                    } 

                    // check if there are any children property, if not then the channel has no posts
                    if ( !property_exists( $scrapes->data, 'children' ) ) {
                        $this->scraped_content = esc_html__('channel empty', 'wp-riotd');
                        return true; 
                    }
                    // check how many results we got
                    $tot_results = $scrapes->data->dist;
                    
                    $data = $scrapes->data->children;

                    // iterate through each child / post to extract an image
                    foreach ($data as $post) {
                        $this->statistics['tot_posts']++;
                        $img_found = array(
                            'thumbnail_url'=>'',
                            'full_res_url'=>'',
                            'width'=>'',
                            'height'=>'',
                            'title'=>'',
                            'post_url'=>'',
                            'author'=>'',
                            'nsfw'=>'',
                        );
                        // check if the post has any data
                        if ( property_exists( $post, 'data' ) ) {
                            $post_data = $post->data;
                            // check if the post is a video, if not proceed otherwise skip
                            $this->statistics['tot_posts']++;
                            if ( $post_data->is_video == false && $post_data->media == null && (property_exists($post_data, 'post_hint') && $post_data->post_hint == "image") ) {
                                // a post can be without images, if there are they will be in the preview node
                                if ( property_exists( $post_data, 'preview' ) ) {  
                                    // extract all the information we need                               
                                    $img_found['thumbnail_url'] = $post_data->thumbnail;
                                    $img_found['full_res_url'] = $post_data->url;
                                    $img_found['width'] = $post_data->preview->images[0]->source->width ;
                                    $img_found['height'] = $post_data->preview->images[0]->source->height;
                                    $img_found['title'] = $post_data->title;
                                    $img_found['post_url'] = \WP_RIOTD_REDDIT_MAIN.$post_data->permalink;
                                    $img_found['author'] = $post_data->author;
                                    $img_found['nsfw'] = $post_data->over_18;

                                    $this->statistics['tot_images']++;
                                    
                                    // check if image resolution is ok                                      
                                    if ( $this->is_resolution_ok( $img_found['width'], $img_found['height'], true) ) {
                                        // check if image is allowed due to adult content
                                        if ( $this->is_nsfw_ok( $img_found['nsfw'] ) )
                                        {
                                            // add to the list of candidates
                                            $this->scraped_content[] = $img_found; 
                                            $this->statistics['tot_viable_images']++;       
                                                                        
                                        } else {
                                            $this->statistics['tot_nsfw']++;
                                        }
                                    }

                                } elseif ( property_exists($post_data, 'is_gallery') && $post_data->is_gallery == true ) {
                                    $this->statistics['tot_galleries']++;
                                }
                            } else {
                                $this->statistics['tot_videos']++;
                            }
                        }
                    }              
                    $this->scraper_status = true;         
                    return true;
                } else {
                    $this->scraper_status = false;
                    return false;
                }
            }            

        } else {
            $this->scraper_status = false;
            return false;
        }        
    }
    /**
     * Check if the given image is allowed based on the nsfw switch
     * @since   1.0.1
     * @access  private
     * @param   bool        $image_nsfw_flag    The flag indicating if the image has nsfw content or not
     * @return  bool                            true if test passed, otherwise false
     */
    private function is_nsfw_ok($image_nsfw_flag = false) {
        $test = false;

        if ( isset($this->settings['wp_riotd_nsfw_switch']) ) {
            if ( $this->settings['wp_riotd_nsfw_switch'] === true )
            {
                $test = true;
            } else {
                $test = $this->settings['wp_riotd_nsfw_switch'] === $this->settings['wp_riotd_nsfw_switch'];
            }             
        }

        return $test;
    }

    /**
     * Check if the given image resolution is correct based on the plugin settings
     * @since   1.0.1
     * @access  private
     * @param   int     $width          the width in pixels of the image to check
     * @param   int     $height         the height in pixels of the image to check
     * @param   bool    $check_aspect   true if aspect_ratio must be checked as well
     * @return  bool                    true if all test passed, otherwise false
     */
    private function is_resolution_ok($width = 0, $height = 0, $check_aspect = true) {
        $test_w = false;
        $test_h = false;
        $test_a = false;

        if ( $width > 0 ) {
            if ( isset($this->settings['wp_riotd_image_max_width']) && intval($this->settings['wp_riotd_image_max_width']) > 0 ) {                      
                    $test_w = $width <= $this->settings['wp_riotd_image_max_width'] ? true : false ; 
            } else {
                // if the max_width setting is not defined or not valid, make the test pass
                $test_w = true;
            }               
        }
        if ( $height > 0 ) {
            if ( isset($this->settings['wp_riotd_image_max_height']) && intval($this->settings['wp_riotd_image_max_height']) > 0 ) {                                
                    $test_h = $height <= $this->settings['wp_riotd_image_max_height'] ? true : false;                
            } else {
                // if the max_height setting is not defined or not valid, make the test pass
                $test_h = true;
            }
        }
        if ( $check_aspect ) {
            if ( isset($this->settings['wp_riotd_aspect_ratio']) ) {
                if ( $this->settings['wp_riotd_aspect_ratio'] == 'portrait' ) {
                    $test_a = $height > $width ? true : false;                    
                } elseif ( $this->settings['wp_riotd_aspect_ratio'] == 'landscape' ) {
                    $test_a = $height < $width ? true : false;
                }
            }
                        
            return $test_w && $test_h && $test_a ? true : false;
        }
        
        return $test_w && $test_h ? true : false;
    }

    public function get_image() {
        if ( isset( $this->settings['wp_riotd_image_scraping'] ) ) {
            switch ( $this->settings['wp_riotd_image_scraping'] ) {
                case 'daily_update':
                    srand( floor( time() / 86400 ) );
                    return $this->scraped_content[rand(0, count($this->scraped_content)-1)];
                    break;
                case 'last_update';
                    return $this->scraped_content[0];
                    break;
                case 'random_update':    
                    srand(time());
                    return $this->scraped_content[rand(0, count($this->scraped_content)-1)];
                    break;
            }
        }
    }
    /**
     * Return the currently set subreddit channel
     * @since   1.0.1
     * @return  string      $reddit_channel     the currently set subreddit channel
     */
    public function get_reddit_channel() {
        return $this->settings['wp_riotd_channel'];
    }
    /**
     * Return the scraped content if any
     * @since   1.0.1
     * @return  string[]    $scraped_content    the scraped content
     */
    public function get_scraped_content() {
        return $this->scraped_content;
    }

    /**
     * Return the requested statistic
     * @since   1.0.1
     * @param   string  $request    The statistic to request. This must be a valid key based on the internal statistics property
     * @return  int     $stat       The figure requested if existeng
     */
    public function get_statistics( $request ) {
        if ( $request == null || $request == "" ) {
            return -1;
        }
        if ( array_key_exists( $request, $this->statistics )) {
            return $this->statistics[$request];
        }
    }
    /**
     * Return the scraper status variable
     * @since   1.0.1
     * @return  bool    $scraper_status         True if scraper operation run successfully otherwise false if not or never ran
     */
    public function get_scraper_status() {
        return $this->scraper_status;
    }

}