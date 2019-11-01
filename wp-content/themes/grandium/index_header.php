
<!-- Site Header -->
<?php if ( ot_get_option('grandium_sticky_menu_display') == 'on' ) : ?>
<div class="site-header sticky-header">
<?php else : ?>
<div class="site-header">
<?php endif; ?>

	<?php if ( ot_get_option('grandium_header_top') != 'off') : ?>
    <!-- Header Top -->
    <div class="header-top">
        <div class="wrapper">

			<?php if ( ot_get_option('grandium_header_top_contact') != 'off') : ?>
				<div class="header-contact">
					<ul>
						<li><?php echo wp_kses( ot_get_option( 'grandium_header_top_number' ), grandium_allowed_html() ) ?></li>
						
						<?php if ( ot_get_option('grandium_social_top_display') != 'off') : ?>
						<?php
							$grandium_social_item = ot_get_option( 'grandium_social_top' );
							if ($grandium_social_item) {
								foreach($grandium_social_item as $key => $value) {
									$grandium_top_target = ot_get_option('grandium_social_top_target');
									echo '<a href="' .esc_url($value['grandium_social_top_link']). '" target="' .esc_attr($grandium_top_target). '" class="icon fa fa-' .esc_attr($value['grandium_social_top_text']). '" title="' .esc_html($value['grandium_social_top_text']). '"></a>';
								}
							} else {
						?>
							<li><a href="#" target="_blank"><i class="fa fa-facebook"></i></a></li>
							<li><a href="#" target="_blank"><i class="fa fa-twitter"></i></a></li>
							<li><a href="#" target="_blank"><i class="fa fa-google-plus"></i></a></li>
							<li><a href="#" target="_blank"><i class="fa fa-instagram"></i></a></li>
						<?php } ?>
						<?php endif; ?>
					</ul>
				</div>
			<?php endif; ?>

			<?php if ( ot_get_option('grandium_header_top_lang') != 'off') : ?>
				<div class="header-lang">
					<ul>

						<?php
							$grandium_lang_item = ot_get_option( 'grandium_header_language' );
							if ($grandium_lang_item) {
								foreach($grandium_lang_item as $key => $lang_value) {
									echo '<li  class="' .esc_attr($lang_value['grandium_lang_active']). '"><a href="' .esc_url($lang_value['grandium_lang_link']). '" title="' .esc_html($lang_value['grandium_lang_text']). '">' .esc_html($lang_value['grandium_lang_text']). '</a></li>';
								}
							} else {
						?>
						<li class="active"><a href="#0"><?php echo esc_html_e( 'EN', 'grandium' ); ?></a></li>
						<li><a href="#0"><?php echo esc_html_e( 'TR', 'grandium' ); ?></a></li>
						<li><a href="#0"><?php echo esc_html_e( 'DE', 'grandium' ); ?></a></li>
						<?php } ?>

					</ul>
				</div>
			<?php endif; ?>

        </div>
    </div>
    <!-- Header Top End -->
	<?php endif; ?>

    <!-- Header Bottom -->
    <div class="header-bottom">
        <div class="wrapper">
            <div class="header-logo">

                <?php if ( ot_get_option('grandium_logo_type') == 'img' || ot_get_option('grandium_logo_type') == '') : ?>
					<?php if ( ot_get_option( 'grandium_logoimg' ) ) : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="header-logo"><img src="<?php echo esc_url( ot_get_option( 'grandium_logoimg' ) ) ?>" alt="<?php echo esc_html_e( 'grandium Theme', 'grandium' ); ?>"></a> <!-- Your Logo -->
						<?php  else : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="header-logo"><img src="<?php echo get_template_directory_uri() . '/img/logo.png';?>" alt="<?php echo esc_html_e( 'grandium Theme', 'grandium' ); ?>"></a> <!-- Your Logo -->
					<?php endif; ?>
				<?php endif; ?>

				<?php if ( ot_get_option('grandium_logo_type') == 'text') : ?>
					<?php if ( ot_get_option( 'grandium_textlogo' ) ) : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="brand"><?php echo esc_html( ot_get_option( 'grandium_textlogo' ) ) ?></a> <!-- Your Logo -->
						<?php  else : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="brand"><?php echo esc_html_e( 'grandium', 'grandium' ); ?></a> <!-- Your Logo -->
					<?php endif; ?>
				<?php endif; ?>

            </div>

            <div class="header-nav">

				<?php
					wp_nav_menu( array(
						'menu'              => 'main-menu-left',
						'theme_location'    => 'primary-left',
						'depth'             => 3,
						'container'         => '',
						'container_class'   => '',
						'menu_class'        => 'nav-left',
						'menu_id'		    => 'main-menu-left',
						'echo' => true,
						'fallback_cb'       => 'grandium_wp_bootstrap_navwalker::fallback',
						'walker'            => new grandium_wp_bootstrap_navwalker()
					));

					wp_nav_menu( array(
						'menu'              => 'main-menu-right',
						'theme_location'    => 'primary-right',
						'depth'             => 3,
						'container'         => '',
						'container_class'   => '',
						'menu_class'        => 'nav-right',
						'menu_id'		    => 'main-menu-right',
						'echo' => true,
						'fallback_cb'       => 'grandium_wp_bootstrap_navwalker::fallback',
						'walker'            => new grandium_wp_bootstrap_navwalker()
					));
				?>

            </div>

            <div class="header-toggle">
                <i class="fa fa-bars"></i>
            </div>

        </div>
    </div>
    <!-- Header Bottom End -->
</div>
<!-- Site Header End -->
