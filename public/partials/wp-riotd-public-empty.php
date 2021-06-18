<?php defined( 'ABSPATH' ) || die( esc_html__('No direct script access allowed!','wp-riotd') ); // Prohibit direct script loading. ?>
<?php echo $custom_css; ?>
<div id="reddit-iotd">
    <div id="reddit-iotd-title-header">
        <div id="reddit-iotd-title"><?php esc_html_e('Reddit image of the day','wp-riotd'); ?></div>
        <div id="reddit-iotd-subtitle">from <a href="<?php echo $reddit_channel_url; ?>" title="<?php esc_html_e('Click to open the subreddit channel in a new tab','wp-riotd'); ?>" target="_blank"><?php echo $reddit_channel; ?></a></div>
    </div>
    <!-- Main display area -->
    <div id="ig-main">
        <!-- Main image -->       
            <img id="ig-iotd" alt="<?php echo $scraped; ?>" title="<?php echo $scraped; ?>" src="https://via.placeholder.com/300x150/e5d2d3/000000?text=<?php echo $scraped; ?>"/>       
        <!-- Image title -->
        <p id="ig-title"><?php echo $scraped; ?></p>
    </div>

</div>