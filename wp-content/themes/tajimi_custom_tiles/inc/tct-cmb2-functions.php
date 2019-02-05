<?php
/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB2 directory)
 *
 * Be sure to replace all instances of 'yourprefix_' with your project's prefix.
 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
 *
 * @category YourThemeOrPlugin
 * @package  Demo_CMB2
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/CMB2/CMB2
 */


/** TCT CMB2 Functions Inventory
 *  
 * SHOW or NO SHOW IN START PAGE BOX
 *
 * TRANSLATION META BOX
 *
 * CUSTOM POST TYPE: BRAND STORY
 * * * MEDIA META BOX
 *
 * CUSTOM POST TYPE: PORTFOLIO
 * * * PORTFOLIO DATA BOX
 *
 */




/* SHOW or NO SHOW IN START PAGE BOX
*
* [radio] weather to show in front page or not
*/
add_action( 'cmb2_admin_init', 'tct_register_show_in_startpage_option_metabox' );

function tct_register_show_in_startpage_option_metabox() {
	$prefix = 'tct_show_in_startpage_options_';
	
	$cmb_show_options = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => esc_html__( 'Start Page Display Option', 'cmb2' ),
		'object_types'  => array( 'brand_story', 'production_method', 'collaborations' ), // Post type
	) );
	
	// RADIO BUTTON FIELD
	$cmb_show_options->add_field( array(
		'name'    => 'Show this Content in Start Page?',
		'id'      => $prefix . 'radio_inline',
		'type'    => 'radio_inline',
		'options' => array(
			'no' => __( 'No', 'cmb2' ),
			'yes'   => __( 'Yes', 'cmb2' ),
		),
		'default' => 'no',
	) );
	
}


/* TRANSLATION META BOX 
*
* Standard Fields:
* [title] content translation
* [wysiwyg] content translation
*/
add_action( 'cmb2_admin_init', 'tct_register_translation_metabox' );

function tct_register_translation_metabox() {
	$prefix = 'tct_translation_';

	$cmb_translation = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => esc_html__( 'Japanese Translation', 'cmb2' ),
		'object_types'  => array( 'brand_story', 'production_method', 'collaborations' ), // Post type
		// 'show_on_cb' => 'yourprefix_show_if_front_page', // function should return a bool value
		// 'context'    => 'normal',
		// 'priority'   => 'high',
		// 'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
		// 'classes'    => 'extra-class', // Extra cmb2-wrap classes
		// 'classes_cb' => 'yourprefix_add_some_classes', // Add classes through a callback.

	) );

	// TITLE FIELD
	$cmb_translation->add_field( array(
		'name' => 'Title JP',
		'desc' => 'Title in Japanese',
//		'default' => 'standard value (optional)',
		'type' => 'text',
		'id'   => $prefix . 'title_JP'
	) );
	
	
	// TEXT EDITOR FIELD
	$cmb_translation->add_field( array(
		'name'    => esc_html__( 'Content JP', 'cmb2' ),
		'desc'    => esc_html__( 'body text content in Japanese', 'cmb2' ),
		'id'      => $prefix . 'wysiwyg_JP',
		'type'    => 'wysiwyg',
		'options' => array(
			'textarea_rows' => 5,
		),
	) );	
}




/*
*
* CUSTOM POST TYPE: BRAND STORY //////////////////////////////////////////////
* (Also used for Production Methods, Collaborations)
*/

/* MEDIA META BOX
*
* Repeatable Field Groups:
* [radio] switch between image or movie
* [images] content images
* [oembed] content movies
*/
add_action( 'cmb2_admin_init', 'tct_register_repeatable_brand_story_group_metabox' );
/**
 * Hook in and add a metabox to demonstrate repeatable grouped fields
 */
