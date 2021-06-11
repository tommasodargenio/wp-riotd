<div class="wrap">    
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>    
    <?php if ( isset($_GET['settings-updated']) && $_GET['settings-updated'] ) {?>
        <div class="notice notice-success is-dismissible">
            <p>Your settings have been updated!</p>
        </div>
    <?php } ?>
    <div id="alert-message" class="notice is-dismissible" style="display:none"><p id="alert-message-text"></p></div>
    <?php settings_errors(); ?>

    <?php $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : $this->default_setting_tab; ?>

    <h2 class="nav-tab-wrapper">
        <?php $this->do_tabs($active_tab); ?>
    </h2>
    
    <form method="POST" action="options.php" id="main-options-form">
        <?php 
            if ( $active_tab == $this->default_setting_tab ) {
                $this->welcome_tab();    
            } elseif ( $active_tab == 'wp_riotd_section_usage' ) {
                $this->usage_tab();
            } else {
                settings_fields( $active_tab );
                do_settings_sections( $active_tab );

                if ( $active_tab == 'wp_riotd_section_general') {
                    $this->do_cache();
                }
                ?>
                <table class="form-table" role="presentation" style="width:5%">
                    <tr>
                        <td><?php submit_button( __( 'Save Settings', 'wp_riotd' ), 'primary', 'submit', false ); ?></td>
                        <td>
                            <?php submit_button( __( 'Reset All Settings', 'wp_riotd'), 'secondary', 'riotd_reset', false, 'title="'.__('Click to reset all settings to default', 'wp_riotd').'"'); ?>
                            <img src="<?php echo admin_url('/images/wpspin_light.gif') ?>" id="reddit_iotd_icon_loading" style="display:none" />                            
                        </td>
                        <td>
                            <?php submit_button( __( 'Show Preview', 'wp_riotd'), 'secondary', 'riotd_preview', false, 'data-action="preview_off" title="'.__('Click to see a preview', 'wp_riotd').'"'); ?>
                        </td>
    <?php  }  ?>
                    </tr>
                </table>
    </form>
    <div id="reddit_iotd_admin_preview" style="display:none">
               <h1>Preview <span class="dashicons dashicons-update" id="update_preview" style="display:none" title="<?php echo __('Update available, click to refresh', 'wp-riotd'); ?>"></span></h1>
               <hr />
                <div id="reddit_iotd_public_view"></div>
    </div>
</div>
