<?php
/*
 Plugin Name: Microformats 2
 Plugin URI: https://github.com/indieweb/wordpress-microformats-2
 Description: Adds microformats2 support to your WordPress installation or theme
 Author: pfefferle
 Author URI: http://notizblog.org/
 Version: 1.0.0
 Text Domain: microformats2
*/

add_action( 'plugins_loaded', array( 'MF2_Plugin', 'init' ) );

/**
 * Adds microformats2 support to your WordPress theme
 *
 * @author Matthias Pfefferle
 */
class MF2_Plugin {
	/**
	 * Initialize plugin
	 */
	public static function init() {
		// check if theme already supports Microformats2
		if ( current_theme_supports( 'microformats2' ) ) {
			return;
		}
		self::plugin_textdomain();
		require_once dirname( __FILE__ ) . '/includes/class-mf2-author.php';
		$MF2author = new MF2_Author();

		require_once dirname( __FILE__ ) . '/includes/class-mf2-comment.php';
		$MF2comment = new MF2_Comment();

		require_once dirname( __FILE__ ) . '/includes/class-mf2-media.php';
		$MF2media = new MF2_Media();

		require_once dirname( __FILE__ ) . '/includes/class-mf2-post.php';
		$MF2post = new MF2_Post();

		if ( function_exists( 'genesis_html5' ) && genesis_html5() ) {
			require_once dirname( __FILE__ ) . '/includes/genesis.php';
		}
	}

	/**
	 * Load language files
	  */
	public static function plugin_textdomain() {
		// Note to self, the third argument must not be hardcoded, to account for relocated folders.
		load_plugin_textdomain( 'microformats-2', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

}
