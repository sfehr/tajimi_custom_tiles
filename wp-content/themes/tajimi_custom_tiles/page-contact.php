<?php
/**
 * Template Name: Contact
 *
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
			
			// VARIABLES
			$selected_tiles = $_POST['tct_tile'];
			
			// NONCE FIELD: for form security
			$tct_add_contact_nonce = wp_create_nonce( 'tct_add_contact_form_nonce' );
			?>
			
			<?php
			// INPUT FIELDS TILE SELECTION
			foreach ( (array) $selected_tiles as $key => $id ) {
				$post = get_post( $id );
				$title = esc_html( get_the_title() );
				$tile_meta = get_post_meta( get_the_ID(), 'tct_sample_tiles_image_1_id', 1 );
				$tile_thumbnail = wp_get_attachment_image( $tile_meta, '' );
				
				$input_html[] = '<div class="message_tile_selection"><input type="text" class="tile-selection" name="tct[selected_tiles][]" value="'. $title .'" readonly><a class="button-delete" href="#">x</a><div class="sample-tile">'. $tile_thumbnail .'</div></div>';
			}
			?>
			
			
  			<?php 
				echo $response; 
				
			// FORM	
			?>
  			<form action="<?php echo esc_url( admin_url('admin-post.php') );  ?>" method="post" enctype="multipart/form-data" id="tct-contact-form" name="tct_contact_form">
				
    			<input type="text" name="tct[full_name]" placeholder="<?php _e( 'Full Name', 'tajimi_custom_tiles' ); ?>" value="<?php echo esc_attr( $_POST['tct']['full_name'] ); ?>" required>
				<input type="text" name="tct[company]" placeholder="<?php _e( 'Company', 'tajimi_custom_tiles' ); ?>" value="<?php echo esc_attr( $_POST['tct']['company'] ); ?>" required>
				<input type="text" name="tct[address]" placeholder="<?php _e( 'Address', 'tajimi_custom_tiles' ); ?>" value="<?php echo esc_attr( $_POST['tct']['address'] ); ?>" required>
				<input type="text" name="tct[postal_code]" placeholder="<?php _e( 'Postal Code', 'tajimi_custom_tiles' ); ?>" value="<?php echo esc_attr( $_POST['tct']['postal_code'] ); ?>" required>
				<input type="text" name="tct[country]" placeholder="<?php _e( 'Country', 'tajimi_custom_tiles' ); ?>" value="<?php echo esc_attr( $_POST['tct']['country'] ); ?>" required>
				<input type="text" name="tct[subject]" placeholder="<?php _e( 'Subject', 'tajimi_custom_tiles' ); ?>" value="<?php echo esc_attr( $_POST['tct']['subject'] ); ?>" required>
				<input type="email" name="tct[email]" placeholder="<?php _e( 'yourname@example.com', 'tajimi_custom_tiles' ); ?>" value="<?php echo esc_attr( $_POST['tct']['email'] ); ?>" required>
				<?php if( isset( $input_html ) && !empty( $input_html ) ) echo implode('', $input_html) ?>
    			<textarea type="text" name="tct[message]" placeholder="<?php _e( 'Message', 'tajimi_custom_tiles' ); ?>" required><?php echo esc_textarea( $_POST['tct']['message'] ); ?></textarea>
				<input type="file" name="tct_multiple_attachments[]" id="tct_file" data-multiple-caption="{count} files selected" multiple="multiple">
				<label id="tct_file_label" for="tct_file"><span><?php _e( 'Attach Files', 'tajimi_custom_tiles' ); ?></span></label> 
				
				<input type="text" name="tct_name" placeholder="Name">
				<input type="hidden" name="tct_contact_form_nonce" value="<?php echo $tct_add_contact_nonce ?>" />
				
				<input type="hidden" name="action" value="tct_form_response">				
    			<input type="submit" name="contact_submit" id="contact_submit" class="button button-primary" value="<?php _e( 'Send Message', 'tajimi_custom_tiles' ); ?>">
				<div id="tct-form-respond"></div>
  			</form>

			<?php
	
			get_template_part( 'template-parts/content', 'contact' );		
	
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
