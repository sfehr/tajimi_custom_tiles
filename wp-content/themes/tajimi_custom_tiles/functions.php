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
 * Add Meta Tags
 * TCT Custom Image Sizes
 * Template Selection for Custom Post Types
 * Get Custom Field Values: Media Group
 * modify_vimeo_embed_url
 * Get Custom Field Values: Profile 
 * Get Custom Field Values: File List
 * Get Custom Field Values: Portfolio Data Bundle
 * Get Custom Field Values: Image (Sample Tile)
 * Get Custom Field Values: Sample Tile: No Stock
 * Get Custom Field Values: Sample Tile: Dimensions 
 * Get Custom Field Values: Sample Tile: Info
 * Get Custom Field Values: Sample Tile: Color Variations
 * tct_tile_filter_menu_attributes: adds a data-slug attribute to the naviagtion links
 * tct_get_child_category
 * display additional header menu
 * display footer menu
 * Sort Posts by Taxonomy Term
 * Register Ajax Scripts
 * Ajax Filter Posts by Category (sample tiles)
 * tct_form_response: handles the post submission form 
 * Display Post Types in homepage
 * Chose a custom template in homepage 
 * Limiting Gutenbergs Block elements
 * Unsync specified custom fields
 * Adding Title Attribute to Images
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
			'tct-tile-filter-menu' => esc_html__( 'Sample Tile Filter Menu', 'tajimi_custom_tiles' ),
			'tct-production-method-menu' => esc_html__( 'Production Method Menu', 'tajimi_custom_tiles' ),
			'tct-collaborations-menu' => esc_html__( 'Collaborations Menu', 'tajimi_custom_tiles' ),
			'tct-footer-menu' => esc_html__( 'Footer Menu', 'tajimi_custom_tiles' ),
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
	
	//SF: load pace.js for page loading progress UI (in Header)
	wp_enqueue_script( 'page-loading-ui-js', get_template_directory_uri() . '/js/pace.js', array(), '', false );
	wp_enqueue_style( 'page-loading-ui-css', get_template_directory_uri() . '/css/page-loading-ui.css' );
	
	//SF: load sample tiles css on sample tile page
	if ( is_page( 'sample-tiles' ) ) {
		wp_enqueue_style( 'sample_tiles_css', get_template_directory_uri() . '/css/sample-tiles.css' );
		wp_enqueue_script( 'sample-tiles-processor', get_template_directory_uri() . '/js/sample-tile-form-processor.js', array('jquery'), '', true );
		wp_enqueue_script( 'sample-tiles-interaction', get_template_directory_uri() . '/js/sample-tile-interaction.js', array('jquery'), '', true );
		wp_enqueue_script( 'sample-tiles-anchor-scroll', get_template_directory_uri() . '/js/tct-anchor-scroll.js', array('jquery'), '', true );
		wp_enqueue_script( 'sample-tiles-color-preview', get_template_directory_uri() . '/js/sample-tile-color-preview.js', array('jquery'), '', true );
		wp_enqueue_script( 'sample-tiles-sorting', get_template_directory_uri() . '/js/tinysort.min.js', array(), '', true );
	}
	
	//SF: load file input js enhancement on contact page
	if ( is_page( 'contact' ) ) {
		wp_enqueue_script( 'sample-tiles-scripts', get_template_directory_uri() . '/js/tct-file-input.js', array('jquery'), '', true );
	}	
	
	//SF: in homepage, load extra css
	if ( is_home() ) {
		wp_enqueue_style( 'sample_tiles_css', get_template_directory_uri() . '/css/sample-tiles.css' );
		wp_enqueue_script( 'sample-tiles-scripts', get_template_directory_uri() . '/js/sample-tile-interaction.js', array('jquery'), '', true );
//		wp_enqueue_style( 'home_page_css', get_template_directory_uri() . '/css/home-page.css' );
//		wp_enqueue_script( 'sample-tiles-scripts', get_template_directory_uri() . '/js/home-grid-layout.js', array('jquery'), '', true );
//		wp_enqueue_script( 'home-layout-scripts', get_template_directory_uri() . '/js/home-shrinking-header.js', array('jquery'), '', true );		
	}
	
	//SF: on designated post-type-archive: load media image slider skript
	if ( is_post_type_archive( array( 'brand_story', 'production_method', 'collaborations', 'portfolio' ) ) ) {
		wp_enqueue_script( 'sample-tiles-scripts', get_template_directory_uri() . '/js/media-image-slider.js', array('jquery'), '', true );
	}
	
	//SF: JS for removing dimensions from img tag
	wp_enqueue_script( 'image-dimensions', get_template_directory_uri() . '/js/tct-img-markup.js', array('jquery'), '', true );
	
	//SF: on designated pages: load vimeo player api
