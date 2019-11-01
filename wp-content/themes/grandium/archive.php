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
				<?php if ( ot_get_option( 'grandium_archive_heading_visibility' )!= 'off') : ?>
					<?php if ( ot_get_option( 'grandium_archive_heading' )!= '') : ?>
						<h5 class="lead-heading"><?php echo ( ot_get_option( 'grandium_archive_heading' )); ?></h5> 
						<?php else : ?>
						<h5 class="lead-heading"><?php echo esc_html_e('Our Archive','grandium');?></h5>
					<?php endif; ?>
				<?php endif; ?>

				<?php if ( ot_get_option( 'grandium_archive_slogan_visibility' )!= 'off') : ?>	
					<?php if ( ot_get_option( 'grandium_archive_slogan' )!= '') : ?>
						<h1><?php echo ( ot_get_option( 'grandium_archive_slogan' )); ?></h1> 
						<?php else : ?>
						<h1><?php the_archive_title(); ?></h1>
					<?php endif; ?>
				<?php endif; ?>
				
		
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
		

			<?php if( ot_get_option( 'grandium_archivelayout' ) == 'right-sidebar' || ot_get_option( 'grandium_archivelayout' ) == '' ) { ?>
			<div class="col-md-9 right-sidebar-class">
			<?php } elseif( ot_get_option( 'grandium_archivelayout' ) == 'left-sidebar') { ?>
			<?php get_sidebar(); ?>
			<div class="col-md-9 left-sidebar-class">
			<?php } elseif( ot_get_option( 'grandium_archivelayout' ) == 'full-width') { ?>
			<div class="col-xs-12 full-width-index">
			<?php } ?>
			
				<div class="widget-blog-list">
					<?php 
					if ( have_posts() ) : 
					while ( have_posts() ) : 
					the_post();
							get_template_part( 'post-format/content', get_post_format() );
						endwhile;
						the_posts_pagination( array(
							'prev_text'          => esc_html__( 'Previous page', 'grandium' ),
							'next_text'          => esc_html__( 'Next page', 'grandium' ),
							'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'grandium' ) . ' </span>',
						) );
						else :
							get_template_part( 'content', 'none' );
						endif;
					?>
				</div><!-- #end content -->
				
			</div><!-- #end sidebar+ content -->
			
			<?php if( ot_get_option( 'grandium_archivelayout' ) == 'right-sidebar' || ot_get_option( 'grandium_archivelayout' ) == '' ) { ?>
				<?php get_sidebar(); ?>
			<?php } ?>
				
			</div>
		</div>
	</div><!-- Section Blog End -->
	
</div><!-- Site Main End -->
<?php get_footer(); ?>