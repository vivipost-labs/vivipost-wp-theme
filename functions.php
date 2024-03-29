<?php
/**
 * vivipost-wp-theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package vivipost-wp-theme
 */

if ( ! function_exists( 'vivipost_wp_theme_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function vivipost_wp_theme_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on vivipost-wp-theme, use a find and replace
		 * to change 'vivipost-wp-theme' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'vivipost-wp-theme', get_template_directory() . '/languages' );

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
			'menu-1' => esc_html__( 'Primary', 'vivipost-wp-theme' ),
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
		add_theme_support( 'custom-background', apply_filters( 'vivipost_wp_theme_custom_background_args', array(
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

		// $wp_customize->add_setting('your_theme_hover_logo');
		// $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'your_theme_hover_logo', array(
		// 		'label' => 'Upload Hover Logo',
		// 		'section' => 'title_tagline', //this is the section where the custom-logo from WordPress is
		// 		'settings' => 'your_theme_hover_logo',
		// 		'priority' => 8 // show it just below the custom-logo
		// )));
	}
endif;
add_action( 'after_setup_theme', 'vivipost_wp_theme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function vivipost_wp_theme_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'vivipost_wp_theme_content_width', 640 );
}
add_action( 'after_setup_theme', 'vivipost_wp_theme_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function vivipost_wp_theme_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'vivipost-wp-theme' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'vivipost-wp-theme' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'vivipost_wp_theme_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function vivipost_wp_theme_scripts() {
	wp_enqueue_style( 'vivipost-wp-theme-style', get_stylesheet_uri() );

	wp_enqueue_script( 'vivipost-wp-theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'vivipost-wp-theme-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	wp_enqueue_script( 'vivipost-wp-theme-libs', get_theme_file_uri( '/dist/js/lib.min.js' ), array(), '' );

	wp_enqueue_script( 'vivipost-wp-theme-app',  get_theme_file_uri( '/dist/js/app.js' ), array(), '', true ); 

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'vivipost_wp_theme_scripts' );

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
 * Enqueue Gutenberg block assets for backend editor.
 */

function editor_assets() {
	wp_enqueue_script( 'vivipost-libs', get_theme_file_uri( '/dist/js/lib.min.js' ), array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ), true );
	wp_enqueue_script( 'vivipost-scripts', get_theme_file_uri( '/dist/js/admin.js' ), array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ), true );
}
add_action( 'enqueue_block_editor_assets', 'editor_assets' );

function vivipost_block_category( $categories, $post ) {
	return array_merge( array( array(
		'slug' => 'vivipost',
		'title' => __( 'Vivipost', 'vivipost' ),
	), ), $categories );
}
add_filter( 'block_categories', 'vivipost_block_category', 10, 2);

function admin_styles() {
	wp_enqueue_style( 'vivipost-style', get_theme_file_uri( '/dist/css/admin.css' ), false, '1.0.0' );
}
add_action( 'admin_enqueue_scripts', 'admin_styles' );

/**
 * Allow SVG MIME Type in Media Upload
 *
 * @param array $mimes Mime types keyed by the file extension regex corresponding to those types.
*/
function cc_mime_types( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );

/**
 * Add social menu.
 */
function vivipost_menus() {
  register_nav_menu('social-menu', __( 'Social Menu' ));
  register_nav_menu('footer-menu', __( 'Footer Menu' ));
}
add_action( 'init', 'vivipost_menus' );

/**
 * Add customize section.
 */
function vivipost_customize_register( $wp_customize ) {
	
	// Footer Section
	$wp_customize->add_section( 'footer-section', array(
		'title'    => 'Site Footer',
		'priority' => 20,
	) );
	
	// Footer Logo
	$wp_customize->add_setting( 'footer-logo' );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'footer-logo', array(
		'settings'   => 'footer-logo',
		'label'      => 'Footer Image',
		'section'    => 'footer-section',
	) ) );

	// Footer Sections
	$wp_customize->add_setting( 'footer-address-one' );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'footer-address-one', array(
		'label'          => 'Address #1',
		'section'        => 'footer-section',
		'settings'       => 'footer-address-one',
		'type'           => 'textarea'
	) ) );
	
	$wp_customize->add_setting( 'footer-address-two' );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'footer-address-two', array(
		'label'          => 'Address #2',
		'section'        => 'footer-section',
		'settings'       => 'footer-address-two',
		'type'           => 'textarea'
	) ) );
	
}
add_action( 'customize_register', 'vivipost_customize_register');