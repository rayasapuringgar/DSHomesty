	

	<div id="post-<?php the_ID(); ?>" <?php post_class('blog-item'); ?>>

		<?php 
			$grandium_images = rwmb_meta( 'grandium_gallery_image', 'type=image_advanced' );
			if (
			ot_get_option('grandium_post_format_type_2') == 'on' || ot_get_option('grandium_post_format_type_1') == 'on' ||
			ot_get_option('grandium_post_format_type_2') == '' || ot_get_option('grandium_post_format_type_1') == '' 
			) : 
		?>
		<?php if ( ! is_single() ) : ?>
			<div class="item-media">
		<?php endif; ?>
		<?php if (  is_single() ) : ?>
			<div class="single-media">
		<?php endif; ?>
				<div class="media-gallery">
					<div class="media-carousel owl-carousel owl-theme owl-type1">
						<?php
							foreach ( $grandium_images as $image ) {
								echo "<a href=''. esc_url( get_permalink() ) .'' data-background='{$image['full_url']}'></a>";
							}
						?>
						
					</div>
				</div>
			</div>
		<?php endif; ?>
		
	
	<?php if ( ! is_single() ) : ?>
		<div class="item-desc">
			<?php
				if ( ! is_single() ) :
					the_title( sprintf( '<h2 class="entry-title all-caps"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
				endif;
			?>
			<h5><?php esc_html_e('BY', 'grandium'); ?> <a class="uppercase" href="<?php echo esc_url( get_permalink() ); ?>"><?php the_author(); ?></a> <i class="fa fa-clock-o"></i> <a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_time('F j, Y'); ?></a> <i class="fa fa-bars"></i> <?php the_tags( '', ',', ' '); ?></h5>
			<?php the_excerpt(); ?>

		</div>
	<?php endif; ?>
	
	<?php if ( is_single() ) : ?>
	
	 <!-- Single Detail -->
		<div class="single-detail">
			<div class="detail-head">
				<?php esc_html_e('BY', 'grandium'); ?> 
				<a class="uppercase" href="<?php echo esc_url( get_permalink() ); ?>"><?php the_author(); ?></a> 
				<i class="fa fa-clock-o"></i> <a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_time('F j, Y'); ?></a> 
				<?php if ( the_tags() ) : ?><i class="fa fa-bars"></i> <?php the_tags( '', ',', ' '); ?> <?php endif; ?>
				<i class="fa fa-commenting-o"></i> 
				<a class="uppercase"href="<?php comments_link(); ?> "><?php comments_number( 'no responses', 'one response', '% responses' ); ?></a>
			</div>
			<div class="detail-content">
				<?php
					/* translators: %s: Name of current post */
					the_content( sprintf(
						esc_html__( 'Continue reading %s', 'grandium' ),
						the_title( '<span class="screen-reader-text">', '</span>', false )
					) );
				?>
			</div>
			
			<div class="detail-tags">
				<h5><?php esc_html_e( 'TAGS', 'grandium'); ?></h5>
					<?php the_tags( '<ul><li>', '</li><li>', '</li></ul>' ); ?>
			</div>
			
		</div>
		<!-- Single Detail End -->
	<?php endif; ?>
</div>

