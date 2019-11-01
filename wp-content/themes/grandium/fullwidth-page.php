	<?php
		/*
		Template name: Fullwidth Template
		*/

		// theme header
		get_header();

		// theme header content
		get_template_part('index_header');

		$grandium_headerbgcolor 		= 	rwmb_meta('grandium_headerbgcolor' );
		$grandium_headertextcolor 		= 	rwmb_meta('grandium_pagetextcolor' );
		$grandium_headerpaddingtop 		= 	rwmb_meta('grandium_headerptop' );
		$grandium_headerpaddingbottom 	= 	rwmb_meta('grandium_headerpbottom' );
		$grandium_pagelayout 			= 	rwmb_meta('grandium_pagelayout' );
		$grandium_disable_mini_title 	= 	rwmb_meta('grandium_disable_mini_title' );

		$grandium_att					=	get_post_thumbnail_id();
		$grandium_image_src 			= 	wp_get_attachment_image_src( $grandium_att, 'full' );
		$grandium_image_src 			= 	$grandium_image_src[0];
	?>

	<style>
		<?php if ($grandium_headertextcolor): ?>
			.breadcrumbs a,
			.subpage-head.page-header ,
			.subpage-head.page-header h3,
			span.breadcrumb-current{ color :<?php echo esc_attr( $grandium_headertextcolor ); ?> ; }
		<?php endif; ?>
		<?php if ($grandium_headerbgcolor): ?>
			.subpage-head { background-color :<?php echo esc_attr( $grandium_headerbgcolor ); ?>; }
		<?php endif; ?>
		<?php if ($grandium_image_src): ?>
		   .page-template-fullwidth-page .widget-background  {
				background: url(<?php echo esc_url( $grandium_image_src ); ?>) no-repeat center center fixed !important;
				background-size: cover !important;
			
			}
		<?php endif; ?>
		<?php if ($grandium_headerpaddingtop || $grandium_headerpaddingbottom ): ?>
			.subpage-head.page-header  {
				padding-top :<?php echo esc_attr( $grandium_headerpaddingtop ); ?>px ;
				padding-bottom :<?php echo esc_attr( $grandium_headerpaddingbottom ); ?>px ;
			}
		<?php endif; ?>
	</style>

<!-- Site Main -->
<div class="site-main">
	<!-- Section Page Title -->
	<div class="section subpage-head page-header">
		<div class="widget-page-title">
			<div class="widget-background" data-background="<?php echo esc_url( $grandium_image_src ); ?>"></div>
			<div class="wrapper-inner">

				<!-- Title -->
				<?php  if((get_post_meta( get_the_ID(), 'grandium_disable_mini_title', true )!= true) ): ?>
					<?php if(get_post_meta( get_the_ID(), 'grandium_mini_title', true )): ?>
						<h5 class="lead-heading">
						<?php echo get_post_meta( get_the_ID(), 'grandium_mini_title', true ); ?></h5>
					<?php else : ?>
						<h5 class="lead-heading"><?php echo esc_html_e( 'Default Page' , 'grandium' ); ?></h5>
					<?php endif; ?>
				<?php endif; ?>

				<?php  if((get_post_meta( get_the_ID(), 'grandium_disable_alt_title', true )!= true) ): ?>
					<?php if(get_post_meta( get_the_ID(), 'grandium_alt_title', true )): ?>
						<h1><?php echo get_post_meta( get_the_ID(), 'grandium_alt_title', true ); ?></h1>
						<?php else : ?>
						<h1><?php the_title(); ?></h1>
					<?php endif; ?>
				<?php endif; ?>

				<?php  if((get_post_meta( get_the_ID(), 'grandium_disable_sub_title', true )!= true) ): ?>
					<?php if(get_post_meta( get_the_ID(), 'grandium_subtitle', true )): ?>
						<p><?php echo get_post_meta( get_the_ID(), 'grandium_subtitle', true ); ?></p>
						<?php else : ?>
						<p><?php echo esc_html_e('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eget commodo orci. Integer varius nibh eu mattis porta. Pellentesque dictum sem eget cursus semper. Nullam quis blandit lorem. Morbi blandit orci urna, eu congue magna faucibus at. In bibendum in mauris nec ultrices. Nunc et magna velit.' , 'grandium' ); ?></p>
					<?php endif; ?>
				<?php endif; ?>
				<!-- Title End -->

			
				<?php if ( ot_get_option('grandium_breadcrubms') != 'off') : ?>
					<!-- Breadcrumb -->
					<div class="widget-breadcrumb">
						
							<?php if ( function_exists('bcn_display') ) :  ?>
								<?php bcn_display(); ?>
							<?php else : ?>
								<ul class="widget-breadcrumb-list">
									<?php grandium_breadcrubms(); ?>
								</ul>
							<?php endif; ?>
					</div>
					<!-- Breadcrumb End -->
				<?php endif; ?>
				

			</div>
		</div>
	</div>
	<!-- Section Page Title End -->

	<?php
		// page content
		if ( have_posts() ) :
			while ( have_posts() ) : the_post();
				the_content();
			endwhile;
		endif;
	?>

	</div>
	<!-- Site Main End -->

	<?php
		// theme footer
		get_footer();
	?>
