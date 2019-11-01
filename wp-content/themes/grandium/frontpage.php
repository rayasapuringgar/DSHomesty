	<?php 
		/*
		Template name: Frontpage Template
		*/
		
		// theme header	
		get_header(); 
		
		// theme header content	
		get_template_part('index_header'); 
		
	?>	
	<!-- Site Main -->
	<div class="site-main">
				
		<?php
			// page content 
			if ( have_posts() ) :
				while ( have_posts() ) : the_post();  
					the_content(); 
				endwhile; 
			endif; 
		?>
		
	</div>
	<!-- Site Main End -->
	
	<?php
		// theme footer	
		get_footer(); 
	?>
