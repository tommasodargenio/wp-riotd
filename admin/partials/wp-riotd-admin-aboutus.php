<?php defined( 'ABSPATH' ) || die( esc_html__('No direct script access allowed!','wp-riotd')); // Prohibit direct script loading. ?>
<h1><?php esc_html_e('About Us', 'wp-riotd' ); ?></h1>
<hr />
<section class="page-content">
    <section class="grid">
        <article>
            <h1><?php esc_html_e('Author and License', 'wp-riotd' ); ?></h1>
            <p>
            <?php esc_html_e('This plugin was written and developed by', 'wp-riotd' ) ?> <a href="https://tommasodargenio.com">Tommaso D'Argenio</a>. <?php esc_html_e('It is licensed as Free Software under GNU General Public License 3 (GPL 3)', 'wp-riotd'); ?>.
            <?php esc_html_e("I'd really appreciate it, if you could rate and review the plugin in the WordPress Plugin Directory.", 'wp-riotd'); ?>
            <?php esc_html_e("Good ratings and constructive feedbacks encourages me to further develop the plugin and to provide support. Thanks!", 'wp-riotd' ); ?>
            </p>
            <p>
                <?php include_once plugin_dir_path( __FILE__ ).'wp-riotd-admin-social-sharing.php'; ?>
            </p>
        </article>
        <article>
            <h1><?php esc_html_e('Acknowledgements', 'wp-riotd' ); ?></h1>
            <p><?php esc_html_e('This work has been inspired, painstakingly tested, and refined with the help of my brother. Thanks for all your support and ideas!', 'wp-riotd' ); ?></p>
            <p><?php esc_html_e('I owe a great deal to my partner Aisling who supported me throughout the development of this and other crazy ideas, and who helped me overcome the fear of publishing and releasing this work to the public.', 'wp-riotd' ); ?> </p>
            <p><?php esc_html_e('To my dear and quirky auntie who always encouraged me and nurtured my brain, I always loved the way she used to say goodbye to me: Ad maiora! (to greater things).', 'wp-riotd' ); ?></p>
        </article>
        <article style="grid-column: 1 / 3;">
            <h1><?php esc_html_e('Help and Support', 'wp-riotd' ); ?></h1>
            <p>
            <?php esc_html_e('Although a lot of care has gone into thoroughly testing this plugin, we couldn\'t possibly cover all cases and different setup scenario, so please bear with us while we improve and fix any issues that you will report.', 'wp-riotd' ); ?>
            </p>
            <p>
            <?php 
                /* translators: 1 is a link  */
                printf(__('Would you have any issue with the plugin, or if you want to request a new feature to be implemented, please open a new ticket on our <a href="%1$s" title="Click to open RIOTD github repository in a new tab" target="_blank">GitHub</a> repository', 'wp-riotd' ),$this->get_github_link().'/issues/new/choose');?>.
            </p>
            <p>
            <?php esc_html_e('Support is provided on best-effort basis, please upload screenshots to show the issue, the debug information shown in the column below called Debug Checkup, and any relevant information to help expedite troubleshooting and resolution.', 'wp-riotd' ); ?>
            </p>
            <p>
            <?php esc_html_e("We would love to hear any feedback and constructive criticisms that could help us improve this plugin and create new one, feature requests will be assessed based on the project's roadmap and mission statement and feedback provided if we decide to implement it or else.", 'wp-riotd' ); ?>                
            </p>
        </article>
        <article>
            <h1><?php esc_html_e('Debug Checkup', 'wp-riotd' ); ?></h1>
            <span style="font-style:italic;font-size:12px;"><?php esc_html_e('Please provide this information in bug and support requests', 'wp-riotd' ); ?></span>
            <p>
            <?php $mysqli = ( isset( $GLOBALS['wpdb'] ) && isset( $GLOBALS['wpdb']->use_mysqli ) && $GLOBALS['wpdb']->use_mysqli && isset( $GLOBALS['wpdb']->dbh ) ); ?>
            <ul style="padding-left:10px;list-style-type: square;">
                <li>Website: <?php echo site_url(); ?></li>
                <li>RIOTD: <?php echo esc_attr($this->version); ?></li>
                <li>RIOTD Settings: <span class="settings_debug"><?php echo esc_attr(WP_RIOTD_Settings::to_base64()); ?></span></li>
                <li>Plugin installed: <?php echo esc_attr(date( 'd/m/Y H:i:s', WP_RIOTD_Settings::get('activation_date') ) ); ?></li>
                <li>Last scraping execution time: <?php echo esc_attr(round(WP_RIOTD_Settings::get('last_scraping_execution_time'), 2).' seconds'); ?></li>
                <li>Last image was scraped on: <?php echo esc_attr(date_i18n('d M, Y H:i:s',WP_RIOTD_Settings::get('last_image_scraped_on'))); ?></li>
                <li>WordPress: <?php echo esc_attr($GLOBALS['wp_version']); ?></li>
                <li>Multisite: <?php echo is_multisite() ? 'yes' : 'no'; ?></li>
                <li>PHP: <?php echo phpversion(); ?></li>
                <li>mysqli Extension: <?php echo $mysqli ? 'true' : 'false'; ?></li>
                <li>mySQL (Server): <?php echo $mysqli ? mysqli_get_server_info( $GLOBALS['wpdb']->dbh ) : '<em>no mysqli</em>'; ?></li>
                <li>mySQL (Client): <?php echo $mysqli ? mysqli_get_client_info( $GLOBALS['wpdb']->dbh ) : '<em>no mysqli</em>'; ?></li>
                <li>UTF-8 conversion: <?php echo ( function_exists( 'mb_detect_encoding' ) && function_exists( 'iconv' ) ) ? 'yes' : 'no'; ?></li>
                <li>WP Memory Limit: <?php echo WP_MEMORY_LIMIT; ?></li>
                <li>Server Memory Limit: <?php echo (int) @ini_get( 'memory_limit' ) . 'M'; ?></li>
                <li>WP_DEBUG: <?php echo WP_DEBUG ? 'true' : 'false'; ?></li>
                <li>WP_POST_REVISIONS: <?php echo is_bool( WP_POST_REVISIONS ) ? ( WP_POST_REVISIONS ? 'true' : 'false' ) : WP_POST_REVISIONS; ?></li>
            </ul>
            </p>            
        </article>
    </section>
</section>