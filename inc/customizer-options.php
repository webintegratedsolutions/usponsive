<?php
/**
 * Customizer: header image width & margin controls, and page layout regions
 *
 * These extend the Customizer with simple options to control
 * the header image width (px) and margin (CSS shorthand).
 */

// Remove default header text color control
function usponsive_cleanup_default_color_controls( $wp_customize ) {
    // Remove the core "Header Text Color" control so only our custom one remains.
    if ( $wp_customize->get_control( 'header_textcolor' ) ) {
        $wp_customize->remove_control( 'header_textcolor' );
    }
}
add_action( 'customize_register', 'usponsive_cleanup_default_color_controls', 20 );

// Rename the Colors section to "Site Region Colors"
function usponsive_rename_colors_section( $wp_customize ) {
    // Rename the built-in Colors section.
    if ( $wp_customize->get_section( 'colors' ) ) {
        $wp_customize->get_section( 'colors' )->title = __( 'Site Region Colors', 'usponsive-theme' );
    }
}
add_action( 'customize_register', 'usponsive_rename_colors_section', 20 );


function usponsive_header_image_customize_register( $wp_customize ) {

	// -----------------------------
// SITE LINK COLORS SECTION
// -----------------------------
$wp_customize->add_section(
    'usponsive_site_link_colors',
    array(
        'title'       => __( 'Site Link Colors', 'usponsive-theme' ),
        'priority'    => 36, // Adjust as needed in the left panel
        'description' => __( 'Controls text colors for navigation and other site links.', 'usponsive-theme' ),
    )
);

	// Add a dedicated section for header image & tagline settings.
	$wp_customize->add_section(
		'usponsive_header_image_settings',
		array(
			'title'       => __( 'Header Image & Tagline Settings', 'usponsive-theme' ),
			'priority'    => 35,
			'description' => __( 'Adjust the header image, and tagline.', 'usponsive-theme' ),
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

	/**
	 * Layout Regions section: toggle metarow and left column.
	 */

	$wp_customize->add_section(
		'usponsive_layout_regions',
		array(
			'title'       => __( 'Page Layout Regions', 'usponsive-theme' ),
			'priority'    => 40,
			'description' => __( 'Turn header and content regions on or off.', 'usponsive-theme' ),
		)
	);

	// Top Bar toggle.
	$wp_customize->add_setting(
		'usponsive_show_topbar',
		array(
			'default'           => true,
			'sanitize_callback' => function( $checked ) {
				return ( isset( $checked ) && (bool) $checked );
			},
		)
	);

	$wp_customize->add_control(
		'usponsive_show_topbar_control',
		array(
			'label'    => __( 'Show Top Bar', 'usponsive-theme' ),
			'section'  => 'usponsive_layout_regions',
			'settings' => 'usponsive_show_topbar',
			'type'     => 'checkbox',
		)
	);

	// Header Region toggle.
	$wp_customize->add_setting(
		'usponsive_show_header_region',
		array(
			'default'           => true,
			'sanitize_callback' => function( $checked ) {
				return ( isset( $checked ) && (bool) $checked );
			},
		)
	);

	$wp_customize->add_control(
		'usponsive_show_header_region_control',
		array(
			'label'    => __( 'Show Header Region', 'usponsive-theme' ),
			'section'  => 'usponsive_layout_regions',
			'settings' => 'usponsive_show_header_region',
			'type'     => 'checkbox',
		)
	);

	// Navigation Row toggle.
	$wp_customize->add_setting(
		'usponsive_show_navrow',
		array(
			'default'           => true,
			'sanitize_callback' => function( $checked ) {
				return ( isset( $checked ) && (bool) $checked );
			},
		)
	);

	$wp_customize->add_control(
		'usponsive_show_navrow_control',
		array(
			'label'    => __( 'Show Navigation Row', 'usponsive-theme' ),
			'section'  => 'usponsive_layout_regions',
			'settings' => 'usponsive_show_navrow',
			'type'     => 'checkbox',
		)
	);

	// Meta Row toggle.
	$wp_customize->add_setting(
		'usponsive_show_metarow',
		array(
			'default'           => true,
			'sanitize_callback' => function( $checked ) {
				return ( isset( $checked ) && (bool) $checked );
			},
		)
	);

	$wp_customize->add_control(
		'usponsive_show_metarow_control',
		array(
			'label'    => __( 'Show Meta Row', 'usponsive-theme' ),
			'section'  => 'usponsive_layout_regions',
			'settings' => 'usponsive_show_metarow',
			'type'     => 'checkbox',
		)
	);

	// Left Column toggle.
	$wp_customize->add_setting(
		'usponsive_show_leftcol',
		array(
			'default'           => true,
			'sanitize_callback' => function( $checked ) {
				return ( isset( $checked ) && (bool) $checked );
			},
		)
	);

	$wp_customize->add_control(
		'usponsive_show_leftcol_control',
		array(
			'label'    => __( 'Show Left Column', 'usponsive-theme' ),
			'section'  => 'usponsive_layout_regions',
			'settings' => 'usponsive_show_leftcol',
			'type'     => 'checkbox',
		)
	);

	// Right Column (Sidebar) toggle.
	$wp_customize->add_setting(
		'usponsive_show_rightcol',
		array(
			'default'           => true,
			'sanitize_callback' => function( $checked ) {
				return ( isset( $checked ) && (bool) $checked );
			},
		)
	);

	$wp_customize->add_control(
		'usponsive_show_rightcol_control',
		array(
			'label'    => __( 'Show Right Column (Sidebar)', 'usponsive-theme' ),
			'section'  => 'usponsive_layout_regions',
			'settings' => 'usponsive_show_rightcol',
			'type'     => 'checkbox',
		)
	);

	// Meta Footer Region toggle.
	$wp_customize->add_setting(
		'usponsive_show_metafooter',
		array(
			'default'           => true,
			'sanitize_callback' => function( $checked ) {
				return ( isset( $checked ) && (bool) $checked );
			},
		)
	);

	$wp_customize->add_control(
		'usponsive_show_metafooter_control',
		array(
			'label'    => __( 'Show Meta Footer Region', 'usponsive-theme' ),
			'section'  => 'usponsive_layout_regions',
			'settings' => 'usponsive_show_metafooter',
			'type'     => 'checkbox',
		)
	);

	// Footer Region toggle.
	$wp_customize->add_setting(
		'usponsive_show_footer_region',
		array(
			'default'           => true,
			'sanitize_callback' => function( $checked ) {
				return ( isset( $checked ) && (bool) $checked );
			},
		)
	);

	$wp_customize->add_control(
		'usponsive_show_footer_region_control',
		array(
			'label'    => __( 'Show Footer Region', 'usponsive-theme' ),
			'section'  => 'usponsive_layout_regions',
			'settings' => 'usponsive_show_footer_region',
			'type'     => 'checkbox',
		)
	);

	// Sub Footer Region toggle.
	$wp_customize->add_setting(
		'usponsive_show_subfooter',
		array(
			'default'           => true,
			'sanitize_callback' => function( $checked ) {
				return ( isset( $checked ) && (bool) $checked );
			},
		)
	);

	$wp_customize->add_control(
		'usponsive_show_subfooter_control',
		array(
			'label'    => __( 'Show Sub Footer Region', 'usponsive-theme' ),
			'section'  => 'usponsive_layout_regions',
			'settings' => 'usponsive_show_subfooter',
			'type'     => 'checkbox',
		)
	);

// -----------------------------
// COLOR SETTINGS
// -----------------------------

	// Page Background Color setting.
    $wp_customize->add_setting(
        'page_background_color',
        array(
            'default'           => '#ccc',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'refresh', // or 'postMessage' if you later add live preview JS
        )
    );

    // Page Background Color control.
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'page_background_color_control',
            array(
                'label'    => __( 'Page BG Color', 'usponsive' ),
                'section'  => 'colors', // Use existing "Colors" section.
                'settings' => 'page_background_color',
				'priority' => 5,
            )
        )
    );

// -----------------------------
// TOP BAR COLOR SETTINGS
// -----------------------------

// Background color
$wp_customize->add_setting(
    'usponsive_topbar_bg_color',
    array(
        'default'           => '#0D1B1E', // matches your CSS
        'sanitize_callback' => 'sanitize_hex_color',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'usponsive_topbar_bg_color_control',
        array(
            'label'    => __( 'Top Bar BG Color', 'usponsive-theme' ),
            'section'  => 'colors',
            'settings' => 'usponsive_topbar_bg_color',
			'priority' => 10,
        )
    )
);

// Text color
$wp_customize->add_setting(
    'usponsive_topbar_text_color',
    array(
        'default'           => '#ffffff', // matches your CSS
        'sanitize_callback' => 'sanitize_hex_color',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'usponsive_topbar_text_color_control',
        array(
            'label'    => __( 'Top Bar Text Color', 'usponsive-theme' ),
            'section'  => 'colors',
            'settings' => 'usponsive_topbar_text_color',
			'priority' => 11,
        )
    )
);

// -----------------------------
// HEADER COLOR SETTINGS
// -----------------------------

// Header background color.
$wp_customize->add_setting(
    'usponsive_header_bg_color',
    array(
        'default'           => '#003F52', // matches your CSS
        'sanitize_callback' => 'sanitize_hex_color',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'usponsive_header_bg_color_control',
        array(
            'label'    => __( 'Header BG Color', 'usponsive-theme' ),
            'section'  => 'colors',
            'settings' => 'usponsive_header_bg_color',
			'priority' => 20,
        )
    )
);

// Header text color.
$wp_customize->add_setting(
    'usponsive_header_text_color',
    array(
        'default'           => '#ffffff', // matches your CSS
        'sanitize_callback' => 'sanitize_hex_color',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'usponsive_header_text_color_control',
        array(
            'label'    => __( 'Header Text Color', 'usponsive-theme' ),
            'section'  => 'colors',
            'settings' => 'usponsive_header_text_color',
			'priority' => 21,
        )
    )
);

// -----------------------------
// NAVIGATION ROW COLOR SETTINGS
// -----------------------------

// Navigation Row background color.
$wp_customize->add_setting(
    'usponsive_navrow_bg_color',
    array(
        'default'           => '#01607E', // updated default
        'sanitize_callback' => 'sanitize_hex_color',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'usponsive_navrow_bg_color_control',
        array(
            'label'    => __( 'Navigation Row BG Color', 'usponsive-theme' ),
            'section'  => 'colors',
            'settings' => 'usponsive_navrow_bg_color',
            'priority' => 25,
        )
    )
);

// Navigation Row hover background color.
$wp_customize->add_setting(
    'usponsive_navrow_hover_bg_color',
    array(
        'default'           => '#eda', // matches your current CSS
        'sanitize_callback' => 'sanitize_hex_color',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'usponsive_navrow_hover_bg_color_control',
        array(
            'label'    => __( 'Navigation Row Hover Color', 'usponsive-theme' ),
            'section'  => 'colors',
            'settings' => 'usponsive_navrow_hover_bg_color',
            'priority' => 26,
        )
    )
);

// -----------------------------
// LEFT COLUMN COLOR SETTINGS
// -----------------------------

// Left Column background color.
$wp_customize->add_setting(
    'usponsive_leftcol_bg_color',
    array(
        'default'           => '#eeeeee', // matches your CSS
        'sanitize_callback' => 'sanitize_hex_color',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'usponsive_leftcol_bg_color_control',
        array(
            'label'    => __( 'Left Column BG Color', 'usponsive-theme' ),
            'section'  => 'colors',
            'settings' => 'usponsive_leftcol_bg_color',
            'priority' => 30,
        )
    )
);

// Left Column text color.
$wp_customize->add_setting(
    'usponsive_leftcol_text_color',
    array(
        'default'           => '#333333', // a good readable default
        'sanitize_callback' => 'sanitize_hex_color',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'usponsive_leftcol_text_color_control',
        array(
            'label'    => __( 'Left Column Text Color', 'usponsive-theme' ),
            'section'  => 'colors',
            'settings' => 'usponsive_leftcol_text_color',
            'priority' => 31,
        )
    )
);

// -----------------------------
// MAIN AREA COLOR SETTINGS
// -----------------------------

// Main Area background color.
$wp_customize->add_setting(
    'usponsive_mainarea_bg_color',
    array(
        'default'           => '#ffffff', // matches your CSS
        'sanitize_callback' => 'sanitize_hex_color',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'usponsive_mainarea_bg_color_control',
        array(
            'label'    => __( 'Main Area BG Color', 'usponsive-theme' ),
            'section'  => 'colors',
            'settings' => 'usponsive_mainarea_bg_color',
            'priority' => 40,
        )
    )
);

// Main Area text color.
$wp_customize->add_setting(
    'usponsive_mainarea_text_color',
    array(
        'default'           => '#333333', // matches your CSS
        'sanitize_callback' => 'sanitize_hex_color',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'usponsive_mainarea_text_color_control',
        array(
            'label'    => __( 'Main Area Text Color', 'usponsive-theme' ),
            'section'  => 'colors',
            'settings' => 'usponsive_mainarea_text_color',
            'priority' => 41,
        )
    )
);

// -----------------------------
// RIGHT COLUMN COLOR SETTINGS
// -----------------------------

// Right Column background color.
$wp_customize->add_setting(
    'usponsive_rightcol_bg_color',
    array(
        'default'           => '#dddddd', // matches your CSS (#ddd)
        'sanitize_callback' => 'sanitize_hex_color',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'usponsive_rightcol_bg_color_control',
        array(
            'label'    => __( 'Right Column BG Color', 'usponsive-theme' ),
            'section'  => 'colors',
            'settings' => 'usponsive_rightcol_bg_color',
            'priority' => 50,
        )
    )
);

// Right Column text color.
$wp_customize->add_setting(
    'usponsive_rightcol_text_color',
    array(
        'default'           => '#333333', // matches your CSS
        'sanitize_callback' => 'sanitize_hex_color',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'usponsive_rightcol_text_color_control',
        array(
            'label'    => __( 'Right Column Text Color', 'usponsive-theme' ),
            'section'  => 'colors',
            'settings' => 'usponsive_rightcol_text_color',
            'priority' => 51,
        )
    )
);

// -----------------------------
// META FOOTER COLOR SETTINGS
// -----------------------------

// Meta Footer background color.
$wp_customize->add_setting(
    'usponsive_metafooter_bg_color',
    array(
        'default'           => '#333333', // matches CSS
        'sanitize_callback' => 'sanitize_hex_color',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'usponsive_metafooter_bg_color_control',
        array(
            'label'    => __( 'Meta Footer BG Color', 'usponsive-theme' ),
            'section'  => 'colors',
            'settings' => 'usponsive_metafooter_bg_color',
            'priority' => 60,
        )
    )
);

// Meta Footer text color.
$wp_customize->add_setting(
    'usponsive_metafooter_text_color',
    array(
        'default'           => '#ffffff', // matches CSS
        'sanitize_callback' => 'sanitize_hex_color',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'usponsive_metafooter_text_color_control',
        array(
            'label'    => __( 'Meta Footer Text Color', 'usponsive-theme' ),
            'section'  => 'colors',
            'settings' => 'usponsive_metafooter_text_color',
            'priority' => 61,
        )
    )
);

// -----------------------------
// FOOTER COLOR SETTINGS
// -----------------------------

// Footer background color.
$wp_customize->add_setting(
    'usponsive_footer_bg_color',
    array(
        'default'           => '#000000', // matches CSS
        'sanitize_callback' => 'sanitize_hex_color',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'usponsive_footer_bg_color_control',
        array(
            'label'    => __( 'Footer BG Color', 'usponsive-theme' ),
            'section'  => 'colors',
            'settings' => 'usponsive_footer_bg_color',
            'priority' => 62,
        )
    )
);

// Footer text color.
$wp_customize->add_setting(
    'usponsive_footer_text_color',
    array(
        'default'           => '#ffffff', // matches CSS
        'sanitize_callback' => 'sanitize_hex_color',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'usponsive_footer_text_color_control',
        array(
            'label'    => __( 'Footer Text Color', 'usponsive-theme' ),
            'section'  => 'colors',
            'settings' => 'usponsive_footer_text_color',
            'priority' => 63,
        )
    )
);

// -----------------------------
// SUB FOOTER COLOR SETTINGS
// -----------------------------

// Sub Footer background color.
$wp_customize->add_setting(
    'usponsive_subfooter_bg_color',
    array(
        'default'           => '#cccccc', // matches CSS
        'sanitize_callback' => 'sanitize_hex_color',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'usponsive_subfooter_bg_color_control',
        array(
            'label'    => __( 'Sub Footer BG Color', 'usponsive-theme' ),
            'section'  => 'colors',
            'settings' => 'usponsive_subfooter_bg_color',
            'priority' => 64,
        )
    )
);

// Sub Footer text color.
$wp_customize->add_setting(
    'usponsive_subfooter_text_color',
    array(
        'default'           => '#404040', // matches CSS
        'sanitize_callback' => 'sanitize_hex_color',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'usponsive_subfooter_text_color_control',
        array(
            'label'    => __( 'Sub Footer Text Color', 'usponsive-theme' ),
            'section'  => 'colors',
            'settings' => 'usponsive_subfooter_text_color',
            'priority' => 65,
        )
    )
);

// -----------------------------
// GLOBAL LINK COLOR PRESETS
// -----------------------------

// Navigation Row text color.
$wp_customize->add_setting(
    'usponsive_navrow_text_color',
    array(
        'default'           => '#ffffff', // matches your CSS
        'sanitize_callback' => 'sanitize_hex_color',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'usponsive_navrow_text_color_control',
        array(
            'label'    => __( 'Navigation Row Link Color', 'usponsive-theme' ),
            'section'  => 'usponsive_site_link_colors',
            'settings' => 'usponsive_navrow_text_color',
            'priority' => 1,  // appears right after BG Color
        )
    )
);

// Navigation Row hover text color.
$wp_customize->add_setting(
    'usponsive_navrow_hover_text_color',
    array(
        'default'           => '#333333', // matches your current CSS
        'sanitize_callback' => 'sanitize_hex_color',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'usponsive_navrow_hover_text_color_control',
        array(
            'label'    => __( 'Navigation Row Hover Link Color', 'usponsive-theme' ),
            'section'  => 'usponsive_site_link_colors',
            'settings' => 'usponsive_navrow_hover_text_color',
            'priority' => 2,
        )
    )
);

// Light BG Links Color.
$wp_customize->add_setting(
    'usponsive_light_bg_links_color',
    array(
        'default'           => '#0066cc', // good default for links on light backgrounds
        'sanitize_callback' => 'sanitize_hex_color',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'usponsive_light_bg_links_color_control',
        array(
            'label'    => __( 'Light BG Links Color', 'usponsive-theme' ),
            'section'  => 'usponsive_site_link_colors',
            'settings' => 'usponsive_light_bg_links_color',
            'priority' => 10,
        )
    )
);

// Light BG Links Hover Color.
$wp_customize->add_setting(
    'usponsive_light_bg_links_hover_color',
    array(
        'default'           => '#004999', // darker hover for light backgrounds
        'sanitize_callback' => 'sanitize_hex_color',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'usponsive_light_bg_links_hover_color_control',
        array(
            'label'    => __( 'Light BG Links Hover Color', 'usponsive-theme' ),
            'section'  => 'usponsive_site_link_colors',
            'settings' => 'usponsive_light_bg_links_hover_color',
            'priority' => 11,
        )
    )
);

// Dark BG Links Color.
$wp_customize->add_setting(
    'usponsive_dark_bg_links_color',
    array(
        'default'           => '#ffffff', // white links on dark backgrounds
        'sanitize_callback' => 'sanitize_hex_color',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'usponsive_dark_bg_links_color_control',
        array(
            'label'    => __( 'Dark BG Links Color', 'usponsive-theme' ),
            'section'  => 'usponsive_site_link_colors',
            'settings' => 'usponsive_dark_bg_links_color',
            'priority' => 22,
        )
    )
);

// Dark BG Links Hover Color.
$wp_customize->add_setting(
    'usponsive_dark_bg_links_hover_color',
    array(
        'default'           => '#cccccc', // lighter hover for dark backgrounds
        'sanitize_callback' => 'sanitize_hex_color',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'usponsive_dark_bg_links_hover_color_control',
        array(
            'label'    => __( 'Dark BG Links Hover Color', 'usponsive-theme' ),
            'section'  => 'usponsive_site_link_colors',
            'settings' => 'usponsive_dark_bg_links_hover_color',
            'priority' => 23,
        )
    )
);

// -----------------------------
// LIGHT BG LINK REGIONS
// -----------------------------

// Helper sanitize for checkboxes.
if ( ! function_exists( 'usponsive_sanitize_checkbox' ) ) {
    function usponsive_sanitize_checkbox( $checked ) {
        return ( isset( $checked ) && (bool) $checked );
    }
}

// Top Bar (light links).
$wp_customize->add_setting(
    'usponsive_light_links_topbar',
    array(
        'default'           => false,
        'sanitize_callback' => 'usponsive_sanitize_checkbox',
    )
);

$wp_customize->add_control(
    'usponsive_light_links_topbar_control',
    array(
        'label'    => __( 'Apply Light Link Colors to Top Bar', 'usponsive-theme' ),
        'section'  => 'usponsive_site_link_colors',
        'settings' => 'usponsive_light_links_topbar',
        'type'     => 'checkbox',
        'priority' => 12,
    )
);

// Header (light links).
$wp_customize->add_setting(
    'usponsive_light_links_header',
    array(
        'default'           => false,
        'sanitize_callback' => 'usponsive_sanitize_checkbox',
    )
);

$wp_customize->add_control(
    'usponsive_light_links_header_control',
    array(
        'label'    => __( 'Apply Light Link Colors to Header', 'usponsive-theme' ),
        'section'  => 'usponsive_site_link_colors',
        'settings' => 'usponsive_light_links_header',
        'type'     => 'checkbox',
        'priority' => 13,
    )
);

// Left Column (light links).
$wp_customize->add_setting(
    'usponsive_light_links_leftcol',
    array(
        'default'           => false,
        'sanitize_callback' => 'usponsive_sanitize_checkbox',
    )
);

$wp_customize->add_control(
    'usponsive_light_links_leftcol_control',
    array(
        'label'    => __( 'Apply Light Link Colors to Left Column', 'usponsive-theme' ),
        'section'  => 'usponsive_site_link_colors',
        'settings' => 'usponsive_light_links_leftcol',
        'type'     => 'checkbox',
        'priority' => 14,
    )
);

// Main Area (light links).
$wp_customize->add_setting(
    'usponsive_light_links_main',
    array(
        'default'           => false,
        'sanitize_callback' => 'usponsive_sanitize_checkbox',
    )
);

$wp_customize->add_control(
    'usponsive_light_links_main_control',
    array(
        'label'    => __( 'Apply Light Link Colors to Main Area', 'usponsive-theme' ),
        'section'  => 'usponsive_site_link_colors',
        'settings' => 'usponsive_light_links_main',
        'type'     => 'checkbox',
        'priority' => 15,
    )
);

// Right Column (light links).
$wp_customize->add_setting(
    'usponsive_light_links_rightcol',
    array(
        'default'           => false,
        'sanitize_callback' => 'usponsive_sanitize_checkbox',
    )
);

$wp_customize->add_control(
    'usponsive_light_links_rightcol_control',
    array(
        'label'    => __( 'Apply Light Link Colors to Right Column', 'usponsive-theme' ),
        'section'  => 'usponsive_site_link_colors',
        'settings' => 'usponsive_light_links_rightcol',
        'type'     => 'checkbox',
        'priority' => 16,
    )
);

// Meta Footer (light links).
$wp_customize->add_setting(
    'usponsive_light_links_metafooter',
    array(
        'default'           => false,
        'sanitize_callback' => 'usponsive_sanitize_checkbox',
    )
);

$wp_customize->add_control(
    'usponsive_light_links_metafooter_control',
    array(
        'label'    => __( 'Apply Light Link Colors to Meta Footer', 'usponsive-theme' ),
        'section'  => 'usponsive_site_link_colors',
        'settings' => 'usponsive_light_links_metafooter',
        'type'     => 'checkbox',
        'priority' => 17,
    )
);

// Footer (light links).
$wp_customize->add_setting(
    'usponsive_light_links_footer',
    array(
        'default'           => false,
        'sanitize_callback' => 'usponsive_sanitize_checkbox',
    )
);

$wp_customize->add_control(
    'usponsive_light_links_footer_control',
    array(
        'label'    => __( 'Apply Light Link Colors to Footer', 'usponsive-theme' ),
        'section'  => 'usponsive_site_link_colors',
        'settings' => 'usponsive_light_links_footer',
        'type'     => 'checkbox',
        'priority' => 18,
    )
);

// Sub Footer (light links).
$wp_customize->add_setting(
    'usponsive_light_links_subfooter',
    array(
        'default'           => false,
        'sanitize_callback' => 'usponsive_sanitize_checkbox',
    )
);

$wp_customize->add_control(
    'usponsive_light_links_subfooter_control',
    array(
        'label'    => __( 'Apply Light Link Colors to Sub Footer', 'usponsive-theme' ),
        'section'  => 'usponsive_site_link_colors',
        'settings' => 'usponsive_light_links_subfooter',
        'type'     => 'checkbox',
        'priority' => 19,
    )
);

// -----------------------------
// DARK BG LINK REGIONS
// -----------------------------

// Top Bar (dark links).
$wp_customize->add_setting(
    'usponsive_dark_links_topbar',
    array(
        'default'           => false,
        'sanitize_callback' => 'usponsive_sanitize_checkbox',
    )
);

$wp_customize->add_control(
    'usponsive_dark_links_topbar_control',
    array(
        'label'    => __( 'Apply Dark Link Colors to Top Bar', 'usponsive-theme' ),
        'section'  => 'usponsive_site_link_colors',
        'settings' => 'usponsive_dark_links_topbar',
        'type'     => 'checkbox',
        'priority' => 24,
    )
);

// Header (dark links).
$wp_customize->add_setting(
    'usponsive_dark_links_header',
    array(
        'default'           => false,
        'sanitize_callback' => 'usponsive_sanitize_checkbox',
    )
);

$wp_customize->add_control(
    'usponsive_dark_links_header_control',
    array(
        'label'    => __( 'Apply Dark Link Colors to Header', 'usponsive-theme' ),
        'section'  => 'usponsive_site_link_colors',
        'settings' => 'usponsive_dark_links_header',
        'type'     => 'checkbox',
        'priority' => 25,
    )
);

// Left Column (dark links).
$wp_customize->add_setting(
    'usponsive_dark_links_leftcol',
    array(
        'default'           => false,
        'sanitize_callback' => 'usponsive_sanitize_checkbox',
    )
);

$wp_customize->add_control(
    'usponsive_dark_links_leftcol_control',
    array(
        'label'    => __( 'Apply Dark Link Colors to Left Column', 'usponsive-theme' ),
        'section'  => 'usponsive_site_link_colors',
        'settings' => 'usponsive_dark_links_leftcol',
        'type'     => 'checkbox',
        'priority' => 26,
    )
);

// Main Area (dark links).
$wp_customize->add_setting(
    'usponsive_dark_links_main',
    array(
        'default'           => false,
        'sanitize_callback' => 'usponsive_sanitize_checkbox',
    )
);

$wp_customize->add_control(
    'usponsive_dark_links_main_control',
    array(
        'label'    => __( 'Apply Dark Link Colors to Main Area', 'usponsive-theme' ),
        'section'  => 'usponsive_site_link_colors',
        'settings' => 'usponsive_dark_links_main',
        'type'     => 'checkbox',
        'priority' => 27,
    )
);

// Right Column (dark links).
$wp_customize->add_setting(
    'usponsive_dark_links_rightcol',
    array(
        'default'           => false,
        'sanitize_callback' => 'usponsive_sanitize_checkbox',
    )
);

$wp_customize->add_control(
    'usponsive_dark_links_rightcol_control',
    array(
        'label'    => __( 'Apply Dark Link Colors to Right Column', 'usponsive-theme' ),
        'section'  => 'usponsive_site_link_colors',
        'settings' => 'usponsive_dark_links_rightcol',
        'type'     => 'checkbox',
        'priority' => 28,
    )
);

// Meta Footer (dark links).
$wp_customize->add_setting(
    'usponsive_dark_links_metafooter',
    array(
        'default'           => false,
        'sanitize_callback' => 'usponsive_sanitize_checkbox',
    )
);

$wp_customize->add_control(
    'usponsive_dark_links_metafooter_control',
    array(
        'label'    => __( 'Apply Dark Link Colors to Meta Footer', 'usponsive-theme' ),
        'section'  => 'usponsive_site_link_colors',
        'settings' => 'usponsive_dark_links_metafooter',
        'type'     => 'checkbox',
        'priority' => 29,
    )
);

// Footer (dark links).
$wp_customize->add_setting(
    'usponsive_dark_links_footer',
    array(
        'default'           => false,
        'sanitize_callback' => 'usponsive_sanitize_checkbox',
    )
);

$wp_customize->add_control(
    'usponsive_dark_links_footer_control',
    array(
        'label'    => __( 'Apply Dark Link Colors to Footer', 'usponsive-theme' ),
        'section'  => 'usponsive_site_link_colors',
        'settings' => 'usponsive_dark_links_footer',
        'type'     => 'checkbox',
        'priority' => 30,
    )
);

// Sub Footer (dark links).
$wp_customize->add_setting(
    'usponsive_dark_links_subfooter',
    array(
        'default'           => false,
        'sanitize_callback' => 'usponsive_sanitize_checkbox',
    )
);

$wp_customize->add_control(
    'usponsive_dark_links_subfooter_control',
    array(
        'label'    => __( 'Apply Dark Link Colors to Sub Footer', 'usponsive-theme' ),
        'section'  => 'usponsive_site_link_colors',
        'settings' => 'usponsive_dark_links_subfooter',
        'type'     => 'checkbox',
        'priority' => 31,
    )
);


}
add_action( 'customize_register', 'usponsive_header_image_customize_register' );

