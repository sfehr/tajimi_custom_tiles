<?php
/**
 * Tajimi Custom Tiles functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Tajimi_Custom_Tiles
 */

/** TCT Custom Functions Inventory:
 *  
 * Load CMB2 Functions  
 * Template Selection for Custom Post Types
 * Get Custom Field Values: File List
 * Get Custom Field Values: Portfolio Data Bundle
 * tct_tile_filter_menu_attributes: adds a data-slug attribute to the naviagtion links
 * Register Custom Menu: Tile filter
 * get children of category
 * Register Ajax Scripts
 * Ajax Filter Posts by Category (sample tiles)
 * ... (Post Form Handler)
 * 
 */


if ( ! function_exists( 'tajimi_custom_tiles_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function tajimi_custom_tiles_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Tajimi Custom Tiles, use a find and replace
		 * to change 'tajimi_custom_tiles' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'tajimi_custom_tiles', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'tajimi_custom_tiles' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'tajimi_custom_tiles_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'tajimi_custom_tiles_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function tajimi_custom_tiles_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'tajimi_custom_tiles_content_width', 640 );
}
add_action( 'after_setup_theme', 'tajimi_custom_tiles_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function tajimi_custom_tiles_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'tajimi_custom_tiles' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'tajimi_custom_tiles' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'tajimi_custom_tiles_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function tajimi_custom_tiles_scripts() {
	wp_enqueue_style( 'tajimi_custom_tiles-style', get_stylesheet_uri() );

	wp_enqueue_script( 'tajimi_custom_tiles-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'tajimi_custom_tiles-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );
	
	//SF: load sample tiles css on sample tile page
	if ( is_page( 'sample-tiles' ) ) {
		wp_enqueue_style( 'sample_tiles_css', get_template_directory_uri() . '/css/sample-tiles.css' );
		wp_enqueue_script( 'sample-tiles-scripts', get_template_directory_uri() . '/js/sample-tile-form-processor.js', array('jquery'), '', true );
	}
		
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'tajimi_custom_tiles_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}







/** SF:
 * Load CMB2 functions
 */
require_once( dirname(__FILE__) . '/inc/tct-cmb2-functions.php');


/** SF:
 * Template Selection for Custom Post Types (Custom Post Types to inherit same template)
 */
add_filter( 'template_include', function( $template ) {
    // your custom post types
    $my_types = array( 'brand_story', 'production_method', 'collaborations' );

    // is the current request for an archive page of one of your post types?
    if ( is_post_type_archive(  $my_types ) ){
        // if it is return the common archive template
        return get_stylesheet_directory() . '/archive-brand_story.php';
    } else 
    // is the current request for a single page of one of your post types?
    if ( is_singular( $my_types ) ){
        // if it is return the common single template
        return get_stylesheet_directory() . '/single-brand_story.php';
    } else {
        // if not a match, return the $template that was passed in
        return $template;
    }
});


/** SF:
 * Get Custom Field Values: Media Group
 */
function tct_get_media_group_entries($class) {
	
	// get the custom field
	$media_group_entries = get_post_meta( get_the_ID(), 'tct_brand_story_group', true );
	
	//get all group values
	foreach ( (array) $media_group_entries as $key => $entry ) {
						
		$radio = isset( $entry['radio_inline'] ) ? $entry['radio_inline'] : '';
		$media = '';
		
		// evaluate if its an image or a movie
		if ( isset( $entry['image'] ) && !empty( $entry['image'] ) && $radio === 'img' ) {
			// special case 'image_id' (!) _id needs to be added to get the value
			$media = wp_get_attachment_image( $entry['image_id'], 'share-pick', null, array(
				'class' => 'thumb',
			) );
		}						

		if ( isset( $entry['movie'] ) && !empty( $entry['movie'] ) && $radio === 'mov' ) {
			$media = wp_oembed_get( esc_url( $entry['movie'] ) );
		}

		// return the value
		print '<div class="' . $class . ' itm-' . $radio . '">' . $media . '</div><!-- .' . $class . ' -->';
	}	
}
add_filter( 'tct_custom_fields', 'tct_get_media_group_entries' );



/** SF:
 * Get Custom Field Values: File List
 */
function tct_get_portfolio_images( $file_list_meta_key, $class, $img_size = '' ) {

	// Get the list of files
	$files = get_post_meta( get_the_ID(), $file_list_meta_key, 1 );

	// Loop through them and output an image
	foreach ( (array) $files as $attachment_id => $attachment_url ) {
		echo '<div class="' . $class . '">';
		echo wp_get_attachment_image( $attachment_id, $img_size );
		echo '</div><!-- .' . $class . ' -->';
	}
}
add_filter( 'tct_custom_fields', 'tct_get_portfolio_images' );



/** SF:
 * Get Custom Field Values: Portfolio Data Bundle
 */
function tct_get_portfolio_data_bundle( $class ) {
	
	$prefix = 'tct_portfolio_data_';
	$fields = array( 'year', 'location_city', 'location_prefecture', 'location_country', 'architect', 'method', 'volume');
	
	// loops through the fields stated in the array $fields
	foreach ( (array) $fields as $field) {
		$field_value = get_post_meta( get_the_ID(), $prefix . $field, true );
		
		
		// SWITCH CASE:
		switch ($field) {
			
			case 'year' :
				// checks if the field contains a value, converts value into a readable format, returns "–" if not
				$field_output = !( $field_value == '' ) ?  date( "Y", $field_value) : '–';
				$field_title = 'year';
				break;
				
			case 'location_city' :
				// checks if the field contains a value, returns "–" if not
				$city = !( $field_value == '' ) ?  $field_value : '–';
				
				// reset value 
				$field_output = '';
				break;
				
			case 'location_prefecture' :
				// checks if the field contains a value, returns "–" if not
				$prefecture = !( $field_value == '' ) ?  $field_value : '–';
				
				// reset value 
				$field_output = '';
				break;
				
			case 'location_country' :
				// checks if the field contains a value, returns "–" if not
				$country = !( $field_value == '' ) ?  $field_value : '–';
				// if all fields are without value ('-'), then display '–' only once
				$field_output = ( !( $city == '–' ) && !( $prefecture == '–' ) && !( $country == '–' ) ) ? $city . ', ' . $prefecture . ', ' . $country : '–';
				$field_title = 'location';
				break;
				
			case 'architect' :
				// checks if the field contains a value, returns "–" if not
				$field_output = !( $field_value == '' ) ?  $field_value : '–';
				$field_title = 'architect';
				break;				

			case 'method' :
				// checks if the field contains a value, returns "–" if not
				$field_output = !( $field_value == '' ) ?  $field_value : '–';
				$field_title = 'method';
				break;
				
			case 'volume' :
				// checks if the field contains a value, adds 'm2' to the value, returns "–" if not
				$field_output = !( $field_value == '' ) && !( $field_value == '0' ) ?  $field_value . 'm2' : '–';
				$field_title = 'volume';
				break;				
				
			default:
				// code to be executed if n is different from all labels;
		} 		
		
		
		// checks weather a field value exist or not
		if ( !empty( $field_output ) ) {
		
			//add specific class to each entry
			$specific_class = !( $field_title == '' ) ? $class . '-' . $field_title : '';
			
			//WRAPPER OPENING TAG
			if( $field_title == 'architect'){
				echo '<div class="portfolio-entry-group">';
			}
			
			echo '<div class="' . $specific_class . '">';
			// checks weather a field title exist or not
			if ( !empty( $field_title ) ) { echo '<span class="data-title">' . esc_html( $field_title ) . '</span>'; }
			echo wpautop( esc_html( $field_output ) );
			echo '</div><!-- .' . $specific_class . ' -->';
			
			//WRAPPER CLOSING TAG
			if( $field_title == 'volume'){
				echo '</div><!-- .portfolio-entry-group -->';
			}			
		}
	}
}

add_filter( 'tct_custom_fields', 'tct_get_portfolio_data_bundle' );


/** SF:
 * Get Custom Field Values: Image (Sample Tile)
 */

function tct_get_sample_tile_images( $meta_key, $class, $img_size = '' ) {
	
	// Get the list of images
	$images = array(
		get_post_meta( get_the_ID(), $meta_key . 'image_1_id', 1 ),
		get_post_meta( get_the_ID(), $meta_key . 'image_2_id', 1 )
	);

	// Loop through them and output an image
	foreach ( (array) $images as $image) {
		$count++;
		echo '<div class="' . $class . ' itm-' . $count . '">';
		echo wp_get_attachment_image( $image, $img_size );
		echo '</div><!-- .' . $class . ' itm-' . $count . ' -->';
	}
	
}
add_filter( 'tct_custom_fields', 'tct_get_sample_tile_images' );


/** SF:
 * Register Custom Menu: Tile filter
 */
function tct_register_custom_new_menu() {
  register_nav_menu('tct-tile-filter-menu',__( 'Sample Tile Filter Menu' ));
}
add_action( 'init', 'tct_register_custom_new_menu' );


/** SF:
 *  tct_tile_filter_menu_attributes: adds a data-slug attribute to the naviagtion links
 */
add_filter( 'nav_menu_link_attributes', 'tct_tile_filter_menu_attributes', 10, 3 );

function tct_tile_filter_menu_attributes( $atts, $item, $args ) {

	// checks with menu object the filter will be applyed on
	if ($args->theme_location == 'tct-tile-filter-menu') {
		
		// get term object by name as title
		$name = $item->title;
		$terms = get_term_by('name', $name, 'tile_category');
		
		// checks if there is a taxonomy term, returns 'no-filter' on false
		if( !empty($terms) ){
			$filter_by = $terms->slug;
		}
		else{
			$filter_by = 'all';
		}
		
		// insert the JS function called in the frontend
//		$atts['data-slug'] = $filter_by;
		$atts['href'] = 'javascript:void(0);';
		$atts['onClick'] = 'filter_posts_by_category("' . $filter_by . '", 1)';
		$atts['class'] = 'tile-filter-link filter-cat-' . $filter_by;
	}
	
	return $atts;

}


/** SF:
 *  conditionally displays child category of a specific parent category (used in ajax_filter_posts_by_category)
 */
function tct_get_child_category($field, $parent, $taxonomy) {
	
	global $post;
	$parents_id = get_term_by($field, $parent, $taxonomy);

	$terms = get_the_terms($post->ID, $taxonomy);
	foreach ($terms as $term) {
		if($term->parent === $parents_id->term_id) { 
			
			$parent_name = get_term_by( 'id', $term->parent, $taxonomy );
			
			print '<span class="' . $parent . '">'. $parent_name->name . ' – ' . $term->name . '</span>';
			break;
		}
	}	
	
}



/** SF:
 *  Register Ajax Scripts
 */
add_action( 'wp_enqueue_scripts', 'ajax_scripts' );

function ajax_scripts() {
	
	//SF: Load Sample Tile Filter JS
	if ( is_page( 'sample-tiles' ) ) {
		wp_enqueue_script( 'ajax-scripts', get_template_directory_uri() . '/js/sample-tile-filter.js', array('jquery'), '', true );
	}
	
	//SF: Load Contact Form Processor JS
	if ( is_page( 'contact' ) ) {
		wp_enqueue_script( 'ajax-scripts', get_template_directory_uri() . '/js/contact-form-processor.js', array('jquery'), '', true );
	}	
	
	//pass the ajax url to javascript
	global $wp_query;
	wp_localize_script( 'ajax-scripts', 'ajaxObject', array( 
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'query_vars' => json_encode( $wp_query->query )
	) );	
}


/** SF:
 *  Ajax Filter Posts by Category (sample tiles)
 */
add_action('wp_ajax_filter_posts_by_category', 'ajax_filter_posts_by_category');
add_action('wp_ajax_nopriv_filter_posts_by_category', 'ajax_filter_posts_by_category');

function ajax_filter_posts_by_category() {

	
	////// CUSTOM WP QUERY (for sample tiles)
	
	// VARIABLES
	$terms = isset($_POST['cat_slug']) && !empty($_POST['cat_slug']) ? $_POST['cat_slug'] : 'all';
	$paged = $_POST['paged'];
	$posts = $_POST['posts'];			

	// ARGS
	if($terms != 'all'){
			
		$args = array(
			'post_type' => 'sample_tile',
			'showposts' => $posts,
			'paged'     => $paged,
			'tax_query' => array(
				array(
					'taxonomy' => 'tile_category',
					'field'    => 'slug',
					'terms'    => $terms
				)
			),
			'order'   => 'asc',
			'orderby' => 'title',
		);
			
	}	
	else{
		$args = array(
			'post_type' => 'sample_tile',
			'showposts' => $posts,
			'paged'     => $paged,
			'order'   => 'asc',
			'orderby' => 'title',				
		);
	}

	// LOOP
	$tct_query = null;
	$tct_query = new WP_Query($args);
	while( $tct_query -> have_posts() ) : $tct_query -> the_post();
	
	
		// TILE CONTAINER
	
		// the tile ID is submitted to give the radio buttons a uniqe name per post
		?>
		<div class="sample-tile">
			
			<input id="tct_sample_tile_checkbox_<?php the_ID(); ?>" type="checkbox" name="tct_tile[]" class="tile-checkbox" value="<?php the_title(); ?>">
			<label class="tile-checkbox-label" ><?php the_title(); ?></label>
			
			<input id="tct_sample_tile_radio_<?php the_ID(); ?>_1" type="radio" name="tct_tile_image_<?php the_ID(); ?>" class="tile-radio-1" checked="checked" value="">
			<label for="tct_sample_tile_radio_<?php the_ID(); ?>_1" class="tile-radio-label" >1</label>
			
			<input id="tct_sample_tile_radio_<?php the_ID(); ?>_2" type="radio" name="tct_tile_image_<?php the_ID(); ?>" class="tile-radio-2" value="">
			<label for="tct_sample_tile_radio_<?php the_ID(); ?>_2" class="tile-radio-label" >2</label>
			
			<?php
			// TILE PRODUCTION METHOD
			tct_get_child_category('slug', 'tile_production_method', 'tile_category');
	

			// TILE IMAGES: image1, image2
			tct_get_sample_tile_images( 'tct_sample_tiles_', 'tile-image' ); 
			
	
			// TILE TOOLTIP
			?>
			<div class="tile-tooltip">
			  <p><?php the_title(); ?></p>
			</div>
			
		</div>
		
	<?php
	endwhile; wp_reset_query();
	
	////// END CUSTOM WP QUERY
	die();
}


/** SF:
 *  tct_form_response: handles the post submission form
 *  progressive enhancement: when JS is available the form is triggered by the AJAX
 */
add_action( 'admin_post_tct_form_response', 'tct_form_response');
add_action( 'admin_post_nopriv_tct_form_response', 'tct_form_response');
add_action( 'wp_ajax_tct_form_response', 'tct_form_response');
add_action( 'wp_ajax_nopriv_tct_form_response', 'tct_form_response');

function tct_form_response(){
	
	//VARIABLES
	$tct_subject = "Incoming message via " . get_bloginfo('name');
	$tct_errors = array();
	$tct_mail_recipient = 'sebastianfehr1@gmail.com';
	
	// SECURITY CHECKS: nonce field, Server Request, if $_POST is not empty, if invisible "name" field is empty
	
	if( isset( $_POST['tct_contact_form_nonce'] ) && wp_verify_nonce( $_POST['tct_contact_form_nonce'], 'tct_add_contact_form_nonce') && 'POST' == $_SERVER['REQUEST_METHOD'] && !empty($_POST) &&  empty($_POST['name']) ) {
		
		
		// BULK CHEK / SANITIZE
		
		$fields = array( 'first_name', 'last_name', 'email', 'company', 'message' );

		foreach ($fields as $field) {
			if( isset($_POST['tct'][$field] ) ) $posted[$field] = strip_tags( trim( $_POST['tct'][$field] ) ); else $posted[$field] = '';
		}		
		
		
		// SANITIZE
		
		// Individual field check and sanitize
//use specific santize function 
		if( $posted['first_name'] == null ) array_push( $tct_errors,  sprintf( 'Notice: Please enter Your First Name.', 'tajimi_custom_tiles' ) );
		if( $posted['last_name'] == null ) array_push( $tct_errors,  sprintf( 'Notice: Please enter Your Last Name.', 'tajimi_custom_tiles' ) );
		if( $posted['email'] == null ) array_push( $tct_errors,  sprintf( 'Notice: Please enter Your Email.', 'tajimi_custom_tiles' ) );
		if( $posted['company'] == null ) array_push( $tct_errors,  sprintf( 'Notice: Please enter Your Company.', 'tajimi_custom_tiles' ) );
		if( $posted['message'] == null ) array_push( $tct_errors,  sprintf( 'Notice: Please enter a Message.', 'tajimi_custom_tiles' ) );
		
		$errors = array_filter( $tct_errors );
		
		
		// FILE HANDLE
		
		// If no errors, handles the upload file
		if( empty( $errors ) ) { 
			
			/*
			// gets the install path
			if ( ! function_exists( 'wp_handle_upload' ) ) {
				require_once( ABSPATH . 'wp-admin/includes/file.php' );
			}			
			
			//file from the superglobal
			
			$uploadedfile = $_FILES['attachmentFile'];
			
			$upload_overrides = array( 'test_form' => false );
			
			$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );

			if ( $movefile && ! isset( $movefile['error'] ) ) { 
				$movefile['url'];
			}
			*/
			
			if ( 'POST' == $_SERVER['REQUEST_METHOD']  ) {
				
				if ( $_FILES ) {
					
					$files = $_FILES["tct_multiple_attachments"]; 
					
					foreach ( $files['name'] as $key => $value ) {
						
						if ( $files['name'][$key] ) { 
							$file = array( 
										'name' => $files['name'][$key],
										'type' => $files['type'][$key], 
										'tmp_name' => $files['tmp_name'][$key], 
										'error' => $files['error'][$key],
										'size' => $files['size'][$key]
									); 
								
							$_FILES = array ( "tct_multiple_attachments" => $file );
								
							
							foreach ( $_FILES as $file => $array ) {
								
								var_dump( $file );
								
								$newupload = tct_handle_attachment( $file ); 
							}
						}
					} 
				}
			}			

			
//var_dump($newupload);
			
			$attachments = array( $movefile['file'] );
			
			$headers = 'From: '. $posted['first_name'] . $posted['last_name'] .' <'. $posted['email'] .'>' . "\r\n";
			
			
			if( wp_mail( $tct_mail_recipient, $tct_subject , $posted['message'], $headers, $attachments ) ){
//				die( 'success!' );
// prepare a Server side response				
			}
			else{
//				die( 'no success!' );
			}
			
			// delete file 
			unlink( $movefile['file'] );
		}
		else{
			die( implode('<br>', $errors) );
		}
		
	
		// RESPONSE (AJAX)
		
		// if JS/Ajax is available -> message 
		if( isset( $_POST['ajaxrequest'] ) && $_POST['ajaxrequest'] === 'true' ) {
			// server response
			echo '<pre>';					
			  print_r( $_POST );
			echo '</pre>';				
			wp_die();
		  }	
		
//temporarely		
//		print_r( $_FILES );
		wp_die();
		
		// RESPONSE (admin Post)
		
		$url = $_SERVER['HTTP_REFERER'];
		wp_redirect( $url );
		die();
	}
	else{

		wp_die( __( 'Invalid nonce specified', '{text-domain}' ), __( 'Error', '{text-domain}' ), array(
					'response' 	=> 403,
//					'back_link' => 'admin.php?page=' . $this->plugin_name,
		) );	
	}
}


function tct_handle_attachment( $file_handler ) {	
	
	// check to make sure its a successful upload
	if ( $_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();

		require_once(ABSPATH . "wp-admin" . '/includes/image.php');
		require_once(ABSPATH . "wp-admin" . '/includes/file.php');
		require_once(ABSPATH . "wp-admin" . '/includes/media.php');

//		$attach_id = media_handle_upload( $file_handler, $post_id );
		$movefile = wp_handle_upload( $file_handler, array( 'test_form' => false ) );

	return $movefile;
}


