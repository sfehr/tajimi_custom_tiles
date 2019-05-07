/**
 * File production-method-sub-menu.js
 *
 * Page Anchour Slider
 * 
 */

// VARIABLES
var bodyStyles = window.getComputedStyle(document.body);
var grid_gap = Number( bodyStyles.getPropertyValue( '--grid-gap' ).replace( 'px', '' ) );

jQuery( document ).ready(function( $ ){

	$( '#menu-production-method-menu a' ).each(function(){
		
		$( this ).click( function( e ) {
			// preventing the link to 'click'
			e.preventDefault();
			
			var menu_item = $( this ).text()
			
//			var target = $( 'body .entry-header' ).find( 'h1' ).text( title );
			
			$( 'body h1.entry-title' ).each(function(){
				if( $( this ).text() == menu_item){
					
					var target = $( this ).closest( 'article' );
					
					$('html, body').animate({
						scrollTop: ( $( target ).offset().top - (grid_gap - 1) )
					}, 500 );
				}
			});
		});
	});
});	
	
