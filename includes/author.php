<?php

/**
 * Enhances Author and Avatar Markup
 *
 */
class UF2_Author {
	/**
	 * Initialize plugin
	 */
	public function __construct() {
		add_filter( 'get_avatar', array( $this, 'get_avatar' ) );
		add_filter( 'the_author', array( $this, 'the_author' ), 99, 1 );
	}

	/**
	 * Adds microformats v2 support to the comment_author_link.
	 */
	public static function author_link( $link ) {
		// Adds a class for microformats v2
		return preg_replace( '/(class\s*=\s*[\"|\'])/i', '${1}u-url ', $link );
	}

	/**
	 * Adds microformats v2 support to the get_avatar() method.
	 */
	public static function get_avatar( $tag ) {
		// Adds a class for microformats v2
		return preg_replace( '/(class\s*=\s*[\"|\'])/i', '${1}u-photo ', $tag );
	}

	/**
	 * Adds microformats v2 support to the author.
	 */
	public static function the_author( $author ) {
		if ( ! is_admin() ) {
			return "<span class='p-author h-card'>$author</span>";
		}

		return $author;
	}
}
