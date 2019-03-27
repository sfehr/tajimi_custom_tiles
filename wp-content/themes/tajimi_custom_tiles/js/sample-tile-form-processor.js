/**
 * File sample-tile-form-processor.js
 *
 * Handles interaction with the sample tile gallery form
 * 
 */

jQuery(document).ready(function () {
	
	// VARIABLES
	var checkbox_limit = 3;	
	
    jQuery( 'body' ).on( 'change', 'input.tile-checkbox', function(event) {
		
		
		//TILES
		
		//Limits the amount of selectable checkboxes
		if( jQuery( 'input.tile-checkbox:checked' ).length > checkbox_limit ) {
			this.checked = false;
			
			//hide tooltip and pointer
		}
		//Toggles the selected class, while limit is not exceeded
		else{
			jQuery( this ).parent().toggleClass( 'tile-selected' );
		}
		
		
		
		//SUBMIT BUTTON
		
		//Displays the submit button when 1 or more tiles are selected, hide if not
		if( jQuery( 'input.tile-checkbox:checked' ).length > 0 ) {
			jQuery( '.tile-submit-container' ).css( 'display', 'block' );
		}
		else{
			jQuery( '.tile-submit-container' ).css( 'display', 'none' );
		}
		
    });
	
});
