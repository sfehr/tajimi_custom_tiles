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

	$( '#menu-production-method-menu a, #menu-production-method-menu-jp a, #menu-collaborations-menu a' ).each(function(){
		
		$( this ).on( 'click', function( e ) {
			// preventing the link to 'click'
			e.preventDefault();
			
			var menu_type = $( this ).parents( '.menu' );
			var menu_item = $( this ).text();
			var menu_item_res = menu_item.split( ' ' );
			var selector;
			
			
			// depending on the menu the selector pics up different elements
			if( menu_type.attr( 'id' ) === 'menu-collaborations-menu' ){
				selector = $( 'body article' );
			}
			else{
				selector = 'body h1.entry-title';
			}
				
			// production method page: checks if text is = menu text
			// collaborations page: checks if class name (taxonomy) contains both first AND last name (of the menu)
			$( selector ).each(function(){
				if( $( this ).text() === menu_item || ( ( $( this ).attr( 'class' ).indexOf( menu_item_res[0].toLowerCase() ) != -1 ) && ( $( this ).attr( 'class' ).indexOf( menu_item_res[1].toLowerCase() ) != -1 ) ) ){
					
					var target = $( this ).closest( 'article' );
					
					$('html, body').stop().animate({
						scrollTop: $( target ).position().top - (grid_gap - 2)
					}, 500, 'swing');					
				}
			});
		});
	});
});	
	
