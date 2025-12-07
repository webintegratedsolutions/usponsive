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


function usponsive_general_customize_register( $wp_customize ) {

	// -----------------------------
// TOP BAR SETTINGS
// -----------------------------
$wp_customize->add_section(
    'usponsive_topbar_settings',
    array(
        'title'       => __( 'Top Bar Settings', 'usponsive-theme' ),
        'priority'    => 32,
        'description' => __( 'Control top bar alignment and text content.', 'usponsive-theme' ),
    )
);

// Top Bar text alignment.
$wp_customize->add_setting(
    'usponsive_topbar_text_align',
    array(
        'default'           => 'right',
        'sanitize_callback' => function( $value ) {
            $allowed = array( 'left', 'center', 'right' );
            return in_array( $value, $allowed, true ) ? $value : 'right';
        },
    )
);

// Top Bar text alignment control.
$wp_customize->add_control(
    'usponsive_topbar_text_align_control',
    array(
        'label'    => __( 'Top Bar Text Alignment', 'usponsive-theme' ),
        'section'  => 'usponsive_topbar_settings',
        'settings' => 'usponsive_topbar_text_align',
        'type'     => 'radio',
        'priority' => 10,
        'choices'  => array(
            'left'   => __( 'Left Align', 'usponsive-theme' ),
            'center' => __( 'Center Align', 'usponsive-theme' ),
            'right'  => __( 'Right Align', 'usponsive-theme' ),
        ),
    )
);

// Top Bar text content (HTML allowed).
$wp_customize->add_setting(
    'usponsive_topbar_text',
    array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post', // allow HTML
    )
);

// Top Bar text content control.
$wp_customize->add_control(
    'usponsive_topbar_text_control',
    array(
        'label'       => __( 'Top Bar Text', 'usponsive-theme' ),
        'description' => __( 'Accepts plain text or HTML.', 'usponsive-theme' ),
        'section'     => 'usponsive_topbar_settings',
        'settings'    => 'usponsive_topbar_text',
        'type'        => 'textarea',
        'priority'    => 20,
    )
);


	// -----------------------------
