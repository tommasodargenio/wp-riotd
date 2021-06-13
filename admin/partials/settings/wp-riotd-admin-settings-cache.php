<?php defined( 'ABSPATH' ) || die( 'No direct script access allowed!' ); // Prohibit direct script loading. ?>
<table class="form-table" role="presentation">
<tr><th scope="row">Cache status</th>
<td>
<span id="expire_seconds" style="display:none"><?php echo $expire_seconds; ?></span>
<?php if ($cache) { ?>
<span id="cache_purged_msg" style="display:none">
    <span class="dashicons dashicons-yes-alt" style="color:#0b0;"></span>
    Cache purged
</span>
<span id="cache_expire_msg">
    <span class="dashicons dashicons-database-view"></span>
    Cache Expires in: 
</span>
<?php if ($expired) {  ?>
    <span style="color:#b00;font-weight:bolder;" id="cache_expires"><?php echo $expires_in ?></span>
<?php } else { ?>
    <span style="color:#0b0;font-weight:bolder;" id="cache_expires"><?php echo $expires_in ?></span>
<?php } ?>
    <?php submit_button( __( 'Purge Cache', 'wp_riotd'), 'secondary', 'riotd_purge_cache', false, 'style="position:relative;left:10px;top:-5px;" title="'.__('Click to clear the cache', 'wp_riotd').'"'); ?>
    <img src="<?php echo admin_url('/images/wpspin_light.gif') ?>" id="reddit_iotd_cache_loading" style="display:none" />                            
<?php } else { ?>
    <span class="dashicons dashicons-warning" style="color:#b00;"></span>
    Cache not created yet or expired
<?php } ?>
</td>
</tr>
</table>