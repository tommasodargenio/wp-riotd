<?php defined( 'ABSPATH' ) || die( 'No direct script access allowed!' ); // Prohibit direct script loading. ?>
<h1>About Us</h1>
<hr />
<section class="page-content">
    <section class="grid">
        <article>
            <h1>Author and License</h1>
            <p>
            This plugin was written and developed by <a href="https://tommasodargenio.com">Tommaso D'Argenio</a>. It is licensed as Free Software under GNU General Public License 3 (GPL 3).
            I'd really appreciate it, if you could rate and review the plugin in the WordPress Plugin Directory.
            Good ratings and constructive feedbacks encourages me to further develop the plugin and to provide support. Thanks!
            </p>
            <p>
                <?php include_once plugin_dir_path( __FILE__ ).'wp-riotd-admin-social-sharing.php'; ?>
            </p>
        </article>
        <article>
            <h1>Acknowledgements</h1>
            <p>This work has been inspired, painstakingly tested, and refined by my brother. Thanks for all you support and ideas!</p>
            <p>I owe a great deal to my partner Aisling who supported me throughout the development of this and other crazy ideas, and who helped me overcome the fear of publishing and releasing this work to the public.</p>
            <p>To my dear and quirky auntie who always encouraged me and nurtured my brain, I always loved the way she used to say goodbye to me: Ad maiora! (to greater things).</p>
        </article>
        <article style="grid-column: 1 / 3;">
            <h1>Help and Support</h1>
            <p>
            Although a lot of care has gone into thoroughly testing this plugin, we couldn't possibly cover all cases and different setup scenario, so please bear with us while we improve and fix any issues that you will report.
            </p>
            <p>
            Would you have any issue with the plugin, or if you want to request a new feature to be implemented, please open a new ticket on the <a href="<?php $this->get_github_link(true); ?>/issues/new/choose" title="Click to open RIOTD github repository in a new tab" target="_blank">github</a> repository.
            </p>
            <p>
            Support is provided on best-effort basis, please upload screenshots to show the issue, the debug information shown in the column below called Debug Checkup, and any relevant information to help expedite troubleshooting and resolution.
            </p>
            <p>
            We would love to hear any feedback and constructive criticisms that could help us improve this plugin and create new one, feature requests will be assessed based on the project's roadmap and mission statement and feedback provided if we decide to implement it or else.                
            </p>
        </article>
        <article>
            <h1>Debug Checkup</h1>
            <span style="font-style:italic;font-size:12px;">Please provide this information in bug and support requests</span>
            <p>
            <?php $mysqli = ( isset( $GLOBALS['wpdb'] ) && isset( $GLOBALS['wpdb']->use_mysqli ) && $GLOBALS['wpdb']->use_mysqli && isset( $GLOBALS['wpdb']->dbh ) ); ?>
            <ul style="padding-left:10px;list-style-type: square;">
                <li>Website: <?php echo site_url(); ?></li>
                <li>RIOTD: <?php echo $this->version; ?></li>
                <li>RIOTD Settings: <span class="settings_debug"><?php echo WP_RIOTD_Settings::to_base64(); ?></span></li>
                <li>Plugin installed: <?php echo date( 'd/m/Y H:i:s', WP_RIOTD_Settings::get('activation_date') ); ?></li>
                <li>WordPress: <?php echo $GLOBALS['wp_version']; ?></li>
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