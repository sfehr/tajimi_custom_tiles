/**
 * File sample-tile-filter.js.
 *
 * Handles custom post query with category filter on sample page by using ajax.
 * 
 */


jQuery(document).ready(function(){
	
	//initial loads all posts
	filter_posts_by_category('all', 1);
	
	jQuery( '#menu-tct-sample-tile-filter a' ).each(function(){
		
		// preventing the link to 'click'
		jQuery(this).click(function( e ) {
			e.preventDefault();
		});
	});
});
    
    
    var filter_posts_by_category = function(cat_slug, paged){
//        var ajax_url = window.location.protocol + "//" + window.location.host + '/wp-admin/admin-ajax.php';
		
        var total_posts = -1; // -1 for show all posts
        
        var data = {
            'action'   : 'filter_posts_by_category', // action called in the WP functions.php (wp_ajax_filter_posts_by_category, wp_ajax_nopriv_filter_posts_by_category)
            'cat_slug' : cat_slug,
            'posts'    : total_posts,
            'paged'    : paged,
        };
        
        jQuery.ajax({
            method     : 'POST',		
            url        : ajaxObject.ajax_url, //defined in functions.php
            data       : data,
            beforeSend : function(){
				
				// FILTER MENU: functionality to select unselect category
                jQuery( '.tile-filter-link' ).each(function(){
                    jQuery(this).removeClass( 'selected-cat' );
                });
                jQuery( '.filter-cat-' + cat_slug ).addClass( 'selected-cat' );
                
				
				// HTML: Remove all the sample-tile divs first before loading new ones
                jQuery( '.sample-tile' ).each(function(){
                    jQuery(this).remove();
                });				
				
				
				// LOADER: insert a loading status
				var loader_msg = '<div class="loader-state">Loading Tiles</div>';
				
				if( jQuery( '.loader-state' ).length === 0 ){
					jQuery( loader_msg ).insertAfter( '.entry-content' );	
				}
                
				
            },
            success: function(result){
	
				// LOADER: Remove loading status
				jQuery( '.loader-state' ).remove();

				
				// HTML: output the markup
				jQuery( result ).insertAfter( '.entry-content' );				
				
            },
            error: function(xhr,status,error){
				//console.log(error);
            }
        });
};