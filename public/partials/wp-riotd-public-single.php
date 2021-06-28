<?php defined( 'ABSPATH' ) || die( esc_html__('No direct script access allowed!' ,'wp-riotd')); // Prohibit direct script loading. ?>
<div id="reddit-iotd">
    <div id="reddit-iotd-title-header">
        <div id="reddit-iotd-title"><?php esc_html_e('Reddit image of the day','wp-riotd') ?></div>
        <?php if ($reddit_channel != "") {?>
            <div id="reddit-iotd-subtitle"><?php esc_html_e('from','wp-riotd'); ?> <a href="<?php echo esc_url($reddit_channel_url); ?>" title="<?php esc_html_e('Click to open the subreddit channel','wp-riotd') ?>" target="_blank">/r/<?php echo esc_attr($reddit_channel); ?></a></div>
        <?php } ?>
    </div>
    <!-- Main display area -->
    <div id="ig-main">
        <!-- Main image -->
        <?php if ( $post_url != "" ) { ?>
            <a href="<?php echo esc_url($post_url); ?>" title="<?php esc_html_e('Click to open the post with this image on reddit','wp-riotd') ?>" target="_blank">
        <?php } ?>            
            <img id="ig-iotd" <?php if ($overlay) { ?> onMouseOver="wp_riotd_image_fullscreen()" <?php } ?>alt="<?php echo esc_attr($title); ?>" title="<?php echo esc_attr($title); ?>" src="<?php echo esc_url($full_res_url); ?>"/>
        <?php if ( $post_url != "" ) { ?>            
            </a>
        <?php } ?>            
        
        <!-- Image title -->
        <p id="ig-title">
            <?php echo esc_attr($title); ?>
            <?php 
            /* translators: 1: is the author's name */
            if ($author != "" ) { printf( __(' by %1$s','wp-riotd'), $author ); } ?>
        </p>
    </div>
    <!-- Full size image area -->
    <div id="reddit-iotd-full-size">
        <div id="reddit-iotd-close-button"><span onClick="wp_riotd_image_close()" class="dashicons dashicons-dismiss" title="<?php esc_html_e('Click here or anywhere outside the window to close the image','wp-riotd') ?>"></span></div>
        <?php if ( $post_url != "" ) { ?>
        <div id="reddit-iotd-link-button"><span onClick="wp_riotd_image_link('<?php echo esc_url($post_url); ?>')" class="dashicons dashicons-admin-links" title="<?php esc_html_e('Click to open the post with this image on reddit','wp-riotd') ?>"></span></div>        
        <?php } ?>
        <img id="ig-iotd-full" alt="<?php echo esc_attr($title); ?>" title="<?php echo esc_attr($title); ?>" src="<?php echo esc_url($full_res_url); ?>"/>
    </div>

</div>