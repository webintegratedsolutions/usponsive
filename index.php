<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package usponsive-theme
 */

get_header();
?>

<!-- content area -->
<div id="content" class="site-content"> 
  
  <!-- primary area -->
  <div id="primary" class="content-area"> 
    
    <!-- leftcol region -->
    <div id="leftcol">
      <div class="leftcol-content">
        <div>
          <div class="menu-unit-testing-container">
  <?php
  wp_nav_menu(
    array(
      'theme_location' => 'sub-navigation-menu',
      'container_id' => 'site-navigation'
    )
  );
  ?>
          </div>
        </div>
      </div>
    </div>
    <!-- #leftcol --> 
    
    <!-- main area -->
    <div id="main" class="site-main" role="main">
      <div class="main-content">
        <main id="primary" class="site-main">
          <?php
          if ( have_posts() ):

            if ( is_home() && !is_front_page() ):
              ?>
          <header>
            <h1 class="page-title screen-reader-text">
              <?php single_post_title(); ?>
            </h1>
          </header>
          <?php
          endif;
          ?>
           <header>
           <h1 class="page-title">
		          <?php echo get_the_title( get_option('page_for_posts', true) ); ?>
	        </h1>
          </header>
          <?php
          /* Start the Loop */
          while ( have_posts() ):
            the_post();

          /*
           * Include the Post-Type-specific template for the content.
           * If you want to override this in a child theme, then include a file
           * called content-___.php (where ___ is the Post Type name) and that will be used instead.
           */
          get_template_part( 'template-parts/content', get_post_type() );

          endwhile;

          the_posts_navigation();

          else :

            get_template_part( 'template-parts/content', 'none' );

          endif;
          ?>
        </main>
        <!-- #main --> 
        
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
