<?php
/**
 * CLASS-WP-RIOTD-SCRAPER
 * 
 * Download images from a reddit channel if they exist via reddit JSON export of the channel
 * 
 * 
 * @link       https://github.com/tommasodargenio/wp-reddit-iodt/includes/class-wp-riotd-scraper.php
 * @since      1.0.1
 * 
 * @package    WP-Reddit-IOTD
 * @subpackage WP-Reddit-IOTD/includes
 * @author     Tommaso D'Argenio <dev@tommasodargenio.com>
 */
class WP_RIOTD_Scraper {
    /**
     * Store the subreddit channel from which to donwload the images
     * 
     * @since   1.0.1
     * @access  protected
     * @var     string      $reddit_channel     an existing subreddit channel
     */
    protected $reddit_channel;

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
     *  @var    array[thumbnail_url: string, full_res_url: string, width:int, height: int, title: string, post_url: string, author: string, nsfw: bool ]    $scraped_content    array containing the images scraped 
     */
    protected $scraped_content;
    
    /**
     * Constructor to initialize the instanced object
     * 
     * @since   1.0.1
     * 
     */
    public function __construct($channel) {        
        if ( $channel != null && $channel != "" ) {
            $this->reddit_channel = $channel;

            if ( defined( '\WP_RIOTD_REDDIT_URL' ) ) {
                $this->reddit_json_url = str_replace( '%reddit_channel%', $channel, \WP_RIOTD_REDDIT_URL );
            } else {
                trigger_error(__("Reddit URL not defined", "wp-riotd"), E_USER_ERROR);    
            }
        }            
        else {
            trigger_error(__("Reddit channel not specified", "wp-riotd"), E_USER_ERROR);
        }
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
            $response   = wp_remote_get( $this->reddit_json_url );            
            $http_code  = wp_remote_retrieve_response_code( $response );
            // check if the download was successfull if not exit
            if ( $http_code != 200 ) {
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
                        trigger_error(__("Reddit returned an unexpected result, check your settings", "wp-riotd"), E_USER_ERROR);   
                    }

                    // if there is no data property in the object, then the channel is empty or something went wrong
                    if ( !property_exists( $scrapes, 'data' ) ) {
                        trigger_error(__("The reddit channel selected is empty or something went wrong during the download", "wp-riotd"), E_USER_ERROR);                           
                    } 

                    // check if there are any children property, if not then the channel has no posts
                    if ( !property_exists( $scrapes->data, 'children' ) ) {
                        $this->scraped_content = 'channel empty';
                        return true; 
                    }
                    // check how many results we got
                    $tot_results = $scrapes->data->dist;

                    $data = $scrapes->data->children;
                    // iterate through each child / post to extract an image
                    foreach ($data as $post) {
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
                            if ( $post_data->is_video == false ) {
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

                                    // add to the property
                                    $this->scraped_content[] = $img_found;
                                }
                            }
                        }
                    }                    
                    return true;
                } else {
                    return false;
                }
            }            

        } else {
            return false;
        }        
    }

    /**
     * Return the currently set subreddit channel
     * @since   1.0.1
     * @return  string      $reddit_channel     the currently set subreddit channel
     */
    public function get_reddit_channel() {
        return $this->reddit_channel;
    }
    /**
     * Return the scraped content if any
     * @since   1.0.1
     * @return  string[]    $scraped_content    the scraped content
     */
    public function get_scraped_content() {
        return $this->scraped_content;
    }


}