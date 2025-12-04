<?php
/**
 * Displays header site branding
 *
 * @package usponsive-theme
 */
?>

<?php if ( get_header_image() ) : ?>

    <div class="custom-header">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
            <img src="<?php echo esc_url( get_header_image() ); ?>"
                 alt="<?php bloginfo( 'name' ); ?>">
        </a>
    </div>

<?php else : ?>

    <!-- Your existing site-branding block -->
<div class="site-branding">

	<?php if ( has_custom_logo() ) : ?>
		<div class="site-logo"><?php the_custom_logo(); ?></div>
	<?php endif; ?>
	<?php $blog_info = get_bloginfo( 'name' ); ?>
	<?php if ( ! empty( $blog_info ) ) : ?>
		<?php if ( is_front_page() && is_home() ) : ?>
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		<?php else : ?>
			<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
		<?php endif; ?>
	<?php endif; ?>
	
</div><!-- .site-branding -->

<?php endif; ?>
