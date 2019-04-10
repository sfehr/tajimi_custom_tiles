<?php

/* 

Template Name: Brand Claim
Template Post Type: brand_story

*/


get_header();



?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			Test
		<?php
		while ( have_posts() ) :
			the_post();
			

			get_template_part( 'template-parts/content', 'tmpl_brand_claim' );
			


		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
