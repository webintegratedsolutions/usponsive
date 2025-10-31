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
            <ul id="menu-unit-testing" class="menu">
              <li id="menu-item-1722" class="menu-item menu-item-type-post_type menu-item-object-post menu-item-1722"><a href="/markup-html-tags-and-formatting/">Markup: HTML Tags and Formatting</a></li>
              <li id="menu-item-1723" class="menu-item menu-item-type-post_type menu-item-object-post menu-item-1723"><a href="/markup-image-alignment/">Markup: Image Alignment</a></li>
              <li id="menu-item-1724" class="menu-item menu-item-type-post_type menu-item-object-post menu-item-1724"><a href="/markup-text-alignment/">Markup: Text Alignment</a></li>
              <li id="menu-item-1725" class="menu-item menu-item-type-post_type menu-item-object-post menu-item-1725"><a href="/title-with-special-characters/">Markup: Title With Special Characters</a></li>
              <li id="menu-item-1726" class="menu-item menu-item-type-post_type menu-item-object-post menu-item-1726"><a href="/markup-title-with-markup/">Markup: Title With Markup</a></li>
            </ul>
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
          while ( have_posts() ):
            the_post();

          get_template_part( 'template-parts/content', 'page' );

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
  
  <?php get_sidebar(); ?>
  <div style="clear:both"></div>
</div>
<!-- #content area -->

<?php
get_footer();
