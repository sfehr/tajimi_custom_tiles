/**
 * File sample-tile-form-processor.js
 *
 * Handles interaction with the sample tile gallery form
 * 
 * VARIABLES
 * TILES
 * SUBMIT BUTTON
 * 
 */

jQuery(document).ready(function () {
	
	// VARIABLES
	var checkbox_limit = 4;	
	
    jQuery( 'body' ).on( 'change', 'input.tile-checkbox', function() {
		
		
		// TILES
		
		//Limits the amount of selectable checkboxes
		if( jQuery( 'input.tile-checkbox:checked' ).length > checkbox_limit || jQuery( 'input.tile-selection:checked' ).length > checkbox_limit ) {
			this.checked = false;
		}
		//Toggles the selected class, while limit is not exceeded
		else{
			jQuery( this ).parent().toggleClass( 'tile-expanded' );
			jQuery( '#tct-sample-tiles' ).removeClass( 'max-selection' );
		}
		
		// UX CONTROL: Hide tooltip and pointer when maximum tiles are selected
		if( jQuery( 'input.tile-checkbox:checked' ).length === checkbox_limit ) {
			jQuery( '#tct-sample-tiles' ).addClass( 'max-selection' );
		}
		else{
			jQuery( '#tct-sample-tiles' ).removeClass( 'max-selection' );
		}
		
		
		// RESET RADIO BUTTON ON CLOSING
		if ( ! this.checked ){
			jQuery( this ).siblings( '.tile-radio-1' ).prop( 'checked', true ); // Checks it
			jQuery( this ).siblings( '.tile-radio-2' ).prop( 'checked', false ); // Unchecks it
		}
		
	});
	
	
		
	// SUBMIT BUTTON
	jQuery( 'body' ).on( 'change', 'input.tile-selection', function() {		
			
		//Displays the submit button when 1 or more tiles are selected, hide if not
		if( jQuery( 'input.tile-selection:checked' ).length > 0 ) {
			jQuery( '.tile-submit-container' ).css( 'display', 'block' );
		}
		else{
			jQuery( '.tile-submit-container' ).css( 'display', 'none' );
		}
		
    });
	
});
