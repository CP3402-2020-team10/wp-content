<?php
/**
 * townsvillejazz functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package townsvillejazz
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'townsvillejazz_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function townsvillejazz_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on townsvillejazz, use a find and replace
		 * to change 'townsvillejazz' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'townsvillejazz', get_template_directory() . '/languages' );

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
		add_image_size('townsvillejazz-gull-bleed',2000,2000,true);
        add_image_size('townsvillejazz-index-img',800,450, true);
		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'primary' => esc_html__( 'Header', 'townsvillejazz' ),
                'social' => esc_html__( 'Social Media Menu', 'townsvillejazz' ),

			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'townsvillejazz_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for custom logo
        add_theme_support('custom-logo', array(
            'width' => 90,
            'height' => 90,
            'flex-width' => true,
        ));

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
//		add_theme_support(
//			'custom-logo',
//			array(
//				'height'      => 250,
//				'width'       => 250,
//				'flex-width'  => true,
//				'flex-height' => true,
//			)
//		);
	}
endif;
add_action( 'after_setup_theme', 'townsvillejazz_setup' );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function townsvillejazz_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'townsvillejazz_content_width', 640 );
}
add_action( 'after_setup_theme', 'townsvillejazz_content_width', 0 );




function townsvillejazz_content_image_sizes_attr( $sizes, $size ) {
    $width = $size[0];

    if ( 900 <= $width ) {
        $sizes = '(min-width: 900px) 700px, 900px';
    }

    if ( is_active_sidebar( 'sidebar-1' ) || is_active_sidebar( 'sidebar-2' ) ) {
        $sizes = '(min-width: 900px) 600px, 900px';
    }

    return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'townsvillejazz_content_image_sizes_attr', 10, 2 );

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
function townsvillejazz_header_image_tag( $html, $header, $attr ) {
    if ( isset( $attr['sizes'] ) ) {
        $html = str_replace( $attr['sizes'], '100vw', $html );
    }
    return $html;
}
add_filter( 'get_header_image_tag', 'townsvillejazz_header_image_tag', 10, 3 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails.
 *
 * @origin Twenty Seventeen 1.0
 *
 * @param array $attr Attributes for the image markup.
 * @param int $attachment Image attachment ID.
 * @param array $size Registered image size or flat array of height and width dimensions.
 * @return array A source size value for use in a post thumbnail 'sizes' attribute.
 */
function townsvillejazz_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {

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
add_filter( 'wp_get_attachment_image_attributes', 'townsvillejazz_post_thumbnail_sizes_attr', 10, 3 );


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function townsvillejazz_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'townsvillejazz' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'townsvillejazz' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'townsvillejazz_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function townsvillejazz_scripts() {
    //google fonts PT SANS and Roboto

    wp_enqueue_style('townsvillejazz-fonts', 'https://fonts.googleapis.com/css2?family=PT+Sans:ital@1&family=Roboto:ital@1&disp');

	wp_enqueue_style( 'townsvillejazz-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'townsvillejazz-style', 'rtl', 'replace' );

	wp_enqueue_script( 'townsvillejazz-navigation', get_template_directory_uri() . '/js/navigation.js', array('jquery'), _S_VERSION, true );

	wp_localize_script('townsvillejazz-navigation','townsvillejazzScreenReaderText', array(
	    'expand' => __( 'Expand child menu','townsvillejazz'),
        'collapse' => __( 'Collapse child menu','townsvillejazz'),
    ));

	wp_enqueue_script( 'townsvillejazz-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

    wp_enqueue_script( 'townsvillejazz-functions', get_template_directory_uri() . '/js/functions.js', array('jquery'), _S_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'townsvillejazz_scripts' );

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

