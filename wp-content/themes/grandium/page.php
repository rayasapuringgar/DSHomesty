
	<?php
		get_header();
		get_template_part('index_header');

		$grandium_headerbgcolor  		= rwmb_meta('grandium_headerbgcolor');
		$grandium_headertextcolor  		= rwmb_meta('grandium_pagetextcolor');
		$grandium_headerpaddingtop  	= rwmb_meta('grandium_headerptop');
		$grandium_headerpaddingbottom  	= rwmb_meta('grandium_headerpbottom');
		$grandium_pagelayout  			= rwmb_meta('grandium_pagelayout');
		$grandium_disable_mini_title 	= rwmb_meta('grandium_disable_mini_title' );

		$grandium_att		= get_post_thumbnail_id();
		$grandium_image_src = wp_get_attachment_image_src( $grandium_att, 'full' );
		$grandium_image_src = $grandium_image_src[0];
	?>

	<style>
		<?php if ($grandium_headertextcolor): ?>
			.breadcrumbs a,
			.subpage-head.page-header ,
			.subpage-head.page-header h3,
			span.breadcrumb-current			{ color :<?php echo esc_attr( $grandium_headertextcolor ); ?> ; }
		<?php endif; ?>

		<?php if ($grandium_headerbgcolor): ?>
			.subpage-head { background-color :<?php echo esc_attr( $grandium_headerbgcolor ); ?>; }
		<?php endif; ?>


		<?php if ($grandium_image_src): ?>
			.page .widget-background  {
			  background: transparent url(<?php echo esc_url( $grandium_image_src ); ?>) no-repeat  center top / cover!important;

			}
		<?php endif; ?>

		<?php if ($grandium_headerpaddingtop || $grandium_headerpaddingbottom ): ?>
			.subpage-head.page-header  {
				padding-top :<?php echo esc_attr( $grandium_headerpaddingtop ); ?>px ;
				padding-bottom :<?php echo esc_attr( $grandium_headerpaddingbottom ); ?>px ;
			}
		<?php endif; ?>
	</style>

<!-- Site Main -->
<div class="site-main">
	<!-- Section Page Title -->
	<div class="section subpage-head page-header">
		<div class="widget-page-title">
			<div class="widget-background" data-background="<?php echo esc_url( $grandium_image_src ); ?>"></div>
			<div class="wrapper-inner">

				<!-- Title -->
				<?php  if((get_post_meta( get_the_ID(), 'grandium_disable_mini_title', true )!= true) ): ?>
					<?php if(get_post_meta( get_the_ID(), 'grandium_mini_title', true )): ?>
						<h5 class="lead-heading">
						<?php echo get_post_meta( get_the_ID(), 'grandium_mini_title', true ); ?></h5>
					<?php else : ?>
						<h5 class="lead-heading"><?php echo ('Default Page'); ?></h5>
					<?php endif; ?>
				<?php endif; ?>

				<?php  if((get_post_meta( get_the_ID(), 'grandium_disable_alt_title', true )!= true) ): ?>
					<?php if(get_post_meta( get_the_ID(), 'grandium_alt_title', true )): ?>
						<h1><?php echo get_post_meta( get_the_ID(), 'grandium_alt_title', true ); ?></h1>
						<?php else : ?>
						<h1><?php the_title(); ?></h1>
					<?php endif; ?>
				<?php endif; ?>

				<?php  if((get_post_meta( get_the_ID(), 'grandium_disable_sub_title', true )!= true) ): ?>
					<?php if(get_post_meta( get_the_ID(), 'grandium_subtitle', true )): ?>
						<p><?php echo get_post_meta( get_the_ID(), 'grandium_subtitle', true ); ?></p>
						<?php else : ?>
						<p><?php echo esc_html_e('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eget commodo orci. Integer varius nibh eu mattis porta.' , 'grandium' ); ?></p>
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

				<?php if( ( $grandium_pagelayout ) =='right-sidebar' || ($grandium_pagelayout ) =='' ){ ?>
				<div class="col-md-9 right-sidebar-class">
				<?php } elseif(( $grandium_pagelayout ) == 'left-sidebar') { ?>
				<?php get_sidebar(); ?>
				<div class="col-md-9 left-sidebar-class">
				<?php } elseif(( $grandium_pagelayout ) == 'full-width') { ?>
				<div class="col-xs-12 full-width-index">
				<?php } ?>

					<div class="single-detail">
						<?php
							// Start the loop.
							while ( have_posts() ) : the_post();

							// Include the page content template.
							get_template_part( 'content', 'page' );
						?>
							<div class="widget-blog-single">
								<div id="comments" class="single-comments">
									<?php
										// If comments are open or we have at least one comment, load up the comment template.
										if ( comments_open() || get_comments_number() ) :
											comments_template();
										endif;
									?>
								</div>
							</div>

						<?php endwhile; ?>
					</div>

				</div>

				<?php if( ( $grandium_pagelayout ) =='right-sidebar' || ($grandium_pagelayout ) =='' ){ ?>
					<?php get_sidebar(); ?>
				<?php } ?>

			</div>
		</div>
	</div>
	<!-- Section Blog End-->

</div> <!-- Site Main End -->
<?php get_footer(); ?>