//	if ( is_home() || is_post_type_archive( array( 'brand_story', 'production_method', 'collaborations' ) ) ) {
//		wp_enqueue_script( 'vimeo-scripts-api', 'https://player.vimeo.com/api/player.js', array(), '', true );
//		wp_enqueue_script( 'vimeo-scripts-player', get_template_directory_uri() . '/js/tct-player.js', array('jquery'), '', true );
//	}	
	
	//SF: on production method page: load sub navigation anchour slider
	if ( is_post_type_archive( array( 'production_method', 'collaborations' ) ) ) {
		wp_enqueue_script( 'production-methods-scripts', get_template_directory_uri() . '/js/sub-menu.js', array('jquery'), '', true );
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
 * Add Meta Tags
 */
function tct_add_meta_tags() {
	
	// Google Tag Manager
	echo "
		<!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-5HMMGD2');</script>
		<!-- End Google Tag Manager -->	
	";
	
	
	// for EN typeface
	echo '<link rel="stylesheet" href="https://use.typekit.net/wlv6frg.css">';
	
	// for JP typeface
	if ( function_exists( 'pll_current_language' ) && ( pll_default_language() != pll_current_language() ) ){	
		echo "
			<script>
			  (function(d) {
				var config = {
				  kitId: 'ept0bzo',
				  scriptTimeout: 3000,
				  async: true
				},
				h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,\"\")+\" wf-inactive\";},config.scriptTimeout),tk=d.createElement(\"script\"),f=false,s=d.getElementsByTagName(\"script\")[0],a;h.className+=\" wf-loading\";tk.src='https://use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!=\"complete\"&&a!=\"loaded\")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
			  })(document);
			</script>
		";
	}

	// Social Media
	echo '
	<!-- Primary Meta Tags -->
	<title>Tajimi Custom Tiles – Bespoke Tiles made in Tajimi, Japan</title>
	<meta name="title" content="Tajimi Custom Tiles – Bespoke Tiles made in Tajimi, Japan">
	<meta name="description" content="Tajimi City is the center of the Japanese tile industry, with a centuries-old tradition of craftsmanship and excellence. Tajimi Custom Tiles creates custom-tailored tiles in any size, shape, color or texture, using a range of unique production, glazing and firing methods. ">

	<!-- Open Graph / Facebook -->
	<meta property="og:type" content="website">
	<meta property="og:url" content="https://tajimicustomtiles.jp/">
	<meta property="og:title" content="Tajimi Custom Tiles – Bespoke Tiles made in Tajimi, Japan">
	<meta property="og:description" content="Tajimi City is the center of the Japanese tile industry, with a centuries-old tradition of craftsmanship and excellence. Tajimi Custom Tiles creates custom-tailored tiles in any size, shape, color or texture, using a range of unique production, glazing and firing methods. ">
	<meta property="og:image" content="https://tajimicustomtiles.jp/wp/wp-content/uploads/2020/04/TCT_Logo_mark_og.png">

	<!-- Twitter -->
	<meta property="twitter:card" content="summary_large_image">
	<meta property="twitter:url" content="http://tajimicustomtiles.jp/">
	<meta property="twitter:title" content="Tajimi Custom Tiles – Bespoke Tiles made in Tajimi, Japan">
	<meta property="twitter:description" content="Tajimi City is the center of the Japanese tile industry, with a centuries-old tradition of craftsmanship and excellence. Tajimi Custom Tiles creates custom-tailored tiles in any size, shape, color or texture, using a range of unique production, glazing and firing methods. ">
	<meta property="twitter:image" content="https://tajimicustomtiles.jp/wp/wp-content/uploads/2020/04/TCT_Logo_mark_og.png">
	';
	
}
add_action('wp_head', 'tct_add_meta_tags');



/** SF:
 * TCT Custom Image Sizes
 */
function tct_add_custom_img_sizes() {
	add_image_size( 'medium-medium', 500, 500 );
	add_image_size( 'medium-large', 768, 768 );
	add_image_size( 'extra-large', 1500, 1500 );
}
add_action( 'after_setup_theme', 'tct_add_custom_img_sizes' );

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
function tct_get_media_group_entries( $file_list_meta_key, $class, $img_size = '' ) {
	
	// get the custom field
	$media_group_entries = get_post_meta( get_the_ID(), $file_list_meta_key, true );
	
	// shuffle the order in start page
	if( is_home() ){
		shuffle( $media_group_entries );
	}
	
	// get all group values
	foreach ( (array) $media_group_entries as $key => $entry ) {
		
		// check if select menu value is set
		$radio = isset( $entry['select'] ) ? $entry['select'] : '';
		
		// resets the array
		$media = null;
		
		// IMAGE (file_list)
		if ( isset( $entry['image'] ) && !empty( $entry['image'] ) && $radio === 'img' ) {
			
			// Loop through the file_list and fill it in the $media array
			foreach ( (array) $entry['image'] as $attachment_id => $attachment_url ) {
				$media[] = wp_get_attachment_image( $attachment_id, $img_size );
			}
		}						
		
		// MOVIE (oembed)
		if ( isset( $entry['movie'] ) && !empty( $entry['movie'] ) && $radio === 'mov' ) {
			$media[] = wp_oembed_get( esc_url( $entry['movie'] ) );
		}

		// final check if a value exists
		if ( ! empty( $media ) ){
			// print the images, in start page print only the 1st image
			$media = ( is_home() ) ?  array_slice( $media, 0, 1 ) : $media;
			print '<div class="' . $class . ' itm-' . $radio . '">' .  implode( '', $media ) . '</div><!-- .' . $class . ' -->';
		}
	}	
}
add_filter( 'tct_custom_fields', 'tct_get_media_group_entries' );



function modify_vimeo_embed_url( $html ) {
	
	// GET HTML
	preg_match('/src\s*=\s*"(.+?)"/', $html, $src);
	
	// OPTIONS
	$params .= '&autoplay=1';
	$params .= '&background=1';
	
	// RETURN HTML
	$html = '<iframe src="' . $src[1] . $params . '" frameborder="0" allow="loop autoplay fullscreen" allowfullscreen></iframe>';
	
	return $html;
}
add_filter( 'oembed_result', 'modify_vimeo_embed_url' );



/** SF:
 * Get Custom Field Values: Profile
 */
function tct_get_profile_entries( $file_list_meta_key, $class ) {
	
	$prefix = 'tct_profile_';
	$fields = array( 'file_id', 'wysiwyg' );
	
	//GET FIELD VALUES
	foreach ( (array) $fields as $field) {
		$field_value = get_post_meta( get_the_ID(), $prefix . $field, true );
		
		
		// SWITCH CASE:
		switch ( $field ) {
			
			case 'file_id' :
				// checks if the field contains a value, converts value into a readable format, returns "–" if not
				$field_output = !( $field_value == '' ) ? wp_get_attachment_image( $field_value, '' ) : '';
				$field_title = 'profile-photo';
				break;
				
			case 'wysiwyg' :
				// checks if the field contains a value, converts value into a readable format, returns "–" if not
				$field_output = !( $field_value == '' ) ? wpautop( $field_value ) : '';
				$field_title = 'profile-text';
				break;				
		}
		
		// checks weather a field value exist or not
		if ( !empty( $field_output ) ) {

			echo '<div class="' . $class . ' '. $field_title . '">';
			echo $field_output;
			echo '</div><!-- .' . $class . ' '. $field_title . ' -->';			
		}		
	}	
}


/** SF:
 * Get Custom Field Values: File List
 */
function tct_get_portfolio_images( $file_list_meta_key, $class, $img_size = '' ) {

	// Get the list of files
	$files = get_post_meta( get_the_ID(), $file_list_meta_key, 1 );

	if( !empty( $files ) ){
		
		echo '<div class="' . $class . ' itm-img">';
		// Loop through them and output an image
		foreach ( (array) $files as $attachment_id => $attachment_url ) {
			echo wp_get_attachment_image( $attachment_id, $img_size );
		}		
		echo '</div><!-- .' . $class . ' -->';
		
	}
}
add_filter( 'tct_custom_fields', 'tct_get_portfolio_images' );



/** SF:
 * Get Custom Field Values: Portfolio Data Bundle
 */
function tct_get_portfolio_data_bundle( $class ) {
	
	$prefix = 'tct_portfolio_data_';
	$fields = array( 'year', 'location_prefecture', 'location_country', 'architect', 'method', 'volume', 'photographer'  );
	
	// loops through the fields stated in the array $fields
	foreach ( (array) $fields as $field) {
		$field_value = get_post_meta( get_the_ID(), $prefix . $field, true );
		
		
		// SWITCH CASE:
		switch ( $field ) {
			
			case 'year' :
				// checks if the field contains a value, converts value into a readable format, returns "–" if not
				$field_output = !( $field_value == '' ) ?  date( "Y", $field_value) : '–';
				$field_title = 'year';
				break;
/*				
			case 'location_city' :
				// checks if the field contains a value, returns "–" if not
				$city = !( $field_value == '' ) ?  $field_value : '–';
				
				// reset value 
				$field_output = '';
				break;
*/				
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
				$field_output = ( !( $prefecture == '–' ) && !( $country == '–' ) ) ? $prefecture . ', ' . $country : '–';
				$field_title = 'location';
				break;
				
			case 'architect' :
				// checks if the field contains a value, returns "–" if not
				$field_output = !( $field_value == '' ) ?  $field_value : '–';
				$field_title = 'architect';
				break;				

			case 'method' :
				// checks if the field contains a value, returns "–" if not
				$term = !( $field_value == '' ) ? get_term( $field_value ) : '–';
				$field_output = $term->name;
				
				// gets translated term if translation is active
				if( function_exists( 'pll_default_language' ) && ( pll_current_language() != pll_default_language() ) ){
					// get the current language
					$lang = ( pll_current_language() === pll_default_language() ) ? '' : pll_current_language();
					// get translation in japanese
					$translation = get_term_by( 'id', pll_get_term( $term->term_id, $lang ), 'tile_category' );
					// overwrite the variable
					$field_output = $translation->name;
				}				
				
				$field_title = 'method';
				break;
				
			case 'volume' :
				// checks if the field contains a value, adds 'm2' to the value, returns "–" if not
				$field_output = !( $field_value == '' ) && !( $field_value == '0' ) ?  $field_value . 'm2' : '–';
				$field_output = __( 'Quantity', 'tajimi_custom_tiles' ) . ' ' .  $field_output;
				$field_title = 'volume';
				break;
				
			case 'photographer' :
				// checks if the field contains a value, returns "–" if not
				$field_output = !( $field_value == '' ) ?  $field_value : '–';
				$field_title = 'photographer';
				break;				
				
			default:
				// code to be executed if n is different from all labels;
		} 		
		
		
		// checks weather a field value exist or not
		if ( !empty( $field_output ) ) {
		
			//add specific class to each entry
			$specific_class = !( $field_title == '' ) ? $class . '-' . $field_title : '';
			
			//WRAPPER OPENING TAG
/*			
			if( $field_title == 'architect'){
				echo '<div class="portfolio-entry-group">';
			}
*/			
			
			echo '<div class="' . $specific_class . '">';
			// checks weather a field title exist or not
			if ( !empty( $field_title ) ) { echo '<span class="data-title">' . esc_html( $field_title ) . '</span>'; }
			echo wpautop( esc_html( $field_output ) );
			echo '</div><!-- .' . $specific_class . ' -->';
			
/*			
			//WRAPPER CLOSING TAG
			if( $field_title == 'volume'){
				echo '</div><!-- .portfolio-entry-group -->';
			}
*/			
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
		// main post images
		get_post_meta( get_the_ID(), $meta_key . 'image_1_id', 1 ),
		get_post_meta( get_the_ID(), $meta_key . 'image_2_id', 1 ),
	);

	// Loop through them and output an image
	foreach ( (array) $images as $image) {
		$count++;
		
		
		echo '<div class="' . $class . ' itm-' . $count . '">';
//		echo wp_get_attachment_image( $image, $img_size );
		
		// Altering the img markup to add lazyloading
		echo wp_get_attachment_image( $image, $img_size, false, array(
			'src' => "data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%202048%201366'%3E%3C/svg%3E",
			'srcset' => ' ',
			'data-lazy-src' => wp_get_attachment_image_url( $image, $img_size ),
			'data-lazy-srcset' => wp_get_attachment_image_srcset( $image, $img_size ),
			'data-lazy-sizes' => wp_calculate_image_sizes( $img_size, wp_get_attachment_image_url( $image, $img_size ), null, $image ),
			'class' => 'rocket-lazyload'
		) );		
		
		echo '<span></span>'; // additional element for displaying a loading state
		
		echo '</div><!-- .' . $class . ' itm-' . $count . ' -->';
		
		// In the contact page, only 1 image is needed
		if( is_page( 'contact' ) ){
			return;
		}
	}
	
}
add_filter( 'tct_custom_fields', 'tct_get_sample_tile_images' );



/** SF:
 *  Get Custom Field Values: Sample Tile: No Stock
 */
function tct_get_no_stock_value() {
	
	$value = get_post_meta( get_the_ID(), 'tct_no_stock_option_nostock', 1 );
	
	if( isset( $value ) && ( ! empty( $value ) ) ) {
		
		if( $value === 'true' ){
			return true;
		}
		else{
			return false;
		}
	}	
}
add_filter( 'tct_custom_fields', 'tct_get_no_stock_value' );


/** SF:
 *  Get Custom Field Values: Sample Tile: Dimensions
 */
/*
function tct_get_sample_tile_dimensions( $class ) {

	$prefix = 'tct_sample_tiles_dimensions_';
	$fields = array( 'width', 'height', 'depth' );
	
	// loops through the fields stated in the array $fields
	foreach ( (array) $fields as $field) {
		$field_value = get_post_meta( get_the_ID(), $prefix . $field, true );
		
		
		// FIELD VALUES
		switch ( $field ) {
			
			case 'width' :
				// checks if the field contains a value, converts value into a readable format, returns "–" if not
				$tile_width = !( $field_value == '' || $field_value == '0' ) ? $field_value : '–';
				break;
				
			case 'height' :
				// checks if the field contains a value, converts value into a readable format, returns "–" if not
				$tile_height = !( $field_value == '' || $field_value == '0' ) ? $field_value : '–';
				break;
				
			case 'depth' :
				// checks if the field contains a value, converts value into a readable format, returns "–" if not
				$tile_depth = !( $field_value == '' || $field_value == '0' ) ? $field_value : '–';
				break;				
				
			default :
				// 
		}		
	}
	
	// MARKUP
	echo '<div class="' . $class . '">';
	echo '<span class="info-title">' . __( 'Size ', 'tajimi_custom_tiles' ) . '</span>';
	
	// checks weather a field value exist or not
	if ( !empty( $field_value ) || $field_value != '0' ) {
		echo $tile_width . ' x ' . $tile_height . ' x t' . $tile_depth . ' mm' ;
	}
	else{
		echo '–';
	}
	
	echo '</div><!-- .' . $class . ' -->';
	
}
add_filter( 'tct_custom_fields', 'tct_get_sample_tile_dimensions' );
*/
function tct_get_sample_tile_dimensions( $class ) {
	
	$prefix = 'tct_sample_tiles_dimensions_';
    $entries = get_post_meta( get_the_ID() , $prefix . 'metabox_sections', true);
    

	
		
	// OUTER MARKUP (wrapper)
	echo '<div class="' . $class . '">';
	echo '<span class="info-title">' . __( 'Size ', 'tajimi_custom_tiles' ) . '</span>';
		
	foreach( (array)$entries as $key => $entry ){

		// GET FIELD VALUES

		$width = $height = $depth = '';

		// get width
		if ( isset( $entry[ $prefix . 'width' ] ) ){ 
			$width = esc_html( $entry[ $prefix . 'width' ] );
		}

		// get height
		if ( isset( $entry[ $prefix . 'height' ] ) ){ 
			$height = esc_html( $entry[ $prefix . 'height' ] );
		}

		// get depth
		if ( isset( $entry[ $prefix . 'depth' ] ) ){ 
			$depth = esc_html( $entry[ $prefix . 'depth' ] );
		}

		// INNER MARKUP

			// field value
			if ( !empty( $width ) && !empty( $height ) && !empty( $depth ) ) {
				echo '<p>';
				echo $width . ' x ' . $height . ' x t' . $depth . ' mm' ;
				echo '</p>';
			}
			else{
				echo '<p>';
				echo '–';
				echo '</p>';
			}
			
	} // end foreach	
		
		echo '</div><!-- .' . $class . ' -->'; // end wrapper		
		



}
add_filter( 'tct_custom_fields', 'tct_get_sample_tile_dimensions' );

	
/** SF:
 *  Get Custom Field Values: Sample Tile: Info
 */
function tct_get_sample_tile_info( $class ) {
	
	$lang = ( function_exists( 'pll_current_language' ) ) ? pll_current_language() : 'en';
	
	$field_value = get_post_meta( get_the_ID(), 'tct_sample_tiles_info_note_' . $lang, true );
	
	// Add a dash (–) in case field is empty
	$field_value = !( $field_value == '' ) ? $field_value : '–';
	
	// MARKUP
	if ( !empty( $field_value ) ) {
		echo '<div class="' . $class . '">';
		echo '<span class="info-title">' . __( 'Note ', 'tajimi_custom_tiles' ) . '</span>' . nl2br( $field_value );
//		echo $field_value;
		echo '</div><!-- .' . $class . ' -->';
	}	
	
}
add_filter( 'tct_custom_fields', 'tct_get_sample_tile_info' );


/** SF:
 *  Get Custom Field Values: Sample Tile: Color Variations
 */
function tct_get_sample_tile_color_variation( $class ) {
	
	// get the attached posts of current post
	$attached = get_post_meta( get_the_ID(), 'attached_sample_tile', true );

	
	/* DEFAULT COLOR */
	
	$default_color = wp_get_post_terms( get_the_ID(), 'tile_category', array( 'fields' => 'ids', 'parent' => '4' ) ); // term id 4 is a parent category [colors]
	$default_color_id = $default_color[ 0 ];
	$default_color_obj = get_term_by( 'id', $default_color_id, 'tile_category' );
	$default_color_name = $default_color_obj->name;	
	
	// gets translated term if translation is active
	if( function_exists( 'pll_default_language' ) && ( pll_current_language() != pll_default_language() ) ){

		// get translation in japanese
		$default_color_obj = get_term_by( 'id', pll_get_term( $default_color_id, 'ja' ), 'tile_category' );
		// overwrite the variable
		$default_color_name = $default_color_obj->name;
	}
	// end default color
	

	
	// MARKUP
	// open tag container
	echo '<div class="' . $class . '">';
	// info title, not linked
	echo '<span class="info-title">' . __( 'Colors ', 'tajimi_custom_tiles' ) . '</span>';
	
	// get the values
	if ( !empty( $attached ) || !empty( $default_color ) ) {
		
	// default color
	echo '<span class="anchor-link">' . $default_color_name . '</span>';		
	
		
		/* COLOR VARIATIONS */
		
		// get the attached post values	
		foreach ( $attached as $attached_post ) {
			
			// get post object	
			$post = get_post( $attached_post );
			
			// ADDITIONAL CONDITION: checks if post is actually published
			if ( get_post_status ( $post->ID ) == 'publish' ) {
				
				// get related sample tile name
				$post_names = $post->post_title;	
				// get related sample tile color
				$post_colors = wp_get_post_terms( $post->ID, 'tile_category', array( 'fields' => 'ids', 'parent' => '4' ) ); // term id 4 is a parent category [colors]
				// term name
				$post_color_id = $post_colors[ 0 ];
				
				$post_color_obj = get_term_by( 'id', $post_color_id, 'tile_category' );
				$post_color_name = $post_color_obj->name;
							
				// gets translated term if translation is active
				if( function_exists( 'pll_default_language' ) && ( pll_current_language() != pll_default_language() ) ){
					
					// get translation in japanese
					$term_trans = get_term_by( 'id', pll_get_term( $post_color_id, 'ja' ), 'tile_category' );					
					// overwrite the variable
					$post_color_name = $term_trans->name;
					
				}


				// the color
				echo '<a class="anchor-link" href="#'. $post_names .'">'. /* $post_colors[ 0 ] */ $post_color_name . '</a>';
			}
		}
	}
	else{
		echo '–';
	}
	
	// close tag container
	echo '</div><!-- .' . $class . ' -->';			
	
}
add_filter( 'tct_custom_fields', 'tct_get_sample_tile_color_variation' );


/** SF:
 *  tct_tile_filter_menu_attributes: adds a data-slug attribute to the naviagtion links
 */
add_filter( 'nav_menu_link_attributes', 'tct_tile_filter_menu_attributes', 10, 3 );

function tct_tile_filter_menu_attributes( $atts, $item, $args ) {

	// TILE FILTER MENU
	// checks which menu object the filter will be applyed on (note: using $args)
	if ( $args->theme_location == 'tct-tile-filter-menu' ) {
		
		// get term object by name as title
		$name = $item->title;
		$terms = get_term_by( 'name', $name, 'tile_category' ); // pll workaround: does not work with polylang as get_term_by is filtered
		
		// Get terms in default language in case translation is active
		if( function_exists( 'pll_default_language' ) && ( pll_current_language() != pll_default_language() ) ){
			
			$term_trans_id = pll_get_term( $terms->term_id, pll_default_language() );
			$term_trans = get_terms( array( 'taxonomy' => 'tile_category', 'lang' => pll_default_language() ) );
			
			foreach( $term_trans as $value ){
				
				if( $term_trans_id === $value->term_id ){
//					$default_term = pll_get_term( $term_trans_id, pll_default_language() );
					$term_slug = $value->slug;
					break;
				}
				
			}			
		}
		else{
			$term_slug = $terms->slug;
		}

/*		
		$terms = get_terms( array( 'taxonomy' => 'tile_category', 'lang' => $default_lang ) );
		
		foreach( $terms as $value ){
			if( $name === $value->name ){
				$term_name = $value->name;
				$term_id = $value->term_id;
				$term_slug = $value->slug;
				break;
			}
		}
*/		

		// checks if there is a taxonomy term, returns 'all' on false
//		if( !empty( $term ) ){
		if( !empty( $term_slug ) ){
//			$filter_by = $terms->slug;
			$filter_by = $term_slug;
		}
		else{
			$filter_by = 'all';
		}
		
		// insert the JS function called in the frontend
		$atts['href'] = 'javascript:void(0);';
		$atts['onClick'] = 'filter_posts_by_category("' . $filter_by . '", 1)';
		$atts['class'] = 'tile-filter-link filter-cat-' . $filter_by;

	}		
	
	return $atts;
}


/** SF:
 *  conditionally displays child category of a specific parent category (used in ajax_filter_posts_by_category)
 */
function tct_get_child_category( $field, $parent, $taxonomy ) {
	
	global $post;
	
	// checks ifs not default lang
	$lang = function_exists( 'pll_default_language' ) && ( pll_current_language() != pll_default_language() ) ? '_' . pll_current_language() : '';
	
	$parents_id = get_term_by( $field, $parent . $lang, $taxonomy );
//	$parents_id = get_term_by( $field, $parent, $taxonomy );
	$terms = get_the_terms( $post->ID, $taxonomy );
	
	$parents_id->term_id;
	$parents_id_trans = function_exists( 'pll_default_language' ) ? pll_get_term( $parents_id->term_id, pll_default_language() ) : '';
	
	foreach ( $terms as $term ) {				
	
		if( ( $term->parent === $parents_id->term_id ) || ( $term->parent === $parents_id_trans ) ) { 
			
			// default language
			$term_name = $term->name;
			
			// translation
			$term_trans = get_term_by( 'id', pll_get_term( $term->term_id ), $taxonomy ) ;
			$term_name = function_exists( 'pll_default_language' ) &&  ( pll_current_language() != pll_default_language() ) ? $term_trans->name : $term->name;

			break;
		}
	}
	
	// In case the production_method category is not set
	if( empty( $term_name ) ){
		$term_name = '–';
	}
	
	// MARKUP
	print '<div class="' . $parent . '"><span class="info-title">' . __( 'Production Method ', 'tajimi_custom_tiles' ) . '</span>' . $term_name . '</div>';
}


/** SF:
 * display additional header menu
 */

function tct_display_additional_menu_in_header() { 
/* 	
	if( is_page( 'sample-tiles' ) ){
		wp_nav_menu( array( 'theme_location' => 'tct-tile-filter-menu' ) );
	}
*/	
	if( is_post_type_archive( 'production_method' ) ){
		wp_nav_menu( array( 'theme_location' => 'tct-production-method-menu' ) );
	}
	
	if( is_post_type_archive( 'collaborations' ) ){
		wp_nav_menu( array( 'theme_location' => 'tct-collaborations-menu' ) );
	}	
}
add_action( 'wp_head', 'tct_display_additional_menu_in_header' ); 


/** SF:
 * display footer menu
 */
function tct_display_footer_menu() { 
 
	wp_nav_menu( array( 'theme_location' => 'tct-footer-menu' ) );
	
}
add_action( 'wp_footer', 'tct_display_footer_menu' ); 


/** SF:
 *  Sort Posts by Taxonomy Term
 */
add_filter('posts_clauses', 'tct_posts_clauses_with_tax', 10, 2);

function tct_posts_clauses_with_tax( $clauses, $wp_query ) {
	global $wpdb;
	//array of sortable taxonomies
	$taxonomies = array( 'tile_category' );
	if( isset( $wp_query->query[ 'orderby' ] ) && in_array( $wp_query->query[ 'orderby' ], $taxonomies ) ) {
		$clauses[ 'join' ] .= "
			LEFT OUTER JOIN {$wpdb->term_relationships} AS rel2 ON {$wpdb->posts}.ID = rel2.object_id
			LEFT OUTER JOIN {$wpdb->term_taxonomy} AS tax2 ON rel2.term_taxonomy_id = tax2.term_taxonomy_id
			LEFT OUTER JOIN {$wpdb->terms} USING (term_id)
		";
		$clauses[ 'where' ] .= " AND (taxonomy = '{$wp_query->query[ 'orderby'] }' OR taxonomy IS NULL)";
		$clauses[ 'groupby' ] = "rel2.object_id";
		$clauses[ 'orderby' ]  = "GROUP_CONCAT({$wpdb->terms}.name ORDER BY name ASC) ";
//		$clauses[ 'orderby' ]  = "CAST(GROUP_CONCAT({$wpdb->terms}.slug ORDER BY slug ASC) as DECIMAL) "; // SF: order by slug instead of name // AS DECIMAl for sorting by integer
		$clauses[ 'orderby' ] .= ( 'ASC' == strtoupper( $wp_query->get('order') ) ) ? 'ASC' : 'DESC';
	}
	return $clauses;
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
	$terms = isset( $_POST[ 'cat_slug' ] ) && !empty( $_POST[ 'cat_slug' ] ) ? $_POST[ 'cat_slug' ] : 'all';
	$paged = $_POST[ 'paged' ];
	$posts = $_POST[ 'posts' ];
	$default_lang = function_exists( 'pll_default_language' ) ? pll_default_language() : '';			
		
	// ARGS
	if( $terms != 'all' ){
			
		$args = array(
			'post_type' => 'sample_tile',
			'lang'		=> $default_lang,
			'showposts' => $posts,
			'paged'     => $paged,
			'tax_query' => array(
				array(
					'taxonomy' => 'tile_category',
					'field'    => 'slug',
					'terms'    => $terms
				)
			),
			'orderby' => 'tile_category', //SF: Special case: taxonomy slug is passed to sort by taxonomy terms -> only possible with tct_posts_clauses_with_tax function
			'order'   => 'ASC',
			'meta_query' => array(
				array(
					'key'     => 'tct_no_stock_option_nostock',
					'value'   => 'true',
					'compare' => '!=',
				),
			),
		);
			
	}	
	else{
		$args = array(
			'post_type' => 'sample_tile',
			'lang'		=> $default_lang,			
			'showposts' => $posts,
			'paged'     => $paged,
//			'orderby' => 'title',
			'order'   => 'DSC',
			'meta_query' => array(
				array(
					'key'     => 'tct_no_stock_option_nostock',
					'value'   => 'true',
					'compare' => '!=',
				),
			),			
		);
	}

	// LOOP
	$tct_query = null;
	$tct_query = new WP_Query( $args );
	while( $tct_query -> have_posts() ) : $tct_query -> the_post();
	
	
		// TILE CONTAINER
	
		// the tile ID is submitted to give the radio buttons a uniqe name per post
		// TILE SELECTION: select / out of stock
	
	
		// pollylang workaround: get_terms instead of get_term_by( 'slug', $terms, 'tile_category' )
		// get term obj of term for retrieving the id
		$terms_obj = get_terms( array( 
			'taxonomy'	=> 'tile_category',
			'slug'		=> $terms,
			'lang'		=> $default_lang,
			)
		);
	
		// get category
		$category = wp_get_post_terms( get_the_ID(), 'tile_category', array( 'fields' => 'slugs', 'child_of' => $terms_obj[0]->term_id ) );
		$category_attribute = ( $terms != 'all' ) ? 'data-category="' . esc_attr( implode( ', ', $category ) ) . '"' : '' ;
	
		?>
		<div id="<?php the_title(); ?>" class="sample-tile" <?php echo $category_attribute; ?> >
			
			<?php
			// get No Stock field value
			$disabeled = ( tct_get_no_stock_value() == true ) ? 'disabled="disabled"' : '';
			$availability = ( tct_get_no_stock_value() == true ) ? __( 'Out of Stock', 'tajimi_custom_tiles' ) : __( 'Select Tile', 'tajimi_custom_tiles' );
	
			// TILE IMAGES: image1, image2
			tct_get_sample_tile_images( 'tct_sample_tiles_', 'tile-image', 'medium-medium' ); 
				
	
			// TITLE
			?>
			<div class="tile-title">
				<span class="info-title"><?php echo __( 'Tile ', 'tajimi_custom_tiles' ); ?></span><?php the_title(); ?>
			</div>
			
			<?php
			// TILE DIMENSIONS
			tct_get_sample_tile_dimensions( 'tile-dimensions' ); //css class
			
			// COLORS (related colors)
			tct_get_sample_tile_color_variation( 'tile-color' ); //css class
	
			// TILE PRODUCTION METHOD (Taxonomy)
			tct_get_child_category( 'slug', 'tile_production_method', 'tile_category' );	
		
			// TILE INFO
			tct_get_sample_tile_info( 'tile-info' ); //css class
	
			// TILE SELECT CHECKBOX ?>
			<input id="tct_sample_tile_selection_<?php the_ID(); ?>" type="checkbox" name="tct_tile_selection[]" class="tile-selection" value="<?php the_ID(); ?>" <?php echo $disabeled ?> >
			<label class="tile-selection-label" for="tct_sample_tile_selection_<?php the_ID(); ?>" ><?php // echo $availability ?></label>
			<div class="tct-ux-tile-check"></div>
			<button type="button" class="switch-expand-info"></button>
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
	$tct_subject = '['. get_bloginfo( 'name' ) . ']';
	$tct_to = 'contact@tajimicustomtiles.jp';
	$tct_fields = array( 'full_name', 'company', 'address', 'city_state', 'postal_code', 'country', 'phone', 'subject', 'email', 'custom-tailored-tiles', 'customized-tiles', 'existing-tiles', 'message' );
	$tct_tile_selection = array();
	$tct_response = array();
	$posted_data = isset( $_POST ) ? $_POST : array();
	$file_data = isset( $_FILES ) ? $_FILES : array();
  
	$data = array_merge( $posted_data, $file_data );
	
	
	// SECURITY CHECKS: nonce field, Server Request, if $_POST is not empty, if invisible "name" field is empty
	if( isset( $_POST[ 'tct_contact_form_nonce' ] ) && wp_verify_nonce( $_POST[ 'tct_contact_form_nonce' ], 'tct_add_contact_form_nonce') && 'POST' == $_SERVER[ 'REQUEST_METHOD' ] && !empty( $_POST ) && empty( $_POST[ 'tct_name' ]) ) {


		// POST FIELDS
		foreach ( $tct_fields as $field ) {
			// sanitize by stripping HTML, PHP tags
			if( isset( $data[ 'tct' ][ $field ] ) ) $posted[ $field ] = strip_tags( trim( $data[ 'tct' ][ $field ] ) ); else $posted[ $field ] = '';
			
			switch ( $field ) {
				// Email
				case 'email' :
					$posted[ $field ] = sanitize_email( $posted[ $field ] );
					break;
					
				// Textarea
				case 'message' :
					$posted[ $field ] = sanitize_textarea_field( $posted[ $field ] );
					break;					
					
				// Textfields
				default : 
					$posted[ $field ] = sanitize_text_field( $posted[ $field ] );
			}
		}

		// ERROR MESSAGE: Check fields content
		$errors_posted = array();
		if( $posted[ 'full_name' ] == null ) array_push( $errors_posted, __( 'Please enter a full name.', 'tajimi_custom_tiles' ) );
		if( $posted[ 'company' ] == null ) array_push( $errors_posted, __( 'Please enter a company.', 'tajimi_custom_tiles' ) );
		if( $posted[ 'address' ] == null ) array_push( $errors_posted, __( 'Please enter a adress.', 'tajimi_custom_tiles' ) );
		if( $posted[ 'city_state' ] == null ) array_push( $errors_posted, __( 'Please enter your City and State.', 'tajimi_custom_tiles' ) );
		if( $posted[ 'postal_code' ] == null ) array_push( $errors_posted, __( 'Please enter your postal code.', 'tajimi_custom_tiles' ) );
		if( $posted[ 'country' ] == null ) array_push( $errors_posted, __( 'Please enter your country.', 'tajimi_custom_tiles' ) );
		if( $posted[ 'phone' ] == null ) array_push( $errors_posted, __( 'Please enter your phone number.', 'tajimi_custom_tiles' ) );
		if( $posted[ 'subject' ] == null ) array_push( $errors_posted, __( 'Please enter a subject.', 'tajimi_custom_tiles' ) );
		if( $posted[ 'email' ] == null ) array_push( $errors_posted, __( 'Please enter a email address.', 'tajimi_custom_tiles' ) );
		if( $posted[ 'message' ] == null ) array_push( $errors_posted, __( 'Please enter a message.', 'tajimi_custom_tiles' ) );
		
		
		// SAMPLE TILES
		// Sanitize / check Sample Tile Fields
		if( isset( $data[ 'tct' ][ 'selected_tiles' ] ) ){
			foreach ( $data[ 'tct' ][ 'selected_tiles' ] as $tile) {
				
				// Sanitize by stripping tags and retrieve Tile Name
				$tile = strip_tags( $tile ) ;
				
				// get tile Image
				$tile_obj = get_page_by_title( $tile, OBJECT, 'sample_tile' );
				$tile_meta = get_post_meta( $tile_obj->ID, 'tct_sample_tiles_image_1_id', 1 );
				$tile_src = wp_get_attachment_image_src( $tile_meta, 'medium' );
				$tile_img = '<img src="' . $tile_src[ 0 ] . '" width="200" height="200">';
				
				// Render the markup
				$tile_markup .= '<div style="float: left;">';
				$tile_markup .= $tile . '<br>';
				$tile_markup .= $tile_img;
				$tile_markup .= '</div>';
				
				// Save markup to selection
				$tct_tile_selection[] = $tile_markup;
				
				// reset variable
				$tile_markup = null;
			}			
		}
		
		// collect errors in array
		$errors_fields = array_filter( $errors_posted );

		
		// CHECK POST FIELDS: If no errors, proceed with upload file
		if( empty( $errors_fields ) ) {
			// response regarding fields
			$tct_response[ 'fields' ] = 'SUCCESS';
			
			
			// FILES
			$uploaded_files = array();
			// manually handle of equal: $data[ 'tct_multiple_attachments' ]['name'][$i] but array can be only 2 arrays deep
			$files = $data[ 'tct_multiple_attachments' ];

			foreach( $files[ 'name' ] as $key => $value ) {			

				if( $files[ 'name' ][ $key ]) {
				$file = array(
					'name'     => $files[ 'name' ][ $key ],
					'type'     => $files[ 'type' ][ $key ],
					'tmp_name' => $files[ 'tmp_name' ][ $key ],
					'error'    => $files[ 'error' ][ $key ],
					'size'     => $files[ 'size' ][ $key ]
				);
				$uploaded_files[] = wp_handle_upload( $file, array( 'test_form' => false ) );
			  }
			}

			
			// RESPONSE FILES
			$response_files = array();

			foreach( $uploaded_files as $key => $up_file ) {

				if( $up_file && ! isset( $up_file[ 'error' ] ) ) {
					$response_files[ $key ][ 'response' ] = 'SUCCESS';
					$response_files[ $key ][ 'filename' ] = basename( $up_file[ 'url' ] );
					$response_files[ $key ][ 'file' ] = $up_file[ 'file' ];
					$response_files[ $key ][ 'url' ] = $up_file[ 'url' ];
					$response_files[ $key ][ 'type' ] = $up_file[ 'type' ];
				} else {
					$response_files[ $key ][ 'response' ] = 'ERROR';
					$response_files[ $key ][ 'error' ] = $up_file[ 'error' ];
				}
			}
			// Response regarding Files
			$tct_response[ 'files' ] = array_column( $response_files, 'response' );
			
			// merge to 1 value if all values are SUCCESS
			if( count( array_unique( $tct_response[ 'files' ] ) ) === 1 && end( $tct_response[ 'files' ] ) === 'SUCCESS') {
				$tct_response[ 'files' ] = 'SUCCESS';
			}
			
			
			// PROCESSING
			// get all file names into the attachement array
			$tct_attachments = array_column( $response_files, 'file' );
			$tct_attachment_names = array_column( $response_files, 'filename' );
//			$tct_headers = 'From: '. $posted[ 'full_name' ] . ', ' . $posted[ 'company' ] .' <'. $posted[ 'email' ] .'>' . "\r\n";
			
			$tct_headers[] = 'Content-Type: text/html; charset=UTF-8';
			$tct_headers[] = 'From: '. $posted[ 'full_name' ] . ', ' . $posted[ 'company' ] .' <'. $posted[ 'email' ] .'>' . "\r\n";
			
//			$tct_headers = array('Content-Type: text/html; charset=UTF-8');
			
			// EMAIL MESSAGE
			$tct_message .= '<p>';
			$tct_message = '[' . __( 'DETAILS', 'tajimi_custom_tiles' ) . ']' . '<br>';
			$tct_message .= __( 'Name: ', 'tajimi_custom_tiles' ) . $posted[ 'full_name' ] . '<br>';
			$tct_message .= __( 'Company: ', 'tajimi_custom_tiles' ) . $posted[ 'company' ] . '<br>';
			$tct_message .= __( 'Address: ', 'tajimi_custom_tiles' ) . $posted[ 'address' ] . '<br>';
			$tct_message .= __( 'City, State: ', 'tajimi_custom_tiles' ) . $posted[ 'city_state' ] . '<br>';			
			$tct_message .= __( 'Postal Code: ', 'tajimi_custom_tiles' ) . $posted[ 'postal_code' ] . '<br>';
			$tct_message .= __( 'Country: ', 'tajimi_custom_tiles' ) . $posted[ 'country' ] . '<br>';
			$tct_message .= __( 'Phone: ', 'tajimi_custom_tiles' ) . $posted[ 'phone' ] . '<br>';
			$tct_message .= __( 'Subject: ', 'tajimi_custom_tiles' ) . $posted[ 'subject' ] . '<br>';
			$tct_message .= __( 'Email: ', 'tajimi_custom_tiles' ) . $posted[ 'email' ] . '<br>';
			// optional checkbox values
			$tct_message .= __( 'Interested in: ', 'tajimi_custom_tiles' ) . '<br>';
				$tct_message .= __( 'Custom-tailored tiles', 'tajimi_custom_tiles' ) . ': '; 
				$tct_message .= ( !empty( $posted[ 'custom-tailored-tiles' ] ) ) ? 'yes' : 'not set';
				$tct_message .= '<br>';
				$tct_message .= __( 'Customized tiles', 'tajimi_custom_tiles' ) . ': '; 
				$tct_message .= ( !empty( $posted[ 'customized-tiles' ] ) ) ? 'yes' : 'not set';
				$tct_message .= '<br>';
				$tct_message .= __( 'Existing tiles', 'tajimi_custom_tiles' ) . ': '; 
				$tct_message .= ( !empty( $posted[ 'existing-tiles' ] ) ) ? 'yes' : 'not set';
			$tct_message .= '</p>';
			
			$tct_message .= '<p>';
			$tct_message .= '[' . __( 'MESSAGE', 'tajimi_custom_tiles' ) . ']' . '<br>';
			$tct_message .= $posted[ 'message' ] . '<br>';
			$tct_message .= '</p>';
			
			$tct_message .= '<p>';
			$tct_message .= '[' . __( 'ATTACHEMENTS', 'tajimi_custom_tiles' ) . ']' . '<br>';
			$tct_message .= ( isset( $tct_attachments ) && !empty( $tct_attachments ) ) ? implode( '<br>', $tct_attachment_names ) : '–';
			$tct_message .= '</p>';
			
			$tct_message .= '<p>';
			$tct_message .= '[' . __( 'SAMPLE TILE ORDER', 'tajimi_custom_tiles' ) . ']' . '<br>';
			$tct_message .= ( isset( $tct_tile_selection ) && !empty( $tct_tile_selection ) ) ? implode( '&nbsp;', $tct_tile_selection ) : '–';
			$tct_message .= '</p>';
			
			
			// SEND MAIL
			if( wp_mail( $tct_to, $tct_subject , $tct_message, $tct_headers, $tct_attachments ) ){
				$tct_response[ 'mail' ] = 'SUCCESS';
			}
			else{
				$tct_response[ 'mail' ] = 'ERROR';
			}

			// delete file from server
			foreach( $tct_attachments as $key => $file ){
				unlink( $file );
			}
		}
		else{
			// Response regarding Input fields
			$tct_response[ 'message' ] = implode( '<br>', $errors_fields );
		}
		
	} //END SECURITY
	
	else{
		$tct_response[ 'security' ] = 'Security failure';
		
		die( $tct_response[ 'security' ] );
	}	

	// RESPONSE
	// simple mail
	if( $tct_response[ 'fields' ] === 'SUCCESS' && $tct_response[ 'mail' ] === 'SUCCESS' ){
		$tct_response[ 'message' ] = __( 'Thank you for your message.', 'tajimi_custom_tiles' );
	}
	
	// mail including attachement, overwrite message if true
	if( $tct_response[ 'fields' ] === 'SUCCESS' && $tct_response[ 'mail' ] === 'SUCCESS' && $tct_response[ 'files' ] === 'SUCCESS' ) {
		$tct_response[ 'message' ] = __( 'Thank you for your message.', 'tajimi_custom_tiles' ) . '<br>' . __( 'Your files has been submitted.', 'tajimi_custom_tiles' );
	}
	
	// add to feedback to the response, in case of sample tile selection
	if( isset( $tct_tile_selection ) && !empty( $tct_tile_selection && $tct_response[ 'fields' ] === 'SUCCESS' && $tct_response[ 'mail' ] === 'SUCCESS') ){
		$tct_response[ 'message' ] .= '<br>' . __( 'Your Sample Tile Selection has been submitted.', 'tajimi_custom_tiles' );
	}	
	
	
	// CHECK IF AJAX CALL
	if( isset( $data[ 'tct_ajaxrequest' ] ) && $data[ 'tct_ajaxrequest' ] === 'true' ) {
		echo json_encode( $tct_response );
		
		die();
	}	
	
	// FALLBACK (admin_post only)
	
	die( $tct_response );
	
}


/** SF:
 * Display Post Types in homepage
 */

function tct_display_home_posts( $query ) {
	
  if ( !is_admin() && $query->is_main_query() ) {
	  
    if ( $query->is_home() ) {
		
		// POST TYPE
//		$query->set( 'post_type', array( 'brand_story', 'sample_tile' ) );
		$query->set( 'post_type', array( 'brand_story' ) );
		
		// LANGUAGE
//		$lang = ( function_exists( 'pll_default_language' ) && pll_default_language() != pll_current_language() ) ? pll_current_language() : '';
//		$query->set( 'lang', '' );		
		
		// PAGINATION
		$query->set( 'posts_per_page', -1 );
		
		// ORDER: orders the post by post_type ASC and by date DESC
		$post_order = array(
			'post_type' => 'ASC',
			'date' => 'DESC',
		);
		$query->set( 'orderby', $post_order );		
    }
  }
}

add_action( 'pre_get_posts', 'tct_display_home_posts' );


/** SF:
 * Chose a custom template in homepage
 */
function tct_choose_template( $template ) {

	if ( !is_admin() && is_home() ) {
		$new_template = locate_template( array( 'tmpl_start_page.php' ) );
		if ( !empty( $new_template ) ) {
			return $new_template;
		}
	}

	return $template;
}
add_filter( 'template_include', 'tct_choose_template', 99 );



/** SF:
 * Limiting Gutenbergs Block elements
 */
function tct_gutenberg_blocks() {
  return array(
	  'core/paragraph',
	  'meow/faq-block',
	  'meowapps/faq'
  );
}
add_filter( 'allowed_block_types', 'tct_gutenberg_blocks' );


/** SF:
 * Unsync specified custom fields
 */

// filter to exclude specified post_meta from Polylang Sync ##
add_filter( 'pll_copy_post_metas', 'tct_pll_copy_post_metas' );
/**
* Remove defined custom fields from Polylang Sync
*
* @since       0.1
* @param       Array       $metas
* @return      Array       Array of meta fields
*/
function tct_pll_copy_post_metas( $metas )
{
    // this needs to be added to the PolyLang Settings page as an option ##
    $unsync = array (
        'tct_portfolio_data_location_city',
		'tct_portfolio_data_location_prefecture',
		'tct_portfolio_data_location_country',
		'tct_portfolio_data_architect',
		'tct_portfolio_data_architect',
		'tct_profile_wysiwyg'
    );
    #var_dump( $unsync );
    #var_dump( $metas );
    if ( is_array( $metas ) && is_array( $unsync ) ) {
        // loop over all passed metas ##
        foreach ( $metas as $key => $value ) {
            // loop over each unsynch item ##
            foreach ( $unsync as $find ) {
                if ( strpos( $value, $find ) !== false ) {
                    unset( $metas[$key] );
                }
            }
        }
    }
    #wp_die( var_dump( $metas ) );
    // kick back the array ##
    return $metas;
}


/** SF:
 * Adding Title Attribute to Images
 */
add_filter( 'wp_get_attachment_image_attributes', 'tct_add_img_title', 10, 2 );

function tct_add_img_title( $attr, $attachment = null ){
	
	// adding the title attribute to all images
	$attr['title'] = $attr['alt'];
	
	return $attr;
}


function remove_img_attr( $html ) {
    return preg_replace('/(width|height)="\d+"\s/', "", $html) ;
}

add_filter( 'get_image_tag', 'remove_img_attr' );

