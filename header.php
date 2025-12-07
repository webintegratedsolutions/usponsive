<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package usponsive-theme
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0" id="userViewport">
<link rel="profile" href="https://gmpg.org/xfn/11">
<style type="text/css">
.recentcomments a {
    display: inline !important;
    padding: 0 !important;
    margin: 0 !important;
}
</style>
<?php wp_head(); ?>
<?php
$show_topbar        = get_theme_mod( 'usponsive_show_topbar', true );
$show_header_region = get_theme_mod( 'usponsive_show_header_region', true );
$show_navrow        = get_theme_mod( 'usponsive_show_navrow', true );
$topbar_text = get_theme_mod( 'usponsive_topbar_text', 'Toprow Text' );
?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="pagecontainer" class="site">
<a class="skip-link screen-reader-text" href="#primary">
<?php esc_html_e( 'Skip to content', 'usponsive' ); ?>
</a>
<!-- page area -->
<div id="page-content" class="hfeed site">

<?php if ( $show_topbar ) : ?>
  <!-- topbar region -->
<div id="topbar">
    <div id="topbar-content">
        <?php if ( $topbar_text ) : ?>
            <?php echo wp_kses_post( wpautop( $topbar_text ) ); ?>
        <?php endif; ?>
    </div>
</div>
  <!-- #topbar -->
<?php endif; ?>


<?php if ( $show_header_region ) : ?>
  <!-- header region -->
  <div id="header" class="site-header" role="banner">
    <div id="header-primary">
      <div id="header-region-one">
        <div class="site-branding-container">
          <div class="site-branding-inner">
            <?php if ( get_header_image() ) : ?>
              <div class="custom-header">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                  <img src="<?php echo esc_url( get_header_image() ); ?>" alt="<?php bloginfo( 'name' ); ?>">
                </a>
              </div>
            <?php endif; ?>

            <?php
            $tagline = get_bloginfo( 'description', 'display' );
            if ( $tagline || is_customize_preview() ) :
              ?>
              <p class="site-tagline"><?php echo esc_html( $tagline ); ?></p>
            <?php endif; ?>
          </div><!-- .site-branding-inner -->
        </div><!-- .site-branding-container -->
      </div>
      <!-- #header-region-one --> 
    </div>
  </div>
  <!-- #header region --> 
<?php endif; ?>

<?php if ( $show_navrow ) : ?>
  <!-- navrow region -->
  <div id="navrow" class="navrow-content">
    <div id="collapse">
      <a href="#" onclick="collapseNavrowMenu('site-navigation', this)">Expand Navigation Menu</a>
    </div>
    <?php
    wp_nav_menu(
      array(
        'theme_location'  => 'menu-1',
        'container_id'    => 'site-navigation',
        'container_class' => 'main-navigation',
        'items_wrap'      => '<ul class="menu">%3$s</ul>',
      )
    );
    ?>
  </div>
  <!-- #navrow region -->
<?php endif; ?>

<div style="clear:both"></div>
