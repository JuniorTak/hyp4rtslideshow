<?php
/**
 * Shortcode
 *
 * @package HypSlideshow
 */

// Add our shortcode 'hypslideshow'.
add_shortcode( 'hypslideshow', 'hypslideshow_func' );
/**
 * Generate the html returned by the shortcode
 */
function hypslideshow_func() {
	// Start an output buffer.
	ob_start();

	$images = get_option( 'hypss_images' ) ?? null;
	if ( $images ) :
		?>
		<section id="tiny" class="tinyslide">
			<aside class="slides">
			<?php foreach ( $images as $image ) : ?>
				<figure><img src="<?php echo esc_url( $image ); ?>" alt="slideshow-image" />
					<figcaption></figcaption>
				</figure>
			<?php endforeach; ?>
			</aside>
		</section>
		<script type="text/javascript">
			var tiny = jQuery('#tiny').tiny().data('api_tiny');
		</script>
		<?php
	endif;

	// End the output buffer and assign its content.
	$output = ob_get_contents();
	ob_end_clean();

	return $output;
}
