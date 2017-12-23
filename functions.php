<?php
/**
 * Campus Housing functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Campus_Housing
 */

if ( ! function_exists( 'campus_housing_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function campus_housing_setup() {

		load_theme_textdomain( 'campus-housing', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		add_theme_support( 'title-tag' );

		add_theme_support( 'post-thumbnails' );
		add_image_size( 'campus_housing-full-bleed', 2000, 1200, true );
		add_image_size( 'campus_housing-index-img', 800, 450, true );

		register_nav_menus( array(
			'header-menu-primary' => esc_html__( 'Header Menu', 'campus-housing' ),
			'footer-menu-social' => esc_html__( 'Footer Social Media Menu', 'campus-housing' ),
		) );

		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		add_theme_support( 'custom-background', apply_filters( 'campus_housing_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		add_theme_support( 'customize-selective-refresh-widgets' );

		add_theme_support( 'custom-logo', array(
			'height'      => 90,
			'width'       => 90,
			'flex-width'  => true,
//			'flex-height' => true,
		) );

	}
endif;
add_action( 'after_setup_theme', 'campus_housing_setup' );

/**
 * Register custom fonts.
 *
 * Borrowed from campus_housing
 */
function campus_housing_fonts_url() {
	$fonts_url = '';

	/*
	 * Translators: If there are characters in your language that are not
	 * supported by Merriweather and Roboto Slab, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$merriweather = _x( 'on', 'Merriweahter font: on or off', 'campus_housing' );
	$roboto_slab = _x( 'on', 'Roboto Slab font: on or off', 'campus_housing' );

	$font_families = array();

	if ( 'off' !== $merriweather ) {
		$font_families[] = 'Merriweahter :400,400i,700,700i';
	}

	if ( 'off' !== $roboto_slab ) {
		$font_families[] = 'Roboto Slab:400,700';
	}

	if ( in_array( 'on', array( $merriweather, $roboto_slab ) ) ) {

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Add preconnect for Google Fonts.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function campus_housing_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'campus_housing-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'campus_housing_resource_hints', 10, 2 );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function campus_housing_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'campus_housing_content_width', 640 );
}
add_action( 'after_setup_theme', 'campus_housing_content_width', 0 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images.
 *
 * @origin Twenty Seventeen 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function campus_housing_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	if ( 900 <= $width ) {
		$sizes = '(min-width: 900px) 700px, 900px';
	}

	if ( is_active_sidebar( 'sidebar-1' ) || is_active_sidebar( 'sidebar-2' ) ) {
		$sizes = '(min-width: 900px) 600px, 900px';
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'campus_housing_content_image_sizes_attr', 10, 2 );

/**
 * Filter the `sizes` value in the header image markup.
 *
 * @origin Twenty Seventeen 1.0
 *
 * @param string $html   The HTML image tag markup being filtered.
 * @param object $header The custom header object returned by 'get_custom_header()'.
 * @param array  $attr   Array of the attributes for the image tag.
 * @return string The filtered header image HTML.
 */
function campus_housing_header_image_tag( $html, $header, $attr ) {
	if ( isset( $attr['sizes'] ) ) {
		$html = str_replace( $attr['sizes'], '100vw', $html );
	}
	return $html;
}
add_filter( 'get_header_image_tag', 'campus_housing_header_image_tag', 10, 3 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails.
 *
 * @origin Twenty Seventeen 1.0
 *
 * @param array $attr       Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size       Registered image size or flat array of height and width dimensions.
 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
 */
function campus_housing_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {

	if ( !is_singular() ) {
		if ( is_active_sidebar( 'sidebar-1' ) ) {
			$attr['sizes'] = '(max-width: 900px) 90vw, 800px';
		} else {
			$attr['sizes'] = '(max-width: 1000px) 90vw, 1000px';
		}
	} else {
		$attr['sizes'] = '100vw';
	}

	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'campus_housing_post_thumbnail_sizes_attr', 10, 3 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function campus_housing_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'campus-housing' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'campus-housing' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Page Sidebar', 'campus-housing' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Add page sidebar widgets here.', 'campus-housing' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widgets', 'campus-housing' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Add footer widgets here.', 'campus-housing' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

}
add_action( 'widgets_init', 'campus_housing_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function campus_housing_scripts() {
	// Enqueue Google Fonts: Merriweather Sans and Roboto Slab

	wp_enqueue_style(  'campus-housing-fonts', campus_housing_fonts_url() );

	wp_enqueue_style( 'campus-housing-style', get_stylesheet_uri() );

	wp_enqueue_script( 'campus-housing-navigation', get_template_directory_uri() . '/js/navigation.js', array( 'jquery' ), time(), true );

																												//	array( 'jquery' ), '20151215', true

	wp_localize_script( 'campus-housing-navigation', 'campus_housingScreenReaderText', array(
		'expand' => __( 'Expand child menu', 'campus_housing' ),
		'collapse' => __( 'Collapse child menu', 'campus_housing' ),
	) );

	wp_enqueue_script( 'campus-housing-functions', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), time(), true );

	wp_enqueue_script( 'campus-housing-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), time(), true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'campus_housing_scripts' );

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

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}