// Page background color CSS
function usponsive_page_background_color_css() {
    // Get the saved value or default.
    $color = get_theme_mod( 'page_background_color', '#ccc' );

    if ( ! $color ) {
        return;
    }
    ?>
    <style id="usponsive-page-background-color-css">
        html, body, #pagecontainer {
            background-color: <?php echo esc_html( $color ); ?>;
        }
    </style>
    <?php
}
add_action( 'wp_head', 'usponsive_page_background_color_css' );

// Top bar dynamic styles
function usponsive_topbar_dynamic_styles() {
    $default_bg  = '#0D1B1E';
    $default_txt = '#ffffff';

    $bg  = get_theme_mod( 'usponsive_topbar_bg_color', $default_bg );
    $txt = get_theme_mod( 'usponsive_topbar_text_color', $default_txt );

    // If the user has NOT changed anything, do nothing
    if ( $bg === $default_bg && $txt === $default_txt ) {
        return;
    }

    echo '<style type="text/css">';

    if ( $bg !== $default_bg ) {
        echo '#topbar { background-color: ' . esc_attr( $bg ) . '; }';
    }

    if ( $txt !== $default_txt ) {
        echo '#topbar, #topbar a { color: ' . esc_attr( $txt ) . '; }';
    }

    echo '</style>';
}
add_action( 'wp_head', 'usponsive_topbar_dynamic_styles' );

