	<?php
		get_header();
		get_template_part('index_header');
		$grandium_current_blog_page_id = get_option('page_for_posts');
		$grandium_blog_bg = ot_get_option('grandium_blog_background');
		$grandium_blog_bg = $grandium_blog_bg ? $grandium_blog_bg : get_template_directory_uri() . '/img/photo-gallery-1.jpg';
	?>

	<!-- Site Main -->
	<div class="site-main">

		<!-- Section Page Title -->
		<div class="section">
			<div class="widget-page-title">
				<div class="widget-background" data-background="<?php echo esc_url($grandium_blog_bg);?>"></div>
				<div class="wrapper-inner">
					<!-- Title -->
					<?php  if((get_post_meta( $grandium_current_blog_page_id, 'grandium_disable_mini_title', true )!= true) ): ?>
						<?php if(get_post_meta( $grandium_current_blog_page_id, 'grandium_mini_title', true )): ?>
							<h5>
							<?php echo get_post_meta( $grandium_current_blog_page_id, 'grandium_mini_title', true ); ?></h5>
							<?php else : ?>
							<h5><?php esc_html_e('LATEST NEWS', 'grandium'); ?></h5>
						<?php endif; ?>
					<?php endif; ?>

					<?php  if((get_post_meta( $grandium_current_blog_page_id, 'grandium_disable_title', true )!= true) ): ?>
						<?php if(get_post_meta( $grandium_current_blog_page_id, 'grandium_alt_title', true )): ?>
							<h1 class="lead-heading">
							<?php echo get_post_meta( $grandium_current_blog_page_id, 'grandium_alt_title', true ); ?></h1>
							<?php else : ?>
							<h1 class="lead-heading"><?php esc_html_e('Blog Page', 'grandium'); ?></h1>
						<?php endif; ?>
					<?php endif; ?>

					<?php  if((get_post_meta( $grandium_current_blog_page_id, 'grandium_disable_sub_title', true )!= true) ): ?>
						<?php if(get_post_meta( $grandium_current_blog_page_id, 'grandium_subtitle', true )): ?>
							<p>
							<?php echo get_post_meta( $grandium_current_blog_page_id, 'grandium_subtitle', true ); ?></p>
							<?php else : ?>
							<p><?php esc_html_e('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eget commodo orci. Integer varius nibh eu mattis porta. Pellentesque dictum sem eget cursus semper. Nullam quis blandit lorem. Morbi blandit orci urna, eu congue magna faucibus at. In bibendum in mauris nec ultrices. Nunc et magna velit.', 'grandium'); ?></p>
						<?php endif; ?>
					<?php endif; ?>
					<!-- Title End -->
					
					<?php if ( ot_get_option('grandium_breadcrubms') != 'off') : ?>
						<!-- Breadcrumb -->
						<div class="widget-breadcrumb">
							<ul class="widget-breadcrumb-list">
								<?php grandium_breadcrubms(); ?>
							</ul>
						</div>
						<!-- Breadcrumb End -->
					<?php endif; ?>

				</div>
			</div>
		</div>
		<!-- Section Page Title End -->

		<!-- Section Blog -->
		<div class="section">
			<div class="wrapper-inner">
				<div class="row">
					<?php if( ot_get_option( 'grandium_bloglayout' ) == 'right-sidebar' || ot_get_option( 'grandium_bloglayout' ) == '') { ?>
					<div class="col-md-9 right-sidebar-class">
					<?php } elseif( ot_get_option( 'grandium_bloglayout' ) == 'left-sidebar') { ?>
					<?php get_sidebar(); ?>
					<div class="col-md-9 left-sidebar-class">
					<?php } elseif( ot_get_option( 'grandium_bloglayout' ) == 'full-width') { ?>
					<div class="col-xs-12 full-width-index">
					<?php } ?>
						<div class="widget-blog-list">
							<?php if ( have_posts() ) : ?>
								<?php while ( have_posts() ) : the_post(); ?>
									<?php get_template_part( 'post-format/content', get_post_format() ); ?>
								<?php endwhile; ?>
								<?php the_posts_pagination( array(
										'prev_text'          => esc_html__( 'Previous page', 'grandium' ),
										'next_text'          => esc_html__( 'Next page', 'grandium' ),
										'before_page_number' => '<span class="meta-nav screen-reader-text"></span>',
									) ); ?>
							<?php else : ?>
							<?php get_template_part( 'content', 'none' ); ?>
							<?php endif; ?>
						</div>
					</div>

					<?php if( ot_get_option( 'grandium_bloglayout' ) == 'right-sidebar' || ot_get_option( 'grandium_bloglayout' ) == '') { ?>
						<?php get_sidebar(); ?>
					<?php } ?>
				</div>
			</div>
		</div>

	</div>


	<?php get_footer(); ?>
