<?php
/**
 * Plugin menu page
 *
 * @package HypSlideshow
 */

/**
 * Register your custom image size
 */
function hypss_register_image_size() {
	add_image_size( 'hypss_thumb', 100, 100, true ); // true for hard crop - custom size width x height: 100 x 100.
}
add_action( 'after_setup_theme', 'hypss_register_image_size' );

 // Create the settings menu page.
add_action( 'admin_menu', 'hypslideshow_settings_menu' );
/**
 * Create settings menu
 */
function hypslideshow_settings_menu() {
	// Create a new menu page.
	add_menu_page(
		'HypSlideshow',             // Page title.
		'HypSlideshow',             // Menu title.
		'manage_options',           // Capability required to access the page.
		'hypslideshow',             // Menu slug.
		'hypslideshow_content',     // Function to display content.
		'dashicons-images-alt2',    // Menu icon.
		58                          // Menu position.
	);
	// Hooking up our register settings function.
	add_action( 'admin_init', 'hypslideshow_register_settings' );
}
/**
 * Register settings
 */
function hypslideshow_register_settings() {
	// Register our settings.
	register_setting( 'hypslideshow-settings-group', 'hypss_images', 'hypss_handle_image_upload' );
}

/**
 * Display content of the settings page
 */
function hypslideshow_content() {
	?>
	<div class="wrap">
		<h2>Hyp Slideshow</h2>
		<?php
		settings_errors();
		?>
		<hr />
		<h3>Add Image</h3>
		<form method="post" action="options.php" enctype="multipart/form-data">
			<?php wp_nonce_field( 'hypss_form_nonce_action', 'hypss_form_nonce_field' ); // Nonce field. ?>
			<?php settings_fields( 'hypslideshow-settings-group' ); // Display settings fields on the plugin settings page. ?>
			<input type="text" name="hypss_image" id="hypss_image" required data-readonly style="pointer-events: none;">
			<input type="button" id="hypss_select_btn" class="button" value="<?php esc_attr_e( 'Select Image', 'hyp4rtslideshow' ); ?>">
			<input type="submit" id="hypss_upload_btn" class="button button-primary" value="<?php esc_attr_e( 'Upload', 'hyp4rtslideshow' ); ?>">
		</form>
		<hr />
		
		<hr />
		<h3>Slideshow Images</h3>
		<?php
		$images = get_option( 'hypss_images' ) ?? null;
		if ( $images ) :
			if ( count( $images ) > 1 ) :
				?>
				<span class="hypss-reorder">Drag and drop images</span><br class="hypss-reorder">
				<button class="button hypss-reorder" onclick="hypss_reorder_images();">Click to reorder</button>
			<?php endif; ?>
			<ul id="sortable">
			<?php foreach ( $images as $index => $image ) : ?>
				<li class="ui-state-default">
					<?php
					// Get the attachment ID from the image URL.
					$attachment_id = attachment_url_to_postid( $image );
					if ( $attachment_id ) {
						// Get the image metadata.
						$meta = wp_get_attachment_metadata( $attachment_id );
						// Generate the custom size if it doesn't exist.
						if ( empty( $meta['sizes']['hypss_thumb'] ) ) {
							$meta = wp_generate_attachment_metadata( $attachment_id, get_attached_file( $attachment_id ) );
							wp_update_attachment_metadata( $attachment_id, $meta );
						}
						// Display the image.
						echo wp_get_attachment_image( 
							$attachment_id,
							'hypss_thumb', // custom size registered.
							false,
							array(
								'alt' => 'slideshow-image',
								'data-full-src' => esc_url( $image ), // Full image URL.
							)
						);
					} else { // fallback if no attachment ID found.
						echo '<p>Image is missing in your Media Library! Please Remove</p>';
					}
					?>
					<button class="button" onclick="hypss_remove_image(this);" data-index="<?php echo (int) $index; ?>">Remove</button>
				</li>
			<?php endforeach; ?>
			</ul>
		<?php else : ?>
			<span>No images found</span>
		<?php endif; ?>
	</div>
	<?php
}
