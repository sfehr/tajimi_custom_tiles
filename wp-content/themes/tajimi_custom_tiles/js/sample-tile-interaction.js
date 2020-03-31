/**
 * File sample-tile-interaction.js
 *
 * Handles click interaction with the sample tile gallery form
 * 
 * TILES
 * 
 */

jQuery(document).ready(function () {
	
    jQuery( 'body' ).on( 'click', '.sample-tile .tile-image', function() {	

		// RESET
		
		// Reset clicked tiles except current clicked tile (this)
		jQuery( '.sample-tile' ).not( jQuery( this ).parent() ).removeClass( 'tile-expanded tile-alternative' );
		
		
		// TILES
		
		// 3 States: normal, 1st click (expanded), 2nd click (expanded, alternative image) 
		
		// 3rd click: resume initial state
		if( jQuery( this ).parent().hasClass( 'tile-alternative' ) ){
			jQuery( this ).parent().toggleClass( 'tile-expanded' );
			jQuery( this ).parent().toggleClass( 'tile-alternative' );
		}		
		
		// 2nd click: show alternative tile image 
		else if( jQuery( this ).parent().hasClass( 'tile-expanded' ) ){
			jQuery( this ).parent().toggleClass( 'tile-alternative' );
		}
		
		// 1st click
		else{
			jQuery( this ).parent().toggleClass( 'tile-expanded' );
		}

		
	});
	
	
});
