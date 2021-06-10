jQuery(document).ready(function($) {
    // reset all settings
    $('#riotd_reset').on('click',function(event) {   
        $('#reddit_iotd_icon_loading').show();
        event.preventDefault();
        jQuery.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'riotd_reset_settings',
                wp_riotd_nonce:  wp_riotd_data.nonce
            },
            success: function (data) {        
                $('#reddit_iotd_icon_loading').hide();
                let parsed_data = JSON.parse(data);
                if (parsed_data.response_code == 200) {            
                    $('#riotd_reset').after('<span id="reddit_iotd_icon_success"><i class="dashicons dashicons-yes-alt"></i>Settings reset successfully</span>');
                    if (parsed_data.payload != null ) {
                        const settings = JSON.parse(parsed_data.payload);
                        if ( Object.keys(settings).length > 0 ) {
                            Object.keys(settings).forEach(function(uid) {                            
                                // check if uid is wp_riotd_cache_lifetime this requires special treatment
                                if (uid == 'wp_riotd_cache_lifetime') {
                                    if (settings[uid] >= 60 * 60 * 24 ) {
                                        let lifetime = Math.ceil(settings[uid] / (60 * 60 * 24));
                                        $('#' + uid).val(lifetime);
                                        $('#time_unit').val("days");
                                    } else if (settings[uid] >= 60 * 60) {
                                        let lifetime = Math.ceil(settings[uid] / (60 * 60));
                                        $('#' + uid).val(lifetime);
                                        $('#time_unit').val("hours");
                                    } else {
                                        let lifetime = Math.ceil(settings[uid] / 60);
                                        $('#' + uid).val(lifetime);
                                        $('#time_unit').val("minutes");
                                    }
                                } else {
                                    // update the uid element with the value from the database
                                    $('#' + uid).val(settings[uid]);
                                }
                            });
                        }
    
                    }

                } else if (parsed_data.response_code == 400) {
                    $('#riotd_reset').after('<span id="reddit_iotd_icon_error"><i class="dashicons dashicons-dismiss"></i>Operation aborted!</span>');
                } else if (parsed_data.response_code == 401) {
                    $('#riotd_reset').after('<span id="reddit_iotd_icon_error"><i class="dashicons dashicons-dismiss"></i>Operation non authorized!</span>');
                }

                setTimeout(function() {
                    $('#reddit_iotd_icon_error').fadeOut('fast');
                }, 2000);
                setTimeout(function() {
                    $('#reddit_iotd_icon_success').fadeOut('fast');
                }, 2000);                
            }
        });
    });

});