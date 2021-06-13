<?php defined( 'ABSPATH' ) || die( 'No direct script access allowed!' ); // Prohibit direct script loading. ?>
<?php echo $custom_css; ?>
<div id="reddit-iotd">
    <div id="reddit-iotd-title-header">
        <div id="reddit-iotd-title">Reddit image of the day</div>
        <?php if ($reddit_channel != "") {?>
            <div id="reddit-iotd-subtitle">from <a href="<?php echo $reddit_channel_url; ?>" title="Click to open the subreddit channel" target="_blank"><?php echo $reddit_channel; ?></a></div>
        <?php } ?>
    </div>
    <!-- Main display area -->
    <div id="ig-main">
        <!-- Main image -->
        <?php if ( $post_url != "" ) { ?>
            <a href="<?php echo $post_url; ?>" title="Click to open the post with this image on reddit" target="_blank">
        <?php } ?>            
            <img id="ig-iotd" <?php if ($overlay) { ?> onMouseOver="wp_riotd_image_fullscreen()" <?php } ?>alt="<?php echo $title; ?>" title="<?php echo $title; ?>" src="<?php echo $full_res_url ?>"/>
        <?php if ( $post_url != "" ) { ?>            
            </a>
        <?php } ?>            
        
        <!-- Image title -->
        <p id="ig-title">
            <?php echo $title; ?>
            <?php if ($author != "" ) { " by ".$author; } ?>
        </p>
    </div>
    <!-- Full size image area -->
    <div id="reddit-iotd-full-size">
        <div id="reddit-iotd-close-button"><span onClick="wp_riotd_image_close()" class="dashicons dashicons-dismiss" title="Click here to close or anywhere outside the image"></span></div>
        <?php if ( $post_url != "" ) { ?>
        <div id="reddit-iotd-link-button"><span onClick="wp_riotd_image_link('<?php echo $post_url; ?>')" class="dashicons dashicons-admin-links" title="Click to open the post with this image on reddit"></span></div>        
        <?php } ?>
        <img id="ig-iotd-full" alt="<?php echo $title; ?>" title="<?php echo $title; ?>" src="<?php echo $full_res_url ?>"/>
    </div>

</div>