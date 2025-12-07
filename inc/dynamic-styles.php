<?php

// Merge Header Image & Tagline Settings into WP Default Section
function usponsive_merge_header_image_sections( $wp_customize ) {

    // Rename WP default section.
    if ( $wp_customize->get_section( 'header_image' ) ) {
        $wp_customize->get_section( 'header_image' )->title = __( 'Header Image & Tagline Settings', 'usponsive-theme' );
        $wp_customize->get_section( 'header_image' )->priority = 35;
    }

    // Move all your custom controls from your section into the WP one.
    $controls = array(
        'usponsive_header_image_width_control',
        'usponsive_header_image_margin_control',
        'usponsive_tagline_font_size_preset_control',
        'usponsive_tagline_bold_control',
        'usponsive_tagline_italic_control',
        'usponsive_tagline_margin_control',
        'usponsive_tagline_text_align_control',
    );

    foreach ( $controls as $control_id ) {
        if ( $wp_customize->get_control( $control_id ) ) {
            $wp_customize->get_control( $control_id )->section = 'header_image';
        }
    }

    // Remove your old section.
    if ( $wp_customize->get_section( 'usponsive_header_image_settings' ) ) {
        $wp_customize->remove_section( 'usponsive_header_image_settings' );
    }
}
add_action( 'customize_register', 'usponsive_merge_header_image_sections', 50 );

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

// Meta Row two-column layout ratio styles
function usponsive_metarow_column_ratio_styles() {
    // Get the slider value; default 50.
    $ratio = get_theme_mod( 'usponsive_metarow_column_ratio', 50 );
    $ratio = (int) $ratio;

    // Clamp into 30–70 for safety.
    if ( $ratio < 30 ) {
        $ratio = 30;
    } elseif ( $ratio > 70 ) {
        $ratio = 70;
    }

    // NEW: ratio now applies to TEXT column.
    $text_ratio  = $ratio;
    $image_ratio = 100 - $text_ratio;
    ?>
    <style type="text/css" id="usponsive-metarow-column-ratio">

        /* Reverse logic: text width = slider value, image width = remainder */

        /* Image-left layout */
        .metarow-layout-two-image-left .metarow-col-image {
            width: <?php echo esc_attr( $image_ratio ); ?>%;
        }
        .metarow-layout-two-image-left .metarow-col-text {
            width: <?php echo esc_attr( $text_ratio ); ?>%;
        }

        /* Image-right layout */
        .metarow-layout-two-image-right .metarow-col-image {
            width: <?php echo esc_attr( $image_ratio ); ?>%;
        }
        .metarow-layout-two-image-right .metarow-col-text {
            width: <?php echo esc_attr( $text_ratio ); ?>%;
        }

        /* Same responsive behavior at ≤640px */
        @media (max-width: 640px) {
            .metarow-layout-two-image-left .metarow-col-image,
            .metarow-layout-two-image-left .metarow-col-text,
            .metarow-layout-two-image-right .metarow-col-image,
            .metarow-layout-two-image-right .metarow-col-text {
                width: 100%;
            }
        }
    </style>
    <?php
}
add_action( 'wp_head', 'usponsive_metarow_column_ratio_styles' );

// Meta Row text typography styles
function usponsive_metarow_text_typography_styles() {

    $size   = get_theme_mod( 'usponsive_metarow_text_size', 'medium' );
    $bold   = get_theme_mod( 'usponsive_metarow_text_bold', false );
    $italic = get_theme_mod( 'usponsive_metarow_text_italic', false );

    // Convert size preset to actual CSS values.
    $size_map = array(
        'x-small' => '0.75rem',
        'small'   => '0.875rem',
        'medium'  => '1rem',
        'large'   => '1.25rem',
        'x-large' => '1.5rem',
    );

    $font_size = isset( $size_map[ $size ] ) ? $size_map[ $size ] : '1rem';
    ?>
    <style id="usponsive-metarow-text-typography">

        /* Apply to BOTH containers */
        #metarow .metarow-text,
        #metarow .metarow-col-text {
            font-size: <?php echo esc_attr( $font_size ); ?>;
            <?php if ( $bold ) : ?>
                font-weight: bold;
            <?php endif; ?>
            <?php if ( $italic ) : ?>
                font-style: italic;
            <?php endif; ?>
        }

    </style>
    <?php
}
add_action( 'wp_head', 'usponsive_metarow_text_typography_styles' );

