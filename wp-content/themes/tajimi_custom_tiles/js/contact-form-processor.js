/**
 * File contact-form-processor.js
 *
 * Handles interaction with the contact form
 * 
 */
	
jQuery( document ).ready( function( $ ) {

        "use strict";
	/**
     * The file is enqueued from inc/admin/class-admin.php.
	 */
        $( '#tct-contact-form' ).submit( function( event ) {
            
            event.preventDefault(); // Prevent the default form submit.            
            
            // serialize the form data
//            var ajax_form_data = $( '#tct-contact-form' ).serialize();
			var ajax_form_data = new FormData($(this)[0]);
//			var ajax_form_data = new FormData();    
			
			$.each( $( '#tct_file' )[0].files, function( i, file ) {
				ajax_form_data.append( 'tct_multiple_attachments[]', file );
			});
            
            //add our own ajax check as X-Requested-With is not always reliable
//            ajax_form_data = ajax_form_data + '&ajaxrequest=true&submit=Submit+Form';
			
			console.log('ajax_form_data:' + ajax_form_data );
			
            $.ajax({
                url:			ajaxObject.ajax_url, // domain/wp-admin/admin-ajax.php
                type:			'post',
                data:			ajax_form_data,
				cache:			false,
				contentType:	false,
				processData:	false,
//				dataType:		'json'
            })
            
            .done( function( response ) { // response from the PHP action
                $(' #tct-form-respond ').html( "<h2>The request was successful </h2><br>" + response );
            })
            
            // something went wrong  
            .fail( function() {
                $(' #tct-form-respond ').html( "<h2>Something went wrong.</h2><br>" );                  
            })
        
            // after all this time?
            .always( function() {
                event.target.reset();
            });
       });
});
