<?php defined( 'ABSPATH' ) || die( esc_html__('No direct script access allowed!' ,'wp-riotd')); // Prohibit direct script loading. ?>
<a href="?page=<?php echo esc_attr($_GET['page']); ?>&tab=<?php echo esc_attr($section['uid']); ?>" class="nav-tab <?php echo $active_tab == $section['uid'] ? 'nav-tab-active' : ''; ?>"><?php esc_html_e($section['label'],'wp-riotd'); ?></a>
