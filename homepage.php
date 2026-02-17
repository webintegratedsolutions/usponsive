<?php

/**
 * Template Name: Home Page
 *
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package usponsive-theme
 */

get_header();

// Retrieve theme settings for metarow and leftcol visibility
$show_leftcol = get_theme_mod('usponsive_show_leftcol', true);
$show_rightcol = get_theme_mod('usponsive_show_rightcol', true);


?>

<?php
// Make sure the toggle still controls whether Meta Row shows at all.
$show_metarow = get_theme_mod('usponsive_show_metarow', true);

if ($show_metarow) :

  // Meta Row layout + content + colors.
  // These will be wired to Customizer controls in the next step.
  // Defaults chosen so the Meta Row *shows by default*, like before.
  $metarow_layout     = get_theme_mod('usponsive_metarow_layout', 'one-column'); // 'one-column', 'two-image-left', 'two-image-right'
  $metarow_image_id   = get_theme_mod('usponsive_metarow_image', 0);
  $metarow_text       = get_theme_mod('usponsive_metarow_text', 'Metarow Area'); // default text same as original
  $metarow_bg_color   = get_theme_mod('usponsive_metarow_bg_color', '#aed9e1;');
  $metarow_text_color = get_theme_mod('usponsive_metarow_text_color', '#333;');

  $metarow_image_url  = $metarow_image_id ? wp_get_attachment_image_url($metarow_image_id, 'large') : '';

  // If a two-column layout is chosen but no image is set, fall back to one-column.
  if (in_array($metarow_layout, array('two-image-left', 'two-image-right'), true) && ! $metarow_image_url) {
    $metarow_layout = 'one-column';
  }
?>
  <!-- metarow region -->
  <div id="metarow">
    <div class="metarow-content" style="background-color: <?php echo esc_attr($metarow_bg_color); ?>; color: <?php echo esc_attr($metarow_text_color); ?>;">
      <div class="metarow-inner metarow-layout-<?php echo esc_attr($metarow_layout); ?>">

        <?php if ('one-column' === $metarow_layout) : ?>

          <div class="metarow-col metarow-col-full">
            <?php if ($metarow_image_url) : ?>
              <div class="metarow-image">
                <img src="<?php echo esc_url($metarow_image_url); ?>" alt="" />
              </div>
            <?php endif; ?>

            <?php if ($metarow_text) : ?>
              <div class="metarow-text">
                <?php echo wp_kses_post(wpautop($metarow_text)); ?>
              </div>
            <?php endif; ?>
          </div>

        <?php elseif ('two-image-left' === $metarow_layout) : ?>

          <div class="metarow-col metarow-col-image">
            <?php if ($metarow_image_url) : ?>
              <img src="<?php echo esc_url($metarow_image_url); ?>" alt="" />
            <?php endif; ?>
          </div>
          <div class="metarow-col metarow-col-text">
            <?php if ($metarow_text) : ?>
              <?php echo wp_kses_post(wpautop($metarow_text)); ?>
            <?php endif; ?>
          </div>

        <?php elseif ('two-image-right' === $metarow_layout) : ?>

          <div class="metarow-col metarow-col-text">
            <?php if ($metarow_text) : ?>
              <?php echo wp_kses_post(wpautop($metarow_text)); ?>
            <?php endif; ?>
          </div>
          <div class="metarow-col metarow-col-image">
            <?php if ($metarow_image_url) : ?>
              <img src="<?php echo esc_url($metarow_image_url); ?>" alt="" />
            <?php endif; ?>
          </div>

        <?php endif; ?>

      </div><!-- .metarow-inner -->
    </div><!-- .metarow-content -->
  </div>
  <!-- #metarow -->
<?php endif; ?>

<!-- content area -->
<div id="content" class="site-content">

  <!-- primary area -->
  <div id="primary" class="content-area">

    <!-- main area -->
    <div id="main" class="site-main" role="main">
      <div class="main-content">
        <main id="primary" class="site-main">
          <?php
          while (have_posts()):
            the_post();

            get_template_part('template-parts/content', 'page');

          // If comments are open or we have at least one comment, load up the comment template.
          //if ( comments_open() || get_comments_number() ):
          //  comments_template();
          //endif;

          endwhile; // End of the loop.
          ?>
        </main>
        <!-- #main -->

      </div>
    </div>
    <!-- #main area -->

  </div>
  <!-- #primary area -->
  <div style="clear:both"></div>
</div>
<!-- #content area -->

<?php
get_footer();
