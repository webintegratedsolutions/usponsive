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
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="pagecontainer" class="site">
<a class="skip-link screen-reader-text" href="#primary">
<?php esc_html_e( 'Skip to content', 'usponsive' ); ?>
</a>

<!-- page area -->
<div id="page-content" class="hfeed site">

<!-- header region -->
<div id="header" class="site-header" role="banner">
  <div id="header-primary">
    <div id="header-region-one">
			<div class="site-branding-container">
				<?php get_template_part( 'template-parts/header/site', 'branding' ); ?>
			</div><!-- .site-branding-container -->
    </div>
    <!-- #header-region-one --> 
  </div>
</div>
<!-- #header region --> 

<!-- navrow region -->
<div id="navrow" class="navrow-content">
  <div id="collapse"><a href="#" onclick="collapseNavrowMenu('site-navigation', this)">Expand Navigation Menu</a></div>
  <?php
  wp_nav_menu(
    array(
      'theme_location' => 'menu-1',
      'container_id' => 'site-navigation',
      'container_class' => 'main-navigation',
      'items_wrap' => '<ul class="menu">%3$s</ul>'
    )
  );
  ?>
</div>
<!-- #navrow region -->

<div style="clear:both"></div>
