<?php
/**
 * minimus functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package minimus
 */

if ( ! function_exists( 'minimus_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function minimus_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on minimus, use a find and replace
	 * to change 'minimus' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'minimus', get_template_directory() . '/languages' );

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
		'menu-1' => esc_html__( 'Primary', 'minimus' ),
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
	add_theme_support( 'custom-background', apply_filters( 'minimus_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif;
add_action( 'after_setup_theme', 'minimus_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function minimus_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'minimus_content_width', 640 );
}
add_action( 'after_setup_theme', 'minimus_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function minimus_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'minimus' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'minimus' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'minimus_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function minimus_scripts() {
	wp_enqueue_style( 'minimus-skeleton', get_template_directory_uri() . '/css/skeleton.css' );	
	wp_enqueue_style( 'font-lora', '//fonts.googleapis.com/css?family=Lora:400,400i,700,700i' );
	wp_enqueue_style( 'minimus-style', get_stylesheet_uri() );

	wp_enqueue_script( 'minimus-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );
	
	wp_enqueue_script( 'minimus-reading-mode', get_template_directory_uri() . '/js/reading-mode.js', array('jquery'), '20151215', true );

	wp_enqueue_script( 'minimus-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'minimus_scripts' );

add_action( 'wp_enqueue_scripts', 'load_dashicons_front_end' );
function load_dashicons_front_end() {
  wp_enqueue_style( 'dashicons' );
}

/* Custom excerpt length */
function custom_excerpt_length( $length ) {
	return 135;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

/* Custom excerpt link*/

function wpdocs_excerpt_more( $more ) {
    return sprintf( ' [...] <a class="read-more" href="%1$s">%2$s</a>',
        get_permalink( get_the_ID() ),
        __( 'Read More', 'minimus' )
    );
}
add_filter( 'excerpt_more', 'wpdocs_excerpt_more' );

/* Register Custom Books Taxonomy */

function books_init() {
	// create a new taxonomy
	register_taxonomy(
		'books',
		'post',
		array(
			'label' => __( 'Book' ),
			'rewrite' => array( 'slug' => 'book' ),
			'hierarchical' => true
		)
	);
}
add_action( 'init', 'books_init' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
