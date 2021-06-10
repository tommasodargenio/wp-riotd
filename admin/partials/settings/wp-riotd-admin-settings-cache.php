<table class="form-table" role="presentation">
<tr><th scope="row">Cache status</th>
<td>
<?php if ($cache) { ?>
<span class="dashicons dashicons-database-view"></span>
Cache Expires in: 
<?php if ($expired) {  ?>
    <span style="color:#b00;font-weight:bolder;"><?php echo $expires_in ?></span>
<?php } else { ?>
    <span style="color:#0b0;font-weight:bolder;"><?php echo $expires_in ?></span>
<?php } ?>
    <button value="Purge Cache"></button>
<?php } else { ?>
    <span class="dashicons dashicons-warning" style="color:#b00;"></span>
    Cache not created yet
<?php } ?>
</td>
</tr>
</table>