// Page Layout Width styles
function usponsive_page_layout_width_styles() {

    $width = get_theme_mod( 'usponsive_page_layout_width', 100 );
    $width = (int) $width;

    // Clamp to 90–100 for safety
    if ( $width < 90 ) {
        $width = 90;
    } elseif ( $width > 100 ) {
        $width = 100;
    }
    ?>
    <style id="usponsive-page-layout-width-css">
        #page-content,
        #subfooter {
            width: <?php echo esc_attr( $width ); ?>%;
            margin: 0 auto; /* Keep centered if width < 100% */
        }
    </style>
    <?php
}
add_action( 'wp_head', 'usponsive_page_layout_width_styles' );

// Site Fonts dynamic styles
function usponsive_site_fonts_styles() {

    // Font families from Customizer.
    $primary_font   = get_theme_mod( 'usponsive_primary_font_family', 'inherit' );
    $secondary_font = get_theme_mod( 'usponsive_secondary_font_family', 'inherit' );
    $alt_font       = get_theme_mod( 'usponsive_alternative_font_family', 'inherit' );

    // If everything is inherit, bail.
    if ( 'inherit' === $primary_font && 'inherit' === $secondary_font && 'inherit' === $alt_font ) {
        return;
    }

    // Optional: whitelist of allowed font-family strings (same as your choices keys).
    $allowed_fonts = array(
        'inherit',
        'Arial, Helvetica, sans-serif',
        '"Times New Roman", Times, serif',
        '"Courier New", Courier, monospace',
        'Georgia, "Times New Roman", Times, serif',
        'Verdana, Geneva, sans-serif',
        'Tahoma, Geneva, sans-serif',
        'Calibri, Candara, "Segoe UI", Segoe, Optima, Arial, sans-serif',
    );

    // Normalize to allowed values only.
    if ( ! in_array( $primary_font, $allowed_fonts, true ) ) {
        $primary_font = 'inherit';
    }
    if ( ! in_array( $secondary_font, $allowed_fonts, true ) ) {
        $secondary_font = 'inherit';
    }
    if ( ! in_array( $alt_font, $allowed_fonts, true ) ) {
        $alt_font = 'inherit';
    }

    // Map region keys to selectors (same keys you used for checkboxes).
    $region_selectors = array(
        'topbar'     => '#topbar',
        'header'     => '#header',
        'navrow'     => '#navrow',
        'metarow'    => '#metarow',
        'leftcol'    => '#leftcol',
        'main'       => '#main',
        'rightcol'   => '#rightcol',
        'metafooter' => '#metafooter',
        'footer'     => '#footer',
        'subfooter'  => '#subfooter',
    );

    $css = '';

    // Helper: determine font for a region with precedence: alt > secondary > primary.
    $get_font_for_region = function( $region_key ) use ( $primary_font, $secondary_font, $alt_font ) {

        // Alternative (highest precedence).
        $alt_setting = get_theme_mod( 'usponsive_alternative_font_' . $region_key, false );
        if ( $alt_setting && 'inherit' !== $alt_font ) {
            return $alt_font;
        }

        // Secondary.
        $secondary_setting = get_theme_mod( 'usponsive_secondary_font_' . $region_key, false );
        if ( $secondary_setting && 'inherit' !== $secondary_font ) {
            return $secondary_font;
        }

        // Primary.
        $primary_setting = get_theme_mod( 'usponsive_primary_font_' . $region_key, false );
        if ( $primary_setting && 'inherit' !== $primary_font ) {
            return $primary_font;
        }

        return '';
    };

    foreach ( $region_selectors as $key => $selector ) {
        $font_family = $get_font_for_region( $key );

        if ( $font_family ) {
            // IMPORTANT: no esc_attr / esc_html here, these are known-safe font strings.
            // Apply to the region and everything inside it.
            $css .= $selector . ', ' . $selector . ' * { font-family: ' . $font_family . '; }';
        }
    }

    if ( empty( $css ) ) {
        return;
    }

    echo '<style id="usponsive-site-fonts-styles">' . $css . '</style>';
}
add_action( 'wp_head', 'usponsive_site_fonts_styles' );

