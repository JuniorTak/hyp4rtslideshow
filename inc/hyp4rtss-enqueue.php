<?php
/**
 * Enqueue styles and scripts
 *
 * @package HypSlideshow
 */

// Action to load scripts in the admin.
add_action( 'admin_enqueue_scripts', 'hypslideshow_admin_enqueue' );
/**
 * Define styles and scripts to load in the admin
 */
function hypslideshow_admin_enqueue() {
	global $pagenow;
	// Get the current page.
	$current_page = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_STRING );
	// Check both current page base and slug.
	if ( 'admin.php' === $pagenow && 'hypslideshow' === $current_page ) {
		// Enqueue WordPress media scripts.
		wp_enqueue_media();
		// Enqueue styles.
		wp_enqueue_style( 'hypss-jquery-ui-style', plugin_dir_url( __FILE__ ) . '../lib/jquery/1.13.2/jquery-ui.css', array(), '1.0.0', 'all' );
		wp_enqueue_style( 'hypss-sortable-style', plugin_dir_url( __FILE__ ) . '../lib/sortable/sortable.css', array(), '1.0.0', 'all' );
		// Enqueue scripts.
		wp_enqueue_script( 'hypss-jquery-sortable', plugin_dir_url( __FILE__ ) . '../lib/jquery/jquery-3.6.0.js', array(), '1.0.0', false );
		wp_enqueue_script( 'hypss-jquery-ui-js', plugin_dir_url( __FILE__ ) . '../lib/jquery/1.13.2/jquery-ui.js', array(), '1.0.0', false );
		wp_enqueue_script( 'hypss-sortable-js', plugin_dir_url( __FILE__ ) . '../lib/sortable/sortable.js', array( 'jquery' ), '1.0.0', false );
		wp_enqueue_script( 'hypss-js', plugin_dir_url( __FILE__ ) . '../js/hyp4rtss-scripts.js', array( 'jquery' ), '1.0.0', true );
		// Ajax nonce to the script.
		$ajax_nonce = wp_create_nonce( 'hypss_ajax_nonce' );
		wp_localize_script(
			'hypss-js',
			'hypss_ajax',
			array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'nonce'    => $ajax_nonce,
			)
		);
	}
}

// Action to load scripts in the site frontend.
add_action( 'wp_enqueue_scripts', 'hypslideshow_site_enqueue' );
/**
 * Define styles and scripts to load in the site frontend
 */
function hypslideshow_site_enqueue() {
	// Enqueue styles.
	wp_enqueue_style( 'hypss-tinyslide-style', plugin_dir_url( __FILE__ ) . '../lib/tinyslide/tinyslide.css', array(), '1.0.0', 'all' );
	// Enqueue scripts.
	wp_enqueue_script( 'hypss-jquery-tinyslide', plugin_dir_url( __FILE__ ) . '../lib/jquery/jquery-1.11.2.min.js', array(), '1.0.0', false );
	wp_enqueue_script( 'hypss-tinyslide-js', plugin_dir_url( __FILE__ ) . '../lib/tinyslide/tinyslide.js', array( 'jquery' ), '1.0.0', false );
}
