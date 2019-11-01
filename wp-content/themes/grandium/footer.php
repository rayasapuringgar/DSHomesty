<?php
/**
* The template for displaying the footer
*
*
* @package WordPress
* @subpackage grandium
* @since grandium 1.0
*/
?>
	<?php if ( ot_get_option('grandium_top_footerwd') == 'on') : ?>
		<div class="footer-top">
			<div class="container">
				<div class="row">
					<?php if ( is_active_sidebar( 'grandium_widgetize_footer' ) ) { ?>
						<?php dynamic_sidebar( 'grandium_widgetize_footer' ); ?>
					<?php } ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
	
	<!-- Site Footer -->
	<div class="site-footer">
		<!-- Footer Top -->
		<div class="footer-top">
			<div class="wrapper">
				<div class="row">
					
					<div class="col-lg-6">
						<?php if ( ot_get_option('grandium_social_section') != 'off') : ?>
							<h5><?php echo esc_html( ot_get_option( 'grandium_footer_social_head' ) ) ?></h5>
							<h6><?php echo esc_html( ot_get_option( 'grandium_footer_social_desc' ) ) ?></h6>
							<div class="widget-social-icons">
						   <ul>
								<?php 
									$grandium_social_item = ot_get_option( 'grandium_social_item' );
									if ($grandium_social_item) {
										foreach($grandium_social_item as $key => $value) {
											$grandium_target = ot_get_option('grandium_social_target');
											echo '<li><a href="' .esc_url($value['grandium_social_link']). '" target="' .esc_attr($grandium_target). '" class="icon fa fa-' .esc_attr($value['grandium_social_text']). '" title="' .esc_html($value['grandium_social_text']). '"></a></li>';
										}
									} else { 
								?> 
									<li><a href="#" target="_blank"><i class="fa fa-facebook"></i></a></li>
									<li><a href="#" target="_blank"><i class="fa fa-twitter"></i></a></li>
									<li><a href="#" target="_blank"><i class="fa fa-google-plus"></i></a></li>
									<li><a href="#" target="_blank"><i class="fa fa-instagram"></i></a></li>
								<?php } ?>
							</ul>
							</div>
						<?php endif; ?>
					</div>
					
					<?php if ( ot_get_option('grandium_newsletter_section') != 'off') : ?>
					<div class="col-lg-6">
						<h5><?php echo esc_html( ot_get_option( 'grandium_footer_newsletter_head' ) ) ?></h5>
						<h6><?php echo esc_html( ot_get_option( 'grandium_footer_newsletter_desc' ) ) ?></h6>
						<div class="widget-newsletter">
						<?php if ( is_active_sidebar( 'grandium_newsletter_footer' ) ) : ?>
							<?php dynamic_sidebar( 'grandium_newsletter_footer' ); ?>
						<?php else : ?>
							<form>
								<h6><?php esc_html_e('Please add a newsletter form', 'grandium'); ?></h6>
							</form>
						<?php endif; ?>
						</div>
					</div>
					<?php endif; ?>
					
				</div>
			</div>
		</div>
		<!-- Footer Top End -->
		<!-- Footer Bottom -->
		<div class="footer-bottom">
			<div class="wrapper">
				<div class="footer-logo">
				
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
				
				<?php if ( ot_get_option('grandium_footer_powered_area') != 'off') : ?>
					<div class="footer-copyright">
						<?php 
							if ( ot_get_option('grandium_copyright') != '') : 
							$grandium_copyright = ot_get_option('grandium_copyright');

							$grandium_allowed_tags = array(
								'br' => array(),
								'strong' => array(),
								'a' => array(
									'href' => array(),
									'title' => array()
								)
							);
							echo wp_kses( $grandium_copyright, $grandium_allowed_tags ); 
							else :
						?>
							<p><?php echo esc_html_e( 'COPYRIGHT', 'grandium' ); ?> <?php echo esc_html_e( 'THE grandium HOTEL', 'grandium' ); ?></p>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				
				<div class="footer-contact">
					<ul>
						<?php if ( ot_get_option('grandium_footer_adress_area') != 'off') : ?>
							<?php if ( ot_get_option( 'grandium_footer_adress' ) ) : ?>
								<li><i class="fa fa-map-marker"></i> <?php echo esc_html( ot_get_option( 'grandium_footer_adress' ) ) ?></li>
								<?php  else : ?>
								<li><i class="fa fa-map-marker"></i> <?php echo esc_html_e( 'LONGRIDGE ROAD, EARLS COURT, LONDON', 'grandium' ); ?></li>
							<?php endif; ?>
						<?php endif; ?>
						
						<?php if ( ot_get_option('grandium_footer_phone_area') != 'off') : ?>
							<?php if ( ot_get_option( 'grandium_footer_phone' ) ) : ?>
								<li><i class="fa fa-phone"></i><?php echo esc_html( ot_get_option( 'grandium_footer_phone' ) ) ?></li>
								<?php  else : ?>
								<li><i class="fa fa-phone"></i> <?php echo esc_html_e( '+1-800-123-45-67', 'grandium' ); ?></li>
							<?php endif; ?>	
						<?php endif; ?>	
						
						<?php if ( ot_get_option('grandium_footer_mail_area') != 'off') : ?>
							<?php if ( ot_get_option( 'grandium_footer_mail' ) ) : ?>
								<li><a href="<?php echo esc_html( ot_get_option( 'grandium_footer_mail' ) ) ?>" target="_top"><i class="fa fa-paper-plane"></i> <?php echo esc_html( ot_get_option( 'grandium_footer_mail_text' ) ) ?></a></li>
								<?php  else : ?>
								<li><a href="#0"><i class="fa fa-paper-plane"></i> <?php echo esc_html_e( 'INFO@dewisriguesthouse.COM', 'grandium' ); ?></a></li>
							<?php endif; ?>
						<?php endif; ?>
					</ul>
				</div>
				<div class="footer-nav">
					<?php
						wp_nav_menu( array(
							'menu'              => 'footer-nav',
							'theme_location'    => 'footer',
							'depth'             => 1,
							'menu_class'        => 'footer-nav',
							'menu_id'		    => 'footer-nav',
							'echo' => true
						));
					?>
				</div>
			</div>
		</div>
		<!-- Footer Bottom End -->
	</div>
	<!-- Site Footer End -->

      
	<?php wp_footer(); ?>
	</body>
</html>