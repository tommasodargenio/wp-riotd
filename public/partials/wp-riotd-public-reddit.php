<div class="reddit-branding">
  <div class="channel_thumbnail"><img src="<?php echo $channel_icon; ?>" /></div>
  <div class="channel_name bold" style="color:#7A9299"><a href="<?php echo $reddit_channel_url; ?>" target="_blank" title="<?php esc_html_e('Click to open this reddit channel in a new tab','wp-riotd');?>">r/<?php echo $reddit_channel; ?></a></div>
  <div class="author regular">&bull; <a href="<?php echo $author_url; ?>"  target="_blank" title="<?php esc_html_e('Click to open the post\'s author reddit profile in a new tab','wp-riotd');?>">u/<?php echo $author; ?></a></div>    
  <div class="reddit_logo"><img src="<?php echo plugin_dir_url( __DIR__ ).'/images/Reddit_Mark_OnWhite.svg'; ?>"></div>
  <div class="post_title bold" style="color:#1A1A1B"><?php echo $title; ?></div>
  <div class="post_image"><img src="<?php echo $full_res_url; ?>"></div>
  <div class="upvotes bold bottom_row"><img style="margin-right:5px;" width="18px" src="<?php echo plugin_dir_url( __DIR__ ).'/images/reddit-upvotes.svg'; ?>" /><?php printf(esc_html__('%1$s upvotes','wp-riotd'),$upvotes); ?></div>
  
  <div class="comments bold bottom_row"><i class="dashicons dashicons-admin-comments"></i><?php printf(esc_html__('%1$s comments','wp-riotd'),$comments); ?></div>  
  <div class="regular bottom_row post_date"><?php echo $post_date; ?></div>
</div>