// Header dynamic styles
function usponsive_header_dynamic_styles() {
    $default_bg  = '#003F52';
    $default_txt = '#ffffff';

    $bg  = get_theme_mod( 'usponsive_header_bg_color', $default_bg );
    $txt = get_theme_mod( 'usponsive_header_text_color', $default_txt );

    // If user has not changed anything, don't output extra CSS.
    if ( $bg === $default_bg && $txt === $default_txt ) {
        return;
    }

    echo '<style type="text/css">';

    if ( $bg !== $default_bg ) {
        echo '#header { background-color: ' . esc_attr( $bg ) . '; }';
    }

    if ( $txt !== $default_txt ) {
        // Apply to header and links inside header.
        echo '#header, #header a, .site-tagline, .site-tagline a { color: ' . esc_attr( $txt ) . '; }';
    }

    echo '</style>';
}
add_action( 'wp_head', 'usponsive_header_dynamic_styles' );

// Navigation Row dynamic styles
function usponsive_navrow_dynamic_styles() {
    $default_bg        = '#01607E';
    $default_txt       = '#ffffff';   // new default for nav text color
    $default_hover_bg  = '#eda';
    $default_hover_txt = '#333333';

    $bg        = get_theme_mod( 'usponsive_navrow_bg_color', $default_bg );
    $txt       = get_theme_mod( 'usponsive_navrow_text_color', $default_txt );
    $hover_bg  = get_theme_mod( 'usponsive_navrow_hover_bg_color', $default_hover_bg );
    $hover_txt = get_theme_mod( 'usponsive_navrow_hover_text_color', $default_hover_txt );

    // Do nothing if all defaults match
    if (
        $bg === $default_bg &&
        $txt === $default_txt &&
        $hover_bg === $default_hover_bg &&
        $hover_txt === $default_hover_txt
    ) {
        return;
    }

    echo '<style type="text/css">';

    // Base background
    if ( $bg !== $default_bg ) {
        echo '#navrow .menu { background-color: ' . esc_attr( $bg ) . '; }';
    }

    // Base text color
    if ( $txt !== $default_txt ) {
        echo '#navrow .menu a { color: ' . esc_attr( $txt ) . '; }';
    }

    // Hover background
    if ( $hover_bg !== $default_hover_bg ) {
        echo '#collapse a:hover,
              #navrow .menu li:hover,
              #navrow .menu li.hover {
                  background-color: ' . esc_attr( $hover_bg ) . ';
              }';
    }

    // Hover text color
    if ( $hover_txt !== $default_hover_txt ) {
        echo '#navrow .menu a:hover,
              #navrow .menu a:active {
                  color: ' . esc_attr( $hover_txt ) . ';
              }';
    }

    echo '</style>';
}
add_action( 'wp_head', 'usponsive_navrow_dynamic_styles' );

