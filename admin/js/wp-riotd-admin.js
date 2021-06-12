
jQuery(document).ready(function($) {
    // utility function to format numbers better    
    $('#cache_purged_msg').hide();
    $('#reddit_iotd_cache_loading').hide();
    $('#update_preview').hide();
    $('#update_cache_preview').hide();    
    $('#reddit_iotd_admin_cache_preview').hide();
    $('#reddit_iotd_admin_preview').hide();

    let countdown = null;
    let timer = null;
    function reset_cache_preview() {
        $('#reddit_iotd_admin_cache_preview').hide();
        $('#reddit_iotd_cache_view').html();
        $('#riotd_view_cache').val('View Cache Content')
        $('#riotd_view_cache').attr('data-action', 'cache_off');
    }
    function reset_public_preview() {
        $('#reddit_iotd_admin_preview').hide();
        $('#reddit_iotd_public_view').html();
        $('#riotd_preview').val('Show Preview')
        $('#riotd_preview').attr('data-action', 'preview_off');
    }

    function fixIntegers(integer)
    {
        if (integer < 0)
            integer = 0;
        return "" + integer;
    }

    var ticker = function() {
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

    }
    // countdown timer for cache expiration or other timers
    if ( !isNaN($('#expire_seconds').text()) && parseInt($('#expire_seconds').text()) > 0 ) {
        timer = new Date()
        timer.setSeconds(timer.getSeconds() + parseInt($('#expire_seconds').text()))
    
        countdown = setInterval(ticker, 1000);   
    }
    
    // check if we need to refresh the cache timer as the hearbeat might force a reload of the image in the cache
    $(document).on('heartbeat-tick', function(event, data) {        
        if ( isNaN( parseInt( $('#expire_seconds').text() ) ) ) {
            // cache is currently showing as empty on the screen, get the timer again from the db and reset it if necessary
            jQuery.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'riotd_get_cache_expiration',
                    wp_riotd_nonce:  wp_riotd_data.nonce
                },
                success: function (response) {
                    const data = JSON.parse(response);
    
                    if ( data.payload != null && !isNaN(data.payload) && parseInt(data.payload) > 0 ) {
                        $('#expire_seconds').text(data.payload)
                        timer = new Date()
                        timer.setSeconds(timer.getSeconds() + parseInt($('#expire_seconds').text()))
                    
                        countdown = setInterval(ticker, 1000);               
                    }
                }   
            });
            
        }
    
    });
    

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
                // if there is something in the preview window clear it and hide it
                reset_public_preview();
                // if there is something in the cache window clear it and hide it
                reset_cache_preview();
                // stop the countdown
                clearInterval(countdown);
                $('#cache_expires').text('');
                $('#expire_seconds').text('');
                $('#cache_purged_msg').show();
                $('#cache_expire_msg').hide();
                if (data.expires_in != null) {
                    console.log('figa:' + data.expires_in);
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
                $('#update_preview').show();            
                $('#update_cache_preview').show();    

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
                            $('#update_preview').show();           
                            $('#update_cache_preview').show();                     
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

    // preview
    $('#riotd_preview').on('click',function(event) {   
        event.preventDefault();
        $('#reddit_iotd_icon_loading').show();
        if ($('#riotd_preview').attr('data-action') == 'preview_off') {

            jQuery.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'riotd_public_preview',
                    wp_riotd_nonce:  wp_riotd_data.nonce
                },
                success: function (response) {
                    $('#reddit_iotd_icon_loading').hide();
                    
                    // if there is something in the cache window clear it and hide it
                    reset_cache_preview();                    

                    const data = JSON.parse(response);
                    if ( data.payload != null ) {
                        $('#reddit_iotd_admin_preview').show();
                        $('#reddit_iotd_public_view').html(data.payload);
                        $('#riotd_preview').val('Hide Preview')
                        $('#riotd_preview').attr('data-action', 'preview_on');
                    }
                    if ( data.cache_time != null ) {
                        $('#expire_seconds').text(data.cache_time);
                        timer = new Date()
                        timer.setSeconds(timer.getSeconds() + parseInt($('#expire_seconds').text()))
                    
                        countdown = setInterval(ticker, 1000);                           
                    }
                }
            });
        } else {
            $('#reddit_iotd_icon_loading').hide();
            $('#reddit_iotd_admin_preview').hide();
            $('#reddit_iotd_public_view').html();
            $('#riotd_preview').val('Show Preview')
            $('#riotd_preview').attr('data-action', 'preview_off');

        }        
    });
    
    // view cache content
    $('#riotd_view_cache').on('click',function(event) {   
        event.preventDefault();
        $('#reddit_iotd_icon_loading').show();
        if ($('#riotd_view_cache').attr('data-action') == 'cache_off') {

            jQuery.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'riotd_view_cache',
                    wp_riotd_nonce:  wp_riotd_data.nonce
                },
                success: function (data) {      
                    $('#reddit_iotd_icon_loading').hide();
                    // if there is something in the preview window clear it and hide it
                    reset_public_preview();
                    
                    const parsed_data = JSON.parse(data);
                    const cache = parsed_data.cache;
                    let cache_out = "";                    
                    if ( typeof cache === 'object') {
                        if ( Object.keys(cache).length > 0 ) {
                            cache_out = '<table id="reddit_iotd_admin_table">\
                                                <tbody>\
                                                    <tr valign="top">\
                                                        <th scope="row">Data name</th>\
                                                        <th scope="row">Content</th>\
                                                    </tr>';
                            Object.keys(cache).forEach(function(key) {   
                                let content = "";
                                
                                if (cache[key].toString().split("http://").length > 1 || cache[key].toString().split("https://").length > 1)  {
                                    // it's a url, create a link for it
                                    content = '<a href="'+cache[key]+'" title="Click to open in a new tab" target="_blank">'+cache[key]+'</a>';
                                } else {
                                    content = cache[key];
                                }
                                cache_out += '<tr>\
                                                <td>'+key+'</td>\
                                                <td>'+content+'</td>\
                                            </tr>';
                            });
                            cache_out += '</tbody></table>';
                        }
                    } else {
                        cache_out = parsed_data.cache;
                    }
                    $('#reddit_iotd_admin_cache_preview').show();
                    $('#reddit_iotd_cache_view').html(cache_out);
                    $('#riotd_view_cache').val('Hide Cache Content')
                    $('#riotd_view_cache').attr('data-action', 'cache_on');
                }
            });
        } else {
            $('#reddit_iotd_icon_loading').hide();
            $('#reddit_iotd_admin_cache_preview').hide();
            $('#reddit_iotd_cache_view').html();
            $('#riotd_view_cache').val('View Cache Content')
            $('#riotd_view_cache').attr('data-action', 'cache_off');

        }        
    });    

});