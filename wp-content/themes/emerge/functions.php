<?php
/**
 * Moral functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Moral
 */

if ( ! function_exists( 'emerge_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function emerge_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Moral, use a find and replace
		 * to change 'emerge' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'emerge' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		add_theme_support( "responsive-embeds" );

		add_theme_support( 'register_block_pattern' ); 

		add_theme_support( 'register_block_style' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		add_image_size( 'emerge-home-blog', 400, 300, true );
		
		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary', 'emerge' ),
			'social' => esc_html__( 'Social', 'emerge' ),
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
		add_theme_support( 'custom-background', apply_filters( 'emerge_custom_background_args', array(
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

		/*
		 * This theme styles the visual editor to resemble the theme style,
		 * specifically font, colors, and column width.
	 	 */
		add_editor_style( array( 'assets/css/editor-style.css', emerge_fonts_url() ) );

		// Gutenberg support
		add_theme_support( 'editor-color-palette', array(
	       	array(
				'name' => esc_html__( 'Red', 'emerge' ),
				'slug' => 'red',
				'color' => '#cf3140',
	       	),
	       	array(
	           	'name' => esc_html__( 'Green', 'emerge' ),
	           	'slug' => 'green',
	           	'color' => '#07d79c',
	       	),
	       	array(
	           	'name' => esc_html__( 'Orange', 'emerge' ),
	           	'slug' => 'orange',
	           	'color' => '#ff8737',
	       	),
	       	array(
	           	'name' => esc_html__( 'Black', 'emerge' ),
	           	'slug' => 'black',
	           	'color' => '#2f3633',
	       	),
	       	array(
	           	'name' => esc_html__( 'Grey', 'emerge' ),
	           	'slug' => 'grey',
	           	'color' => '#82868b',
	       	),
	   	));

		add_theme_support( 'align-wide' );
		add_theme_support( 'editor-font-sizes', array(
		   	array(
		       	'name' => esc_html__( 'small', 'emerge' ),
		       	'shortName' => esc_html__( 'S', 'emerge' ),
		       	'size' => 12,
		       	'slug' => 'small'
		   	),
		   	array(
		       	'name' => esc_html__( 'regular', 'emerge' ),
		       	'shortName' => esc_html__( 'M', 'emerge' ),
		       	'size' => 16,
		       	'slug' => 'regular'
		   	),
		   	array(
		       	'name' => esc_html__( 'larger', 'emerge' ),
		       	'shortName' => esc_html__( 'L', 'emerge' ),
		       	'size' => 36,
		       	'slug' => 'larger'
		   	),
		   	array(
		       	'name' => esc_html__( 'huge', 'emerge' ),
		       	'shortName' => esc_html__( 'XL', 'emerge' ),
		       	'size' => 48,
		       	'slug' => 'huge'
		   	)
		));
		add_theme_support('editor-styles');
		add_theme_support( 'wp-block-styles' );
	}
endif;
add_action( 'after_setup_theme', 'emerge_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function emerge_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'emerge_content_width', 900 );
}
add_action( 'after_setup_theme', 'emerge_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function emerge_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Primary Sidebar', 'emerge' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'emerge' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	for ( $i=1; $i <= 3; $i++ ) { 
		register_sidebar( array(
			'name'          => esc_html__( 'Footer Widget Area ', 'emerge' ) . $i,
			'id'            => 'footer-' . $i,
			'description'   => esc_html__( 'Add widgets here.', 'emerge' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
	}
}
add_action( 'widgets_init', 'emerge_widgets_init' );

/**
 * Register custom fonts.
 */
function emerge_fonts_url() {
	$fonts_url = '';

	$font_families = array();
	
	/*
	 * Translators: If there are characters in your language that are not
	 * supported by Pacifico, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$pacifico = _x( 'on', 'Pacifico font: on or off', 'emerge' );

	if ( 'off' !== $pacifico ) {
		$font_families[] = 'Pacifico';
	}

	$oxygen = _x( 'on', 'Oxygen font: on or off', 'emerge' );

	if ( 'off' !== $oxygen ) {
		$font_families[] = 'Oxygen:300,400,700';
	}

	$raleway = _x( 'on', 'Raleway font: on or off', 'emerge' );

	if ( 'off' !== $raleway ) {
		$font_families[] = 'Raleway:300,400,500,600,700';
	}

	$query_args = array(
		'family' => urlencode( implode( '|', $font_families ) ),
		'subset' => urlencode( 'latin,latin-ext' ),
	);

	$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );

	return esc_url_raw( $fonts_url );
}

/**
 * Enqueue scripts and styles.
 */
function emerge_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'emerge-fonts', emerge_fonts_url(), array(), null );

	// blocks
	wp_enqueue_style( 'emerge-blocks', get_template_directory_uri() . '/assets/css/blocks.css' );

	wp_enqueue_style( 'emerge-style', get_stylesheet_uri() );

	wp_enqueue_script( 'packery-pkgd', get_theme_file_uri( '/assets/js/packery.pkgd.js' ), array( 'jquery' ), '20151215', true );

	wp_enqueue_script( 'emerge-navigation', get_theme_file_uri( '/assets/js/navigation.js' ), array(), '20151215', true );

	wp_enqueue_script( 'emerge-skip-link-focus-fix', get_theme_file_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20151215', true );

	wp_enqueue_script( 'emerge-custom', get_theme_file_uri( '/assets/js/custom.js' ), array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'emerge_scripts' );

/**
 * Enqueue editor styles for Gutenberg
 *
 * @since Emerge 1.0.0
 */
function emerge_block_editor_styles() {
	// Block styles.
	wp_enqueue_style( 'emerge-block-editor-style', get_theme_file_uri( '/assets/css/editor-blocks.css' ) );
	// Add custom fonts.
	wp_enqueue_style( 'emerge-fonts', emerge_fonts_url(), array(), null );
}
add_action( 'enqueue_block_editor_assets', 'emerge_block_editor_styles' );

/**
 * Custom template tags for this theme.
 */
require get_parent_theme_file_path( '/inc/template-tags.php' );

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_parent_theme_file_path( '/inc/template-functions.php' );

/**
 * Customizer additions.
 */
require get_parent_theme_file_path( '/inc/customizer.php' );

/**
 * SVG icons functions and filters.
 */
require get_parent_theme_file_path( '/inc/icon-functions.php' );

/**
 * Admin welcome page
 */
require get_parent_theme_file_path( '/inc/welcome.php' );

/**
 * TGMPA call
 */
require get_parent_theme_file_path( '/inc/tgmpa/call.php' );

/**
 * OCDI compatibility.
 */
if ( class_exists( 'OCDI_Plugin' ) ) {
	require get_parent_theme_file_path( '/inc/ocdi.php' );
}

/**
 * Enqueue admin css.
 * @return [type] [description]
 */
function emerge_load_custom_wp_admin_style( $hook ) {
	if ( 'appearance_page_emerge-welcome' != $hook ) {
        return;
    }
    wp_register_style( 'emerge-admin', get_theme_file_uri( 'assets/css/emerge-admin.css' ), false, '1.0.0' );
    wp_enqueue_style( 'emerge-admin' );
}
add_action( 'admin_enqueue_scripts', 'emerge_load_custom_wp_admin_style' );

/**
 * Styles the header image and text displayed on the blog.
 *
 * @see emerge_custom_header_setup().
 */
function emerge_header_text_style() {
	// If we get this far, we have custom styles. Let's do this.
	$header_text_display = get_theme_mod( 'emerge_header_text_display', true );
	?>
	<style type="text/css">
	<?php if ( ! $header_text_display ) : ?>
		.site-branding .site-branding-text .site-title a,
		.site-branding .site-branding-text .site-description {
		display: none;
	}
	<?php endif; ?>

	.site-branding .site-branding-text .site-title a,
	.home.lite-version.absolute-header #masthead .site-branding .site-branding-text .site-title a, 
	.home.dark-version.absolute-header #masthead .site-branding .site-branding-text .site-title a,
	.dark-version .site-branding .site-branding-text .site-title a 
	{
		color: <?php echo esc_attr( get_theme_mod( 'emerge_header_title_color', '#cf3140' ) ); ?>;
	}
	.site-branding .site-branding-text .site-description,
	.home.lite-version.absolute-header #masthead .site-branding .site-branding-text .site-description, 
	.home.dark-version.absolute-header #masthead .site-branding .site-branding-text .site-description,
	.dark-version .site-branding .site-branding-text .site-description
	{
		color: <?php echo esc_attr( get_theme_mod( 'emerge_header_tagline', '#2e2e2e' ) ); ?>;
	}
	</style>
	<?php
}
add_action( 'wp_head', 'emerge_header_text_style' );