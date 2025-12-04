<?php
/**
 * usponsive functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package usponsive-theme
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function usponsive_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on usponsive, use a find and replace
	 * to change 'usponsive' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'usponsive', get_template_directory() . '/languages' );

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
	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'usponsive-theme' ),
			'leftcol' => __( 'Left Column Menu', 'usponsive-theme' ),
		)
	);

	// Debug helper (can be removed when no longer needed).
	add_filter(
		'template_include',
		function( $template ) {
			error_log( 'TEMPLATE_INCLUDE: ' . $template );
			return $template;
		}
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
			'usponsive_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	// Add support for core custom header (image).
	add_theme_support(
		'custom-header',
		array(
			'width'       => 1000,
			'height'      => 250,
			'flex-width'  => true,
			'flex-height' => true,
			'header-text' => false, // hides automatic overlay text
		)
	);
}
add_action( 'after_setup_theme', 'usponsive_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function usponsive_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'usponsive_content_width', 640 );
}
add_action( 'after_setup_theme', 'usponsive_content_width', 0 );

/**
 * Create Custom Navigation Menu.
 *
 * @link https://developer.wordpress.org/themes/functionality/navigation-menus/
 */
function sub_navigation_menu() {
	register_nav_menu( 'sub-navigation-menu', __( 'Sub Navigation Menu' ) );
}
add_action( 'init', 'sub_navigation_menu' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function usponsive_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'usponsive' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'usponsive' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'usponsive_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function usponsive_scripts() {
	wp_enqueue_style( 'usponsive-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'usponsive-style', 'rtl', 'replace' );

	wp_enqueue_style(
		'basestyle',
		get_template_directory_uri() . '/library/css/style.css',
		array(),
		filemtime( get_template_directory() . '/library/css/style.css' ),
		false
	);

	wp_enqueue_script( 'usponsive-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	wp_enqueue_script(
		'usponsive-functions',
		get_template_directory_uri() . '/library/js/usponsive.js',
		array(),
		filemtime( get_template_directory() . '/library/js/usponsive.js' ),
		true
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'usponsive_scripts' );

/**
 * Customizer: header image width & margin controls.
 *
 * These extend the Customizer with simple options to control
 * the header image width (px) and margin (CSS shorthand).
 */
function usponsive_header_image_customize_register( $wp_customize ) {

	// Add a dedicated section for header image & tagline settings.
	$wp_customize->add_section(
		'usponsive_header_image_settings',
		array(
			'title'       => __( 'Header Image & Tagline Settings', 'usponsive-theme' ),
			'priority'    => 35,
			'description' => __( 'Adjust the header image, background, and tagline.', 'usponsive-theme' ),
		)
	);

	// Header Image Width (in pixels).
	$wp_customize->add_setting(
		'usponsive_header_image_width',
		array(
			'default'           => 300,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'usponsive_header_image_width_control',
		array(
			'label'       => __( 'Header Image Width (px)', 'usponsive-theme' ),
			'section'     => 'usponsive_header_image_settings',
			'settings'    => 'usponsive_header_image_width',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 50,
				'max'  => 2000,
				'step' => 1,
			),
		)
	);

	// Header Image Margin (CSS shorthand).
	$wp_customize->add_setting(
		'usponsive_header_image_margin',
		array(
			'default'           => '0px',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'usponsive_header_image_margin_control',
		array(
			'label'       => __( 'Header Image Margin (CSS shorthand)', 'usponsive-theme' ),
			'section'     => 'usponsive_header_image_settings',
			'settings'    => 'usponsive_header_image_margin',
			'type'        => 'text',
			'description' => __( 'Example: 10px 0 or 20px 10px 0 10px', 'usponsive-theme' ),
		)
	);

	// Header Background Color.
	$wp_customize->add_setting(
		'usponsive_header_background_color',
		array(
			'default'           => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'usponsive_header_background_color_control',
			array(
				'label'    => __( 'Header Background Color', 'usponsive-theme' ),
				'section'  => 'usponsive_header_image_settings',
				'settings' => 'usponsive_header_background_color',
			)
		)
	);

	// Tagline font size preset.
	$wp_customize->add_setting(
		'usponsive_tagline_font_size_preset',
		array(
			'default'           => 'medium',
			'sanitize_callback' => function( $value ) {
				$allowed = array( 'x-small', 'small', 'medium', 'large', 'x-large' );
				return in_array( $value, $allowed, true ) ? $value : 'medium';
			},
		)
	);

	$wp_customize->add_control(
		'usponsive_tagline_font_size_preset_control',
		array(
			'label'    => __( 'Tagline Font Size', 'usponsive-theme' ),
			'section'  => 'usponsive_header_image_settings',
			'settings' => 'usponsive_tagline_font_size_preset',
			'type'     => 'select',
			'choices'  => array(
				'x-small' => __( 'Extra Small', 'usponsive-theme' ),
				'small'   => __( 'Small', 'usponsive-theme' ),
				'medium'  => __( 'Medium', 'usponsive-theme' ),
				'large'   => __( 'Large', 'usponsive-theme' ),
				'x-large' => __( 'Extra Large', 'usponsive-theme' ),
			),
		)
	);

	// Tagline font color.
	$wp_customize->add_setting(
		'usponsive_tagline_font_color',
		array(
			'default'           => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'usponsive_tagline_font_color_control',
			array(
				'label'    => __( 'Tagline Font Color', 'usponsive-theme' ),
				'section'  => 'usponsive_header_image_settings',
				'settings' => 'usponsive_tagline_font_color',
			)
		)
	);

	// Tagline bold (font-weight).
	$wp_customize->add_setting(
		'usponsive_tagline_bold',
		array(
			'default'           => false,
			'sanitize_callback' => function( $checked ) {
				return ( isset( $checked ) && true == $checked );
			},
		)
	);

	$wp_customize->add_control(
		'usponsive_tagline_bold_control',
		array(
			'label'    => __( 'Bold tagline', 'usponsive-theme' ),
			'section'  => 'usponsive_header_image_settings',
			'settings' => 'usponsive_tagline_bold',
			'type'     => 'checkbox',
		)
	);

	// Tagline italic (font-style).
	$wp_customize->add_setting(
		'usponsive_tagline_italic',
		array(
			'default'           => false,
			'sanitize_callback' => function( $checked ) {
				return ( isset( $checked ) && true == $checked );
			},
		)
	);

	$wp_customize->add_control(
		'usponsive_tagline_italic_control',
		array(
			'label'    => __( 'Italic tagline', 'usponsive-theme' ),
			'section'  => 'usponsive_header_image_settings',
			'settings' => 'usponsive_tagline_italic',
			'type'     => 'checkbox',
		)
	);

	// Tagline margin (CSS shorthand).
	$wp_customize->add_setting(
		'usponsive_tagline_margin',
		array(
			'default'           => '0',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'usponsive_tagline_margin_control',
		array(
			'label'       => __( 'Tagline Margin (CSS shorthand)', 'usponsive-theme' ),
			'section'     => 'usponsive_header_image_settings',
			'settings'    => 'usponsive_tagline_margin',
			'type'        => 'text',
			'description' => __( 'Example: 0, 5px 0, or 10px 15px 0 15px', 'usponsive-theme' ),
		)
	);

	// Tagline text alignment.
	$wp_customize->add_setting(
		'usponsive_tagline_text_align',
		array(
			'default'           => 'left',
			'sanitize_callback' => function( $value ) {
				$allowed = array( 'left', 'center', 'right' );
				return in_array( $value, $allowed, true ) ? $value : 'left';
			},
		)
	);

	$wp_customize->add_control(
		'usponsive_tagline_text_align_control',
		array(
			'label'    => __( 'Tagline Alignment', 'usponsive-theme' ),
			'section'  => 'usponsive_header_image_settings',
			'settings' => 'usponsive_tagline_text_align',
			'type'     => 'select',
			'choices'  => array(
				'left'   => __( 'Left', 'usponsive-theme' ),
				'center' => __( 'Center', 'usponsive-theme' ),
				'right'  => __( 'Right', 'usponsive-theme' ),
			),
		)
	);
}
add_action( 'customize_register', 'usponsive_header_image_customize_register' );

/**
 * Output dynamic CSS for header image width & margin.
 */
function usponsive_header_image_custom_styles() {

	$width             = get_theme_mod( 'usponsive_header_image_width', 300 );
	$margin            = get_theme_mod( 'usponsive_header_image_margin', '0px' );
	$bgcolor           = get_theme_mod( 'usponsive_header_background_color', '#ffffff' );
	$tag_size_preset   = get_theme_mod( 'usponsive_tagline_font_size_preset', 'medium' );
	$tag_color         = get_theme_mod( 'usponsive_tagline_font_color', '#ffffff' );
	$tag_bold          = get_theme_mod( 'usponsive_tagline_bold', false );
	$tag_italic        = get_theme_mod( 'usponsive_tagline_italic', false );
	$tag_margin        = get_theme_mod( 'usponsive_tagline_margin', '0' );
	$tag_align         = get_theme_mod( 'usponsive_tagline_text_align', 'left' );

	// Map preset sizes to actual pixel values.
	$size_map = array(
		'x-small' => 12,
		'small'   => 14,
		'medium'  => 16,
		'large'   => 20,
		'x-large' => 24,
	);

	$tag_font_size = isset( $size_map[ $tag_size_preset ] ) ? $size_map[ $tag_size_preset ] : $size_map['medium'];
	$tag_font_weight = $tag_bold ? '700' : '400';
	$tag_font_style  = $tag_italic ? 'italic' : 'normal';
	?>
	<style>
		/* Header background override */
		#header {
			background-color: <?php echo esc_attr( $bgcolor ); ?> !important;
		}

		/* Layout: logo + tagline side by side */
		.site-branding-container {
			width: 100%;
		}

		.site-branding-inner {
			display: flex;
			align-items: center;
			gap: 1rem;
			width: 100%;
		}

		/* Tagline styling and alignment */
		.site-tagline {
			margin: <?php echo esc_attr( $tag_margin ); ?>;
			font-size: <?php echo esc_attr( $tag_font_size ); ?>px;
			flex: 1; /* take up remaining space so text-align has an effect */
			text-align: <?php echo esc_attr( $tag_align ); ?>;
			color: <?php echo esc_attr( $tag_color ); ?>;
			font-weight: <?php echo esc_attr( $tag_font_weight ); ?>;
			font-style: <?php echo esc_attr( $tag_font_style ); ?>;
		}

		/* Header image styling (only when present) */
		<?php if ( get_header_image() ) : ?>
		#header img {
			width: <?php echo esc_attr( $width ); ?>px;
			margin: <?php echo esc_attr( $margin ); ?>;
			height: auto;
			display: block;
		}
		<?php endif; ?>
	</style>
	<?php
}
add_action( 'wp_head', 'usponsive_header_image_custom_styles' );


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
