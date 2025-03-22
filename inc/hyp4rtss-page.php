<?php
/**
 * Plugin menu page
 *
 * @package HypSlideshow
 */

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
			<?php settings_fields( 'hypslideshow-settings-group' ); // Display settings fields on the plugin settings page. ?>
			<input type="text" name="hypss_image" id="hypss_image" required data-readonly style="pointer-events: none;">
			<input type="button" id="hypss_select_btn" class="button" value="<?php esc_attr_e( 'Select Image' ); ?>">
			<input type="submit" id="hypss_upload_btn" class="button button-primary" value="<?php esc_attr_e( 'Upload' ); ?>">
		</form>
		<hr />
		
		<hr />
		<h3>Slideshow Images</h3>
		<?php
		$images = get_option( 'hypss_images' ) ?? null;
		if ( $images ) :
			if ( count( $images ) > 1 ) :
				?>
				<span>Drag and drop images</span><br>
				<button class="button" onclick="hypss_reorder_images();">Click to reorder</button>
			<?php endif; ?>
			<ul id="sortable">
			<?php foreach ( $images as $index => $image ) : ?>
				<li class="ui-state-default">
					<img src="<?php echo esc_url( $image ); ?>" alt="slideshow-image" width="100" height="100" />
					<button class="button" onclick="hypss_remove_image(this, '<?php echo (int) $index; ?>');">Remove</button>
				</li>
			<?php endforeach; ?>
			</ul>
		<?php else : ?>
			<span>No images found</span>
		<?php endif; ?>
	</div>
	<script type="text/javascript" src="<?php echo esc_url( plugin_dir_url( __FILE__ ) . '../js/hyp4rtss-scripts.js' ); ?> "></script>
	<?php
}
