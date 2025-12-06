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

function usponsive_header_image_customize_register( $wp_customize ) {

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
            'label'    => __( 'Navigation Row Hover Text Color', 'usponsive-theme' ),
            'section'  => 'colors',
            'settings' => 'usponsive_navrow_hover_text_color',
            'priority' => 27,
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

// Navigation Row dynamic styles (hover)
function usponsive_navrow_dynamic_styles() {
    $default_bg        = '#01607E';   // nav row background default
    $default_hover_bg  = '#eda';      // hover background default
    $default_hover_txt = '#333333';   // hover text default

    $bg        = get_theme_mod( 'usponsive_navrow_bg_color', $default_bg );
    $hover_bg  = get_theme_mod( 'usponsive_navrow_hover_bg_color', $default_hover_bg );
    $hover_txt = get_theme_mod( 'usponsive_navrow_hover_text_color', $default_hover_txt );

    // If everything is at defaults, don't output extra CSS;
    // your static stylesheet will provide the base styles.
    if ( $bg === $default_bg && $hover_bg === $default_hover_bg && $hover_txt === $default_hover_txt ) {
        return;
    }

    echo '<style type="text/css">';

    // Base nav row background override.
    if ( $bg !== $default_bg ) {
        echo '#navrow .menu { background-color: ' . esc_attr( $bg ) . '; }';
    }

// Hover text & background override.
if ( $hover_bg !== $default_hover_bg || $hover_txt !== $default_hover_txt ) {

    // Hover background applies to LI or broader container.
    if ( $hover_bg !== $default_hover_bg ) {
        echo '#collapse a:hover, 
              #navrow .menu li:hover, 
              #navrow .menu li.hover {
                  background-color: ' . esc_attr( $hover_bg ) . ';
              }';
    }

    // Hover TEXT applies to the <a> tag, not the <li>.
    if ( $hover_txt !== $default_hover_txt ) {
        echo '#navrow .menu a:hover, 
              #navrow .menu a:active {
                  color: ' . esc_attr( $hover_txt ) . ';
              }';
    }
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

?>