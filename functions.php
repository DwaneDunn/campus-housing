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
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Campus Housing, use a find and replace
		 * to change 'campus-housing' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'campus-housing', get_template_directory() . '/languages' );

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
			'menu-1' => esc_html__( 'Header Menu', 'campus-housing' ),
			'menu-2' => esc_html__( 'Social Media Menu', 'campus-housing' ),
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
		add_theme_support( 'custom-background', apply_filters( 'campus_housing_custom_background_args', array(
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


		add_theme_support( 'custom-logo', array(
			'width' => 90,
			'height' => 90,
			'flex-width' => true,
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
	 *
	 * https://fonts.googleapis.com/css?family=Merriweather+Sans:400,400i,700,700i|Roboto+Slab:400,700
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

//	wp_enqueue_script( 'campus-housing-navigation', get_template_directory_uri() . '/js/navigation.js', array( 'jquery' ), '20151215', true );


	wp_localize_script( 'campus-housing-navigation', 'campus_housingScreenReaderText', array(
		'expand' => __( 'Expand child menu', 'campus_housing' ),
		'collapse' => __( 'Collapse child menu', 'campus_housing' ),
	) );

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
