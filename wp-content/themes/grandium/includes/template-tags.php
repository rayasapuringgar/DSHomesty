<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package grandium
 */

if ( ! function_exists( 'grandium_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @return void
 */
function grandium_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<ul class="pager">

			<?php if ( get_next_posts_link() ) : ?>
			<li class="previous"><?php next_posts_link( esc_html__( ' Older posts', 'grandium' ) ); ?></li>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<li class="next"><span class="icon-facebook"></span><?php previous_posts_link( esc_html__( 'Newer posts ', 'grandium' ) ); ?></li>
			<?php endif; ?>

		</ul><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'grandium_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 *
 * @return void
 */
function grandium_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<!-- Navigation -->
	<ul class="pager">
		<li class="previous"><?php previous_post_link( '%link', _x( '<i class="fa fa-angle-left"></i> %title ', 'Previous post link', 'grandium' ) ); ?></li>
		<li class="next"><?php next_post_link(     '%link', _x( '%title <i class="fa fa-angle-right"></i> ', 'Next post link',     'grandium' ) ); ?><li>
	</ul>
	<?php
}
endif;

if ( ! function_exists( 'grandium_post_nav_old' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 *
 * @return void
 */
function grandium_post_nav_old() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<!-- Navigation -->
	<ul class="pager">
	<?php $next_post = get_next_post();
	if (!empty( $next_post )):
	$nexty=$next_post->post_title;
	if (strlen($nexty) > 15){$newshort = substr($nexty,0,25).'...';}else{$newshort=$nexty;}
	endif; ?>
	
	<?php $prev_post = get_previous_post();
	if (!empty( $prev_post )):
	$previ=$prev_post->post_title;
	if (strlen($previ) > 15){$newshortprev = substr($previ,0,25).'...';}else{$newshortprev=$previ;}
	endif; ?>

	
		<li class="previous"><?php if (!empty( $prev_post )): next_post_link('%link', $newshortprev ); endif; ?></li>
		<li class="next"><?php if (!empty( $next_post )): next_post_link('%link', $newshort ); endif; ?><li>
	</ul>
	<?php
}
endif;