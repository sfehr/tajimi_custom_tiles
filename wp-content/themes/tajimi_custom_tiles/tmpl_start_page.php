<?php
/**
 * 
 * Template Name: Start Page
 *  
 * The template for displaying Start Page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Tajimi_Custom_Tiles
 */

get_header();

?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();
		
		// outputs selected sample tiles 
		if ( get_post_type( get_the_ID() ) == 'sample_tile' ) {
			
			?>
			
			<div class="sample-tile">
				<?php tct_get_sample_tile_images( 'tct_sample_tiles_', 'tile-image', 'medium-medium' ); ?>
			</div>	
			<?php
			
		}
				
		// outputs post with template
		else{
			get_template_part( 'template-parts/content', 'tmpl_start_page' );
		}	
			

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
