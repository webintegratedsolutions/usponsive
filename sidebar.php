<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package usponsive-theme
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>
<!-- secondary area -->
<div id="secondary" class="widget-area" role="complementary">
	<!-- rightcol region --> 
	<div id="rightcol">
		<div class="rightcol-content">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</div>
	</div><!-- #rightcol region --> 
<!-- end rightcol region -->
</div><!-- #secondary area -->
