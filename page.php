<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package usponsive-theme
 */

get_header();

// Retrieve theme settings for metarow and leftcol visibility
$show_metarow = get_theme_mod( 'usponsive_show_metarow', true );
$show_leftcol = get_theme_mod( 'usponsive_show_leftcol', true );

?>

<?php if ( $show_metarow ) : ?>
  <!-- metarow region -->
  <div id="metarow">
    <div class="metarow-content">
      <p>Metarow Area</p>
    </div>
  </div>
  <!-- #metarow -->
<?php endif; ?>

<!-- content area -->
<div id="content" class="site-content"> 
  
  <!-- primary area -->
  <div id="primary" class="content-area"> 
    
<?php if ( $show_leftcol ) : ?>
  <!-- leftcol region -->
  <div id="leftcol">
    <div class="leftcol-content">
      <nav class="menu-unit-testing-container" aria-label="<?php esc_attr_e( 'Left column menu', 'usponsive-theme' ); ?>">
        <?php
        wp_nav_menu(
          array(
            'theme_location' => 'leftcol',
            'menu_id'        => 'menu-unit-testing',
            'menu_class'     => 'menu',
            'container'      => false,
            'depth'          => 1,
            'fallback_cb'    => false,
          )
        );
        ?>
      </nav>
    </div>
  </div>
  <!-- #leftcol -->
<?php endif; ?>
 
    <!-- main area -->
    <div id="main" class="site-main" role="main">
      <div class="main-content">
          <?php
          while ( have_posts() ):
            the_post();

          get_template_part( 'template-parts/content', 'page' );

          // If comments are open or we have at least one comment, load up the comment template.
          //if ( comments_open() || get_comments_number() ):
          //  comments_template();
          //endif;

          endwhile; // End of the loop.
          ?>
        
      </div>
    </div>
    <!-- #main area --> 
    
  </div>
  <!-- #primary area -->
  
  <?php get_sidebar(); ?>
  <div style="clear:both"></div>
</div>
<!-- #content area -->

<?php
get_footer();
