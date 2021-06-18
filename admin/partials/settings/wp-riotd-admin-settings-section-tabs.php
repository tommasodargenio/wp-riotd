<?php defined( 'ABSPATH' ) || die( esc_html__('No direct script access allowed!' ,'wp-riotd')); // Prohibit direct script loading. ?>
<a href="?page=<?php echo $_GET['page']; ?>&tab=<?php echo $section['uid']; ?>" class="nav-tab <?php echo $active_tab == $section['uid'] ? 'nav-tab-active' : ''; ?>"><?php echo $section['label']; ?></a>
