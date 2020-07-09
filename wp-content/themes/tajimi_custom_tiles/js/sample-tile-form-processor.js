/**
 * File sample-tile-form-processor.js
 *
 * Handles interaction with the sample tile gallery form
 * 
 * VARIABLES
 * TILES
 * SUBMIT BUTTON, SELECTION ACTIVE STATE 
 * RESTORE TILE CHECKS AFTER FILTER
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
	var	tile_selection = []; // stores selected tiles in array to have them accessable when the makup is reloaded
	

	
	jQuery( 'body' ).on( 'change', 'input.tile-selection', function() {
		
		// ARRAY
		// CHECKBOX
		
		// CHECK: does value already exist?
		if( tile_selection.indexOf( jQuery( this ).attr( 'id' ) ) !== -1 ){ // checks if tile-id is already in array ...
			
			// DELETE: delete value from array
			tile_selection = tile_selection.filter( item => item !== jQuery( this ).attr( 'id' ) );
			
			//Remove class for active state
			jQuery( this ).parent( '.sample-tile' ).removeClass( 'selection-sample-tile' );						
			
		}
		// CHECK: is limit not yet reached?
		else if( tile_selection.length < checkbox_limit ){
			
			// SAFE: safe value to array
			tile_selection.push( jQuery( this ).attr( 'id' ) );
			
			//Add class for active state
			jQuery( this ).parent( '.sample-tile' ).addClass( 'selection-sample-tile' );
						
		}
		// REJECT: limmit has been reached
		else{
			
			this.checked = false;
			
		}
		
		
		// SUBMIT CONTAIMER
		
		if( tile_selection.length > 0 ){
			
			// makes the submit buttom visible
			jQuery( '.tile-submit-container' ).css( 'display', 'block' );
			// updates the tile count
			jQuery( '.tile-submit-container .tile-count' ).html( tile_selection.length + '/' + checkbox_limit );
			
		}
		else{
			// hide submit container
			jQuery( '.tile-submit-container' ).css( 'display', 'none' );
			
			// empty the tile selection array
			tile_selection = [];			
		}
		
		
		// ACITVE SELECTION STATE CLASS
		
		if( tile_selection.length === checkbox_limit ){
			
			jQuery( '#tct-sample-tiles' ).addClass( 'max-selection' );
			
		}
		else{
			jQuery( '#tct-sample-tiles' ).removeClass( 'max-selection' );
		}

		
	});		
	
	
	// RESTORE TILE CHECKS AFTER FILTER
	jQuery( document ).ajaxSuccess( function() {
		
		// check if tile_selection is still empty (first load)
		if ( typeof tile_selection !== 'undefined' && tile_selection.length > 0 ) {
			
			
			// find the checkboxes stored in the variable and restores checked-state
			jQuery.each( tile_selection, function( ind, val ){
				
//				console.log( jQuery( '#' + val + '.tile-selection' ) );
				// restore check state: checkbox 
				jQuery( '#' + val + '.tile-selection' ).prop( 'checked', true);
				// restore check state: css
				jQuery( '#' + val + '.tile-selection' ).parent().addClass( 'selection-sample-tile' );
				
			});
			
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
