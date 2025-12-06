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

	/**
	 * Layout Region Colors (in Colors panel).
	 * Foreground and background for each region.
	 */
	$region_colors = array(
		'topbar' => array(
			'label' => __( 'Top Bar', 'usponsive-theme' ),
		),
		'header_region' => array(
			'label' => __( 'Header Region', 'usponsive-theme' ),
		),
		'navrow' => array(
			'label' => __( 'Navigation Row', 'usponsive-theme' ),
		),
		'metarow' => array(
			'label' => __( 'Meta Row', 'usponsive-theme' ),
		),
		'leftcol' => array(
			'label' => __( 'Left Column', 'usponsive-theme' ),
		),
		'rightcol' => array(
			'label' => __( 'Right Column (Sidebar)', 'usponsive-theme' ),
		),
		'metafooter' => array(
			'label' => __( 'Meta Footer Region', 'usponsive-theme' ),
		),
		'footer_region' => array(
			'label' => __( 'Footer Region', 'usponsive-theme' ),
		),
		'subfooter' => array(
			'label' => __( 'Sub Footer Region', 'usponsive-theme' ),
		),
	);

	foreach ( $region_colors as $slug => $data ) {

		// Background color.
		$wp_customize->add_setting(
			"usponsive_{$slug}_bg_color",
			array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				"usponsive_{$slug}_bg_color_control",
				array(
					'label'   => sprintf( __( '%s Background Color', 'usponsive-theme' ), $data['label'] ),
					'section' => 'colors',
					'settings'=> "usponsive_{$slug}_bg_color",
				)
			)
		);

		// Foreground (text) color.
		$wp_customize->add_setting(
			"usponsive_{$slug}_fg_color",
			array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				"usponsive_{$slug}_fg_color_control",
				array(
					'label'   => sprintf( __( '%s Text Color', 'usponsive-theme' ), $data['label'] ),
					'section' => 'colors',
					'settings'=> "usponsive_{$slug}_fg_color",
				)
			)
		);
	}

	/**
	 * Link color schemes (Light / Dark).
	 * Each has: normal, hover, active, visited.
	 */

	// Light link scheme (for dark backgrounds).
	$link_states = array( 'normal', 'hover', 'active', 'visited' );

	foreach ( $link_states as $state ) {

		$wp_customize->add_setting(
			"usponsive_links_light_{$state}",
			array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				"usponsive_links_light_{$state}_control",
				array(
					/* translators: %s: link state (Normal / Hover / Active / Visited) */
					'label'   => sprintf( __( 'Light Links: %s', 'usponsive-theme' ), ucfirst( $state ) ),
					'section' => 'colors',
					'settings'=> "usponsive_links_light_{$state}",
				)
			)
		);
	}

	// Dark link scheme (for light backgrounds).
	foreach ( $link_states as $state ) {

		$wp_customize->add_setting(
			"usponsive_links_dark_{$state}",
			array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				"usponsive_links_dark_{$state}_control",
				array(
					/* translators: %s: link state (Normal / Hover / Active / Visited) */
					'label'   => sprintf( __( 'Dark Links: %s', 'usponsive-theme' ), ucfirst( $state ) ),
					'section' => 'colors',
					'settings'=> "usponsive_links_dark_{$state}",
				)
			)
		);
	}

}
add_action( 'customize_register', 'usponsive_header_image_customize_register' );

function usponsive_layout_region_colors_styles() {

	// Region → selector mapping.
	$regions = array(
		'topbar'        => '#topbar',
		'header_region' => '#header',
		'navrow'        => '#navrow',
		'metarow'       => '#metarow',
		'leftcol'       => '#leftcol',
		'rightcol'      => '#secondary', // adjust if your sidebar wrapper uses a different ID.
		'metafooter'    => '#metafooter',
		'footer_region' => '#footer',
		'subfooter'     => '#subfooter',
	);

	// Collect CSS rules.
	$css = '';

	foreach ( $regions as $slug => $selector ) {

		$bg = get_theme_mod( "usponsive_{$slug}_bg_color", '' );
		$fg = get_theme_mod( "usponsive_{$slug}_fg_color", '' );

		if ( $bg ) {
			$css .= sprintf(
				'%1$s { background-color: %2$s; }' . "\n",
				$selector,
				esc_html( $bg )
			);
		}

		if ( $fg ) {
			// Apply text color to region and its links.
			$css .= sprintf(
				'%1$s, %1$s a, %1$s a:visited { color: %2$s; }' . "\n",
				$selector,
				esc_html( $fg )
			);
		}
	}

	// Link schemes.
	$link_states = array( 'normal', 'hover', 'active', 'visited' );

	$light = array();
	$dark  = array();

	foreach ( $link_states as $state ) {
		$light[ $state ] = get_theme_mod( "usponsive_links_light_{$state}", '' );
		$dark[ $state ]  = get_theme_mod( "usponsive_links_dark_{$state}", '' );
	}

	// Global "dark links" scheme as default for body (for light backgrounds).
	if ( ! empty( $dark['normal'] ) ) {
		$css .= 'body a:link { color: ' . esc_html( $dark['normal'] ) . "; }\n";
	}
	if ( ! empty( $dark['visited'] ) ) {
		$css .= 'body a:visited { color: ' . esc_html( $dark['visited'] ) . "; }\n";
	}
	if ( ! empty( $dark['hover'] ) ) {
		$css .= 'body a:hover { color: ' . esc_html( $dark['hover'] ) . "; }\n";
	}
	if ( ! empty( $dark['active'] ) ) {
		$css .= 'body a:active { color: ' . esc_html( $dark['active'] ) . "; }\n";
	}

	// Light link scheme: apply where you add the class "link-scheme-light" on a container.
	if ( ! empty( $light['normal'] ) ) {
		$css .= '.link-scheme-light a:link { color: ' . esc_html( $light['normal'] ) . "; }\n";
	}
	if ( ! empty( $light['visited'] ) ) {
		$css .= '.link-scheme-light a:visited { color: ' . esc_html( $light['visited'] ) . "; }\n";
	}
	if ( ! empty( $light['hover'] ) ) {
		$css .= '.link-scheme-light a:hover { color: ' . esc_html( $light['hover'] ) . "; }\n";
	}
	if ( ! empty( $light['active'] ) ) {
		$css .= '.link-scheme-light a:active { color: ' . esc_html( $light['active'] ) . "; }\n";
	}

	if ( ! $css ) {
		return;
	}
	?>
	<style>
	<?php echo $css; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</style>
	<?php
}
add_action( 'wp_head', 'usponsive_layout_region_colors_styles' );

?>