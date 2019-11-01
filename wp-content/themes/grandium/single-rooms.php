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
				
					<?php if ( ot_get_option('grandium_single_disable_heading') != 'off') : ?>
						<h1 class="lead-heading"><?php echo the_title();?></h1>
					<?php endif; ?>
					
					<?php 
						while ( have_posts() ) : 
						the_post(); ?>
						<p><?php the_excerpt(); ?></p>
					<?php 
						endwhile; 
					?>
					
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
		<?php 
			while ( have_posts() ) : 
				the_post(); 
				get_template_part( 'post-format/rooms/content', get_post_format() ); 
			endwhile; // end of the loop. 
		?>
	</div>

	<?php get_footer(); ?>

