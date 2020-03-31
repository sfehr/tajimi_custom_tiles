/**
 * File production-method-sub-menu.js
 *
 * Page Anchour Slider
 * 
 */

// VARIABLES
/*
var bodyStyles = window.getComputedStyle(document.body);
var grid_gap = Number( bodyStyles.getPropertyValue( '--grid-gap' ).replace( /px|vw/, '' ) );
*/
var grid_gap = 0;

jQuery( document ).ready(function( $ ){

	$( '#menu-production-method-menu a, #menu-production-method-menu-jp a' ).each(function(){
		
		$( this ).on( 'click', function( e ) {
			// preventing the link to 'click'
			e.preventDefault();
			
			var menu_item = $( this ).text();
			
			$( 'body h1.entry-title' ).each(function(){
				if( $( this ).text() === menu_item){
					
					var target = $( this ).closest( 'article' );
					
					$('html, body').stop().animate({
						scrollTop: $( target ).position().top - (grid_gap - 2)
					}, 500, 'swing');					
				}
			});
		});
	});
});	
	
