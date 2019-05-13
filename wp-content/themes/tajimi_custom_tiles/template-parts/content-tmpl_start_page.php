<?php
/**
 * Template part for displaying posts in start page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Tajimi_Custom_Tiles
 */

if ( get_page_template_slug( get_the_ID() ) ){
	$template = pathinfo(get_page_template_slug( get_the_ID() ) );
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $template['filename'] ); ?>>
	
	<?php
	
		/* CUSTOM FIELDS */
		tct_get_media_group_entries( 'tct_brand_story_group', 'entry-media' ); // ($meta_key, $class)
	
	/*
	?>	
	
	<header class="entry-header">
		<?php
			the_title( '<h1 class="entry-title">', '</h1>' );

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
	*/ ?>

	<?php tajimi_custom_tiles_post_thumbnail(); ?>
	
	<div class="entry-content">
		
		<a href="<?php echo get_post_type_archive_link( get_post_type() ) ?>">
			<?php
			the_title( '<h1 class="entry-title">', '</h1>' );
			the_content();
			?>
		</a>
		
		<div class="entry-link">
			<a href="<?php echo get_post_type_archive_link( get_post_type() ) ?>"><?php _e( 'Read More', 'tajimi_custom_tiles'  ) ?><i></i></a>
		</div><!-- .entry-link -->
			
		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'tajimi_custom_tiles' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php tajimi_custom_tiles_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->


