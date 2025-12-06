<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package usponsive-theme
 */

$show_metafooter     = get_theme_mod( 'usponsive_show_metafooter', true );
$show_footer_region  = get_theme_mod( 'usponsive_show_footer_region', true );
$show_subfooter      = get_theme_mod( 'usponsive_show_subfooter', true );
?>

<?php if ( $show_metafooter ) : ?>
  <!-- metafooter region -->
  <div id="metafooter">
    <div id="metafooter-content">
      <div id="column-one">
        <h4>Column 1</h4>
        <p>Some text..</p>
      </div>
      <div id="column-two">
        <h4>Column 2</h4>
        <p>Some text..</p>
      </div>
      <div id="column-three">
        <h4>Column 3</h4>
        <p>Some text..</p>
      </div>
    </div>
  </div>
  <!-- #metafooter -->
<?php endif; ?>

<?php if ( $show_footer_region ) : ?>
  <!-- footer region -->
  <div id="footer" class="site-footer" role="banner">
    <div id="footer-primary">
      <div id="footer-region-one">
        <div class="credit-line">Theme By: <a href="#">Higher Level Web</a></div>
      </div>
      <div id="footer-region-two">
        <div class="credit-line">
          <div class="site-info">
            <?php
            printf( esc_html__( 'Theme' ) );
            ?>
            <span class="sep"> | </span>
            <a href="<?php echo esc_url( __( 'https://www.usponsive.com', 'usponsive' ) ); ?>">
              <?php
              printf( esc_html__( 'Usponsive' ), 'Usponsive' );
              ?>
            </a>
          </div>
          <!-- .site-info --> 
        </div>
      </div>
    </div>
    <div id="footer-region-three">
      <div class="view-mode"><a href="?viewMode=full">View Full-Size Mode</a></div>
    </div>
  </div>
  <!-- #footer region -->
<?php endif; ?>

</div>
<!-- #page-content -->

<?php if ( $show_subfooter ) : ?>
    <!-- subfooter region -->
  <div id="subfooter">Thank-you</div>
    <!-- #subfooter region -->
<?php endif; ?>

<div id="cadata"></div>
<?php wp_footer(); ?>
</body></html>