function tct_register_repeatable_brand_story_group_metabox() {
	$prefix = 'tct_brand_story_';

	/**
	 * Repeatable Field Groups
	 */
	$cmb_brand_story_group = new_cmb2_box( array(
		'id'           => $prefix . 'metabox',
		'title'        => esc_html__( 'Media (Image or Movie)', 'cmb2' ),
		'object_types' => array( 'brand_story', 'production_method', 'collaborations' ),
	) );

	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$group_field_id = $cmb_brand_story_group->add_field( array(
		'id'          => $prefix . 'group',
		'type'        => 'group',
		'description' => esc_html__( 'Choose either an image or a movie', 'cmb2' ),
		'options'     => array(
			'group_title'    => esc_html__( 'Media Entry {#}', 'cmb2' ), // {#} gets replaced by row number
			'add_button'     => esc_html__( 'Add Another Media Entry', 'cmb2' ),
			'remove_button'  => esc_html__( 'Remove Media Entry', 'cmb2' ),
			'sortable'       => true,
			// 'closed'      => true, // true to have the groups closed by default
			// 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
		),
	) );

	/**
	 * Group fields works the same, except ids only need
	 * to be unique to the group. Prefix is not needed.
	 *
	 * The parent field's id needs to be passed as the first argument.
	 */
	
	// RADIO BUTTON FIELD
	$cmb_brand_story_group->add_group_field( $group_field_id, array(
		'name'    => 'Image or Movie',
		'id'      => 'radio_inline',
		'type'    => 'radio_inline',
		'options' => array(
			'img' => __( 'Image', 'cmb2' ),
			'mov'   => __( 'Movie', 'cmb2' ),
		),
		'default' => 'img',
	) );	
	
	
	// IMAGE FIELD
	$cmb_brand_story_group->add_group_field( $group_field_id, array(
		'name' => esc_html__( 'Image', 'cmb2' ),
		'id'   => 'image',
		'type' => 'file',
	) );	
	
	// MOVIE FIELD
	$cmb_brand_story_group->add_group_field( $group_field_id, array(
		'name' => 'Movie',
		'desc' => 'Enter a youtube, twitter, or instagram URL. Supports services listed at <a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>.',
		'id'   => 'movie',
		'type' => 'oembed',
	) );	
}



/*
*
* CUSTOM POST TYPE: PORTFOLIO //////////////////////////////////////////////
* []
*
*/


add_action( 'cmb2_admin_init', 'tct_register_portfolio_data_metabox' );

