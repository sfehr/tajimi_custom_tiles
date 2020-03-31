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


////// CUSTOM WP QUERY (for sample tiles)
	
// VARIABLES
$default_lang = function_exists( 'pll_default_language' ) ? pll_default_language() : '';			
		
// ARGS
$args = array(
	'post_type' => 'sample_tile',
	'lang'		=> $default_lang,
	'posts_per_page' => -1,
	'orderby' => 'rand',
/*	
	'orderby' => array(
		'post_type' => 'ASC',
		'date' => 'DESC',
	),			
*/	
);



?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
			
		// DEFAULT LOOP
		while ( have_posts() ) :
			the_post();
				
		// outputs only brand_story posts with the template 'tmpl_hero_entry.php' 
		if( get_page_template_slug( get_the_ID() ) == 'tmpl_hero_entry.php' ){
			
			get_template_part( 'template-parts/content', 'tmpl_start_page' );
			
		}	
			
		endwhile; // End of the loop.
			
			
		// CUSTOM LOOP
		$tct_query = null;
		$tct_query = new WP_Query( $args );
			
		while( $tct_query -> have_posts() ) : $tct_query -> the_post();

		?>
			
			<div class="sample-tile">
				
				<?php tct_get_sample_tile_images( 'tct_sample_tiles_', 'tile-image', 'medium-medium' ); ?>
				
				<div class="tile-tooltip">
				  <p><?php the_title(); ?></p>
				</div>				
				
			</div>	
			<?php			
			
		endwhile; // End of the loop.
		wp_reset_query();				
			
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
