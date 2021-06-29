/**
 * The JS functions used for the admin-specific area.
 *
 * @link       https://github.com/tommasodargenio/wp-riotd/admin/js/wp-riotd-admin.js
 * @since      1.0.0
 * 
 * @package    RIOTD
 * @subpackage RIOTD/admin
 * @author     Tommaso D'Argenio <dev@tommasodargenio.com>
 *  
 */
  
jQuery(document).ready(function($) {
    // wp localization obj
    const __ = wp.i18n.__;
    // utility function to format numbers better    
    $('#cache_purged_msg').hide();
    $('#reddit_iotd_cache_loading').hide();
    $('#update_preview').hide();
    $('#update_cache_preview').hide();    
    $('#reddit_iotd_admin_cache_preview').hide();
    $('#reddit_iotd_admin_preview').hide();

    let countdown = false;
    let timer = null;
    function reset_cache_preview() {
        $('#reddit_iotd_admin_cache_preview').hide();
        $('#reddit_iotd_cache_view').html();
        $('#riotd_view_cache').val(__('View Cache Content','wp-riotd'))
        $('#riotd_view_cache').attr('data-action', 'cache_off');
    }
    function reset_public_preview() {
        $('#reddit_iotd_admin_preview').hide();
        $('#reddit_iotd_public_view').html();
        $('#riotd_preview').val(__('Show Preview','wp-riotd'))
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
                output += " " + __('day','wp-riotd')+", ";
            } else {
                output += " "+ __('days','wp-riotd')+", ";
            }
        }
        if ( hours > 0 ) {
            output += hours;
            if (hours == 1) {
                output += " "+__('hour','wp-riotd')+", ";
            } else {
                output += " "+__('hours','wp-riotd')+", ";
            }

        }
        if ( minutes > 0 ) {
            output += minutes +" ";
            if (minutes == 1) {
                output += " "+__('minute','wp-riotd')+", ";
            } else {
                output += " "+__('minutes','wp-riotd')+", ";
            }                
            
        }
        if ( seconds > 0 ) {
            if (minutes > 0 || hours > 0 || days > 0)
                output += " "+__('and','wp-riotd')+" "+ seconds;
            else {
                output += " " + seconds;
            }
            if (seconds == 1) {
                output += " "+__('second','wp-riotd');
            } else {
                output += " "+__('seconds','wp-riotd');
            }                

        }
        $('#cache_expires').text(output);
        if (output == "") {
            // cache has expired, let's change the text
            $('#cache_expire_msg').hide();
            $('#cache_expired_msg').show();
            $('#expire_seconds').text('');
        }
    }
    // countdown timer for cache expiration or other timers
    if ( !isNaN($('#expire_seconds').text()) && parseInt($('#expire_seconds').text()) > 0 ) {
        timer = new Date()
        timer.setSeconds(timer.getSeconds() + parseInt($('#expire_seconds').text()))
        if (!countdown) {
            countdown = setInterval(ticker, 1000);           
        }
        // there is a cache, activate the button to view it
        $('#riotd_view_cache').prop("disabled",false);
        // disable cache purge message and show cache expiration message
        $('#cache_purged_msg').hide();
        $('#cache_expire_msg').show();        
    }
    // cache is probably empty, disabling the button to view it
    if ( isNaN($('#expire_seconds').text()) ) {
        $('#riotd_view_cache').prop("disabled",true);
    }


    // code mirror
    if ($('#wp_riotd_custom_css').length) {
        var CM_custom_css = wp.codeEditor.initialize($('#wp_riotd_custom_css'), cm_settings);
    }
    
    // show / hide area for custom css
    $('#wp_riotd_css_switch').on('change', function(){
        var use_custom_css = $(this).prop( 'checked' );  
        CM_custom_css.codemirror.setOption('readonly', ! use_custom_css );
        $('#main-options-form').find( '.CodeMirror' ).toggleClass( 'disabled', ! use_custom_css );
        $('#main-options-form').find( '.CodeMirror' ).prop( 'disabled', ! use_custom_css );        
        $('#wp_riotd_custom_css').prop( 'disabled', ! use_custom_css );
    });

    // social sharing button area
    $('#social-sharing-twitter-script').html('<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>');
    $('#social-sharing-twitter-follow-script').html('<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>');
    $('#social-sharing-linkedin-script').html('<script src="https://platform.linkedin.com/in.js" type="text/javascript">lang: en_US</script><script type="IN/Share" data-url="https://wordpress.org/plugins/riotd/"></script>');


    // check if we need to refresh the cache timer as the hearbeat might force a reload of the image in the cache
    $(document).on('heartbeat-tick', function(event, data) {        
        if ( isNaN( parseInt( $('#expire_seconds').text() ) ) ) {
            // cache is currently showing as empty on the screen, get the timer again from the db and reset it if necessary
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'riotd_get_cache_expiration',
                    wp_riotd_nonce:  wp_riotd_data.nonce
                }
            })
            .always( function (data, status) {    
                if ( data.payload != null && !isNaN(data.payload) && parseInt(data.payload) > 0 ) {
                    // there is a cache, activate the button to view it
                    $('#riotd_view_cache').prop("disabled",false);                        
                    // disable cache purge message and show cache expiration message
                    $('#cache_purged_msg').hide();
                    $('#cache_expire_msg').show();      
                    $('#cache_expired_msg').hide();      

                    $('#expire_seconds').text(data.payload)
                    timer = new Date()
                    timer.setSeconds(timer.getSeconds() + parseInt($('#expire_seconds').text()))
                    if (!countdown) {
                        countdown = setInterval(ticker, 1000);               
                    }
                    // retrieve the new preview
                    $('#riotd_preview').attr('data-action', 'preview_off');
                    $('#riotd_preview').trigger('click')                    
                }
            });
        }
    });
    

    // purge cache
    $('#riotd_purge_cache').on('click',function(event) { 
        event.preventDefault();
        
        $('#reddit_iotd_cache_loading').show();
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'riotd_purge_cache',
                wp_riotd_nonce:  wp_riotd_data.nonce
            },
        })
        .fail( function() {
                $('#reddit_iotd_cache_loading').hide();
                $('#riotd_purge_cache').after('<span id="reddit_iotd_icon_error"><i class="dashicons dashicons-dismiss"></i>'+__('Operation not completed','wp-riotd')+'</span>');

                setTimeout(function() {
                    $('#reddit_iotd_icon_error').fadeOut('fast');
                }, 2000);                
            })
        .done( function (data, status) {        
                $('#reddit_iotd_cache_loading').hide();
                // if there is something in the preview window clear it and hide it
                reset_public_preview();
                // if there is something in the cache window clear it and hide it
                reset_cache_preview();
                // stop the countdown
                clearInterval(countdown);
                countdown = false;
                // disable the button to view the cache
                $('#riotd_view_cache').prop("disabled",true);
                $('#cache_expires').text('');
                $('#expire_seconds').text('');
                $('#cache_purged_msg').show();
                $('#cache_expire_msg').hide();
                $('#cache_expired_msg').hide();                    
                if (data.expires_in != null) {                    
                    $('#cache_expires').text(data.expires_in);
                }
                setTimeout(function() {
                    $('#reddit_iotd_icon_success').fadeOut('fast');
                }, 2000);
            });        
    });

    $('#update_preview').on('click', function(event) {
        event.preventDefault();

        // retrieve new preview
        $('#riotd_preview').attr('data-action', 'preview_off');
        $('#riotd_preview').trigger('click')     
        $('#update_preview').hide();       
    })

    // save setting
    $('#main-options-form').submit( function () {
        $('#reddit_iotd_icon_loading').show();
        var b =  $(this).serialize();
        $.ajax({
            url: 'options.php',
            type: 'POST',
            data: b
        })            
        .fail( function() {
            $('#reddit_iotd_icon_loading').hide();
            $('#alert-message-text').text(__('Something went wrong while saving the settings, try again later','wp-riotd'));
            $('#alert-message').addClass('notice-error')
            $('#alert-message').show();
            setTimeout(function() {
                $('#alert-message').fadeOut('fast');
            }, 3000);
        })
        .done ( function() {
            $('#reddit_iotd_icon_loading').hide();
            $('#alert-message-text').text(__('Settings saved successfully','wp-riotd'));
            $('#alert-message').addClass('notice-success')
            $('#alert-message').show();
            $('#update_preview').show(); 
            $('#update_preview').addClass('reddit_iotd_admin_update_preview_spin');
            $('#update_cache_preview').show();    

            setTimeout(function() {
                $('#alert-message').fadeOut('slow');
            }, 3000);
        })  
    });
    
    // reset all settings
    $('#riotd_reset').on('click',function(event) {   
        $('#reddit_iotd_icon_loading').show();
        event.preventDefault();
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'riotd_reset_settings',
                wp_riotd_nonce:  wp_riotd_data.nonce
            },
        })
        .done( function (data, status) {        
                $('#reddit_iotd_icon_loading').hide();                     
                    $('#riotd_response_messages').html('<span id="reddit_iotd_icon_success"><i class="dashicons dashicons-yes-alt"></i>'+__('Settings reset successfully','wp-riotd')+'</span>');
                    if (data.payload != null ) {                        
                        const settings = data.payload;
                        if ( Object.keys(settings).length > 0 ) {                            
                            $('#update_preview').show();  
                            $('#update_preview').addClass('reddit_iotd_admin_update_preview_spin');         
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
                                    // if the element is a checkbox set the checked flag appropriately
                                    if ( $('#' + uid).is(':checkbox') ) {
                                        $('#' + uid).prop('checked', settings[uid]);
                                    } else {
                                        $('#' + uid).val(settings[uid]);
                                    }
                                }
                            });
                        }
    
                    }                
                setTimeout(function() {
                    $('#reddit_iotd_icon_error').fadeOut('fast');
                }, 2000);
                setTimeout(function() {
                    $('#reddit_iotd_icon_success').fadeOut('fast');
                }, 2000);                
        })
        .fail( function (jqXHR) {
                if (jqXHR.status == 400) {
                    $('#riotd_response_messages').html('<span id="reddit_iotd_icon_error"><i class="dashicons dashicons-dismiss"></i>'+__('Operation aborted','wp-riotd')+'!</span>');
                } else if (jqXHR.status == 401) {
                    $('#riotd_response_messages').html('<span id="reddit_iotd_icon_error"><i class="dashicons dashicons-dismiss"></i>'+__('Operation non authorized','wp-riotd')+'!</span>');
                }                
                setTimeout(function() {
                    $('#riotd_response_messages').fadeOut('fast');
                }, 2000); 
        })        
    });

    // preview
    $('#riotd_preview').on('click',function(event) {   
        event.preventDefault();
        $('#reddit_iotd_icon_loading').show();
        if ($('#riotd_preview').attr('data-action') == 'preview_off') {
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'riotd_public_preview',
                    wp_riotd_nonce:  wp_riotd_data.nonce
                },
            })
            .fail( function (jqXHR) {                
                $('#reddit_iotd_icon_loading').hide();                
                if (jqXHR.status == 400) {
                    $('#riotd_response_messages').html('<span id="reddit_iotd_icon_error"><i class="dashicons dashicons-dismiss"></i>'+__('Operation aborted','wp-riotd')+'!</span>');
                } else if (jqXHR.status == 401) {
                    $('#riotd_response_messages').html('<span id="reddit_iotd_icon_error"><i class="dashicons dashicons-dismiss"></i>'+__('Operation non authorized','wp-riotd')+'!</span>');
                } else if (jqXHR.status == 500) {
                    $('#riotd_response_messages').html('<span id="reddit_iotd_icon_error"><i class="dashicons dashicons-dismiss"></i>'+jqXHR.responseJSON.error+'!</span>');
                }
                setTimeout(function() {
                    $('#riotd_response_messages').fadeOut('fast');
                }, 5000);                 
            })        
            .done( function (data, status) {
                    $('#reddit_iotd_icon_loading').hide();
                    
                    // if there is something in the cache window clear it and hide it
                    reset_cache_preview();                    
                    if ( data.payload != null ) {
                        $('#reddit_iotd_admin_preview').show();
                        $('#reddit_iotd_public_view').html(data.payload);
                        $('#riotd_preview').val(__('Hide Preview','wp-riotd'));
                        $('#riotd_preview').attr('data-action', 'preview_on');
                    }
                    if ( data.cache_time != null ) {
                        // there is a cache, activate the button to view it
                        $('#riotd_view_cache').prop("disabled",false);
                        // disable cache purge message and show cache expiration message
                        $('#cache_purged_msg').hide();
                        $('#cache_expire_msg').show();        
                        $('#cache_expired_msg').hide();                            
                        $('#expire_seconds').text(data.cache_time);
                        timer = new Date();
                        timer.setSeconds(timer.getSeconds() + parseInt($('#expire_seconds').text()));
                        if (!countdown) {
                            countdown = setInterval(ticker, 1000);                           
                        }
                    }
            })            
        } else {
            $('#reddit_iotd_icon_loading').hide();
            $('#reddit_iotd_admin_preview').hide();
            $('#reddit_iotd_public_view').html();
            $('#riotd_preview').val(__('Show Preview','wp-riotd'));
            $('#riotd_preview').attr('data-action', 'preview_off');

        }        
    });
    
    // view cache content
    $('#riotd_view_cache').on('click',function(event) {   
        event.preventDefault();
        $('#reddit_iotd_icon_loading').show();
        if ($('#riotd_view_cache').attr('data-action') == 'cache_off') {
            $.ajax({
                url: ajaxurl,
                method: 'POST',
                data: {
                    action: 'riotd_view_cache',
                    wp_riotd_nonce:  wp_riotd_data.nonce
                },
            })
            .fail( function (jqXHR) {
                $('#reddit_iotd_icon_loading').hide();                
                if (jqXHR.status == 400) {
                    $('#riotd_response_messages').html('<span id="reddit_iotd_icon_error"><i class="dashicons dashicons-dismiss"></i>'+__('Operation aborted','wp-riotd')+'!</span>');
                } else if (jqXHR.status == 401) {
                    $('#riotd_response_messages').html('<span id="reddit_iotd_icon_error"><i class="dashicons dashicons-dismiss"></i>'+__('Operation non authorized','wp-riotd')+'!</span>');
                }
                setTimeout(function() {
                    $('#riotd_response_messages').fadeOut('fast');
                }, 2000);                                 
            })        
            .done( function(data) {                    
                $('#reddit_iotd_icon_loading').hide();
                // if there is something in the preview window clear it and hide it
                reset_public_preview();                    
                const cache = data.cache;
                let cache_out = "";                    
                if ( typeof cache === 'object') {
                    if ( Object.keys(cache).length > 0 ) {
                        cache_out = '<table id="reddit_iotd_admin_table">\
                                            <tbody>\
                                                <tr valign="top">\
                                                    <th scope="row">'+__('Data name','wp-riotd')+'</th>\
                                                    <th scope="row">'+__('Content','wp-riotd')+'</th>\
                                                </tr>';
                        Object.keys(cache).forEach(function(key) {   
                            let content = "";
                            
                            if (cache[key].toString().split("http://").length > 1 || cache[key].toString().split("https://").length > 1)  {
                                // it's a url, create a link for it
                                content = '<a href="'+cache[key]+'" title="'+__('Click to open in a new tab','wp-riotd')+'" target="_blank">'+cache[key]+'</a>';
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
                $('#riotd_view_cache').val(__('Hide Cache Content','wp-riotd'));
                $('#riotd_view_cache').attr('data-action', 'cache_on');
            });         
        } else {
            $('#reddit_iotd_icon_loading').hide();
            $('#reddit_iotd_admin_cache_preview').hide();
            $('#reddit_iotd_cache_view').html();
            $('#riotd_view_cache').val(__('View Cache Content','wp-riotd'));
            $('#riotd_view_cache').attr('data-action', 'cache_off');

        }        
    });    

});