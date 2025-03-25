<?php
/**
 * Plugin activation
 *
 * @package HypSlideshow
 */

/**
 * Plugin activation routine with multisite compatible.
 *
 * @param boolean $network_wide Whether the plugin is activated network-wide.
 */
function hypslideshow_activate( $network_wide ) {
	if ( is_multisite() && $network_wide ) {
		$sites = get_sites();
		foreach ( $sites as $site ) {
			if ( ! get_blog_option( $site->blog_id, 'hypss_images' ) ) {
				update_blog_option( $site->blog_id, 'hypss_images', array() );
			}
		}
	} elseif ( ! get_option( 'hypss_images' ) ) {
			update_option( 'hypss_images', array() );
	}
}
