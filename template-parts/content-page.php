<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package usponsive-theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<?php usponsive_post_thumbnail(); ?>

	<div class="entry-content">
		<?php
		the_content();

		// Display pagination for paginated posts
		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'usponsive' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->


</article><!-- #post-<?php the_ID(); ?> -->
