<?php defined( 'ABSPATH' ) || die( esc_html__('No direct script access allowed!' )); // Prohibit direct script loading. ?>
<h1><?php esc_html_e('How to use the plugin','wp-riotd'); ?></h1>
<hr />
<section class="page-content">
    <section class="grid">
        <article style="grid-column: 1 / 4;">
            <p>
                <?php
                /* translators: 1: is a link */
                printf(__('The first step is to setup the plugin, indicating the subdreddit <a href="%1$s">channel</a> you want to fetch images from','wp-riotd'),$this->get_tab_url("channel")); ?>,
                <?php
                /* translators: 1: is a link 2: is a link */
                printf(__('then the <a href="%1$s">image</a> resolution and aspect ratio, which kind of data you want it <a href="%2$s">displayed</a>','wp-riotd'),$this->get_tab_url("image"),$this->get_tab_url("layout"));?>.
            </p>
            <p>
            <?php
                /* translators: 1: is a link */
                printf(__('There are a couple of ways to display the image feed from the subreddit channel you have specified in the <a href="%1$s">settings</a>','wp-riotd'),$this->get_tab_url("channel")); ?>. 
                <?php _e('It involves using shortcodes (specific keywords contained in square brackets, read more <a href="https://wordpress.com/support/shortcodes/" title="open the wordpress support web page in a new tab" target="_blank">here</a>)','wp-riotd'); ?>,
                <?php esc_html_e("beware that shortcodes might not be processed in posts' excerpts but only in full posts depending on how your wordpress theme has been developed.",'wp-riotd'); ?>
            </p>
            <p>
                <?php esc_html_e('We strongly suggest to not modify the plugin files directly as any successive updates will overwrite your customization, use the override mechanism provided via the settings menu as this will not be touched during an upgrade and are stored in your WordPress database.','wp-riotd'); ?>
            </p>
        </article>
        <article style="grid-column: 1 / 2;">
            <h2><?php esc_html_e('Styled Shortcode','wp-riotd'); ?></h2>
            <p>
                <?php
                /* translators: 1: is a keyword representing the shortcode and can't be translated */
                printf(__('Using the main shortcode: <code>[%1$s]</code> will create a rectangular box where the image, title, subreddit channel will be displayed.','wp-riotd'),$shortcode); 
                /* translators: 1: is a link */
                printf(__('You can affect the information displayed by using the switches in the Theme Layout <a href="%1$s">settings</a> tab.','wp-riotd'),$this->get_tab_url("layout")); ?>
                <div id="highlight_box">
                    <h3><span class="dashicons dashicons-admin-post" id="pin"></span>&nbsp;<?php esc_html_e('Display the feed','wp-riotd'); ?></h3>
                    <p><?php esc_html_e("Copy and paste this shortcode directly into the page, post or widget where you'd like to display the feed",'wp-riotd'); ?></p>
                    <input type="text" value="[<?php echo $shortcode; ?>]" size="10" readonly="readonly" style="text-align:center" onClick="this.focus();this.select()" title="<?php esc_html_e('To copy, click the field than press Ctrl + C (PC) or Cmd + C (Mac)','wp-riotd'); ?>" />
                </div>
            </p>
        </article>
        <article style="grid-column: 2 / 4;">
            <h2><?php esc_html_e('Data Extraction shortcode','wp-riotd'); ?></h2>
            <p>
                <?php 
                /* translators: 1: is a keyword representing the shortcode and can't be translated 2: is a keyword used for the parameters call and can't be translated */
                printf( __('The second way is to just get the information you are interested to display, instead of using the plugin UI. In this case use the shortcode <code>[%1$s %2$s=&quot;parameter&quot;]</code>','wp-riotd'),$shortcode_data,'key'); ?>
                <div id="highlight_box">
                    <h3><span class="dashicons dashicons-admin-post" id="pin"></span>&nbsp;<?php esc_html_e('Display a piece of data','wp-riotd'); ?></h3>
                    <p><?php esc_html_e("Copy and paste this shortcode directly into the page, post or widget where you'd like to display the requested data",'wp-riotd'); ?>
                    <input type="text" value="[<?php echo $shortcode_data; ?> key=&quot;<?php esc_html_e('parameter','wp-riotd'); ?>&quot;]" size="32 " readonly="readonly" style="text-align:center" onClick="this.focus();this.select()" title="<?php esc_html_e('To copy, click the field than press Ctrl + C (PC) or Cmd + C (Mac)','wp-riotd'); ?>" />
                </div>
            </p>

            <p style="clear:both;padding-top:25px;">
                <?php esc_html_e('where parameter is the field you want to extract from the plugin, you can choose from the following list of available data','wp-riotd'); ?>:
                <table id="reddit_iotd_admin_table">
                    <tbody>
                        <tr valign="top">
                            <th scope="row"><?php esc_html_e('Shortcode key parameter','wp-riotd'); ?></th>
                            <th scope="row"><?php esc_html_e('Description','wp-riotd'); ?></th>
                            <th scope="row"><?php esc_html_e('Example','wp-riotd'); ?></th>
                        </tr>
                        <tr>
                            <td>thumbnail_url</td>
                            <td><?php esc_html_e('The url pointing at the thumbnail version of the image','wp-riotd'); ?></td>
                            <td><code>[<?php echo $shortcode_data; ?> key="thumbnail_url"]</code></td>
                        </tr>
                        <tr>
                            <td>full_res_url</td>
                            <td><?php esc_html_e('The url pointing at the full resolution image','wp-riotd'); ?></td>
                            <td><code>[<?php echo $shortcode_data; ?> key="full_res_url"]</code></td>
                        </tr>
                        <tr>
                            <td>width</td>
                            <td><?php esc_html_e('The full resolution width in pixels of the image','wp-riotd'); ?></td>
                            <td><code>[<?php echo $shortcode_data; ?> key="width"]</code></td>
                        </tr>
                        <tr>
                            <td>height</td>
                            <td><?php esc_html_e('The full resolution height in pixels of the image','wp-riotd'); ?></td>
                            <td><code>[<?php echo $shortcode_data; ?> key="height"]</code></td>
                        </tr>
                        <tr>
                            <td>title</td>
                            <td><?php esc_html_e('The title or caption of the image as provided by the post\'s author','wp-riotd'); ?></td>
                            <td><code>[<?php echo $shortcode_data; ?> key="title"]</code></td>
                        </tr>
                        <tr>
                            <td>post_url</td>
                            <td><?php esc_html_e('The url pointing at the subreddit post containing the image','wp-riotd'); ?></td>
                            <td><code>[<?php echo $shortcode_data; ?> key="post_url"]</code></td>
                        </tr>
                        <tr>
                            <td>author</td>
                            <td><?php esc_html_e('The author username of the post containing the image','wp-riotd'); ?></td>
                            <td><code>[<?php echo $shortcode_data; ?> key="author"]</code></td>
                        </tr>
                        <tr>
                            <td>nsfw</td>
                            <td><?php esc_html_e('A boolean value (either true or false) indicating if the image is marked as NSFW (i.e.: adult content) or not','wp-riotd'); ?></td>
                            <td><code>[<?php echo $shortcode_data; ?> key="nsfw"]</code></td>
                        </tr>

                    </tbody>
                </table>
            </p>
        </article>
        <article style="grid-column: 1 / 4;">
            <h1><?php esc_html_e('Styling','wp-riodt'); ?></h1>
            <hr />

            <p>
                <?php esc_html_e('While the CSS styling built-in with this plugin is compatible in color palette and style with the default WordPress theme Twenty Twenty-One, it might not be of your liking or it could not work with your theme of choice.','wp-riotd'); ?>
                <?php 
                /* translators: 1: is a link */
                printf(__('In such case you can disable the plug-in CSS with the toggle in the <a href="$1%s">setting</a> page, and override the CSS classes we use with your own styling.','wp-riotd'),$this->get_tab_url("layout")); ?>
                <?php esc_html_e('You can find below a summary of the classes used by the plugin:','wp-riodt'); ?>
                <table id="reddit_iotd_admin_table">
                    <tbody>
                        <tr valign="top">
                            <th scope="row"><?php esc_html_e('CSS Id ','wp-riodt'); ?>#</th>
                            <th scope="row"><?php esc_html_e('Description','wp-riodt'); ?></th>            
                            <th scope="row"><?php esc_html_e('CSS Id','wp-riodt'); ?> #</th>
                            <th scope="row"><?php esc_html_e('Description','wp-riodt'); ?></th>                
                        </tr>
                        <tr>
                            <td><code>reddit-iotd</code></td>
                            <td><?php esc_html_e('this is the main box that will contain the title, image, links, etc.','wp-riodt'); ?></td>            
                            <td><code>ig-main</code></td>
                            <td><?php esc_html_e('the main box where the image is contained','wp-riodt'); ?></td>            
                        </tr>
                        <tr>
                            <td><code>reddit-iotd-title-header</code></td>
                            <td><?php esc_html_e('the main title area','wp-riodt'); ?></td>            
                            <td><code>ig-iotd</code></td>
                            <td><?php esc_html_e('the thumbnail image styling','wp-riodt'); ?></td>            
                        </tr>
                        <tr>
                            <td><code>reddit-iotd-title</code></td>
                            <td><?php 
                            /* translators: 1: is a link  */
                            printf(__('the plugin name by default or a title of your choice as specified in the <a href="$1%s">settings</a>','wp-riodt'),$this->get_tab_url("general")); ?></td>
                            <td><code>ig-iotd-full</code></td>
                            <td><?php esc_html_e('the full resolution image styling','wp-riodt'); ?></td>            
                        </tr>
                        <tr>
                            <td><code>reddit-iotd-subtitle</code></td>
                            <td><?php esc_html_e('the subtitle, containing the subreddit from which the image has been fetched','wp-riodt'); ?></td>
                            <td><code>ig-title</code></td>
                            <td><?php esc_html_e('the image caption and its author','wp-riodt'); ?></td>            
                        </tr>               
                        <tr>
                            <td><code>reddit-iotd-close-button</code></td>
                            <td><?php esc_html_e('the close button showing in the ligthbox','wp-riodt'); ?></td>
                            <td><code>reddit-iotd-close-button span:hover</code></td>
                            <td><?php esc_html_e('the style change on the mouseOver of the close button','wp-riodt'); ?></td>            
                        </tr>  
                        <tr>
                            <td><code>reddit-iotd-link-button</code></td>
                            <td><?php esc_html_e('the link button showing in the lightbox, this will contain the link to the original subreddit post with the image','wp-riodt'); ?></td>
                            <td><code>reddit-iotd-link-button span:hover</code></td>
                            <td><?php esc_html_e('the style change on the mouseOver event of the link button','wp-riodt'); ?></td>            
                        </tr>        
                        <tr>
                            <td><code>reddit-iotd-full-size</code></td>
                            <td><?php esc_html_e('the lightbox containing the full-resolution image','wp-riodt'); ?></td>
                            <td></td>
                            <td></td>            
                        </tr>           
                    </tbody>
                </table>
            </p>
        </article>
    </section>
</section>