// Left Column dynamic styles
function usponsive_leftcol_dynamic_styles() {
    $default_bg  = '#eeeeee';
    $default_txt = '#333333';

    $bg  = get_theme_mod( 'usponsive_leftcol_bg_color', $default_bg );
    $txt = get_theme_mod( 'usponsive_leftcol_text_color', $default_txt );

    // If default values, output nothing.
    if ( $bg === $default_bg && $txt === $default_txt ) {
        return;
    }

    echo '<style type="text/css">';

    // Background override.
    if ( $bg !== $default_bg ) {
        echo '#page-content, #leftcol { background-color: ' . esc_attr( $bg ) . '; }';
    }

    // Text color override.
    if ( $txt !== $default_txt ) {
        echo '#page-content, #page-content a, #leftcol, #leftcol a { color: ' . esc_attr( $txt ) . '; }';
    }

    echo '</style>';
}
add_action( 'wp_head', 'usponsive_leftcol_dynamic_styles' );

function usponsive_mainarea_dynamic_styles() {
    $default_bg  = '#ffffff';
    $default_txt = '#333333';

    $bg  = get_theme_mod( 'usponsive_mainarea_bg_color', $default_bg );
    $txt = get_theme_mod( 'usponsive_mainarea_text_color', $default_txt );

    // If both are defaults, output nothing.
    if ( $bg === $default_bg && $txt === $default_txt ) {
        return;
    }

    echo '<style type="text/css">';

    /* Background override for main containers */
    if ( $bg !== $default_bg ) {
        echo '#primary, #secondary, #main { background-color: ' . esc_attr( $bg ) . '; }';
    }

    /* Text color override ONLY for #main */
    if ( $txt !== $default_txt ) {
        echo '#main, #main a { color: ' . esc_attr( $txt ) . '; }';
    }

    echo '</style>';
}
add_action( 'wp_head', 'usponsive_mainarea_dynamic_styles' );

