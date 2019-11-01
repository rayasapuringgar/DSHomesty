<?php 
	get_header();  
	get_template_part('index_header');
	
	// index.php
	$grandium_thumb_id 				= get_post_thumbnail_id();
	$grandium_thumb_url_array 		= wp_get_attachment_image_src($grandium_thumb_id, 'thumbnail-size', true);
	$grandium_img_featured 			= $grandium_thumb_url_array[0];
	
	$grandium_f 					= ($grandium_img_featured != '') ? 'data-background="'. $grandium_img_featured .'"' : 'data-background="'. get_template_directory_uri() . '/img/photo-gallery-1.jpg' .'"';
	
?>

	<!-- Site Main -->
	<div class="site-main">
		<!-- Section Page Title -->
		<div class="section">
			<div class="widget-page-title">
				<div class="widget-background" <?php echo esc_attr( $grandium_f );?>></div>
				<div class="wrapper-inner">
				
					<?php while ( have_posts() ) : the_post(); ?>
						<h5><?php the_author(); ?></h5>
					<?php endwhile; // end of the loop. ?>
					
					<?php if ( ot_get_option('grandium_single_disable_heading') != 'off') : ?>
						<h1 class="lead-heading"><?php echo the_title();?></h1>
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
				
				<?php if(  ot_get_option( 'grandium_postlayout' ) == 'right-sidebar' || ot_get_option( 'grandium_postlayout' ) == '' ) { ?>
				<div class="col-lg-8 col-md-8 col-sm-12 index float-right posts">
				<?php } elseif( ot_get_option( 'grandium_postlayout' ) == 'left-sidebar') { ?>
				<?php get_sidebar(); ?>
				<div class="col-lg-8 col-md-8 col-sm-12 index float-left posts">
				<?php } elseif( ot_get_option( 'grandium_postlayout' ) == 'full-width') { ?>
				<div class="col-xs-12 full-width-index v">
				<?php } ?>
				
					<div class="widget-blog-single">
						<?php while ( have_posts() ) : the_post(); ?>
							<?php get_template_part( 'post-format/content', get_post_format() ); ?>
							<div id="comments" class="single-comments">
								<?php
									if ( comments_open() || '0' != get_comments_number() ) :
										comments_template();
									endif;
								?>
							</div>
						<?php endwhile; // end of the loop. ?>
					</div><!-- #end sidebar+ content -->
					<?php grandium_post_nav(); ?>
				</div><!-- #end sidebar+ content -->
				<?php 
					if( ot_get_option( 'grandium_postlayout' ) == 'right-sidebar' || ot_get_option( 'grandium_postlayout' ) == '' ) { 
					get_sidebar(); 
					} 
				?>
				</div>
			</div>
		</div>
	</div>

<?php get_footer(); ?>