// SITE LINK COLORS SECTION
// -----------------------------
$wp_customize->add_section(
    'usponsive_site_link_colors',
    array(
        'title'       => __( 'Site Link Colors', 'usponsive-theme' ),
        'priority'    => 40, // Adjust as needed in the left panel
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
			'priority'    => 36,
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
			'label'    => __( 'Top Bar', 'usponsive-theme' ),
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
			'label'    => __( 'Header Region', 'usponsive-theme' ),
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
			'label'    => __( 'Navigation Row', 'usponsive-theme' ),
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
			'label'    => __( 'Meta Row (Homepage Template)', 'usponsive-theme' ),
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
			'label'    => __( 'Left Column', 'usponsive-theme' ),
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
			'label'    => __( 'Right Column (Sidebar)', 'usponsive-theme' ),
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
			'label'    => __( 'Meta Footer Region', 'usponsive-theme' ),
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
			'label'    => __( 'Footer Region', 'usponsive-theme' ),
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
			'label'    => __( 'Sub Footer Region', 'usponsive-theme' ),
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

// -----------------------------
// META ROW SETTINGS SECTION
// -----------------------------
$wp_customize->add_section(
    'usponsive_meta_row_settings',
    array(
        'title'       => __( 'Meta Row Settings', 'usponsive-theme' ),
        'priority'    => 45, // sits nicely after layout / header sections
        'description' => __( 'Configure the Meta Row content and appearance on the homepage.', 'usponsive-theme' ),
    )
);

// Meta Row layout: one / two columns.
$wp_customize->add_setting(
    'usponsive_metarow_layout',
    array(
        'default'           => 'one-column',
        'sanitize_callback' => function( $value ) {
            $allowed = array( 'one-column', 'two-image-left', 'two-image-right' );
            return in_array( $value, $allowed, true ) ? $value : 'one-column';
        },
    )
);

$wp_customize->add_control(
    'usponsive_metarow_layout_control',
    array(
        'label'       => __( 'Meta Row Layout', 'usponsive-theme' ),
        'description' => __( 'Choose how the Meta Row content is laid out.', 'usponsive-theme' ),
        'section'     => 'usponsive_meta_row_settings',
        'settings'    => 'usponsive_metarow_layout',
        'type'        => 'select',
        'priority'    => 10,
        'choices'     => array(
            'one-column'     => __( 'One Column (full width)', 'usponsive-theme' ),
            'two-image-left' => __( 'Two Columns – Image Left, Text Right', 'usponsive-theme' ),
            'two-image-right'=> __( 'Two Columns – Text Left, Image Right', 'usponsive-theme' ),
        ),
    )
);

// Meta Row image.
$wp_customize->add_setting(
    'usponsive_metarow_image',
    array(
        'default'           => 0,
        'sanitize_callback' => 'absint',
    )
);

$wp_customize->add_control(
    new WP_Customize_Media_Control(
        $wp_customize,
        'usponsive_metarow_image_control',
        array(
            'label'       => __( 'Meta Row Image', 'usponsive-theme' ),
            'description' => __( 'Shown in one of the columns for two-column layouts. If empty, layout falls back to one column.', 'usponsive-theme' ),
            'section'     => 'usponsive_meta_row_settings',
            'settings'    => 'usponsive_metarow_image',
            'mime_type'   => 'image',
            'priority'    => 20,
        )
    )
);

// Meta Row text content.
$wp_customize->add_setting(
    'usponsive_metarow_text',
    array(
        'default'           => 'Metarow Area',
        'sanitize_callback' => 'wp_kses_post',
    )
);

$wp_customize->add_control(
    'usponsive_metarow_text_control',
    array(
        'label'       => __( 'Meta Row Text', 'usponsive-theme' ),
        'description' => __( 'Text or HTML content displayed inside the Meta Row.', 'usponsive-theme' ),
        'section'     => 'usponsive_meta_row_settings',
        'settings'    => 'usponsive_metarow_text',
        'type'        => 'textarea',
        'priority'    => 30,
    )
);

// Meta Row background color (self-contained, not in Site Region Colors).
$wp_customize->add_setting(
    'usponsive_metarow_bg_color',
    array(
        'default'           => '#333333',
        'sanitize_callback' => 'sanitize_hex_color',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'usponsive_metarow_bg_color_control',
        array(
            'label'    => __( 'Meta Row Background Color', 'usponsive-theme' ),
            'section'  => 'usponsive_meta_row_settings',
            'settings' => 'usponsive_metarow_bg_color',
            'priority' => 40,
        )
    )
);

// Meta Row text color.
$wp_customize->add_setting(
    'usponsive_metarow_text_color',
    array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'usponsive_metarow_text_color_control',
        array(
            'label'    => __( 'Meta Row Text Color', 'usponsive-theme' ),
            'section'  => 'usponsive_meta_row_settings',
            'settings' => 'usponsive_metarow_text_color',
            'priority' => 41,
        )
    )
);

// Meta Row two-column split (image column width).
$wp_customize->add_setting(
    'usponsive_metarow_column_ratio',
    array(
        'default'           => 50,      // 50/50 split by default
        'sanitize_callback' => 'absint',
    )
);

$wp_customize->add_control(
    'usponsive_metarow_column_ratio_control',
    array(
        'label'       => __( 'Two-Column Split (%)', 'usponsive-theme' ),
        'description' => __( 'Controls the width of the image column in two-column layouts. The text column uses the remaining width.', 'usponsive-theme' ),
        'section'     => 'usponsive_meta_row_settings',
        'settings'    => 'usponsive_metarow_column_ratio',
        'type'        => 'range',
        'priority'    => 25, // place between image and text controls
        'input_attrs' => array(
            'min'  => 30,
            'max'  => 70,
            'step' => 1,
        ),
    )
);

// Meta Row text size preset.
$wp_customize->add_setting(
    'usponsive_metarow_text_size',
    array(
        'default'           => 'medium',
        'sanitize_callback' => function( $value ) {
            $allowed = array( 'x-small', 'small', 'medium', 'large', 'x-large' );
            return in_array( $value, $allowed, true ) ? $value : 'medium';
        },
    )
);

$wp_customize->add_control(
    'usponsive_metarow_text_size_control',
    array(
        'label'       => __( 'Meta Row Text Size', 'usponsive-theme' ),
        'section'     => 'usponsive_meta_row_settings',
        'settings'    => 'usponsive_metarow_text_size',
        'type'        => 'select',
        'priority'    => 50,
        'choices'     => array(
            'x-small' => __( 'Extra Small', 'usponsive-theme' ),
            'small'   => __( 'Small', 'usponsive-theme' ),
            'medium'  => __( 'Medium', 'usponsive-theme' ),
            'large'   => __( 'Large', 'usponsive-theme' ),
            'x-large' => __( 'Extra Large', 'usponsive-theme' ),
        ),
    )
);

// Meta Row text bold.
$wp_customize->add_setting(
    'usponsive_metarow_text_bold',
    array(
        'default'           => false,
        'sanitize_callback' => function( $checked ) {
            return ( isset( $checked ) && true == $checked );
        },
    )
);

$wp_customize->add_control(
    'usponsive_metarow_text_bold_control',
    array(
        'label'    => __( 'Bold Meta Row Text', 'usponsive-theme' ),
        'section'  => 'usponsive_meta_row_settings',
        'settings' => 'usponsive_metarow_text_bold',
        'type'     => 'checkbox',
        'priority' => 51,
    )
);

// Meta Row text italic.
$wp_customize->add_setting(
    'usponsive_metarow_text_italic',
    array(
        'default'           => false,
        'sanitize_callback' => function( $checked ) {
            return ( isset( $checked ) && true == $checked );
        },
    )
);

$wp_customize->add_control(
    'usponsive_metarow_text_italic_control',
    array(
        'label'    => __( 'Italic Meta Row Text', 'usponsive-theme' ),
        'section'  => 'usponsive_meta_row_settings',
        'settings' => 'usponsive_metarow_text_italic',
        'type'     => 'checkbox',
        'priority' => 52,
    )
);

// -----------------------------
// PAGE LAYOUT WIDTH
// -----------------------------
$wp_customize->add_setting(
    'usponsive_page_layout_width',
    array(
        'default'           => 100, // 100% default
        'sanitize_callback' => 'absint',
    )
);

$wp_customize->add_control(
    'usponsive_page_layout_width_control',
    array(
        'label'       => __( 'Page Layout Width (%)', 'usponsive-theme' ),
        'description' => __( 'Adjust the width of the page content and subfooter regions (90%–100%).', 'usponsive-theme' ),
        'section'     => 'usponsive_layout_regions', // Or create a new section if you prefer
        'settings'    => 'usponsive_page_layout_width',
        'type'        => 'range',
        'priority'    => 1,
        'input_attrs' => array(
            'min'  => 90,
            'max'  => 100,
            'step' => 1,
        ),
    )
);

// -----------------------------
// SITE FONTS SECTION
// -----------------------------
$wp_customize->add_section(
    'usponsive_site_fonts',
    array(
        'title'       => __( 'Site Fonts', 'usponsive-theme' ),
        'priority'    => 50,
        'description' => __( 'Choose primary, secondary, and alternative fonts and assign them to site regions.', 'usponsive-theme' ),
    )
);

// Available font choices.
$usponsive_font_choices = array(
    'inherit'                                        => __( 'Theme Default (inherit)', 'usponsive-theme' ),
    'Arial, Helvetica, sans-serif'                  => 'Arial',
    '"Times New Roman", Times, serif'               => 'Times New Roman',
    '"Courier New", Courier, monospace'             => 'Courier New',
    'Georgia, "Times New Roman", Times, serif'      => 'Georgia',
    'Verdana, Geneva, sans-serif'                   => 'Verdana',
    'Tahoma, Geneva, sans-serif'                    => 'Tahoma',
    'Calibri, Candara, "Segoe UI", Segoe, Optima, Arial, sans-serif' => 'Calibri',
);

// Shared region labels for font + heading controls.
$usponsive_font_regions = array(
    'topbar'     => __( 'Top Bar', 'usponsive-theme' ),
    'header'     => __( 'Header', 'usponsive-theme' ),
    'navrow'     => __( 'Navigation Row', 'usponsive-theme' ),
    'metarow'    => __( 'Meta Row', 'usponsive-theme' ),
    'leftcol'    => __( 'Left Column', 'usponsive-theme' ),
    'main'       => __( 'Main Area', 'usponsive-theme' ),
    'rightcol'   => __( 'Right Column', 'usponsive-theme' ),
    'metafooter' => __( 'Meta Footer', 'usponsive-theme' ),
    'footer'     => __( 'Footer', 'usponsive-theme' ),
    'subfooter'  => __( 'Sub Footer', 'usponsive-theme' ),
);

// Primary Font
$wp_customize->add_setting(
    'usponsive_primary_font_family',
    array(
        'default'           => 'inherit',
        'sanitize_callback' => 'sanitize_text_field',
    )
);

$wp_customize->add_control(
    'usponsive_primary_font_family_control',
    array(
        'label'    => __( 'Primary Font', 'usponsive-theme' ),
        'section'  => 'usponsive_site_fonts',
        'settings' => 'usponsive_primary_font_family',
        'type'     => 'select',
        'priority' => 10,
        'choices'  => $usponsive_font_choices,
    )
);

// Secondary Font
$wp_customize->add_setting(
    'usponsive_secondary_font_family',
    array(
        'default'           => 'inherit',
        'sanitize_callback' => 'sanitize_text_field',
    )
);

$wp_customize->add_control(
    'usponsive_secondary_font_family_control',
    array(
        'label'    => __( 'Secondary Font', 'usponsive-theme' ),
        'section'  => 'usponsive_site_fonts',
        'settings' => 'usponsive_secondary_font_family',
        'type'     => 'select',
        'priority' => 30,
        'choices'  => $usponsive_font_choices,
    )
);

// Alternative Font
$wp_customize->add_setting(
    'usponsive_alternative_font_family',
    array(
        'default'           => 'inherit',
        'sanitize_callback' => 'sanitize_text_field',
    )
);

$wp_customize->add_control(
    'usponsive_alternative_font_family_control',
    array(
        'label'    => __( 'Alternative Font', 'usponsive-theme' ),
        'section'  => 'usponsive_site_fonts',
        'settings' => 'usponsive_alternative_font_family',
        'type'     => 'select',
        'priority' => 50,
        'choices'  => $usponsive_font_choices,
    )
);

// -----------------------------
// PRIMARY FONT REGIONS
// -----------------------------

$primary_regions = array(
    'topbar'     => __( 'Top Bar', 'usponsive-theme' ),
    'header'     => __( 'Header', 'usponsive-theme' ),
    'navrow'     => __( 'Navigation Row', 'usponsive-theme' ),
    'metarow'    => __( 'Meta Row', 'usponsive-theme' ),
    'leftcol'    => __( 'Left Column', 'usponsive-theme' ),
    'main'       => __( 'Main Area', 'usponsive-theme' ),
    'rightcol'   => __( 'Right Column', 'usponsive-theme' ),
    'metafooter' => __( 'Meta Footer', 'usponsive-theme' ),
    'footer'     => __( 'Footer', 'usponsive-theme' ),
    'subfooter'  => __( 'Sub Footer', 'usponsive-theme' ),
);

$priority = 11;

foreach ( $primary_regions as $key => $label ) {

    $setting_id = 'usponsive_primary_font_' . $key;

    $wp_customize->add_setting(
        $setting_id,
        array(
            'default'           => false,
            'sanitize_callback' => 'usponsive_sanitize_checkbox',
        )
    );

    $wp_customize->add_control(
        $setting_id . '_control',
        array(
            'label'    => sprintf( __( 'Apply Primary Font to %s', 'usponsive-theme' ), $label ),
            'section'  => 'usponsive_site_fonts',
            'settings' => $setting_id,
            'type'     => 'checkbox',
            'priority' => $priority++,
        )
    );
}

// -----------------------------
// SECONDARY FONT REGIONS
// -----------------------------
$secondary_regions = $primary_regions; // same list

$priority = 31;

foreach ( $secondary_regions as $key => $label ) {

    $setting_id = 'usponsive_secondary_font_' . $key;

    $wp_customize->add_setting(
        $setting_id,
        array(
            'default'           => false,
            'sanitize_callback' => 'usponsive_sanitize_checkbox',
        )
    );

    $wp_customize->add_control(
        $setting_id . '_control',
        array(
            'label'    => sprintf( __( 'Apply Secondary Font to %s', 'usponsive-theme' ), $label ),
            'section'  => 'usponsive_site_fonts',
            'settings' => $setting_id,
            'type'     => 'checkbox',
            'priority' => $priority++,
        )
    );
}

// -----------------------------
// ALTERNATIVE FONT REGIONS
// -----------------------------
$alternative_regions = $primary_regions; // same list

$priority = 51;

foreach ( $alternative_regions as $key => $label ) {

    $setting_id = 'usponsive_alternative_font_' . $key;

    $wp_customize->add_setting(
        $setting_id,
        array(
            'default'           => false,
            'sanitize_callback' => 'usponsive_sanitize_checkbox',
        )
    );

    $wp_customize->add_control(
        $setting_id . '_control',
        array(
            'label'    => sprintf( __( 'Apply Alternative Font to %s', 'usponsive-theme' ), $label ),
            'section'  => 'usponsive_site_fonts',
            'settings' => $setting_id,
            'type'     => 'checkbox',
            'priority' => $priority++,
        )
    );
}

// -----------------------------
// HEADING FONT ASSIGNMENTS
// -----------------------------

// For each region, choose which font group to use for headings.
$heading_priority = 70;

foreach ( $usponsive_font_regions as $key => $label ) {

    $setting_id = 'usponsive_heading_font_choice_' . $key;

    $wp_customize->add_setting(
        $setting_id,
        array(
            'default'           => 'inherit', // inherit region/body font
            'sanitize_callback' => function( $value ) {
                $allowed = array( 'inherit', 'primary', 'secondary', 'alternative' );
                return in_array( $value, $allowed, true ) ? $value : 'inherit';
            },
        )
    );

    $wp_customize->add_control(
        $setting_id . '_control',
        array(
            'label'       => sprintf( __( 'Heading Font for %s', 'usponsive-theme' ), $label ),
            'description' => __( 'Choose which font family to use for H1–H6 in this region.', 'usponsive-theme' ),
            'section'     => 'usponsive_site_fonts',
            'settings'    => $setting_id,
            'type'        => 'select',
            'priority'    => $heading_priority++,
            'choices'     => array(
                'inherit'    => __( 'Inherit region font', 'usponsive-theme' ),
                'primary'    => __( 'Primary Font', 'usponsive-theme' ),
                'secondary'  => __( 'Secondary Font', 'usponsive-theme' ),
                'alternative'=> __( 'Alternative Font', 'usponsive-theme' ),
            ),
        )
    );
}

// -----------------------------
// HEADING SIZE PRESETS PER REGION
// -----------------------------

$heading_size_priority = 90;

foreach ( $usponsive_font_regions as $key => $label ) {

    $setting_id = 'usponsive_heading_size_' . $key;

    $wp_customize->add_setting(
        $setting_id,
        array(
            'default'           => 'normal',
            'sanitize_callback' => function( $value ) {
                $allowed = array( 'small', 'normal', 'large' );
                return in_array( $value, $allowed, true ) ? $value : 'normal';
            },
        )
    );

    $wp_customize->add_control(
        $setting_id . '_control',
        array(
            'label'       => sprintf( __( 'Heading Size for %s', 'usponsive-theme' ), $label ),
            'description' => __( 'Choose overall size scale for H1–H6 in this region.', 'usponsive-theme' ),
            'section'     => 'usponsive_site_fonts',
            'settings'    => $setting_id,
            'type'        => 'select',
            'priority'    => $heading_size_priority++,
            'choices'     => array(
                'small'  => __( 'Small', 'usponsive-theme' ),
                'normal' => __( 'Normal', 'usponsive-theme' ),
                'large'  => __( 'Large', 'usponsive-theme' ),
            ),
        )
    );
}

// -----------------------------------------
// GLOBAL DEFAULT FONT (html, body)
// -----------------------------------------
$wp_customize->add_setting(
    'usponsive_global_font_family',
    array(
        'default'           => 'Arial, Helvetica, sans-serif',
        'sanitize_callback' => 'sanitize_text_field',
    )
);

$wp_customize->add_control(
    'usponsive_global_font_family_control',
    array(
        'label'    => __( 'Global Default Font (html, body)', 'usponsive-theme' ),
        'section'  => 'usponsive_site_fonts',
        'settings' => 'usponsive_global_font_family',
        'type'     => 'select',
        'priority' => 1, // VERY TOP
        'choices'  => array(
            'inherit'                                        => __( 'Theme Default (inherit)', 'usponsive-theme' ),
            'Arial, Helvetica, sans-serif'                  => 'Arial',
            '"Times New Roman", Times, serif'               => 'Times New Roman',
            '"Courier New", Courier, monospace'             => 'Courier New',
            'Georgia, "Times New Roman", Times, serif'      => 'Georgia',
            'Verdana, Geneva, sans-serif'                   => 'Verdana',
            'Tahoma, Geneva, sans-serif'                    => 'Tahoma',
            'Calibri, Candara, "Segoe UI", Segoe, Optima, Arial, sans-serif' => 'Calibri',
        ),
    )
);

// -----------------------------------------
// GLOBAL DEFAULT FONT SIZE
// -----------------------------------------
$wp_customize->add_setting(
    'usponsive_global_font_size',
    array(
        'default'           => '14px',
        'sanitize_callback' => 'sanitize_text_field',
    )
);

$wp_customize->add_control(
    'usponsive_global_font_size_control',
    array(
        'label'       => __( 'Global Font Size (html, body)', 'usponsive-theme' ),
        'description' => __( 'Example: 14px, 16px, 1rem', 'usponsive-theme' ),
        'section'     => 'usponsive_site_fonts',
        'settings'    => 'usponsive_global_font_size',
        'type'        => 'text',
        'priority'    => 2,
    )
);


}
add_action( 'customize_register', 'usponsive_general_customize_register' );

?>