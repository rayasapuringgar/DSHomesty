

	<!-- Site Main -->
	<div class="site-main">
	<!-- Section Page Title -->
	<div class="section">
		<div class="widget-page-title">
			<div class="widget-background" data-background="<?php echo get_template_directory_uri() . '/img/photo-gallery-1.jpg';?>"></div>
			<div class="wrapper-inner">
			
				<?php if ( ot_get_option('grandium_shop_sub_d_s_t') != 'off' && ot_get_option('grandium_sub_shop_s_t') != '' ) : ?>
					<h5><?php echo ot_get_option('grandium_sub_shop_s_t'); ?></h5>
					<?php else : ?>
					<h5><?php esc_html_e( 'SHOP', 'grandium' ); ?></h5>
				<?php endif; ?>
				
				<?php if ( ot_get_option('grandium_shop_d_s_t') != 'off' && ot_get_option('grandium_shop_s_t') != '' ) : ?>
					<h1 class="lead-heading"><?php echo ot_get_option('grandium_shop_s_t'); ?></h1>
				<?php else: ?>
					<h1 class="lead-heading"><?php echo wp_title('', true,'');?></h1>
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
	
	
	<section id="blog" class="page-internal-content">
		<div class="container">
			<div class="row">
				<div class="col-md-12-off has-margin-bottom-off">
				
				<?php if( ot_get_option( 'woopage' ) == 'right-sidebar' || ot_get_option( 'woopage' ) == '') { ?>
					<div class="col-lg-9  col-md-9 col-sm-9 index float-right posts">
				<?php } elseif( ot_get_option( 'woopage' ) == 'left-sidebar') { ?>
				
					<div id="widget-area" class="widget-area col-lg-3 col-md-3 col-sm-3 woo-sidebar">
						<?php dynamic_sidebar( 'shop-page-sidebar' ); ?>
					</div>
					<div class="col-lg-9  col-md-9 col-sm-9 index float-left posts">
				
				<?php } elseif( ot_get_option( 'woopage' ) == 'full-width') { ?>
					<div class="col-xs-12 full-width-index v">
				<?php } ?>
				  
					<?php woocommerce_content(); ?>
			   
			   </div><!-- #end sidebar+ content -->

				<?php if( ot_get_option( 'woopage' ) == 'right-sidebar' || ot_get_option( 'woopage' ) == '') { ?>
					<div id="widget-area" class="widget-area col-lg-3 col-md-3 col-sm-3 woo-sidebar">
						<?php dynamic_sidebar( 'shop-page-sidebar' ); ?>
					</div>
				<?php } ?>
					
				</div>
			</div>
		</div>
	</section>	
	
	<?php get_footer(); ?>
	