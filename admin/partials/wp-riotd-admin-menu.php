<?php defined( 'ABSPATH' ) || die( esc_html__('No direct script access allowed!','wp-riotd' )); // Prohibit direct script loading. ?>
<div class="wrap">    
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>    
    <?php if ( isset($_GET['settings-updated']) && $_GET['settings-updated'] ) {?>
        <div class="notice notice-success is-dismissible">
            <p><?php esc_html_e('Your settings have been updated!', 'wp-riotd' ); ?></p>
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
                    ?>
                    <section class="page-content">
                    <section class="grid">
                        <article>                        
                    <?php
                        settings_fields( $active_tab );
                        do_settings_sections( $active_tab );

                        if ( $active_tab == 'wp_riotd_section_general') {
                            $this->do_cache();
                        }
                        ?>
                        <table class="form-table" role="presentation" style="width:5%">
                            <tr>
                                <td><?php submit_button( esc_html__( 'Save Settings', 'wp-riotd' ), 'primary', 'submit', false ); ?></td>
                                <td>
                                    <?php submit_button( esc_html__( 'Reset All Settings', 'wp-riotd'), 'secondary', 'riotd_reset', false, 'title="'.esc_html__('Click to reset all settings to default', 'wp-riotd').'"'); ?>                           
                                </td>
                                <td>
                                    <?php submit_button( esc_html__( 'Show Preview', 'wp-riotd'), 'secondary', 'riotd_preview', false, 'data-action="preview_off" title="'.esc_html__('Click to see a preview', 'wp-riotd').'"'); ?>
                                </td>
                                <td>
                                    <?php submit_button( esc_html__( 'View Cache Content', 'wp-riotd'), 'secondary', 'riotd_view_cache', false, 'data-action="cache_off" title="'.esc_html__('Click to see the content of the cache stored in the database', 'wp-riotd').'"'); ?>
                                </td>
                                <td>
                                    <img src="<?php echo admin_url('/images/wpspin_light.gif') ?>" id="reddit_iotd_icon_loading" style="display:none" />                            
                                </td>

            <?php  }  ?>
                            </tr>
                        </table>
            </form>
            <div id="reddit_iotd_admin_preview" style="display:none">
                    <h1><?php esc_html_e('Preview', 'wp-riotd' ); ?><span class="dashicons dashicons-update" id="update_preview" style="display:none" title="<?php esc_html_e('Update available, click to refresh', 'wp-riotd'); ?>"></span></h1>
                    <hr />
                        <div id="reddit_iotd_public_view"></div>
            </div>
            <div id="reddit_iotd_admin_cache_preview" style="display:none">
                    <h1><?php esc_html_e('Cache Content', 'wp-riotd' ); ?><span class="dashicons dashicons-update" id="update_cache_preview" style="display:none" title="<?php esc_html_e('Update available, click to refresh', 'wp-riotd'); ?>"></span></h1>
                    <hr />
                        <div id="reddit_iotd_cache_view"></div>
            </div>    
        </article>
    </section>
    </section>
</div>
