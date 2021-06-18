<?php defined( 'ABSPATH' ) || die( esc_html__('No direct script access allowed!','wp-riotd' )); // Prohibit direct script loading. ?>
<table class="form-table" role="presentation">
<tr><th scope="row"><?php esc_html_e('Cache status','wp-riotd'); ?></th>
<td>
<span id="expire_seconds" style="display:none"><?php echo $expire_seconds; ?></span>
<?php if ($cache) { ?>
<span id="cache_purged_msg" style="display:none">
    <span class="dashicons dashicons-yes-alt" style="color:#0b0;"></span>
    <?php esc_html_e('Cache purged','wp-riotd'); ?>
</span>
<span id="cache_expire_msg">
    <span class="dashicons dashicons-database-view"></span>
    <?php esc_html_e('Cache Expires in:','wp-riotd'); ?> 
</span>
<?php if ($expired) {  ?>
    <span style="color:#b00;font-weight:bolder;" id="cache_expires"><?php echo $expires_in ?></span>
<?php } else { ?>
    <span style="color:#0b0;font-weight:bolder;" id="cache_expires"><?php echo $expires_in ?></span>
<?php } ?>
    <?php submit_button( esc_html__( 'Purge Cache', 'wp-riotd'), 'secondary', 'riotd_purge_cache', false, 'style="position:relative;left:10px;top:-5px;" title="'.esc_html__('Click to clear the cache', 'wp-riotd').'"'); ?>
    <img src="<?php echo admin_url('/images/wpspin_light.gif') ?>" id="reddit_iotd_cache_loading" style="display:none" />                            
<?php } else { ?>
    <span class="dashicons dashicons-warning" style="color:#b00;"></span>
    <?php esc_html_e('Cache not created yet or expired','wp-riotd'); ?>
<?php } ?>
</td>
</tr>
</table>