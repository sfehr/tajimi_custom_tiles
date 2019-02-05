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
 * Template Selection for Custom Post Types
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
				break;
				
			case 'architect' :
				// checks if the field contains a value, returns "–" if not
				$field_output = !( $field_value == '' ) ?  $field_value : '–';
				$field_title = 'Architect';
				break;				

			case 'method' :
				// checks if the field contains a value, returns "–" if not
				$field_output = !( $field_value == '' ) ?  $field_value : '–';
				$field_title = 'Method used';
				break;
				
			case 'volume' :
				// checks if the field contains a value, adds 'm2' to the value, returns "–" if not
				$field_output = !( $field_value == '' ) && !( $field_value == '0' ) ?  $field_value . 'm2' : '–';
				$field_title = 'Volume';
				break;				
				
			default:
				// code to be executed if n is different from all labels;
		} 		
				
		echo '<div class="' . $class . '">';
		echo '<span class="data-title">' . esc_html( $field_title ) . '</span>';
		echo wpautop( esc_html( $field_output ) );
		echo '</div><!-- .' . $class . ' -->';
	}
}
add_filter( 'tct_custom_fields', 'tct_get_portfolio_data_bundle' );

