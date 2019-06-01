/**
 * File tct-player.js
 *
 */
	
jQuery( document ).ready( function( $ ){
	
	var players = [];
	
	$( 'body' ).find( '.itm-mov' ).each(function( ind ){
		
		// GET SRC
		var url = $( this ).children( 'iframe' ).attr( 'src' );
		console.log('url: ' + url);
		
		// REPLACE MARKUP
		$( this ).attr( 'id', 'vid-' + ind );
		$( this ).children( 'iframe' ).remove();
		
		// PLAYER OPTIONS
		var options = {
			url: url,
			background: true,
			autopause: false
		};		
		
		// PLAYER INIT
		players[ ind ] = new Vimeo.Player( $( this ).attr( 'id' ), options);
	});

	// PLAYER INTERACTION
/*	
	$( players ).each(function() {		
		this.on('play', function() {
			console.log('played the video!');
		});	
	});	
*/
	
});