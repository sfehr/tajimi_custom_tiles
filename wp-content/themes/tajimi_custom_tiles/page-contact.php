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
			foreach ( (array) $selected_tiles as $key => $tile ) {
				$input_html[] = '<div class="message_tile_selection"><input type="text" name="tct[selected_tile]" value="' . $tile . '" readonly><a class="button-delete" href="#">x</a></div>';
			}
			?>
			
			
  			<?php 
				echo $response; 
				
			// FORM	
			?>
  			<form action="<?php /* the_permalink(); */ echo esc_url( admin_url('admin-post.php') );  ?>" method="post" enctype="multipart/form-data" id="tct-contact-form" name="tct_contact_form">
				
    			<input type="text" name="tct[full_name]" placeholder="Full Name" value="<?php echo esc_attr( $_POST['tct']['full_name'] ); ?>">
				<input type="text" name="tct[company]" placeholder="Company" value="<?php echo esc_attr( $_POST['tct']['company'] ); ?>">
				<input type="text" name="tct[address]" placeholder="Adress" value="<?php echo esc_attr( $_POST['tct']['address'] ); ?>">
				<input type="text" name="tct[postal_code]" placeholder="Postal Code" value="<?php echo esc_attr( $_POST['tct']['postal_code'] ); ?>">
				<input type="text" name="tct[country]" placeholder="Country" value="<?php echo esc_attr( $_POST['tct']['country'] ); ?>">
				<input type="text" name="tct[subject]" placeholder="Subject" value="<?php echo esc_attr( $_POST['tct']['subject'] ); ?>">
				<input type="email" name="tct[email]" placeholder="yourname@example.com" value="<?php echo esc_attr( $_POST['tct']['email'] ); ?>">
				<?php echo implode('', $input_html) ?>	
    			<textarea type="text" name="tct[message]" placeholder="Message"><?php echo esc_textarea( $_POST['tct']['message'] ); ?></textarea>
				<label> Attach your file </label> 
				<input type="file" name="tct_multiple_attachments[]" id="tct_file" multiple="multiple">
				
				<input type="text" name="tct_name" placeholder="Name">
				<input type="hidden" name="tct_contact_form_nonce" value="<?php echo $tct_add_contact_nonce ?>" />
				
				<input type="hidden" name="action" value="tct_form_response">				
    			<input type="submit" name="contact_submit" id="contact_submit" class="button button-primary" value="Send Message">
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
