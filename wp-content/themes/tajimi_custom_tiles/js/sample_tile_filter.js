
jQuery(document).ready(function(){
	
	console.log('test');
	filter_posts_by_category('all', 1);

});
    
    
    var filter_posts_by_category = function(cat_slug, paged){
//        var ajax_url = window.location.protocol + "//" + window.location.host + '/wp-admin/admin-ajax.php';
        
        var total_posts = -1; // -1 for show all posts
        
        var data = {
            'action'      : 'filter_posts_by_category', // action called in the WP functions.php (wp_ajax_filter_posts_by_category, wp_ajax_nopriv_filter_posts_by_category)
            'cat_slug'    : cat_slug,
            'posts'       : total_posts,
            'paged'       : paged,
        };
        
        jQuery.ajax({
            method:"POST",		
            url: ajaxFilterPosts.ajax_url, //defined in functions.php
            data: data,
            beforeSend : function(){
                // functionality to select unselect category
                jQuery('.filter_icon').each(function(){
                    jQuery(this).removeClass('selected_cat');
                });
                
                jQuery('.'+cat_slug).addClass('selected_cat');
                
                // function to set calender icon url to another location
                setCalenderUrl(cat_slug);
                
                jQuery('#post_filtered').html('<p style="text-align:center"><img class="img_loader" src="' + window.location.protocol + '//' + window.location.host + '/images/postloading.gif" /></p>');
            },
            success: function(result){
                jQuery('#post_filtered').html(result);
            },
            error: function(xhr,status,error){
                // console.log(error);
            }
        });
};