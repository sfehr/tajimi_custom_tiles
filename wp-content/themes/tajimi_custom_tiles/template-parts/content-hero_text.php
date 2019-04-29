<?php
/**
 * Template part for highlighting post content
 *
 * Template Post Type: brand_story, production_method, collaborations
 * 
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Tajimi_Custom_Tiles
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<div class="container-media">
	
		<?php

			/* CUSTOM FIELDS */
			tct_get_media_group_entries( 'tct_brand_story_group', 'entry-media' ); // ($meta_key, $class)
		
		?>
	
	</div><!-- .media-container -->
	
	<div class="container-content">
	
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

		<div class="entry-content">
			<?php

			the_content( sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'tajimi_custom_tiles' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'tajimi_custom_tiles' ),
				'after'  => '</div>',
			) );
			?>
		</div><!-- .entry-content -->
		
	</div><!-- .container-content -->		

	<footer class="entry-footer">
		<?php tajimi_custom_tiles_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
