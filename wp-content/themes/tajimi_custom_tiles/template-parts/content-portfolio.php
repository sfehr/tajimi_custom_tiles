<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Tajimi_Custom_Tiles
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<?php
	
		/* CUSTOM FIELDS */
		
		//portfolio images from file_list field
		tct_get_portfolio_images( 'tct_portfolio_data_file_list', 'entry-media' );
	
	?>
	
	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h1 class="entry-title">', '</h1>' );
		endif;

		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta">
				<?php
				tajimi_custom_tiles_posted_on();
				tajimi_custom_tiles_posted_by();
				?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php tajimi_custom_tiles_post_thumbnail(); ?>
	
	<?php
	
	/* CUSTOM FIELDS */
	
	//portfolio data from several fields
	tct_get_portfolio_data_bundle( 'entry-portfolio-data' );
	
	// display QA only when content exists
	if( !empty( get_the_content() ) ) :
	?>	
	<div class="entry-qa">
		<input type="checkbox" id="qa-<?php the_ID(); ?>" name="qa-<?php the_ID(); ?>">
		<label for="qa-<?php the_ID(); ?>"><?php echo esc_html__( 'Q&A', 'tajimi_custom_tiles' ); ?></label>
		<div class="entry-content">
			<?php the_content(); ?>
		</div><!-- .entry-content -->	
	</div>	
	<?php
	endif;
	?>
	
	<footer class="entry-footer">
		<?php tajimi_custom_tiles_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
