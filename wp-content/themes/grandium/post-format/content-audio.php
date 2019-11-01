
	<?php if ( has_post_thumbnail() && ot_get_option('grandium_post_format_type_1') == 'on' || ! is_single() ) : ?>
	<div id="post-<?php the_ID(); ?>" <?php post_class('blog-item'); ?>>
	<?php else : ?>
	<div id="post-<?php the_ID(); ?>" <?php post_class('blog-item no-left-content'); ?>>
	<?php endif; ?>

    <?php
		$grandium_mp3 		= rwmb_meta('grandium_audio_mp3', 'type=text');
		$grandium_oga 		= rwmb_meta('grandium_audio_ogg', 'type=text');
		$grandium_sc_url 	= rwmb_meta('grandium_audio_sc', 'type=text');
		$grandium_sc_color 	= rwmb_meta('grandium_audio_sc_color', 'type=color');
		$grandium_wp_audio 	= '[audio mp3="'.$grandium_mp3.'"  ogg="'.$grandium_oga.'"]';
		$grandium_soundcloud_audio 	= '<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url='.urlencode($grandium_sc_url).'&amp;show_comments=true&amp;auto_play=false&amp;color='.$grandium_sc_color.'"></iframe>';
	?>

		<?php

			if (
			ot_get_option('grandium_post_format_type_2') == 'on' || ot_get_option('grandium_post_format_type_1') == 'on' ||
			ot_get_option('grandium_post_format_type_2') == '' || ot_get_option('grandium_post_format_type_1') == ''
			) :
			if ( ! is_single() ) :
		 ?>
			<div class="item-media">
		<?php endif; ?>
		<?php if (  is_single() ) : ?>
			<div class="single-media">
		<?php endif; ?>
				<div class="media-photo">
					<?php if($grandium_sc_url!='') : ?>
						<?php echo wp_kses( $grandium_soundcloud_audio, grandium_allowed_html() );  ?>
					<?php else : ?>
						<div class="post-thumb blog-bg">
							<?php if(has_post_thumbnail()) : the_post_thumbnail(); endif; ?>
							<?php echo do_shortcode ($grandium_wp_audio); ?>
						</div>
					<?php endif; ?>
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
