<?php
/**
 * Template part for displaying posts in start page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Tajimi_Custom_Tiles
 */

if ( get_page_template_slug( get_the_ID() ) ){
	$template = pathinfo( get_page_template_slug( get_the_ID() ) );
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $template[ 'filename' ] ); ?>>
	
	<?php
	
		/* CUSTOM FIELDS */
//		tct_get_media_group_entries( 'tct_brand_story_group', 'entry-media' ); // ($meta_key, $class)
	
	?>

	<?php tajimi_custom_tiles_post_thumbnail(); ?>
	
	<div class="entry-content">
		
		<a href="<?php echo get_post_type_archive_link( get_post_type() ) ?>">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		   
			<?php	
			// in english: 150words and 350 words in japanese
//			$words = ( function_exists( 'pll_current_language' ) && pll_current_language() == 'jp' ) ? 350 : 150;
//			echo '<p>' . wp_trim_words( get_the_content(), $words, ' ...' ) . '</p>';
			echo '<p>' . get_the_content() . '</p>';
			?>
		</a>	

	</div><!-- .entry-content -->
	
</article><!-- #post-<?php the_ID(); ?> -->

<div class="extra-content">
	<?php

	// page id with extra text contnt for start page
	$id = 1553;
	
	if ( function_exists( 'pll_current_language' ) && pll_current_language() != pll_default_language() ){
		$id = pll_get_post( $id );
	}
	
//	$page = get_page_by_title( 'Start Page: Extra Content' );
	$page = get_post( $id );
	$content = apply_filters( 'the_content', $page->post_content );
	echo $content;
	
	?>	
</div><!-- .extra-content -->
