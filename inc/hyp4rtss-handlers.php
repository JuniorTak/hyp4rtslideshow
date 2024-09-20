<?php
/**
 * Images handlers
 *
 * @package HypSlideshow
 */

/**
 * Handle the image upload
 */
function hypss_handle_image_upload() {
	$urls = get_option( 'hypss_images' );
	if ( empty( $urls ) ) {
		$urls = array();
	}
	if ( isset( $_POST['hypss_image'] ) && ! empty( $_POST['hypss_image'] ) ) {
		$url = sanitize_text_field( wp_unslash( $_POST['hypss_image'] ) );
		array_push( $urls, $url );
		add_settings_error(
	        'hypss_settings_error',
	        esc_attr( 'settings_saved' ),
	        __( 'Image added.', 'hypslideshow' ),
	        'success'
	    );
	}
	return $urls;
}

// AJAX action to handle the image reordering.
add_action( 'wp_ajax_hypss_reorder_images', 'hypss_handle_reorder_images' );
/**
 * Handle image reordering
 */
function hypss_handle_reorder_images() {
	if ( isset( $_POST['image_urls'] ) && ! empty( $_POST['image_urls'] ) ) {
		$image_urls = $_POST['image_urls'];
		update_option( 'hypss_images', $image_urls );
		wp_send_json_success();
	}
}

// AJAX action to handle the image removal.
add_action( 'wp_ajax_hypss_remove_image', 'hypss_handle_remove_image' );
/**
 * Handle image removal
 */
function hypss_handle_remove_image() {
	if ( isset( $_POST['image_url'] ) && ! empty( $_POST['image_url'] ) ) {
		$image_url = sanitize_text_field( wp_unslash( $_POST['image_url'] ) );
		$options   = get_option( 'hypss_images' );
		$key       = array_search( $image_url, $options, true );
		if ( $key ) {
			unset( $options[ $key ] );
			update_option( 'hypss_images', $options );
			wp_send_json_success();
		} else {
			wp_send_json_error( array( 'message' => 'Image not found in settings.' ) );
		}
	}
}
