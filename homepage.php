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
?>

<!-- content area -->
<div id="content" class="site-content"> 
  
  <!-- primary area -->
  <div id="primary" class="content-area"> 
    
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
  
  <div style="clear:both"></div>
</div>
<!-- #content area -->

<?php
get_footer();
