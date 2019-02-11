<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ioBoot
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer row">
		<div class="site-info col">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'ioboot' ) ); ?>">
				<?php
				/* translators: %s: CMS name, i.e. WordPress. */
				printf( esc_html__( 'Proudly powered by %s', 'ioboot' ), 'WordPress' );
				?>
			</a>
			<span class="sep"> | </span>
				<?php
				/* translators: 1: Theme name, 2: Theme author. */
				printf( esc_html__( 'Theme: %1$s by %2$s.', 'ioboot' ), 'ioboot', '<a href="http://iotheme.com">ioTheme</a>' );
				?>
		</div><!-- .site-info col -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
