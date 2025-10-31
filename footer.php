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

?>

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
          <span class="sep"> | </span> <a href="<?php echo esc_url( __( 'https://www.usponsive.com', 'usponsive' ) ); ?>">
          <?php
          printf( esc_html__( 'Usponsive' ), 'Usponsive' );
          ?>
          </a> </div>
        <!-- .site-info --> 
      </div>
    </div>
  </div>
  <div id="footer-region-three">
    <div class="view-mode"><a href="?viewMode=full">View Full-Size Mode</a></div>
  </div>
</div>
<!-- #footer region -->

</div>
<!-- #page-content -->

<div id="subfooter">Thank-you</div>
<div id="cadata"></div>
<?php wp_footer(); ?>
</body></html>