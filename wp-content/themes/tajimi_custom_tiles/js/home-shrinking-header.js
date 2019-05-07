/**
 * File home-shrinking-header.js
 *
 * Lets the logo shrink in home page
 * 
 */

// VARIABLES
var bodyStyles = window.getComputedStyle(document.body);
var size_small = bodyStyles.getPropertyValue( '--logo-size-small' ).replace( 'px', '' );

jQuery( document ).ready(function( $ ){

	$( document ).on( 'scroll', function() {

	  if ( $( this ).scrollTop() > size_small ){
//		  console.log('shrink');
		  $( 'header' ).addClass( 'shrink' );
	  } else {
//		  console.log('grow');
		  $( 'header' ).removeClass( 'shrink' );
	  }

	});
});	
	
