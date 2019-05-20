/**
 * File contact-form-processor.js
 *
 * FORM SUBMISSION: Handles interaction with the contact form
 * FORM INTERACTION TILE SELECTION: Removes selected input fields when button is clicked
 * 
 */


// FORM SUBMISSION
jQuery( document ).ready( function( $ ) {

        "use strict";
	/**
     * The file is enqueued from inc/admin/class-admin.php.
	 */
        $( '#tct-contact-form' ).submit( function( event ) {
            
            event.preventDefault(); // Prevent the default form submit.            
			
			$( '#contact_submit' ).attr( 'disabled', true ); // Disable Button while AJAX processing
			
			// FORM DATA OBJECT
			var data = new FormData( $( this )[0] );						
            
            // add our own ajax check as X-Requested-With is not always reliable
            //data = data + '&ajaxrequest=true&submit=Submit+Form';
			data.append( 'tct_ajaxrequest', 'true' );
			
            $.ajax({
                url:			ajaxObject.ajax_url, // domain/wp-admin/admin-ajax.php
                type:			'POST',
                data:			data,
				cache:			false,
				dataType:		'json',
				processData:	false,
				contentType:	false,
            })
			
            
            .done( function( response ) { // response from the PHP action
				$( '#tct-form-respond' ).html( response.message );
				
				//reset the input fields on success
				if( ( response.fields && response.mail ) == 'SUCCESS' ){
					event.target.reset();
					$( '.message_tile_selection' ).remove();
				}
            })
            
            // something went wrong  
            .fail( function() {
                $( '#tct-form-respond' ).html( "Something went wrong.<br>" );                  
            })
        
            // after all this time?
            .always( function() {
				$( '#contact_submit' ).attr( 'disabled', false ); // Enable Button while AJAX processing
            });
       });
});


// FORM INTERACTION TILE SELECTION: Removes selected input fields when button is clicked
jQuery( document ).ready( function( $ ) {
	
	$( '#tct-contact-form' ).on( 'click', 'a.button-delete', function( event ){
		
		event.preventDefault();
		// remove the parent container field
		$( this ).parent( '.message_tile_selection' ).remove();
		// remove the delete button
//		$( this ).remove();
	});
	
});	
	
