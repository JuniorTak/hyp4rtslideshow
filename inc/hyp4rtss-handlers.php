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
	// Verify the nonce.
	if ( ! isset( $_POST['hypss_form_nonce_field'] ) || ! wp_verify_nonce(
		sanitize_text_field( wp_unslash( $_POST['hypss_form_nonce_field'] ) ),
		'hypss_form_nonce_action'
	) ) {
		wp_die(
			esc_html__( 'Security check failed.', 'hyp4rtslideshow' ),
			esc_html__( 'Error', 'hyp4rtslideshow' ),
			array( 'response' => 403 )
		);
	} elseif ( isset( $_POST['hypss_image'] ) && ! empty( $_POST['hypss_image'] ) ) {
		$url = sanitize_url( wp_unslash( $_POST['hypss_image'] ) );
		array_push( $urls, $url );
		add_settings_error(
			'hypss_settings_error',
			esc_attr( 'settings_saved' ),
			__( 'Image added.', 'hyp4rtslideshow' ),
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
	// Verify the nonce.
	check_ajax_referer( 'hypss_ajax_nonce' );
	if ( isset( $_POST['image_urls'] ) && ! empty( $_POST['image_urls'] ) ) {
		$image_urls = sanitize_option( 'hypss_images', wp_unslash( $_POST['image_urls'] ) );
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
	// Verify the nonce.
	check_ajax_referer( 'hypss_ajax_nonce' );
	if ( isset( $_POST['image_index'] ) ) {
		$index  = (int) $_POST['image_index'];
		$images = get_option( 'hypss_images' );
		unset( $images[ $index ] );
		update_option( 'hypss_images', array_values( $images ) );
		wp_send_json_success( array( 'count_images' => count( $images ) ) );
	} else {
		wp_send_json_error( array( 'message' => __( 'Image not found.', 'hyp4rtslideshow' ) ) );
	}
}
