<?php
/**
 * The template for displaying posts in the Video post format.
 *
 * @package WordPress
 * @subpackage grandium_
 * @since grandium_ 1.0
 */
?>


<?php if ( has_post_thumbnail() && ot_get_option('grandium_post_format_type_1') == 'on' || ! is_single() ) : ?>
<div id="post-<?php the_ID(); ?>" <?php post_class('blog-item'); ?>>
<?php else : ?>
<div id="post-<?php the_ID(); ?>" <?php post_class('blog-item no-left-content'); ?>>
<?php endif; ?>



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
				<div class="media-video video-full">
					<?php
						$grandium_embed = rwmb_meta('grandium_video_embed', 'type=textarea');
						if($grandium_embed!='') :
						echo wp_kses( $grandium_embed, grandium_allowed_html() ); 
						else :
						$grandium_m4v = rwmb_meta('grandium_video_m4v', 'type=text');
						$grandium_ogv = rwmb_meta('grandium_video_ogv', 'type=text');
						$grandium_webm = rwmb_meta('grandium_video_webm', 'type=text');
						$grandium_image_id = get_post_thumbnail_id();
						$grandium_image_url = wp_get_attachment_image_src($grandium_image_id, true);
						$grandium_wp_video = '[video poster="'.$grandium_image_url[0].'" mp4="'.$grandium_m4v.'"  webm="'.$grandium_webm.'"]';
						echo do_shortcode ($grandium_wp_video);
						endif;
					?>
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
