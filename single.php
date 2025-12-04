<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
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
    <nav class="menu-unit-testing-container" aria-label="<?php esc_attr_e( 'Left column menu', 'usponsive-theme' ); ?>">
      <?php
      wp_nav_menu(
        array(
          'theme_location' => 'leftcol',          // matches the location we registered
          'menu_id'        => 'menu-unit-testing',
          'menu_class'     => 'menu',
          'container'      => false,
          'depth'          => 1,                  // single-level list; adjust if you want submenus
          'fallback_cb'    => false,              // no output if no menu is assigned
        )
      );
      ?>
    </nav>
  </div>
</div>
<!-- #leftcol -->
    
    <!-- main area -->
    <div id="main" class="site-main" role="main">
      <div class="main-content">
<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );

			the_post_navigation(
				array(
					'prev_text' => '<span class="nav-subtitle">' . __( 'Previous:', '_s' ) . '</span> <span class="nav-title">%title</span>',
					'next_text' => '<span class="nav-subtitle">' . __( 'Next:', '_s' ) . '</span> <span class="nav-title">%title</span>',
				)
			);

			// Load comments if you want them
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

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
