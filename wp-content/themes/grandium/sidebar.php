<?php
/**
 * The sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage grandium
 * @since grandium 1.0
 */

if (  is_active_sidebar( 'sidebar-1' )  ) : 
?>
	<div id="widget-area" class="widget-area col-md-3">
		<div class="widget-blog-sidebar">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</div><!-- .widget-area -->
	</div><!-- .widget-area -->
<?php endif; ?>

