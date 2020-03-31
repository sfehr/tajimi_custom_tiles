/**
 * File sample-tile-form-processor.js
 *
 * Handles interaction with the sample tile gallery form
 * 
 * VARIABLES
 * TILES
 * SUBMIT BUTTON, SELECTION ACTIVE STATE 
 * TILE LIST VIEW SWITCH
 * TILE INFO EXPANSION SWITCH (COMPACT VIEW)
 * RESETTING EXPANDED/ALTERNATIVE TILE ON UI SWITCHING
 * RESETTING EXPANDED-TILE-INFO ON UI SWITCHING 
 * MEDIA QUERY
 * 
 */

jQuery(document).ready(function () {
	
	// VARIABLES
	var checkbox_limit = 4;	
	var min_width = 970; //min width for standard list type view
	var submit_btn_text = jQuery( '.tile-submit-container' ).text();
	
    jQuery( 'body' ).on( 'change', 'input.tile-selection', function() {
		
		// TILES
		
		//Limits the amount of selectable checkboxes
		if( jQuery( 'input.tile-selection:checked' ).length > checkbox_limit ) {
			this.checked = false;
		}
		//Toggles the selected class, while limit is not exceeded
		else{
//			jQuery( this ).parent().toggleClass( 'tile-expanded' );
			jQuery( '#tct-sample-tiles' ).removeClass( 'max-selection' );
			//Add class for active state
			jQuery( this ).parent( '.sample-tile' ).toggleClass( 'selection-sample-tile' );			
		}
		
		// UX CONTROL: Hide tooltip and pointer when maximum tiles are selected
		if( jQuery( 'input.tile-selection:checked' ).length === checkbox_limit ) {
			jQuery( '#tct-sample-tiles' ).addClass( 'max-selection' );
		}
		else{
			jQuery( '#tct-sample-tiles' ).removeClass( 'max-selection' );
		}
		
		// RESET RADIO BUTTON ON CLOSING
		/*
		if ( ! this.checked ){
			jQuery( this ).siblings( '.tile-radio-1' ).prop( 'checked', true ); // Checks it
			jQuery( this ).siblings( '.tile-radio-2' ).prop( 'checked', false ); // Unchecks it
		}
		*/
		
	});
	
	
		
	// SUBMIT BUTTON, SELECTION ACTIVE STATE
	jQuery( 'body' ).on( 'change', 'input.tile-selection', function() {		
			
		//Displays the submit button when 1 or more tiles are selected, hide if not
		if( jQuery( 'input.tile-selection:checked' ).length > 0 ) {
			jQuery( '.tile-submit-container' ).css( 'display', 'block' );
			var tile_count = jQuery( 'input.tile-selection:checked' ).length;
			jQuery( '.tile-submit-container .tile-count' ).html( tile_count + '/' + checkbox_limit );
		}
		else{
			jQuery( '.tile-submit-container' ).css( 'display', 'none' );
		}
		
    });
	
	
		
	// TILE LIST VIEW SWITCH
	jQuery( '.switch-list-type' ).on( 'click', function() {
		jQuery( this ).parents( '#tct-sample-tiles' ).toggleClass( 'tile-grid-compact' );
		jQuery( '#tct-sample-tiles' ).removeClass( 'tile-expanded tile-alternative' );
	});	
	
	
	// TILE INFO EXPANSION SWITCH (COMPACT VIEW)
	jQuery( document ).on( 'click', '.switch-expand-info', function() {
		jQuery( this ).parents( '.sample-tile' ).toggleClass( 'tile-info-expanded' );
	});	
	
	
	// RESETTING EXPANDED/ALTERNATIVE TILE ON UI SWITCHING
	jQuery( document ).on( 'click', '.switch-list-type, .switch-expand-info', function() {
		jQuery( '.sample-tile' ).removeClass( 'tile-expanded tile-alternative' );
	});
	

	// RESETTING EXPANDED-TILE-INFO ON UI SWITCHING
	jQuery( document ).on( 'click', '.switch-list-type', function() {
		jQuery( '.sample-tile' ).removeClass( 'tile-info-expanded' );
	});	
	
	
	// MEDIA QUERY (toggle compact list view)
	jQuery( window ).load( function() {
		
		if ( jQuery( window ).width() < min_width ) {
				jQuery( '#tct-sample-tiles' ).addClass( 'tile-grid-compact' );
		}

		jQuery( window ).resize( function (){
			
			if ( jQuery( window ).width() < min_width ){
				jQuery( '#tct-sample-tiles' ).addClass( 'tile-grid-compact' );
			}
		});
	});
	
	
});
