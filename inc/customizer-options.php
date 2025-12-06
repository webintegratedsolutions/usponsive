<?php
/**
 * Customizer: header image width & margin controls, and page layout regions
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
            'default'           => '#ffffff',
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
                'label'    => __( 'Page Background Color', 'usponsive' ),
                'section'  => 'colors', // Use existing "Colors" section.
                'settings' => 'page_background_color',
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
            'label'    => __( 'Top Bar Background Color', 'usponsive-theme' ),
            'section'  => 'colors',
            'settings' => 'usponsive_topbar_bg_color',
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
            'label'    => __( 'Header Background Color', 'usponsive-theme' ),
            'section'  => 'colors',
            'settings' => 'usponsive_header_bg_color',
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
        )
    )
);

}
add_action( 'customize_register', 'usponsive_header_image_customize_register' );

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

// functions.php (or an included file)

function usponsive_page_background_color_css() {
    // Get the saved value or default.
    $color = get_theme_mod( 'page_background_color', '#ffffff' );

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

?>