<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Nine_grandium
 * @since Nine grandium 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('widget-blog-single'); ?>>

	<div class="single-detail">
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
	</div><!-- .entry-content -->

</article><!-- #post-## -->

