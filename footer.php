<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package minimus
 */

?>
		</div><!-- .row  -->
	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="container">
			<div class="site-info row">
				<div class="six columns">
					<a href="<?php echo esc_url( __( site_url() ) ); ?>"><?php printf( esc_html__( bloginfo('name') )); ?> &copy; <?php echo date("Y"); ?></a>
				</div>
				<div class="six columns textright">
			<?php printf( esc_html__( 'Theme: %1$s by %2$s', 'minimus' ), 'minimus', '<a href="'. esc_url( wp_get_theme()->get( 'AuthorURI' ) ).'" rel="designer">Riccardo Zaffalon</a>' ); ?>
				</div>
			</div><!-- .site-info -->
		</div><!-- .container -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
