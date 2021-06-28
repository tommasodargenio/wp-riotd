<?php defined( 'ABSPATH' ) || die( esc_html__('No direct script access allowed!','wp-riotd') ); // Prohibit direct script loading. ?>
<div id="reddit-iotd">
    <div id="reddit-iotd-title-header">
        <div id="reddit-iotd-title"><?php esc_html_e('Reddit image of the day','wp-riotd'); ?></div>
        <div id="reddit-iotd-subtitle">from <a href="<?php echo esc_url($reddit_channel_url); ?>" title="<?php esc_html_e('Click to open the subreddit channel in a new tab','wp-riotd'); ?>" target="_blank"><?php echo esc_attr($reddit_channel); ?></a></div>
    </div>
    <!-- Main display area -->
    <div id="ig-main">
        <!-- Main image -->       
            <img id="ig-iotd" alt="<?php echo esc_attr($scraped); ?>" title="<?php echo esc_attr($scraped); ?>" src="<?php echo plugin_dir_url( __DIR__ ).'/images/image_post_placeholder.png'; ?>"/>       
        <!-- Image title -->
        <p id="ig-title"><?php echo esc_attr($scraped); ?></p>
    </div>

</div>