jQuery(document).ready(function($) {
    // utility function to format numbers better    
    $('#cache_purged_msg').hide();
    $('#reddit_iotd_cache_loading').hide();
    
    let countdown = null;

    function fixIntegers(integer)
    {
        if (integer < 0)
            integer = 0;
        return "" + integer;
    }
    
    // countdown timer for cache expiration or other timers
    if ( parseInt($('#expire_seconds').text()) > 0 ) {
        let timer = new Date()
        timer.setSeconds(timer.getSeconds() + parseInt($('#expire_seconds').text()))
    
        countdown = setInterval(function() {
            var now = new Date();
            var difference = Math.floor((timer.getTime() - now.getTime()) / 1000);
            
            var seconds = fixIntegers(difference % 60);
            difference = Math.floor(difference / 60);
            
            var minutes = fixIntegers(difference % 60);
            difference = Math.floor(difference / 60);
            
            var hours = fixIntegers(difference % 24);
            difference = Math.floor(difference / 24);
            
            var days = difference;
            
            let output = "";
            if ( days > 0 ) {
                output += days;
                if (days == 1) {
                    output += " day, ";
                } else {
                    output += " days, ";
                }
            }
            if ( hours > 0 ) {
                output += hours;
                if (hours == 1) {
                    output += " hour, ";
                } else {
                    output += " hours, ";
                }

            }
            if ( minutes > 0 ) {
                output += minutes +" ";
                if (minutes == 1) {
                    output += " minute, ";
                } else {
                    output += " minutes, ";
                }                
                
            }
            if ( seconds > 0 ) {
                output += " and " + seconds;
                if (seconds == 1) {
                    output += " second";
                } else {
                    output += " seconds";
                }                

            }
            $('#cache_expires').text(output);

        }, 1000);   
    }

    // purge cache
    $('#riotd_purge_cache').on('click',function(event) { 
        event.preventDefault();
        
        $('#reddit_iotd_cache_loading').show();
        jQuery.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'riotd_purge_cache',
                wp_riotd_nonce:  wp_riotd_data.nonce
            },
            error: function(data) {
                $('#reddit_iotd_cache_loading').hide();
                $('#riotd_purge_cache').after('<span id="reddit_iotd_icon_error"><i class="dashicons dashicons-dismiss"></i>Operation not completed</span>');

                setTimeout(function() {
                    $('#reddit_iotd_icon_error').fadeOut('fast');
                }, 2000);                
            },
            success: function (data) {        
                $('#reddit_iotd_cache_loading').hide();
                
                // stop the countdown
                clearInterval(countdown);
                $('#cache_expires').text('');
                $('#cache_purged_msg').show();
                $('#cache_expire_msg').hide();
                if (data.expires_in != null) {
                    $('#cache_expires').text(data.expires_in);
                }
                setTimeout(function() {
                    $('#reddit_iotd_icon_success').fadeOut('fast');
                }, 2000);
            }
        });
  
            
    });

    // save setting
    $('#main-options-form').submit( function () {
        $('#reddit_iotd_icon_loading').show();
        var b =  $(this).serialize();        
        $.post( 'options.php', b ).error( 
            function() {
                $('#reddit_iotd_icon_loading').hide();
                $('#alert-message-text').text('Something went wrong while saving the settings, try again later');
                $('#alert-message').addClass('notice-error')
                $('#alert-message').show();
                setTimeout(function() {
                    $('#alert-message').fadeOut('fast');
                }, 3000);
            }).success( function() {
                $('#reddit_iotd_icon_loading').hide();
                $('#alert-message-text').text('Settings saved successfully');
                $('#alert-message').addClass('notice-success')
                $('#alert-message').show();
                setTimeout(function() {
                    $('#alert-message').fadeOut('slow');
                }, 3000);
            });            
            return false;    
            
    });
    
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