function usponsive_rightcol_dynamic_styles() {
    $default_bg  = '#dddddd'; // #ddd
    $default_txt = '#333333';

    $bg  = get_theme_mod( 'usponsive_rightcol_bg_color', $default_bg );
    $txt = get_theme_mod( 'usponsive_rightcol_text_color', $default_txt );

    // If nothing changed, output nothing.
    if ( $bg === $default_bg && $txt === $default_txt ) {
        return;
    }

    echo '<style type="text/css">';

    /* Background override for right column containers */
    if ( $bg !== $default_bg ) {
        echo '#content, #rightcol { background-color: ' . esc_attr( $bg ) . '; }';
    }

    /* Text color override ONLY for #rightcol */
    if ( $txt !== $default_txt ) {
        echo '#rightcol, #rightcol a { color: ' . esc_attr( $txt ) . '; }';
    }

    echo '</style>';
}
add_action( 'wp_head', 'usponsive_rightcol_dynamic_styles' );

// Meta Footer dynamic styles
function usponsive_metafooter_dynamic_styles() {
    $default_bg  = '#333333';
    $default_txt = '#ffffff';

    $bg  = get_theme_mod( 'usponsive_metafooter_bg_color', $default_bg );
    $txt = get_theme_mod( 'usponsive_metafooter_text_color', $default_txt );

    if ( $bg === $default_bg && $txt === $default_txt ) {
        return;
    }

    echo '<style type="text/css">';

    if ( $bg !== $default_bg ) {
        echo '#metafooter { background-color: ' . esc_attr( $bg ) . '; }';
    }

    if ( $txt !== $default_txt ) {
        echo '#metafooter, #metafooter a { color: ' . esc_attr( $txt ) . '; }';
    }

    echo '</style>';
}
add_action( 'wp_head', 'usponsive_metafooter_dynamic_styles' );

