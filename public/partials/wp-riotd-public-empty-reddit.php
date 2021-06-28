<div class="reddit-branding">
  <div class="channel_thumbnail"><img src="<?php echo plugin_dir_url( __DIR__ ).'/images/channel_icon_placeholder.png'; ?>" /></div>
  <div class="channel_name bold" style="color:#7A9299"><a href="<?php echo esc_url($reddit_channel_url); ?>" target="_blank" title="<?php esc_html_e('Click to open this reddit channel in a new tab','wp-riotd');?>">r/<?php echo esc_attr($reddit_channel); ?></a></div>
  <div class="author regular">&bull; <a href="#"  target="_blank" title="">u/NotAvailable</a></div>    
  <div class="reddit_logo"><img src="<?php echo plugin_dir_url( __DIR__ ).'/images/Reddit_Mark_OnWhite.svg'; ?>"></div>
  <div class="post_title bold" style="color:#1A1A1B"><?php echo esc_attr($title); ?></div>
  <div class="post_image"><img src="<?php echo plugin_dir_url( __DIR__ ).'/images/image_post_placeholder.png'; ?>"></div>
  <div class="upvotes bold bottom_row"><img style="margin-right:5px;" width="18px" src="<?php echo plugin_dir_url( __DIR__ ).'/images/reddit-upvotes.svg'; ?>" /><?php printf(esc_html__('%1$s upvotes','wp-riotd'),0); ?></div>
  
  <div class="comments bold bottom_row"><i class="dashicons dashicons-admin-comments"></i><?php printf(esc_html__('%1$s comments','wp-riotd'),0); ?></div>  
  <div class="regular bottom_row post_date"><?php echo date('M d, Y'); ?></div>
</div>