<?php defined( 'ABSPATH' ) || die( 'No direct script access allowed!' ); // Prohibit direct script loading. ?>
<?php echo $custom_css; ?>
<div id="reddit-iotd">
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
    </div>
</div>