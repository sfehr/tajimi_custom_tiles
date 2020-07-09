/**
 * File tct-tile-color-preview.js
 *
 * Previews the alternative color of a tile
 *
 *
 * SHOW ALTERNATIVE COLOR IMAGE
 * REMOVE ALTERNATIVE COLOR IMAGE
 *  
*/

jQuery( document ).ready( function( $ ) {
	
	// SHOW ALTERNATIVE COLOR IMAGE
	$( document ).on( 'mouseenter', 'a[href^="#"]', function() { 
		
		// href value links to target id
		var target = $( this ).attr( 'href' );
		// the target image div element
		var target_image = $( 'body' ).find( target + ' .tile-image.itm-1' );
		// current container
		var current_container = $( this ).parents( '.sample-tile' );
		// clone target into current container
		$( target_image ).clone().appendTo( current_container ).attr( 'class', 'tile-color-preview' );
		
	});
	
	// REMOVE ALTERNATIVE COLOR IMAGE
	$( document ).on( 'mouseleave', 'a[href^="#"]', function() { 
		$( '.tile-color-preview' ).remove();
	});	
});