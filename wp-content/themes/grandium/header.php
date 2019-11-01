<!DOCTYPE html>
<html <?php language_attributes(); ?> > 

<head>

	<!-- Meta UTF8 charset -->
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<!-- Mobile Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

	<?php wp_head(); ?>
	
</head>

<!-- BODY START=========== -->
<body <?php body_class(); ?>>

<?php if ( ot_get_option('grandium_pre') != 'off') : ?>	
	<!-- Site Loading -->
	<div class="site-loading">
	<?php if ( ot_get_option('grandium_custom_preloader') != '') : ?>
		<img src="<?php echo esc_html( ot_get_option( 'grandium_custom_preloader' ) ) ?>" alt="<?php esc_html_e( 'Loading', 'grandium' ); ?>">
	<?php else : ?>
		<img src="<?php echo get_template_directory_uri() . '/img/loading.gif';?>" alt="<?php esc_html_e( 'Loading', 'grandium' ); ?>">
	<?php endif; ?>
	</div>
	<!-- Site Loading End -->
<?php endif; ?>

<?php if ( ot_get_option('grandium_back_to_top') != 'off') : ?>	
	<!-- Site Back Top -->
	<div class="site-backtop" title="<?php esc_html_e( 'Back to top','grandium' ); ?>">
		<i class="fa fa-angle-up"></i>
	</div>
	<!-- Site Back Top End -->
<?php endif; ?>

