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
				<?php if ( ot_get_option( 'grandium_error_heading_visibility' )!= 'off') : ?>
					<?php if ( ot_get_option( 'grandium_error_heading' )!= '') : ?>
						<h5 class="lead-heading"><?php echo ( ot_get_option( 'grandium_error_heading' )); ?></h5> 
						<?php else : ?>
						<h5 class="lead-heading"><?php echo esc_html_e('404 Page','grandium');?></h5>
					<?php endif; ?>
				<?php endif; ?>

				<?php if ( ot_get_option( 'grandium_error_slogan_visibility' )!= 'off') : ?>	
					<?php if ( ot_get_option( 'grandium_error_slogan' )!= '') : ?>
						<h1><?php echo ( ot_get_option( 'grandium_error_slogan' )); ?></h1> 
						<?php else : ?>
						<h1><?php echo  the_title();?></h1>
					<?php endif; ?>
				<?php endif; ?>
				
				<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'grandium' ); ?></p>
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
		
			<?php if( ot_get_option( 'grandium_404layout' ) == 'right-sidebar') { ?>
			<div class="col-md-9 right-sidebar-class">
			<?php } elseif( ot_get_option( 'grandium_404layout' ) == 'left-sidebar') { ?>
			<?php get_sidebar(); ?>
			<div class="col-md-9 right-sidebar-class">
			<?php } elseif( ot_get_option( 'grandium_404layout' ) == 'full-width') { ?>
			<div class="col-xs-12 full-width-index">
			<?php } ?>
			
				<h3><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'grandium' ); ?></h3>
				<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'grandium' ); ?></p>
				<div class="row">
					<div class="col-md-6 right-sidebar-class">
						<?php get_search_form(); ?>
					</div>
				</div>
				
			</div>
			
			<?php if( ot_get_option( 'grandium_404layout' ) == 'right-sidebar') { ?>
				<?php get_sidebar(); ?>
			<?php } ?>
			</div>
		</div>
	</div><!-- Section Blog End -->
	
</div><!-- Site Main End -->
<?php get_footer(); ?>