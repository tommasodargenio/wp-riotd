<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <?php if ( isset($_GET['settings-updated']) && $_GET['settings-updated'] ) {?>
        <div class="notice notice-success is-dismissible">
            <p>Your settings have been updated!</p>
        </div>
    <?php } ?>
    <form method="POST" action="options.php">
        <?php 
            settings_fields( 'wp_riotd' ); 
            do_settings_sections( 'wp_riotd' );
            submit_button( __( 'Save Settings', 'wp_riotd' ) );
        ?>
    </form>
</div>
