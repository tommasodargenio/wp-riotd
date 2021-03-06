<?php defined( 'ABSPATH' ) || die( esc_html__('No direct script access allowed!' ,'wp-riotd')); // Prohibit direct script loading. ?>
<div id="social_sharing_box">
    <hr/>
    <?php esc_html_e('Like the plugin? Spread the love!', 'wp-riotd' ); ?><br/><br/>
    <table>
        <tbody>
            <tr>
                <td style="padding-top:4px"><a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-text="<?php esc_html_e('Display a random image from a reddit channel of your choice on your WordPress website with RIOTD', 'wp-riotd' ); ?>" data-url="https://wordpress.org/plugins/riotd/" data-via="tommasodargenio" data-show-count="false">Tweet</a><span id="social-sharing-twitter-script"></span></td>
                <td style="padding-top:4px"><a href="https://twitter.com/tommasodargenio?ref_src=twsrc%5Etfw" class="twitter-follow-button" data-show-count="false">Follow @tommasodargenio</a><span id="social-sharing-twitter-follow-script"></span></td>
                <td><span id="social-sharing-linkedin-script"></span></td>
                <td><a target='_blank' href='https://www.reddit.com/submit?url=https://wordpress.org/plugins/riotd-reddit-image-of-the-day'><img src='<?php echo plugin_dir_url( __DIR__ ); ?>images/reddit-share-button.svg' alt='Reddit' width="60px" height="20px" style="vertical-align:bottom"/></a></td>
            </tr>
        </tbody>    
    </table>
</div>