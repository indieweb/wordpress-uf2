<?php
/**
 * Plugin Name: Microformats 2
 * Plugin URI: https://github.com/indieweb/wordpress-uf2
 * Description: Adds Microformats 2 support to your WordPress installation or theme
 * Author: IndieWeb WordPress Outreach Club
 * Author URI: https://indieweb.org/WordPress_Outreach_Club
 * Version: 1.1.0
 * Text Domain: wp-uf2
 */

add_action( 'after_setup_theme', array( 'UF2_Plugin', 'init' ), 99 );

/**
 * Adds Microformats 2 support to your WordPress theme
 *
 * @author Matthias Pfefferle
 */
class UF2_Plugin {
	/**
	 * Initialize plugin
	 */
	public static function init() {
		// check if theme already supports Microformats 2
		if ( current_theme_supports( 'microformats2' ) ) {
			return;
		}
		self::plugin_textdomain();
		require_once dirname( __FILE__ ) . '/includes/class-uf2-author.php';
		$author = new UF2_Author();

		require_once dirname( __FILE__ ) . '/includes/class-uf2-comment.php';
		$comment = new UF2_Comment();

		require_once dirname( __FILE__ ) . '/includes/class-uf2-media.php';
		$media = new UF2_Media();

		require_once dirname( __FILE__ ) . '/includes/class-uf2-post.php';
		$post = new UF2_Post();

		if ( function_exists( 'genesis_html5' ) && genesis_html5() ) {
			require_once dirname( __FILE__ ) . '/includes/genesis.php';
		}
	}

	/**
	 * Load language files
	 */
	public static function plugin_textdomain() {
		// Note to self, the third argument must not be hardcoded, to account for relocated folders.
		load_plugin_textdomain( 'wp-uf2', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

}
