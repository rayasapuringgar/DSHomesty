	<?php 
		if ( ! is_single() ) : 
		if ( has_post_thumbnail() && ot_get_option('grandium_post_format_type_1') == 'on') : 
	?>
		<div id="post-<?php the_ID(); ?>" <?php post_class('blog-item'); ?>>
	<?php else : ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class('blog-item no-left-content'); ?>>
	<?php 
		endif;  
		endif; 
	?>


	<?php 
		if ( has_post_thumbnail() ) : 
		$grandium_att=get_post_thumbnail_id();
		$grandium_image_src = wp_get_attachment_image_src( $grandium_att, 'span5' );
		$grandium_image_src = $grandium_image_src[0]; 
	?>
	
	<?php if ( ot_get_option('grandium_post_format_type_2') != 'on' || ot_get_option('grandium_post_format_type_1') != 'off' ) : ?>
		<img src="<?php echo esc_url($grandium_image_src); ?>"/>
	<?php endif; ?>
		
		<?php if ( ot_get_option('grandium_post_format_type_2') == 'on' || ot_get_option('grandium_post_format_type_1') == 'on' ) : ?>
			<div class="item-media">
				<div class="media-photo">
					<a href="<?php echo esc_url( get_permalink() ); ?>" data-background="<?php echo esc_url($grandium_image_src); ?>" style="background-image: url(<?php echo esc_url($grandium_image_src); ?>);"></a>
				</div>
			</div>
		<?php endif; ?>
		
	<?php endif; ?>
	
	<?php if ( ! is_single() ) : ?>
		<div class="item-desc">
			<?php
				if ( ! is_single() ) :
					the_title( sprintf( '<h2 class="entry-title all-caps"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
				endif;
			?>
			<h5><?php esc_html_e('BY', 'grandium'); ?> <a class="uppercase" href="<?php echo esc_url( get_permalink() ); ?>"><?php the_author(); ?></a> <i class="fa fa-clock-o"></i> <a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_time('F j, Y'); ?></a> <i class="fa fa-bars"></i> <?php the_tags( '', ',', ' '); ?></h5>
			<?php
				/* translators: %s: Name of current post */
				the_content( sprintf(
					esc_html__( 'Continue reading %s', 'grandium' ),
					the_title( '<span class="screen-reader-text">', '</span>', false )
				) );

				wp_link_pages( array(
					'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'grandium' ) . '</span>',
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
					'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'grandium' ) . ' </span>%',
					'separator'   => '<span class="screen-reader-text">, </span>',
				) );
			?>
		</div>
	<?php endif; ?>
	
	<?php if ( is_single() ) : ?>
	
	 <!-- Single Detail -->
		<div class="single-detail">
			<div class="detail-head">
				<?php esc_html_e('BY', 'grandium'); ?> <a class="uppercase" href="<?php echo esc_url( get_permalink() ); ?>"><?php the_author(); ?></a> <i class="fa fa-clock-o"></i> <a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_time('F j, Y'); ?></a> <i class="fa fa-bars"></i> <?php the_tags( '', ',', ' '); ?> <i class="fa fa-commenting-o"></i> <a class="uppercase"href="<?php comments_link(); ?> "><?php comments_number( 'no responses', 'one response', '% responses' ); ?></a>
			</div>
			<div class="detail-content">
				<?php
					/* translators: %s: Name of current post */
					the_content( sprintf(
						esc_html__( 'Continue reading %s', 'grandium' ),
						the_title( '<span class="screen-reader-text">', '</span>', false )
					) );

					wp_link_pages( array(
						'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'grandium' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
						'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'grandium' ) . ' </span>%',
						'separator'   => '<span class="screen-reader-text">, </span>',
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
<?php if ( ! is_single() ) : ?>	
</div>
<?php endif; ?>