// Footer dynamic styles
function usponsive_footer_dynamic_styles() {
    $default_bg  = '#000000';
    $default_txt = '#ffffff';

    $bg  = get_theme_mod( 'usponsive_footer_bg_color', $default_bg );
    $txt = get_theme_mod( 'usponsive_footer_text_color', $default_txt );

    if ( $bg === $default_bg && $txt === $default_txt ) {
        return;
    }

    echo '<style type="text/css">';

    if ( $bg !== $default_bg ) {
        echo '#footer { background-color: ' . esc_attr( $bg ) . '; }';
    }

    if ( $txt !== $default_txt ) {
        echo '#footer, #footer a { color: ' . esc_attr( $txt ) . '; }';
    }

    echo '</style>';
}
add_action( 'wp_head', 'usponsive_footer_dynamic_styles' );

// Sub Footer dynamic styles
function usponsive_subfooter_dynamic_styles() {
    $default_bg  = '#cccccc';
    $default_txt = '#404040';

    $bg  = get_theme_mod( 'usponsive_subfooter_bg_color', $default_bg );
    $txt = get_theme_mod( 'usponsive_subfooter_text_color', $default_txt );

    if ( $bg === $default_bg && $txt === $default_txt ) {
        return;
    }

    echo '<style type="text/css">';

    if ( $bg !== $default_bg ) {
        echo '#subfooter { background-color: ' . esc_attr( $bg ) . '; }';
    }

    if ( $txt !== $default_txt ) {
        echo '#subfooter, #subfooter a { color: ' . esc_attr( $txt ) . '; }';
    }

    echo '</style>';
}
add_action( 'wp_head', 'usponsive_subfooter_dynamic_styles' );

