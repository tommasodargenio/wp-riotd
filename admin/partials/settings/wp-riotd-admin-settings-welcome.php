<?php defined( 'ABSPATH' ) || die( 'No direct script access allowed!' ); // Prohibit direct script loading. ?>
<h1>Welcome</h1>
<hr />
<section class="page-content">
    <section class="grid">
        <article>
            <p>
            Whether you own a subreddit channel and wants to showcase the images posted, or you are passionate about some of the many topics discussed in a subreddit and wants to show some images from there in your posts or your website, 
            this plugin is for you. It will scrape images from a subreddit channel of your choice, and display it on your website through a text widget or in any of your post where you would use the shortcodes available. The images are fetched
            based on criteria you can setup in the settings, you can choose between two layout or simply grab the image url and use it anywhere you want.
            </p>
            <p>
            The code for this plugin is available on my github <a href="<?php $this->get_github_link(true); ?>" target="_blank" title="Click to open the github repo in a new tab">repository</a>, and all are welcome to inspect it, and contribute.
            </p>
            <p>
            The plugin comes with some parameters pre-set, however we strongly recommend you to review and change them according to your own need. 
            Please check the <a href="<?php echo admin_url( 'admin.php?page='.$this->menu_slug.'-usage' ); ?>">How to use</a> page for usage instructions, would you need help or support you can open an issue on the github <a href="<?php $this->get_github_link(true); ?>/issues" target="_blank" title="Click to open the github repo in a new tab">repository</a>
            we'll respond to that as soon as possible.
            </p>
        </article>
        <article>
            <h1>Disclaimer</h1>
            <hr />
            <p>
            This plugin and its code is provided <span style="font-style: italic">as-is</span> without warranty of any kind, either express or implied, including any implied warranties or fitness for a particular purpose, merchantibility, or non-infringement.
            <br/><br/>
            Reddit is a copyright &copy; of Reddit Inc., please refer to Reddit user agreement <a href="https://www.redditinc.com/policies/user-agreement" target="_blank" title="Click to open the reddit website user agreemenet page in a new tab">website</a> for further details
            </p>
        </article>
        <article style="grid-column: 1 / 4;">
            <h1>Data Privacy and GDPR</h1>
            <hr />
            <p>
            <li>We do not collect or store any personal or usage information, the data fetched from Reddit is publicly available and exported via Reddit JSON RSS feed.</li>
            <li>The post from Reddit where the image is selected, contains the username of the post's author which you can choose not to display on your Website. <strong>(always read and respect the author's copyright terms)</strong></li>
            <li>Images not stored on Reddit but on 3rd party hosting sites will not be selected</li>
            <li>Galleries and Videos will not be selected</li>
            <li>The image's content is never analyzed, we rely on Reddit's flags to determine whether or not the image has adult content, you can choose to display such content or not with the related flag (<strong>Allow NSFW content</strong>) in the <a href="<?php $this->get_tab_url( 'section_general', true ); ?>">general settings</a> area.</li>
            <li>All data is stored on your Website at all time (in the wp_options table within the WordPress database), the lifetime of the data within this table is limited and it can be purged at anytime by using the control on the <a href="<?php $this->get_tab_url( 'section_general', true ); ?>">general settings</a> page.</li>
            <li>The plugin do not transfer or send any of the data collected (in its entirity or partially) anywhere outside your website.</li>
            <li>If you would like to check the exact data that the plugin has collected and stored in the database, you can use the utlity button on <a href="<?php $this->get_tab_url( 'section_general', true ); ?>">general settings</a> page</li>
            <br/>
            <br/>
            Reddit Inc. has the ownership of the post from which the image has been fetched, please refer to <a href="https://www.redditinc.com/policies/privacy-policy" target="_blank" title="Click to open the reddit website privacy policy page in a new tab">Reddit</a> privacy policies for more information on how this data is treated.
            </p>
        </article>
    </section>
    <p>
        <?php include_once plugin_dir_path( __DIR__ ).'wp-riotd-admin-social-sharing.php'; ?>
    </p>    
</section>




