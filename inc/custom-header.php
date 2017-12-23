<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Campus_Housing
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses campus_housing_header_style()
 */
function campus_housing_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'campus_housing_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => 'ffffff',
		'width'                  => 2000,
		'height'                 => 850,
		'flex-height'            => true,
		'wp-head-callback'       => 'campus_housing_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'campus_housing_custom_header_setup' );