// Site Link Colors dynamic styles
function usponsive_site_link_colors_styles() {
    // Global link color presets.
    $light_link       = get_theme_mod( 'usponsive_light_bg_links_color', '#0066cc' );
    $light_link_hover = get_theme_mod( 'usponsive_light_bg_links_hover_color', '#004999' );
    $dark_link        = get_theme_mod( 'usponsive_dark_bg_links_color', '#ffffff' );
    $dark_link_hover  = get_theme_mod( 'usponsive_dark_bg_links_hover_color', '#cccccc' );

    // Region assignments for light scheme.
    $light_topbar     = get_theme_mod( 'usponsive_light_links_topbar', false );
    $light_header     = get_theme_mod( 'usponsive_light_links_header', false );
    $light_leftcol    = get_theme_mod( 'usponsive_light_links_leftcol', false );
    $light_main       = get_theme_mod( 'usponsive_light_links_main', false );
    $light_rightcol   = get_theme_mod( 'usponsive_light_links_rightcol', false );
    $light_metafooter = get_theme_mod( 'usponsive_light_links_metafooter', false );
    $light_footer     = get_theme_mod( 'usponsive_light_links_footer', false );
    $light_subfooter  = get_theme_mod( 'usponsive_light_links_subfooter', false );

    // Region assignments for dark scheme.
    $dark_topbar      = get_theme_mod( 'usponsive_dark_links_topbar', false );
    $dark_header      = get_theme_mod( 'usponsive_dark_links_header', false );
    $dark_leftcol     = get_theme_mod( 'usponsive_dark_links_leftcol', false );
    $dark_main        = get_theme_mod( 'usponsive_dark_links_main', false );
    $dark_rightcol    = get_theme_mod( 'usponsive_dark_links_rightcol', false );
    $dark_metafooter  = get_theme_mod( 'usponsive_dark_links_metafooter', false );
    $dark_footer      = get_theme_mod( 'usponsive_dark_links_footer', false );
    $dark_subfooter   = get_theme_mod( 'usponsive_dark_links_subfooter', false );

    $css = '';

    // Helper closures to keep things tidy.
    $build_link_rules = function( $selector, $color, $hover_color ) {
        $selector      = trim( $selector );
        $rules  = $selector . ' a { color: ' . esc_attr( $color ) . '; }';
        $rules .= $selector . ' a:hover, '
               .  $selector . ' a:focus, '
               .  $selector . ' a:active { color: ' . esc_attr( $hover_color ) . '; }';
        return $rules;
    };

    // LIGHT scheme regions.
    if ( $light_topbar ) {
        $css .= $build_link_rules( '#topbar', $light_link, $light_link_hover );
    }

    if ( $light_header ) {
        $css .= $build_link_rules( '#header', $light_link, $light_link_hover );
    }

    if ( $light_leftcol ) {
        // Left column region (page-content + leftcol).
        $css .= $build_link_rules( '#leftcol', $light_link, $light_link_hover );
    }

    if ( $light_main ) {
        // Main area (#main only – matches your text color scope).
        $css .= $build_link_rules( '#main', $light_link, $light_link_hover );
    }

    if ( $light_rightcol ) {
        // Right column (#rightcol only – matches your text color scope).
        $css .= $build_link_rules( '#rightcol', $light_link, $light_link_hover );
    }

    if ( $light_metafooter ) {
        $css .= $build_link_rules( '#metafooter', $light_link, $light_link_hover );
    }

    if ( $light_footer ) {
        $css .= $build_link_rules( '#footer', $light_link, $light_link_hover );
    }

    if ( $light_subfooter ) {
        $css .= $build_link_rules( '#subfooter', $light_link, $light_link_hover );
    }

    // DARK scheme regions.
    // Note: printed AFTER light scheme, so dark settings win if both are checked.
    if ( $dark_topbar ) {
        $css .= $build_link_rules( '#topbar', $dark_link, $dark_link_hover );
    }

    if ( $dark_header ) {
        $css .= $build_link_rules( '#header', $dark_link, $dark_link_hover );
    }

    if ( $dark_leftcol ) {
        $css .= $build_link_rules( '#leftcol', $dark_link, $dark_link_hover );
    }

    if ( $dark_main ) {
        $css .= $build_link_rules( '#main', $dark_link, $dark_link_hover );
    }

    if ( $dark_rightcol ) {
        $css .= $build_link_rules( '#rightcol', $dark_link, $dark_link_hover );
    }

    if ( $dark_metafooter ) {
        $css .= $build_link_rules( '#metafooter', $dark_link, $dark_link_hover );
    }

    if ( $dark_footer ) {
        $css .= $build_link_rules( '#footer', $dark_link, $dark_link_hover );
    }

    if ( $dark_subfooter ) {
        $css .= $build_link_rules( '#subfooter', $dark_link, $dark_link_hover );
    }

    // If nothing selected, don't output anything.
    if ( empty( $css ) ) {
        return;
    }

    echo '<style type="text/css" id="usponsive-site-link-colors">' . $css . '</style>';
}
add_action( 'wp_head', 'usponsive_site_link_colors_styles', 25 );


?>