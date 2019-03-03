<?php
/**
 * Template part for displaying archive content in tmpl_sample_tiles.php
 *
 * @package Tajimi_Custom_Tiles
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<?php
	// NONCE FIELD: for form security
	$tct_add_meta_nonce = wp_create_nonce( 'tct_add_sample_tiles_form_nonce' );
	?>
	<form action="<?php echo esc_url( home_url('contact') ); /* echo esc_url( admin_url('admin-post.php') ); */ ?>" method="post" id="tct-sample-tiles">
	
		<input type="submit" name="tile_submit" id="tile_submit" class="button button-primary" value="Order Tiles">
		<input type="hidden" name="tct_sample_tiles_form_nonce" value="<?php echo $tct_add_meta_nonce ?>" />
		<input type="hidden" name="action" value="tct_form_response">

		<div class="entry-content">
			<?php

			// PAGE CONTENT: before the sample tile archive
			the_content();
			?>

		</div><!-- .entry-content -->
	
	</form><!-- #tct-sample-tiles -->	

		<?php

		if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Edit <span class="screen-reader-text">%s</span>', 'tajimi_custom_tiles' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				),
				'<span class="edit-link">',
				'</span>'
			);	
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
