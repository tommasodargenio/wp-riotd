<div class="wrap">
    <div id="icon-themes" class="icon32"></div>
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <?php if ( isset($_GET['settings-updated']) && $_GET['settings-updated'] ) {?>
        <div class="notice notice-success is-dismissible">
            <p>Your settings have been updated!</p>
        </div>
    <?php } ?>

    <?php settings_errors(); ?>

    <?php $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : $this->default_setting_tab; ?>

    <h2 class="nav-tab-wrapper">
        <?php $this->do_tabs($active_tab); ?>
    </h2>

    <form method="POST" action="options.php">
        <?php 
            if ( $active_tab == $this->default_setting_tab ) {
                $this->welcome_tab();    
            } elseif ( $active_tab == 'wp_riotd_section_usage' ) {
                $this->usage_tab();
            } else {
                settings_fields( $active_tab );
                do_settings_sections( $active_tab );
                submit_button( __( 'Save Settings', 'wp_riotd' ) );    
            }
        ?>
    </form>
</div>
