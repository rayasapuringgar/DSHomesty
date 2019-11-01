<?php
	wp_nav_menu( array(
		'menu'              => 'main-menu',
		'theme_location'    => 'primary',
		'depth'             => 2,
		'container'         => '',
		'container_class'   => '',
		'menu_class'        => 'nav navbar-nav navbar-right',
		'menu_id'		    => 'main-menu',
		'echo' => true,
		'fallback_cb'       => 'grandium_wp_bootstrap_navwalker::fallback',
		'walker'            => new grandium_wp_bootstrap_navwalker()
	));
?>
 