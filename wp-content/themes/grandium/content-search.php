<?php
/**
 * The template part for displaying results in search pages
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage grandium
 * @since grandium 1.0
 */
?>


<!-- ARTICLE -->
<article id="post-<?php the_ID(); ?>" <?php post_class('blog-item no-left-content'); ?>>

	<div class="item-desc">
	
		<?php
			if ( ! is_single() ) :
				the_title( sprintf( '<h2 class="entry-title all-caps"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
			endif;
		?>

		<h5><?php esc_html_e('BY', 'grandium'); ?> <a class="uppercase" href="<?php echo esc_url( get_permalink() ); ?>"><?php the_author(); ?></a> <i class="fa fa-clock-o"></i> <a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_time('F j, Y'); ?></a> <i class="fa fa-bars"></i> <?php the_tags( '', ',', ' '); ?></h5>

		<?php the_excerpt(); ?>

	</div><!-- .entry-footer -->

</article><!-- #post-## -->