function tct_register_portfolio_data_metabox() {
	$prefix = 'tct_portfolio_data_';

	$cmb_portfolio = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => esc_html__( 'Portfolio Data', 'cmb2' ),
		'object_types'  => array( 'portfolio' ), // Post type
		// 'show_on_cb' => 'yourprefix_show_if_front_page', // function should return a bool value
		// 'context'    => 'normal',
		// 'priority'   => 'high',
		// 'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
		// 'classes'    => 'extra-class', // Extra cmb2-wrap classes
		// 'classes_cb' => 'yourprefix_add_some_classes', // Add classes through a callback.

	) );
	
	// IMAGES (FILE LIST)
	$cmb_portfolio->add_field( array(
		'name' => 'Portfolio Images',
		'desc' => '',
		'id'   => $prefix . 'file_list',
		'type' => 'file_list',
		'preview_size' => array( 200, 200 ), // Default: array( 50, 50 )
		// 'query_args' => array( 'type' => 'image' ), // Only images attachment
		// Optional, override default text strings
		'text' => array(
			'add_upload_files_text' => 'Add Image', // default: "Add or Upload Files"
			'remove_image_text' => 'Replacement', // default: "Remove Image"
			'file_text' => 'Replacement', // default: "File:"
			'file_download_text' => 'Replacement', // default: "Download"
			'remove_text' => 'Replacement', // default: "Remove"
		),
	) );
	
	// YEAR FIELD
	$cmb_portfolio->add_field( array(
		'name' => 'Year',
		'desc' => 'choose random date, only the year will be displayed',
		'id'   => $prefix . 'year',
		'type' => 'text_date_timestamp',
		// 'timezone_meta_key' => 'wiki_test_timezone',
		// 'date_format' => 'l jS \of F Y',
		'date_format' => 'Y',
	) );	
	
	// LOCATION: CITY FIELD
	$cmb_portfolio->add_field( array(
		'name' => 'Location: City',
		'desc' => 'if blank a "–" will appear',
//		'default' => 'standard value (optional)',
		'type' => 'text',
		'id'   => $prefix . 'location_city'
	) );
	
	// LOCATION: PREFECTURE FIELD
	$cmb_portfolio->add_field( array(
		'name' => 'Location: Prefecture',
		'desc' => 'if blank a "–" will appear',
//		'default' => 'standard value (optional)',
		'type' => 'text',
		'id'   => $prefix . 'location_prefecture'
	) );
	
	// LOCATION: COUNTRY FIELD
	$cmb_portfolio->add_field( array(
		'name' => 'Location: Country',
//		'desc' => 'e.g. Japan -> JP',
		'desc' => 'if blank a "–" will appear',
//		'default' => 'standard value (optional)',
		'type' => 'text',
		'id'   => $prefix . 'location_country'
	) );	
	
	// ARCHITECT FIELD
	$cmb_portfolio->add_field( array(
		'name' => 'Architect',
		'desc' => 'who is the architect?',
//		'default' => 'standard value (optional)',
		'type' => 'text',
		'id'   => $prefix . 'architect'
	) );
	
	// METHOD USED FIELD
	$cmb_portfolio->add_field( array(
		'name' => 'Method used',
		'desc' => 'which production method?',
//		'default' => 'standard value (optional)',
		'type' => 'text',
		'id'   => $prefix . 'method'
	) );
	
	// VOLUME FIELD
	$cmb_portfolio->add_field( array(
		'name' => 'Volume',
		'desc' => '(positive number only)',
//		'default' => 'standard value (optional)',
		'type' => 'text_small',
		'id'   => $prefix . 'volume',
		'before_field' => 'tile surface in m2: ', // Replaces default '$'
		'attributes' => array(
			'type' => 'number',
			'pattern' => '\d*',
		),
		'sanitization_cb' => 'absint',
		'escape_cb'       => 'absint',
	) );
}





/*
* Flexible Fields:
* [wysiwyg] content translation
* [radio] weather to show in front page or not
*/

//add_action( 'cmb2_admin_init', 'tct_register_brand_story_flexible_metabox' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
/*
function tct_register_brand_story_flexible_metabox() {
	$prefix = '_tct_brand_story_';


	 // Sample metabox to demonstrate each field type included

	$cmb_brand_story_flexible = new_cmb2_box( array(
		'id'            => $prefix . 'flexible',
		'title'         => esc_html__( 'Test Metabox', 'cmb2' ),
		'object_types'  => array( 'brand_story' ), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true,
	) );

//Then add your flexible field definition. Each layout group should be defined in the layouts array, with the `ID` for that group as its key. Each layout group can contain a `title` and a list of CMB2 `fields`.

// Sample Flexible Field
	$cmb_brand_story_flexible->add_field( array(
		'name'       => __( 'Test Flexible', 'cmb2-flexible' ),
		'desc'       => __( 'field description (optional)', 'cmb2-flexible' ),
		'id'         => $prefix . 'flexible',
		'type'       => 'flexible',
		'layouts' => array(
			
			//text field
				'text' => array(
					'title' => 'Text Group',
					'fields' => array(
						array(
							'type' => 'text',
							'name' => 'Title for Text Group',
							'id' => $prefix . 'title',
						),
						
						array(
							'type' => 'textarea',
							'name' => 'Description for Text Group',
							'id' => $prefix . 'description',
						)
					),
				),
			
			//image field
				'image' => array(
					'title' => 'Image Group',
					'fields' => array(
						array(
							'type' => 'file',
							'name' => 'Image for Image Group',
							'id' => $prefix . 'title',
						),
						array(
							'type' => 'textarea',
							'name' => 'Description for Image Group',
							'id' => $prefix . 'description',
						)
					),
				),
			)
	) );
}
*/


