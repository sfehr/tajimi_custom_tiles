/**
 * File tct-anchor-scroll.js
 *
 * Scrolls to anchor
 *
 *
 * SCROLL TO ANCHOR FUNCTION	
 *  
*/

jQuery( document ).ready( function( $ ) {
	
	// SCROLL TO ANCHOR FUNCTION	
	$( document ).on( 'click', 'a[href^="#"]', function( e ) { 
		
		e.preventDefault(); 
		var dest = $( this ).attr( 'href' ); 
		
		
		$( 'html, body' ).animate({ 
			scrollTop: $( dest ).offset().top + 2 }, 'smooth' ); 
		
	});
	
});
