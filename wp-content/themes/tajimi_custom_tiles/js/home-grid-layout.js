/**
 * File home-grid-layout.js
 * Layouting the grid items in the front page
 * 
 * VARIABLES 
 * TILE LAYOUT DISTRIBUTION (across the DOM Tree)
 * TEXT ITEM INIT (adapting to the grid)
 * ENTRY MEDIA INIT: distributes different sizes and placing options via css class
 * RIGHT HAND POSITION IN GRID
 * GRID ALIGNER FUNCTION (TEXT)
 * MEDIA ITEM PLACING FUNCTION 
 * MEDIA QUERIES
 */

// VARIABLES
var n_random_sizing = '';
var n_random_placing = '';

jQuery( document ).ready( function( $ ) {
	'use strict';
	
	// TILE LAYOUT DISTRIBUTION (across the DOM Tree)
	var articles = $( 'body article' );
	var articles_ind = 0;

	$( 'body .sample-tile' ).each( function( ind, ele ) {	
		
		articles[ articles_ind ].append( ele );
//		console.log( 'tile: ' + ind + ', article: ' + articles_ind );		
		
		if( articles_ind < ( articles.length -1 )  ){
			articles_ind++;
		}
		else{
			articles_ind = 0;
		}
		
	});
	
	
	txt_elements_init();
	
	// TEXT ITEM AUTO HEIGHT (adapting to the grid)
	function txt_elements_init(){
		
		var html_styles = window.getComputedStyle( document.querySelector( 'html' ) );
		var grid_col_width = parseInt( html_styles.getPropertyValue( '--grid-column' ) );
		var grid_row_height = parseInt( html_styles.getPropertyValue( '--grid-row' ) );
		var grid_gap = parseInt( html_styles.getPropertyValue( '--grid-gap' ) );		
		var itm_dimensions;
		var x_off = 1;
		var y_off = 2;
		
		// Breakpoint Check
		if( $( window ).width() < 506 ) {
			
			grid_col_width = 15.5;
			
			// convert vw/vh units into px
			grid_col_width = ( $( window ).width() * grid_col_width ) / 100;
			grid_row_height = grid_col_width;
			grid_gap = ( $( window ).width() * grid_gap ) / 100;
			x_off = y_off = 0;
		}		
		
		$( 'body .entry-content' ).each( function() {
				
			itm_dimensions = grid_aligner( $( this ), grid_col_width, grid_row_height, grid_gap, x_off, y_off );

			//container height in px
			$(this).height( (itm_dimensions[1] * (grid_row_height + grid_gap) - grid_gap) );

			//container height in unit (depending on content)
			$(this).css('grid-row-end', 'span ' + itm_dimensions[3] );

			//add content aligning class for txt item
			$(this).addClass('pl-c-l');
		});		
		
	}

	
	
	// ENTRY MEDIA INIT: distributes different sizes and placing options via css class
	$( '.entry-media' ).each( function( index ) {	
		// get a random value from 1~3
		var n = Math.floor( Math.random() * Math.floor( 3 ) );
		
		while (n_random_sizing === n) {
			n = Math.floor( Math.random() * Math.floor( 3 ) );
		}		
		
		// ITM SIZING and PLACING
		switch( n ){
			case 0:
				// 'itm-s' -> 2-2 -> 1~7
				$(this).addClass( 'itm-s' );
				$(this).addClass( get_css_placement( 6 ) );
				
				break;
		
			case 1:
				// 'itm-m' -> 1-1 -> 1~4
				$(this).addClass( 'itm-m' );
				$(this).addClass( get_css_placement( 3 ) );
				
				break;
		
			case 2:
				 // 'itm-l' -> 1-1 -> 1~4
				 $(this).addClass( 'itm-l' );
				 $(this).addClass( get_css_placement( 3 ) );
				
				 break;		
		 }
		
		n_random_sizing = n;
		
		// RIGHT HAND POSITION IN GRID: toggles right position class (only right aligned itmes and  only even items)
		if( $( this ).hasClass( 'pl-t-r' ) || $( this ).hasClass( 'pl-b-r' ) || $( this ).hasClass( 'pl-c-r' ) && ( index % 2 ) === 0 ){

			// Right Position s
			if( $( this ).hasClass( 'itm-s' ) ){
				$( this ).toggleClass( 'rpos-s' );
			}

			// Right Position m
			if( $( this ).hasClass( 'itm-m' ) ){
				$( this ).toggleClass( 'rpos-m' );
			}

			// Right Position l
			if( $( this ).hasClass( 'itm-l' ) ){
			  $( this ).toggleClass( 'rpos-l' );
			}
		  }
	});
	
	
	
	// GRID ALIGNER FUNCTION (TEXT)
	
	function grid_aligner( itm, grid_col_width, grid_row_height, grid_gap, x_off = '0', y_off = '0' ){

		var itm_w = 0;
		var itm_h = 0;		
		
		//get dimensions of all children and summarize

		itm.children().each( function() {
			itm_w += $( this ).outerWidth( true );
			itm_h += $( this ).outerHeight( true );
		});
		
		//aligne dimension to grid by rounding up
		var aligned_w = Math.ceil( itm_w / (grid_col_width + grid_gap) );
		var aligned_h = Math.ceil( itm_h / (grid_row_height + grid_gap) );

		//add offset
		var item_w_new = aligned_w + x_off;
		var item_h_new = aligned_h + y_off;

		//prepare array for output
		var itm_dimension = [aligned_w, aligned_h, item_w_new, item_h_new];

		return itm_dimension;
	}
	
	
	// MEDIA ITEM PLACING FUNCTION 
	function get_css_placement( max ){
		// different placing options depending on size of the item 
		var n = Math.floor( Math.random() * Math.floor(max) );
		var css_align = '';
		
		while (n_random_placing === n) {
			n = Math.floor( Math.random() * Math.floor(max) );
		}		
		
		switch(n){
			case 0:
				// top left
				css_align = 'pl-t-l';
				break;

			case 1:
				// top right				
				css_align = 'pl-t-r';
				break;

			case 2:
				// top right				
				css_align = 'pl-b-l';
				break;

			case 3:
				// bottom right
				css_align = 'pl-b-r';
				break;

			case 4:
				// center left
				css_align = 'pl-c-l';
				break;

			case 5:
				// center right
				css_align = 'pl-c-r';
				break;

			case 6:
				// center center
				css_align = 'pl-c-c';
				break;      

	//    default:
			// code block
		}
		
		n_random_placing = n;
		
		return css_align;		
		
	}
	

	// MEDIA QUERIES
	$( window ).on( 'resize', function(){
		
//		if( $( window ).width() < 700 ){
		   txt_elements_init();
//		}
		
	});
	 
});


