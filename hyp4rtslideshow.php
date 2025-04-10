<?php
/**
 * WordPress Plugin
 *
 * @package HypSlideshow
 */

/**
 * Plugin Name: Hyp Slideshow
 * Plugin URI: https://github.com/JuniorTak/hyp4rtslideshow
 * Description: A plugin to generate a slideshow for users to add into their websites
 * Version: 1.0
 * Author: Hyppolite Takoua Foduop
 * Author URI: https://hyppolitetakouafoduop.mystrikingly.com/
 * License: GPLv2 or later
 * Text Domain: hyp4rtslideshow
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once plugin_dir_path( __FILE__ ) . 'inc/hyp4rtss-activation.php';
require_once plugin_dir_path( __FILE__ ) . 'inc/hyp4rtss-enqueue.php';
require_once plugin_dir_path( __FILE__ ) . 'inc/hyp4rtss-handlers.php';
require_once plugin_dir_path( __FILE__ ) . 'inc/hyp4rtss-page.php';
require_once plugin_dir_path( __FILE__ ) . 'inc/hyp4rtss-shortcode.php';

// Hook for activation.
register_activation_hook( __FILE__, 'hypslideshow_activate' );
