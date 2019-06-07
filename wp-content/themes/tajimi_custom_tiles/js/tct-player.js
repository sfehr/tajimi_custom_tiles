/**
 * File tct-player.js
 *
 */

/*
jQuery( document ).ready( function( $ ){	
	
	// VARIABLES
	var tct_players = [];
	var video_url = [];
	var iframes = [];
	
	// INITIALIZE
	$( '.itm-mov iframe' ).each( function( ind ){
		
		iframes[ ind ] = $( this );
		
		// GET SRC
		video_url[ ind ]  = $( this ).attr( 'src' );
		
		// SET ID TO PARENT DIV
		$( this ).parent( '.itm-mov' ).attr( 'id', 'vid-' + ind );
		
		tct_players[ ind ] = new Vimeo.Player( $( this ) );
		
	});
	
	// FIRE WHEN VIDEO LOADED
	$( tct_players ).each( function( ind ) {		
		
		this.on( 'loaded', function() {
			console.log( 'video ' + ind + ' loaded!' );
			
			// SAVE TARGET DIV IN VARIABLE
			var parent_div = iframes[ ind ].parent( '.itm-mov' );
			console.log( parent_div );
			
			// REMOVE IFRAME
			iframes[ ind ].remove();
			
			// PLAYER OPTIONS
			var tct_options = {
				url: video_url[ ind ],
				background: true,
				autopause: false
			};			
			
			// REPLACE PLAYER OBJECT
			tct_players[ ind ] = new Vimeo.Player( parent_div, tct_options);
			
		});	
		
	});

	
	console.log( 'video_url: ' + video_url );
	
});



/*
jQuery( document ).ready( function( $ ){
	
	var players = [];
	
	$( 'body' ).find( '.itm-mov' ).each(function( ind ){
		
		// GET SRC
		var url = $( this ).children( 'iframe' ).attr( 'src' );
		console.log('url: ' + url);
		
		// REPLACE MARKUP
		$( this ).attr( 'id', 'vid-' + ind );
//		$( this ).children( 'iframe' ).remove();
		
		// PLAYER OPTIONS
		var options = {
			url: url,
			background: true,
			autopause: false
		};		
		
		// PLAYER INIT
		players[ ind ] = new Vimeo.Player( $( this ).attr( 'id' ), options);
		
		
		// VIDEO IMAGE
		
	});

	// PLAYER INTERACTION
/*	
	$( players ).each(function() {		
		this.on('play', function() {
			console.log('played the video!');
		});	
	});	
*/
	
//});