// Site Heading Fonts dynamic styles
function usponsive_site_heading_fonts_styles() {

    // Same allowed fonts as your Site Fonts function.
    $primary_font   = get_theme_mod( 'usponsive_primary_font_family', 'inherit' );
    $secondary_font = get_theme_mod( 'usponsive_secondary_font_family', 'inherit' );
    $alt_font       = get_theme_mod( 'usponsive_alternative_font_family', 'inherit' );

    $allowed_fonts = array(
        'inherit',
        'Arial, Helvetica, sans-serif',
        '"Times New Roman", Times, serif',
        '"Courier New", Courier, monospace',
        'Georgia, "Times New Roman", Times, serif',
        'Verdana, Geneva, sans-serif',
        'Tahoma, Geneva, sans-serif',
        'Calibri, Candara, "Segoe UI", Segoe, Optima, Arial, sans-serif',
    );

    if ( ! in_array( $primary_font, $allowed_fonts, true ) ) {
        $primary_font = 'inherit';
    }
    if ( ! in_array( $secondary_font, $allowed_fonts, true ) ) {
        $secondary_font = 'inherit';
    }
    if ( ! in_array( $alt_font, $allowed_fonts, true ) ) {
        $alt_font = 'inherit';
    }

    // Region → selector mapping.
    $region_selectors = array(
        'topbar'     => '#topbar',
        'header'     => '#header',
        'navrow'     => '#navrow',
        'metarow'    => '#metarow',
        'leftcol'    => '#leftcol',
        'main'       => '#main',
        'rightcol'   => '#rightcol',
        'metafooter' => '#metafooter',
        'footer'     => '#footer',
        'subfooter'  => '#subfooter',
    );

    // Heading size presets (per level).
    $size_presets = array(
        'small' => array(
            'h1' => '1.8rem',
            'h2' => '1.6rem',
            'h3' => '1.4rem',
            'h4' => '1.2rem',
            'h5' => '1.05rem',
            'h6' => '0.95rem',
        ),
        'normal' => array(
            'h1' => '2.2rem',
            'h2' => '1.9rem',
            'h3' => '1.6rem',
            'h4' => '1.3rem',
            'h5' => '1.1rem',
            'h6' => '1rem',
        ),
        'large' => array(
            'h1' => '2.6rem',
            'h2' => '2.2rem',
            'h3' => '1.8rem',
            'h4' => '1.5rem',
            'h5' => '1.2rem',
            'h6' => '1.05rem',
        ),
    );

    $css = '';

    foreach ( $region_selectors as $key => $selector ) {

        // --- Heading font selection per region ---
        $font_choice = get_theme_mod( 'usponsive_heading_font_choice_' . $key, 'inherit' );
        $font_family = '';

        if ( 'primary' === $font_choice && 'inherit' !== $primary_font ) {
            $font_family = $primary_font;
        } elseif ( 'secondary' === $font_choice && 'inherit' !== $secondary_font ) {
            $font_family = $secondary_font;
        } elseif ( 'alternative' === $font_choice && 'inherit' !== $alt_font ) {
            $font_family = $alt_font;
        }

        if ( $font_family ) {
            // Apply only to headings inside the region.
            $css .= $selector . ' h1, ' .
                    $selector . ' h2, ' .
                    $selector . ' h3, ' .
                    $selector . ' h4, ' .
                    $selector . ' h5, ' .
                    $selector . ' h6 { font-family: ' . $font_family . '; }';
        }

        // --- Heading sizes per region ---
        $size_choice = get_theme_mod( 'usponsive_heading_size_' . $key, 'normal' );
        $sizes       = isset( $size_presets[ $size_choice ] ) ? $size_presets[ $size_choice ] : $size_presets['normal'];

        foreach ( $sizes as $tag => $size_value ) {
            $css .= $selector . ' ' . $tag . ' { font-size: ' . $size_value . '; }';
        }
    }

    if ( empty( $css ) ) {
        return;
    }

    echo '<style id="usponsive-site-heading-fonts-styles">' . $css . '</style>';
}
add_action( 'wp_head', 'usponsive_site_heading_fonts_styles', 21 );

// Global font styles
function usponsive_global_font_styles() {

    $font_family = get_theme_mod( 'usponsive_global_font_family', 'Arial, Helvetica, sans-serif' );
    $font_size   = get_theme_mod( 'usponsive_global_font_size', '14px' );

    // Whitelist allowed font stacks (same as Customizer choices).
    $allowed_fonts = array(
        'Arial, Helvetica, sans-serif',
        '"Times New Roman", Times, serif',
        '"Courier New", Courier, monospace',
        'Georgia, "Times New Roman", Times, serif',
        'Verdana, Geneva, sans-serif',
        'Tahoma, Geneva, sans-serif',
        'Calibri, Candara, "Segoe UI", Segoe, Optima, Arial, sans-serif',
    );

    if ( ! in_array( $font_family, $allowed_fonts, true ) ) {
        $font_family = 'Arial, Helvetica, sans-serif';
    }

    if ( empty( $font_size ) ) {
        $font_size = '14px';
    }
    ?>
    <style id="usponsive-global-font-css">
        html,
        body {
            font-family: <?php echo $font_family; ?>;
            font-size: <?php echo esc_attr( $font_size ); ?>;
        }
    </style>
    <?php
}
// IMPORTANT: run this LATE so it wins over stylesheet rules.
add_action( 'wp_head', 'usponsive_global_font_styles', 99 );


?>