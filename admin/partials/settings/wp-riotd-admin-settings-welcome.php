<?php defined( 'ABSPATH' ) || die( esc_html__('No direct script access allowed!' )); // Prohibit direct script loading. ?>
<h1><?php esc_html_e('Welcome','wp-riotd' ); ?></h1>
<hr />
<section class="page-content">
    <section class="grid">
        <article>
            <p>
            <?php esc_html_e("Whether you own a subreddit channel and wants to showcase the images posted, or you are passionate about some of the many topics discussed in a subreddit and wants to show some images from there in your posts or your website", 'wp-riotd'  ); ?>, 
            <?php esc_html_e("this plugin is for you. It will scrape images from a subreddit channel of your choice, and display it on your website through a text widget or in any of your post where you would use the shortcodes available. The images are fetched", 'wp-riotd'  ); ?>
            <?php esc_html_e("based on criteria you can setup in the settings, you can choose between two layout or simply grab the image url and use it anywhere you want.", 'wp-riotd'  ); ?>
            </p>
            <p>
            <?php 
            /* translators: 1: is a link */
            printf(__('The code for this plugin is available on my GitHub <a href="%1$s" target="_blank" title="Click to open the github repo in a new tab">repository</a>, feel free to take a peek at it, star it, fork it, and submit pull requests to contribute', 'wp-riotd' ),$this->get_github_link()); 
            ?>. 
            </p>
            <p>
            <?php esc_html_e('The plugin comes with some parameters pre-set, however we strongly recommend you to review and change them according to your own need.', 'wp-riotd' ); ?>
            <?php 
            /* translators: 1: is a link 2: is a link */
            printf(__('Please check the <a href="%1$s">How to use</a> page for usage instructions, would you need help or support you can open an issue on our GitHub <a href="%2$s" target="_blank" title="Click to open the github repo in a new tab">repository</a>', 'wp-riotd' ),admin_url( 'admin.php?page='.$this->menu_slug.'-usage' ),$this->get_github_link().'/issues'); ?>
            <?php esc_html_e("we'll respond to that as soon as possible", 'wp-riotd' ); ?>.
            </p>
        </article>
        <article>
            <h1><?php esc_html_e('Disclaimer', 'wp-riotd' ); ?></h1>
            <hr />
            <p>
            <?php _e('This plugin and its code is provided <span style="font-style: italic">as-is</span> without warranty of any kind, either express or implied, including any implied warranties or fitness for a particular purpose, merchantibility, or non-infringement', 'wp-riotd' ); ?>
            <br/><br/>
            <?php _e('Reddit is a copyright of Reddit Inc., please refer to Reddit user agreement <a href="https://www.redditinc.com/policies/user-agreement" target="_blank" title="Click to open the reddit website user agreement page in a new tab">website</a> for further details', 'wp-riotd' ); ?>
            </p>
        </article>
        <article style="grid-column: 1 / 4;">
            <h1><?php esc_html_e('Data Privacy and GDPR', 'wp-riotd' ); ?></h1>
            <hr />
            <p>
            <li><?php esc_html_e('We do not collect or store any personal or usage information, the data fetched from Reddit is publicly available and exported via Reddit JSON RSS feed.', 'wp-riotd' ); ?></li>
            <li><?php _e("The post from Reddit where the image is selected, contains the username of the post's author which you can choose not to display on your Website.<strong>(always read and respect the author's copyright terms)</strong>", 'wp-riotd' ); ?></li>
            <li><?php esc_html_e('Images not stored on Reddit but on 3rd party hosting sites will not be selected', 'wp-riotd' ); ?></li>
            <li><?php esc_html_e('Galleries and Videos will not be selected', 'wp-riotd' ); ?></li>
            <li><?php 
            /* translators: 1: is a link */
            printf(__('The image\'s content is never analyzed, we rely on Reddit\'s flags to determine whether or not the image has adult content, you can choose to display such content or not with the related flag (<strong>Allow NSFW content</strong>) in the <a href="%1$s">general settings</a> area', 'wp-riotd'),$this->get_tab_url( 'section_general' ));  ?></li>
            <li><?php 
            /* translators: 1: is a link */
            printf(__('All data is stored on your Website at all time (in the wp_options table within the WordPress database), the lifetime of the data within this table is limited and it can be purged at anytime by using the control in the <a href="%1$s">general settings</a> area', 'wp-riotd'),$this->get_tab_url( 'section_general' )); ?> .</li>
            <li><?php esc_html_e('The plugin do not transfer or send any of the data collected (in its entirity or partially) anywhere outside your website.','wp-riotd');?></li>
            <li><?php 
            /* translators: 1: is a link */
            printf(__('If you would like to check the exact data that the plugin has collected and stored in the database, you can use the utlity button on <a href="%1$s">general settings</a> page'),$this->get_tab_url( 'section_general'));?></li>
            <br/>
            <br/>
            <?php _e('Reddit Inc. has the ownership of the post from which the image has been fetched, please refer to <a href="https://www.redditinc.com/policies/privacy-policy" target="_blank" title="Click to open the reddit website privacy policy page in a new tab">Reddit</a> privacy policies for more information on how this data is treated.','wp-riotd'); ?>
            </p>
        </article>
    </section>
    <p>
        <?php include_once plugin_dir_path( __DIR__ ).'wp-riotd-admin-social-sharing.php'; ?>
    </p>    
</section>




