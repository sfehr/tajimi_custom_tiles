<?php

/* Template Name: Sample Tiles Archive Page */


get_header();

// add custom menu
wp_nav_menu( array( 'theme_location' => 'tct-tile-filter-menu' ) );


?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();
			

			get_template_part( 'template-parts/content', 'tmpl_sample_tile' );
			


		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
