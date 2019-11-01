<?php
	get_header();
	get_template_part('index_header');
?>

<!-- Site Main -->
<div class="site-main">
	<!-- Section Page Title -->
	<div class="section">
		<div class="widget-page-title">
			<div class="widget-background" data-background="<?php echo get_template_directory_uri() . '/img/photo-gallery-1.jpg';?>"></div>
			<div class="wrapper-inner">
				<!-- Title -->
				<?php if ( ot_get_option( 'grandium_search_slogan_visibility' )!= 'off') : ?>
					<?php if ( ot_get_option( 'grandium_search_slogan' )!= '') : ?>
						<h5><?php echo ( ot_get_option( 'grandium_search_slogan' )); ?></h5>
						<?php else : ?>
						<h5><?php esc_html_e('Search Page', 'grandium'); ?></h5>
					<?php endif; ?>
				<?php endif; ?>


				<?php if ( ot_get_option( 'grandium_search_heading_visibility' )!= 'off') : ?>
					<?php if ( ot_get_option( 'grandium_search_heading' )!= '') : ?>
						<h1 class="lead-heading"><?php echo ( ot_get_option( 'grandium_search_heading' )); ?></h1>
						<?php else : ?>
						<h1 class="lead-heading"><?php echo esc_html( $wp_query->found_posts ); ?> <?php esc_html_e( 'Results found for', 'grandium' ); ?>: "<?php the_search_query(); ?>"</h1>
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

				<?php if( ot_get_option( 'grandium_searchlayout' ) == 'right-sidebar' || ot_get_option( 'grandium_searchlayout' ) == '' ) { ?>
				<div class="col-md-9 right-sidebar-class">
				<?php } elseif( ot_get_option( 'grandium_searchlayout' ) == 'left-sidebar') { ?>
				<?php get_sidebar(); ?>
				<div class="col-md-9 left-sidebar-class">
				<?php } elseif( ot_get_option( 'grandium_searchlayout' ) == 'full-width') { ?>
				<div class="col-xs-12 full-width-index">
				<?php } ?>

					<div class="widget-blog-list">
						<?php if ( have_posts() ) : ?>
							<?php
							// Start the loop.
							while ( have_posts() ) : the_post();
								/*
								 * Include the Post-Format-specific template for the content.
								 * If you want to override this in a child theme, then include a file
								 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
								 */
								get_template_part( 'content', 'search' );
							// End the loop.
							endwhile;
							// Previous/next page navigation.
							the_posts_pagination( array(
								'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'grandium' ) . ' </span>',
							) );
						// If no content, include the "No posts found" template.
						else :
							get_template_part( 'content', 'none' );
						endif;
						?>
						<?php wp_link_pages(); ?>
					</div><!-- #end single-detail -->
				</div><!-- #end sidebar+ content -->

				<?php if( ot_get_option( 'grandium_searchlayout' ) == 'right-sidebar' || ot_get_option( 'grandium_searchlayout' ) == '' ) { ?>
					<?php get_sidebar(); ?>
				<?php } ?>

			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>
